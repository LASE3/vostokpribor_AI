<?php
// Retired fixture-based test. Use tests/http_workflow.py on an isolated _test database.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
fwrite(STDERR, "Retired unsafe fixture suite. Run the guarded HTTP workflow instead.\n");
exit(78);
