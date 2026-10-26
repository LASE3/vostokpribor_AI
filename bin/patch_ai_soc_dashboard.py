# Patch AI Operations Center (AI SOC)/Dashboard.php and OperationsDashboard.php

p = r'AI Operations Center (AI SOC)/Dashboard.php'
with open(p, 'r', encoding='utf-8') as f:
    c = f.read()

queries = """
$totalCadets = (int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role = 'STUDENT'");
$activeCadets = (int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE'");
$totalScenarios = (int)$db->fetchValue("SELECT COUNT(*) FROM scenarios");
$totalTickets = (int)$db->fetchValue("SELECT COUNT(*) FROM tickets");
$pendingReviews = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE status IN ('SUBMITTED', 'UNDER_REVIEW')");
$totalModels = (int)$db->fetchValue("SELECT COUNT(*) FROM models");
$deployedModels = (int)$db->fetchValue("SELECT COUNT(*) FROM model_deployments WHERE status = 'DEPLOYED'");
$openIncidents = (int)$db->fetchValue("SELECT COUNT(*) FROM execution_jobs WHERE status = 'FAILED'");
$totalDatasets = (int)$db->fetchValue("SELECT COUNT(*) FROM datasets");
"""

target_str = "$activeJobs = $db->fetchAll(\"SELECT * FROM execution_jobs WHERE status IN ('QUEUED', 'RUNNING') ORDER BY created_at ASC\");"
if target_str in c:
    c = c.replace(target_str, target_str + queries)

# Metric 1: Total Cadets
c = c.replace('<div class="font-headline-xl text-headline-xl text-primary leading-none">128</div>',
              '<div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalCadets ?></div>')

# Metric 2: Blueprints
c = c.replace('<div class="font-headline-xl text-headline-xl text-primary leading-none">7</div>',
              '<div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalScenarios ?></div>')

# Metric 3: Live Tickets
c = c.replace('<div class="font-headline-xl text-headline-xl text-primary leading-none">24</div>',
              '<div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalTickets ?></div>')

# Metric 4: Pending Reviews
c = c.replace('<div class="font-headline-xl text-headline-xl text-primary leading-none">14</div>',
              '<div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $pendingReviews ?></div>')

# Metric 5: Deployed Models
c = c.replace('<div class="font-headline-xl text-headline-xl text-primary leading-none">18</div>',
              '<div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $deployedModels ?></div>')

# Metric 6: Incidents
c = c.replace('<div class="font-headline-xl text-headline-xl text-error leading-none">2</div>',
              '<div class="font-headline-xl text-headline-xl text-error leading-none"><?= $openIncidents ?></div>')

# Quick review badge
c = c.replace('<span class="px-1.5 py-0.2 bg-primary text-on-primary rounded-full font-label-sm text-label-sm">14</span>',
              '<span class="px-1.5 py-0.2 bg-primary text-on-primary rounded-full font-label-sm text-label-sm"><?= $pendingReviews ?></span>')

with open(p, 'w', encoding='utf-8') as f:
    f.write(c)

print('Dashboard.php successfully patched.')
