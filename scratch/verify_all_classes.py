import os
import re

css_text = ''
for css_file in ['assets/css/design-tokens.css', 'assets/css/app-layout.css', 'assets/css/components.css', 'assets/css/responsive.css']:
    if os.path.exists(css_file):
        with open(css_file, 'r', encoding='utf-8') as f:
            css_text += '\n' + f.read()

with open('app/Views/Layout/AppLayout.php', 'r', encoding='utf-8') as f:
    app_layout = f.read()

# Extract defined tailwind config colors and spacing
tw_colors = re.findall(r"['\"]?([a-zA-Z0-9_-]+)['\"]?\s*:\s*['\"]#[0-9a-fA-F]+['\"]", app_layout)
tw_spacing = re.findall(r"['\"]?([a-zA-Z0-9_-]+)['\"]?\s*:\s*['\"][0-9.]+rem['\"]", app_layout)
tw_fontsize = re.findall(r"['\"]?([a-zA-Z0-9_-]+)['\"]?\s*:\s*\[['\"][0-9.]+rem['\"]", app_layout)

print(f"Tailwind config in AppLayout has: {len(tw_colors)} colors, {len(tw_spacing)} spacing, {len(tw_fontsize)} font sizes")

# Scan all PHP files in project
all_php_classes = set()
for root, dirs, files in os.walk('.'):
    if any(p in root for p in ['.git', 'vendor', 'node_modules', 'verification']):
        continue
    for file in files:
        if file.endswith('.php'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
                matches = re.findall(r'class=["\']([^"\']+)["\']', content)
                for m in matches:
                    # skip php tags inside class
                    cleaned = re.sub(r'<\?php.*?\?>', '', m)
                    cleaned = re.sub(r'<\?=.*?\?>', '', cleaned)
                    for c in cleaned.split():
                        c = c.strip(';,{}()[]$')
                        if c and not c.startswith('<') and not c.endswith('>'):
                            all_php_classes.add(c)

print(f"Total unique classes used in all PHP files: {len(all_php_classes)}")

# Standard tailwind prefixes
std_tw_patterns = [
    r'^(flex|grid|block|inline|hidden|relative|absolute|fixed|sticky)',
    r'^(w-|h-|min-w-|min-h-|max-w-|max-h-)',
    r'^(p-|px-|py-|pt-|pb-|pl-|pr-|m-|mx-|my-|mt-|mb-|ml-|mr-|gap-)',
    r'^(text-|font-|leading-|tracking-|align-|whitespace-|break-|truncate)',
    r'^(bg-|border-|rounded-|shadow-|divide-|opacity-|z-|overflow-)',
    r'^(items-|justify-|self-|content-|col-|row-|shrink-|grow-)',
    r'^(cursor-|pointer-|select-|transition-|duration-|ease-|transform-|translate-|scale-)',
    r'^(hover:|focus:|active:|group-|sm:|md:|lg:|xl:|2xl:)',
    r'^(vp-|material-symbols)'
]

unrecognized = []
for c in sorted(all_php_classes):
    # Check if in CSS
    clean_selector = c.replace('/', '\\/').replace(':', '\\:')
    if f".{clean_selector}" in css_text or f".{c}" in css_text:
        continue
    
    # Check if matches standard TW
    matched = False
    for pat in std_tw_patterns:
        if re.search(pat, c):
            matched = True
            break
    if not matched:
        unrecognized.append(c)

print(f"Unrecognized non-Tailwind classes ({len(unrecognized)}):")
for u in unrecognized[:30]:
    print(" -", u)
