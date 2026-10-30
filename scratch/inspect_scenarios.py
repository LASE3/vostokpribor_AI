import re

with open('AI Operations Center (AI SOC)/TicketsAndScenarios.php', 'r', encoding='utf-8') as f:
    text = f.read()

print('Length of file:', len(text))
matches = re.findall(r'<div[^>]*id="([^"]+)"', text)
print('Div IDs found:', matches[:20])

# Check for classes used in TicketsAndScenarios.php
classes = set(re.findall(r'class="([^"]+)"', text))
all_classes = set()
for c_group in classes:
    for c in c_group.split():
        all_classes.add(c)

print('Total unique classes in TicketsAndScenarios:', len(all_classes))
# Check classes containing 'outline', 'error', 'surface'
specials = [c for c in sorted(all_classes) if any(k in c for k in ['outline', 'error', 'surface', 'container'])]
print('Special classes in TicketsAndScenarios:', specials)
