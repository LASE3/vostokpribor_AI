from pathlib import Path
import re
for directory in ['AI Project Management', 'Data Center']:
 for p in Path(directory).glob('*.php'):
  s=p.read_text(encoding='utf-8-sig')
  insertion="\n$rangeUnreadCount = (int)(\\App\\Core\\Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id = :id AND is_read = 0', ['id' => (int)$currentUser['id']])['n'] ?? 0);"
  needle='$currentUser = \\App\\Middleware\\AuthenticationMiddleware::handle();'
  s=s.replace(needle,needle+insertion)
  s=s.replace('COHORT-24B::AI-ENG', "<?= htmlspecialchars($currentUser['cohort'] ?: 'No cohort assigned') ?>")
  s=s.replace('>3</span>', '><?= $rangeUnreadCount ?></span>')
  s=s.replace('<span class="text-on-surface">OK</span>', '<span class="text-on-surface">NOT AVAILABLE</span>')
  s=re.sub(r'>ONLINE</span>', '>NOT AVAILABLE</span>', s)
  dot='<span class="absolute top-1.5 right-1.5 flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-error"></span></span>'
  s=s.replace(dot, '<?php if ($rangeUnreadCount > 0): ?>'+dot+'<?php endif; ?>')
  s=s.replace('bg-[#10B981] animate-pulse', 'bg-outline-variant').replace('bg-[#10B981]', 'bg-outline-variant').replace('text-[#10B981]', 'text-outline')
  s=s.replace(' bg-primary animate-pulse', ' bg-outline-variant')
  s=re.sub(r'(<a\b[^>]*href="\.\./AI Operations Center \(AI SOC\)/[^\"]+"[^>]*>.*?</a>)', r"<?php if ($currentUser['role'] === 'ADMIN'): ?>\1<?php endif; ?>", s, flags=re.S)
  s=s.replace('Search datasets, tables, schemas, ticket IDs...', 'Filter displayed datasets…')
  s=s.replace('placeholder="Filter displayed datasets…"', 'data-range-search placeholder="Filter displayed datasets…"')
  p.write_text(s,encoding='utf-8')
