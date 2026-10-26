<?php
declare(strict_types=1);
// Deliberately no bootstrap or database access. This host bridge cannot safely
// authenticate an isolated worker and must not claim or complete queued jobs.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
fwrite(STDERR, "Execution unavailable: the host worker bridge is disabled.\n");
exit(78);
