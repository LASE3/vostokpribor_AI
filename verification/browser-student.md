# Student browser verification — 2026-10-26

The real XAMPP application used `APP_ENV=testing`, `vostok_range_20261026_acceptance_test`, and the student created by the HTTP suite. A separate `127.0.0.1` browser session avoided sharing the administrator's localhost CSRF session.

1. Signed in through the HTML login form. The portal displayed the student's one assigned dataset, one notebook, and one registered model.
2. Opened Notebook Workbench. Its textarea contained the exact code saved by the HTTP suite. Execution controls were disabled.
3. Replaced the code with `values = [2, 3]`, `print(sum(values))`, and a browser verification comment; clicked Save Notebook. The POST redirected to `?id=1&saved=1`, and version increased from 2 to 3.
4. Fully reloaded. The same code remained in the textarea, alongside Execution unavailable and No metrics available. [Screenshot](browser-notebook.png).
5. A later real edit replaced that test marker with `print('hello world')`. This later saved code was preserved. [Current read-only database evidence](browser-student-database.log) confirms the current code, null execution output/count, APPROVED ticket, persisted revision feedback, zero execution jobs, and zero deployment requests. An earlier stale-marker assertion is retained in `browser-student-stale-marker.log`; it was superseded by the later legitimate edit, not a rollback or data reset.

The first login attempt shared localhost browser cookies with the administrator's concurrently rotating session and correctly received a CSRF rejection. Moving the student check to the separate loopback hostname resolved that test-session collision. No CSRF protection was bypassed.

After browser verification, the application was returned to the separate fresh installation. Test student credentials do not authenticate against the fresh database. The active fresh installation then recorded one real failed login; this event was retained.
