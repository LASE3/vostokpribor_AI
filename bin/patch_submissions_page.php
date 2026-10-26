<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
fwrite(STDERR, "Retired migration patcher. Use bin/migrate.php; no data or source changes were made.\n");
exit(78);
