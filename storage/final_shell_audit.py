from pathlib import Path
for p in Path('ML Workbench').glob('*.php'):
 s=p.read_text()
 s=s.replace('Local Python 3 (Container Sandbox: Not Installed)', 'Execution unavailable — isolated runner not deployed')
 s=s.replace('Runtime / GPU: NOT AVAILABLE', 'Execution unavailable — isolated runner not deployed')
 s=s.replace('Memory: Host Process', 'Memory metrics: NOT AVAILABLE').replace('Storage: Local Range', 'Private file storage')
 s=s.replace('Kernel: Host Mode', 'KERNEL: UNAVAILABLE').replace('Kernel unavailable', 'KERNEL: UNAVAILABLE')
 s=s.replace('w-[NOT AVAILABLE]', 'w-0')
 p.write_text(s)
p=Path('index.php');s=p.read_text()
s=s.replace('<?= $studentCount ?> Total', "<?= $isAdmin ? $studentCount . ' Total' : 'Restricted' ?>")
s=s.replace('<?= $pendingSubmissions ?> Pending', "<?= $isAdmin ? $pendingSubmissions . ' Pending' : 'Restricted' ?>")
s=s.replace('<?= $queuedJobs + $runningJobs ?> Active', "<?= $isAdmin ? ($queuedJobs + $runningJobs) . ' Active' : 'Restricted' ?>")
p.write_text(s)
