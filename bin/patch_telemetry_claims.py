# Truthful telemetry replacement

files = [
    (r'AI Operations Center (AI SOC)/TicketsAndScenarios.php', '5 SYSTEMS SYNCED', 'RANGE ACTIVE & CONNECTED'),
    (r'AI Operations Center (AI SOC)/TicketsAndScenarios.php', 'SLA: 99.98%', 'STATUS: ACTIVE'),
    (r'AI Operations Center (AI SOC)/Dashboard.php', '<span class="text-primary font-semibold">99.98%</span>', '<span class="text-primary font-semibold">HOST ONLINE</span>'),
    (r'index.php', 'CLUSTER SLA: 99.98%', 'LOCAL HOST RANGE')
]

for path, old, new in files:
    with open(path, 'r', encoding='utf-8') as f:
        c = f.read()
    if old in c:
        c = c.replace(old, new)
        with open(path, 'w', encoding='utf-8') as f:
            f.write(c)
        print(f"Updated {path}")
    else:
        print(f"Target '{old}' not found in {path}")
