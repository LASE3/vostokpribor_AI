<?php
declare(strict_types=1);
namespace App\Execution;

use App\Core\Env;

/** Official Enterprise contract preparation; activation deliberately awaits cloud acceptance. */
final class ColabEnterpriseProvider implements ExecutionProvider
{
    private array $config;
    private bool $invalid = false;

    public function __construct(?array $configuration = null)
    {
        if ($configuration !== null) { $this->config = $configuration; return; }
        $this->config = [];
        $file = Env::get('COLAB_CONFIG_FILE', '');
        if ($file === '') return;
        try {
            if (!is_string($file)) throw new \RuntimeException();
            $real = realpath($file);
            $root = realpath(dirname(__DIR__, 2));
            $normalized = $real ? strtolower(str_replace('\\','/', $real)) : '';
            if (!$real || !is_file($real) || is_link($file) || filesize($real) > 131072
                || str_starts_with($normalized, strtolower(str_replace('\\','/', $root)).'/')
                || preg_match('~/(?:htdocs|public_html|wwwroot)/~', $normalized)) throw new \RuntimeException();
            $this->config = json_decode(file_get_contents($real), true, 32, JSON_THROW_ON_ERROR);
            if (!is_array($this->config)) throw new \RuntimeException();
            $this->validate();
        } catch (\Throwable $e) { $this->config = []; $this->invalid = true; }
    }

    public function availability(): array
    {
        return ['provider'=>'GOOGLE_COLAB_ENTERPRISE', 'status'=>'UNAVAILABLE', 'can_execute'=>false,
            'configuration_status'=>$this->invalid ? 'INVALID' : ($this->config ? 'PENDING_VERIFICATION' : 'NOT_CONFIGURED'),
            'integration_stage'=>'PREPARED_NOT_LIVE_VERIFIED', 'supports_code_exchange'=>true,
            'supports_verified_cancellation'=>false,
            'reason'=>'Execution unavailable: Google Cloud project, authentication, per-student isolation, quotas, output retrieval and cancellation/cleanup have not passed provider-backed acceptance. Notebook code can be exchanged with Colab manually.',
            'dataset_transfer_enabled'=>false, 'trusted_evaluation_enabled'=>false, 'inference_enabled'=>false];
    }

    private function validate(): void
    {
        foreach (['project','location','runtime_template','output_bucket','credentials_file'] as $key) {
            if (!is_string($this->config[$key] ?? null) || $this->config[$key] === '') throw new \InvalidArgumentException('Provider configuration is incomplete.');
        }
        if (!preg_match('/^[a-z][a-z0-9-]{4,61}[a-z0-9]$/D', $this->config['project'])
            || !preg_match('/^[a-z]+-[a-z]+[0-9]$/D', $this->config['location'])
            || !preg_match('/^[a-z0-9][a-z0-9._-]{1,220}[a-z0-9]$/D', $this->config['output_bucket'])) throw new \InvalidArgumentException('Invalid Google project, region or bucket.');
        $parent = 'projects/'.$this->config['project'].'/locations/'.$this->config['location'];
        if (!preg_match('~^'.preg_quote($parent,'~').'/notebookRuntimeTemplates/[A-Za-z0-9_-]+$~D', $this->config['runtime_template'])) throw new \InvalidArgumentException('Runtime template must belong to the configured project and region.');
        $seconds = $this->config['timeout_seconds'] ?? 600;
        if (!is_int($seconds) || $seconds < 30 || $seconds > 1800) throw new \InvalidArgumentException('Timeout must be 30–1800 seconds.');
    }

    /** Offline only: constructing this request neither submits code nor authorizes a transfer. */
    public function prepare(array $notebook, int $studentId, string $jobId): array
    {
        $this->validate();
        if ($studentId < 1 || (int)($notebook['student_id'] ?? 0) !== $studentId) throw new \InvalidArgumentException('Snapshot owner must match the execution student.');
        if (!preg_match('/^vostok-[a-z0-9-]{8,54}$/D', $jobId)) throw new \InvalidArgumentException('Invalid provider job identifier.');
        $accounts = $this->config['execution_service_accounts'] ?? [];
        if (!is_array($accounts)) throw new \InvalidArgumentException('Execution identities must be an operator-managed map.');
        $account = $accounts[(string)$studentId] ?? null;
        if (!is_string($account) || !preg_match('/^[a-z][a-z0-9-]{4,28}[a-z0-9]@'.preg_quote($this->config['project'],'/').'\.iam\.gserviceaccount\.com$/D', $account)
            || count(array_keys($accounts, $account, true)) !== 1) throw new \InvalidArgumentException('An independently scoped, unique execution identity is required for this student.');
        $parent = 'projects/'.$this->config['project'].'/locations/'.$this->config['location'];
        $plan = ['method'=>'POST', 'url'=>'https://'.$this->config['location'].'-aiplatform.googleapis.com/v1/'.$parent.'/notebookExecutionJobs?notebookExecutionJobId='.rawurlencode($jobId),
            'body'=>['displayName'=>$jobId, 'directNotebookSource'=>['content'=>base64_encode(NotebookDocument::encode($notebook))],
                'notebookRuntimeTemplateResourceName'=>$this->config['runtime_template'],
                'serviceAccount'=>$account, 'executionTimeout'=>($this->config['timeout_seconds'] ?? 600).'s',
                'gcsOutputUri'=>'gs://'.$this->config['output_bucket'].'/students/'.$studentId.'/jobs/'.$jobId,
                'labels'=>['vostok-student'=>(string)$studentId, 'vostok-job'=>$jobId]],
            'submitted'=>false, 'requires_verified_isolation'=>true, 'automatic_dataset_transfer'=>false];
        if (strlen(json_encode($plan['body'],JSON_THROW_ON_ERROR|JSON_UNESCAPED_SLASHES)) > GoogleHttpTransport::MAX_REQUEST_BYTES) {
            throw new \InvalidArgumentException('Encoded notebook exceeds the provider request size limit.');
        }
        return $plan;
    }

    public function submit(array $snapshot): array
    {
        // Credentials/configuration alone do not establish isolation or cancellation.
        throw new \DomainException($this->availability()['reason']);
    }

    public function cancel(string $reference): void
    {
        // Enterprise's documented delete is not a documented execution cancellation.
        throw new \DomainException('Verified Colab Enterprise cancellation is unavailable; no remote cancellation was claimed.');
    }

    /** Explicit operator CLI probe only; no remote writes, job creation or dataset transfer. */
    public function probe(): array
    {
        if (PHP_SAPI !== 'cli') throw new \DomainException('Google provider probing is CLI-only.');
        $this->validate();
        $token = (new GoogleOAuthCredentials($this->config['credentials_file']))->getAccessToken();
        $url = 'https://'.$this->config['location'].'-aiplatform.googleapis.com/v1/'.$this->config['runtime_template'];
        $result = GoogleHttpTransport::request('GET', $url, ['Authorization'=>'Bearer '.$token], null);
        if ($result['status'] !== 200) throw new \RuntimeException('Google authentication/IAM/runtime-template probe failed.', $result['status']);
        try { $data = json_decode($result['body'], true, 64, JSON_THROW_ON_ERROR); }
        catch (\JsonException $e) { throw new \RuntimeException('Google returned an invalid runtime-template response.'); }
        if (($data['name'] ?? '') !== $this->config['runtime_template']) throw new \RuntimeException('Google returned an unexpected runtime template.');
        return ['authenticated_template_read'=>true, 'live_execution_tested'=>false, 'can_execute'=>false,
            'isolation_verified'=>false, 'cancellation_verified'=>false, 'data_transferred'=>false];
    }
}
