from pathlib import Path
import re
for system, directory in [('ml', 'ML Workbench'), ('registry', 'Model Registry & Deployment')]:
    for p in Path(directory).glob('*.php'):
        source = p.read_text(encoding='utf-8-sig')
        doc = source.index('<!DOCTYPE html>')
        main = re.search(r'<main\b[^>]*>', source[doc:], re.I)
        if not main: raise RuntimeError(str(p))
        start = doc + main.end()
        shell = source[doc:start]
        replacements = {
            'SCENARIO-01: Churn Prediction (P-AI-204)': '<?= range_h($rangeContextName) ?>',
            'TRAINING IN PROGRESS': 'EXECUTION UNAVAILABLE',
            'F1 ≥ 0.80': 'NOT EVALUATED',
            'Python 3.10.12 (GPU A100-SXM4-40GB: Idle 14% RAM)': 'Runtime / GPU: NOT AVAILABLE',
            'RAM: 4.8 / 32 GB': 'RAM: NOT AVAILABLE',
            'Disk: 18.2 / 100 GB': 'Worker disk: NOT AVAILABLE',
            'Kernel Connected': 'Kernel unavailable',
            'GPU CLUSTER UTIL': 'GPU TELEMETRY',
            '86%': 'NOT AVAILABLE',
            'w-[86%]': 'w-0',
            'Customer Churn Prediction (v2.4)': '<?= range_h($rangeContextName) ?>',
            'GATEWAY: OK (14ms)': 'GATEWAY: NOT AVAILABLE',
            'POD #04': 'NO WORKER',
            'VP-TKT-1082: Churn Baseline v2': "<?= range_h($activeTicket['ticket_code'] ?? 'No assigned tickets') ?>",
            'EXP-884_xgboost_churn.ipynb': "<?= range_h($rangeNotebooks[0]['title'] ?? 'No notebooks') ?>",
            'Telemetry Range Pod #04': 'Execution unavailable',
        }
        for old,new in replacements.items(): shell = shell.replace(old,new)
        # Existing chrome controls cannot assert runtime activity without a provider.
        shell = re.sub(r'<button\b', '<button disabled aria-disabled="true"', shell)
        shell = shell.replace(' animate-pulse', '')
        shell = re.sub(r'<span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span>', '<?php if ($rangeNotificationCount > 0): ?><span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span><?php endif; ?>', shell)
        shell = re.sub(r'(<a\b[^>]*href="\.\./AI Operations Center \(AI SOC\)/[^\"]+"[^>]*>.*?</a>)', r'<?php if ($rangeAdmin): ?>\1<?php endif; ?>', shell, flags=re.S)
        prefix = "<?php\n$rangeSystem = '"+system+"';\n$rangePage = '"+p.stem+"';\nrequire __DIR__ . '/../app/Views/range_context.php';\n?>\n"
        p.write_text(prefix+shell+"\n<?php require __DIR__ . '/../app/Views/range_panels.php'; ?>\n        </main>\n    </div>\n    <script src=\"js/main.js\"></script>\n</body>\n</html>\n", encoding='utf-8')
