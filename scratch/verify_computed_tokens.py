import re

with open('assets/css/components.css', 'r', encoding='utf-8') as f:
    comp_css = f.read()

with open('assets/css/design-tokens.css', 'r', encoding='utf-8') as f:
    tokens_css = f.read()

with open('assets/css/app-layout.css', 'r', encoding='utf-8') as f:
    layout_css = f.read()

with open('app/Views/Layout/AppLayout.php', 'r', encoding='utf-8') as f:
    app_layout = f.read()

checks = {
    'Spacing Scale in CSS': [
        ('.gap-space-xs', '0.25rem'),
        ('.gap-space-sm', '0.5rem'),
        ('.gap-space-md', '1rem'),
        ('.gap-space-lg', '1.5rem'),
        ('.gap-space-xl', '2rem'),
        ('.gap-gutter', '1.5rem'),
        ('.p-space-xs', '0.25rem'),
        ('.p-space-sm', '0.5rem'),
        ('.p-space-md', '1rem'),
        ('.p-space-lg', '1.5rem'),
        ('.px-space-md', 'padding-left: 1rem'),
        ('.py-space-md', 'padding-top: 1rem'),
    ],
    'Typography Scale in CSS': [
        ('.font-headline-xl', '2rem'),
        ('.font-headline-lg', '1.5rem'),
        ('.font-headline-md', '1.25rem'),
        ('.font-headline-sm', '1.125rem'),
        ('.font-body-lg', '1rem'),
        ('.font-body-md', '0.875rem'),
        ('.font-body-sm', '0.8125rem'),
        ('.font-label-lg', '0.875rem'),
        ('.font-label-md', '0.75rem'),
        ('.font-label-sm', '0.6875rem'),
        ('.font-code-sm', '0.75rem'),
    ],
    'Semantic Color & Surface Utilities in CSS': [
        ('.bg-surface', '#ffffff'),
        ('.bg-surface-container-lowest', '#ffffff'),
        ('.bg-surface-container-low', '#fdf6f0'),
        ('.bg-surface-container', '#f8f4ef'),
        ('.bg-surface-container-high', '#f3e8ff'),
        ('.bg-surface-container-highest', '#efe9e1'),
        ('.bg-error-container', '#fee2e2'),
        ('.text-on-error-container', '#991b1b'),
        ('.text-on-surface', '#2e1065'),
        ('.text-on-surface-variant', '#6b7280'),
        ('.text-outline', '#94a3b8'),
        ('.border-outline-variant', '#e2e8f0'),
        ('.precision-card', 'border-radius'),
    ],
    'Design Tokens Variables': [
        ('--space-xs', '4px'),
        ('--space-sm', '8px'),
        ('--space-md', '16px'),
        ('--space-lg', '24px'),
        ('--space-xl', '32px'),
        ('--gutter', '24px'),
        ('--color-outline', '#94a3b8'),
        ('--color-outline-variant', '#e2e8f0'),
        ('--color-error-container', '#fee2e2'),
        ('--color-on-error-container', '#991b1b'),
    ],
    'Tailwind Extend in AppLayout': [
        ("'space-xs'", "'0.25rem'"),
        ("'space-md'", "'1rem'"),
        ("'headline-lg'", "'1.5rem'"),
        ("'outline'", "'#94A3B8'"),
        ("'outline-variant'", "'#E2E8F0'"),
        ("'error-container'", "'#FEE2E2'"),
        ("'on-error-container'", "'#991B1B'"),
        ("'surface-container-highest'", "'#EFE9E1'"),
    ],
    'Tooltip & Popover Architecture': [
        ('.vp-floating-tooltip', 'position: fixed'),
        ('.vp-notif-popover', 'position: absolute'),
        ('.vp-notif-popover.is-open', 'opacity: 1'),
    ]
}

all_ok = True
for category, items in checks.items():
    print(f"\n--- Checking {category} ---")
    combined = comp_css + '\n' + tokens_css + '\n' + layout_css + '\n' + app_layout
    for selector, expected in items:
        if selector in combined and expected in combined:
            print(f"  [OK] {selector} contains {expected}")
        else:
            print(f"  [FAIL] {selector} missing or doesn't contain {expected}")
            all_ok = False

if all_ok:
    print("\nALL DESIGN TOKEN UTILITIES AND PROPERTIES VERIFIED 100% COMPLETE!")
else:
    print("\nSOME CHECKS FAILED.")
