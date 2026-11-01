# V10 role and application access matrix

Source: `C:/xampp/htdocs/vostokpribor_AI`, branch main. This document describes the implemented server-side role policy. Test results belong in the final V10 test report; route visibility is not inferred from a screenshot or JavaScript flag.

## Application boundaries

| Surface | STUDENT | ADMIN | Anonymous |
|---|---|---|---|
| Successful login destination, after required password rotation | Student portal, index.php | AI Operations Center (AI SOC)/Dashboard.php | Login required |
| Root index.php | Four student system cards and links | Redirect to SOC Dashboard | Redirect to login |
| SYS-01 AI Project Management HTML pages | Allowed; own active assignments/private work |403; use SOC administration | Login required |
| SYS-02 Data Center HTML pages | Allowed; granted ticket/version datasets and own processed outputs |403; use SOC Dataset Management | Login required |
| SYS-03 ML Workbench HTML pages | Allowed; own notebooks/experiments |403; use SOC Student Workspaces | Login required |
| SYS-04 Model Registry & Deployment HTML pages | Allowed; own models/reviews/requests |403; use SOC Model Management/review pages | Login required |
| SYS-05 SOC HTML entry pages |403 | Allowed | Login required |
| Direct requests to SOC partial templates |403 |403; include-only from protected entries |403 |
| soc/* APIs |403 | Administrator role plus service/object validation |401 |
| Common authenticated APIs/compatibility aliases | Existing ownership/assignment restrictions | Existing legitimate administrative inspection privileges retained |401 |
| Notebook code import | Explicit POST, student only, new owned notebook |403; no student impersonation |401 |
| Notebook code export | Own saved notebook only | Authorized inspection, including soc/notebooks/{id}/export |401 |
| Python execution | Unavailable; no host or Google execution is claimed | Provider inspection only; no bypass | Authentication required |
| Password change/logout | Own authenticated account and CSRF | Own authenticated account and CSRF | Authentication required |

Password rotation takes precedence over business navigation. An unrotated account receives the required-password-change response/redirect before entering applications. The matrix describes otherwise active, rotated accounts. Individual missing/unauthorized resources may intentionally return403/404. CSRF, input validation, admission and inactive-account handling still apply independently of the role check.

## Authoritative implementation

`app/Core/SystemAccess.php` defines the four student system keys, the sole administrator system and role-specific home destination. `AuthenticationMiddleware::handle(false)` classifies the **executing PHP file**, resolving the real path so an Apache junction does not bypass the boundary. It does not trust a caller's redirect parameter or browser role. Disallowed page access is audited and denied before normal page rendering. The shared AppLayout independently verifies its system key against the authenticated user role.

API requests keep their existing middleware/service checks. The HTML restriction does not remove administrator backend privileges needed by central SOC. Shared services preserve the original student's ownership and record the actual administrator actor for privileged operations. No administrator authoring endpoint is added to the student pages.

HTML login, already-authenticated login visits and password rotation use the trusted session role. A client-provided return parameter cannot route a student into SOC or an administrator into a student application. API login/password-change responses include `redirect_url`; authentication remains authoritative even if a client ignores it. Mandatory rotation routes to change-password.php first.

## Rendered navigation

The student portal contains exactly four system launcher cards. The locked SOC card, SOC quick-navigation item and auxiliary API-exchange launcher card were removed from that student landing page. The architecture illustration also shows the four student systems. Shared branding, colors, layout shell, sidebar animation, profile, notifications and Sign Out are retained.

Student shared header/sidebar home links return to the student portal. Their notifications footer links to the student's own notification history. Administrator home/notification links return to SOC Dashboard; SOC navigation contains administrative panels rather than launches into the four student applications. Sidebar navigation rejects a system key not permitted to its current user. The obsolete administrator-inspection/SOC link was removed from the ML student Dashboard.

The navigation configuration still legitimately contains the SOC administrative menu. Shared notification rendering still legitimately contains its administrator-only destination. These server-selected definitions are not student-visible SOC links and are not deleted from the backend merely for containing “SOC.” Legitimate service relationships and API references also remain.

## Central administration and testing account

SOC provides ticket/assignment/review, dataset/version/grant, original notebook/experiment/job inspection, model/version/integrity/validation and deployment-request administration through the existing shared backend. Unconfigured provider resources/quotas are unavailable; no administrator can turn absent infrastructure into successful execution by entering a student URL.

Provision `student_test` and a second student only through the secure account workflow in the isolated testing installation. Generate temporary passwords, store them hashed and complete initial rotation. Keep credentials outside source/webroot and exclude them from logs/screenshots/packages. These accounts must never be a seed, startup action or new records in main. The companion HTTP test provisions its guarded `_test` target and checks application visibility, direct role denials and cross-student scope; consult its actual final log for observed results.
