'use strict';

// Real compiler output, all shipped HTML/JS templates, no HTTP or database writes.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const postcss = require('postcss');
const selectorParser = require('postcss-selector-parser');
const resolveConfig = require('tailwindcss/resolveConfig');
const { defaultExtractor } = require('tailwindcss/lib/lib/defaultExtractor');
const { createContext } = require('tailwindcss/lib/lib/setupContextUtils');
const { generateRules } = require('tailwindcss/lib/lib/generateRules');
const root = path.resolve(__dirname, '..');
let checks = 0;
const check = (condition, label) => { assert.ok(condition, label); checks++; console.log(`PASS ${label}`); };
const sourceFiles = [];
for (const relative of ['app/Views', 'assets/js', 'AI Project Management', 'Data Center', 'ML Workbench', 'Model Registry & Deployment', 'AI Operations Center (AI SOC)']) {
    const walk = directory => {
        for (const item of fs.readdirSync(directory, { withFileTypes: true })) {
            const filename = path.join(directory, item.name);
            if (item.isDirectory()) walk(filename);
            else if (/\.(php|js)$/.test(item.name)) sourceFiles.push(filename);
        }
    };
    walk(path.join(root, relative));
}
sourceFiles.push(...fs.readdirSync(root).filter(name => name.endsWith('.php')).map(name => path.join(root, name)));
const text = sourceFiles.map(filename => fs.readFileSync(filename, 'utf8')).join('\n');
check(!text.includes('https://cdn.tailwindcss.com') && !text.includes('tailwind.config ='), 'No shipped PHP/JS depends on the development browser compiler');
const packageJson = require('../package.json');
const lock = require('../package-lock.json');
check(packageJson.private && packageJson.devDependencies.tailwindcss === '3.4.17', 'Same reviewed Tailwind patch version is a private build-only dependency');
check(lock.packages['node_modules/tailwindcss'].version === '3.4.17' && !!lock.packages['node_modules/tailwindcss'].integrity, 'Lockfile pins compiler version and package integrity');
check(Object.entries(lock.packages).every(([name, value]) => !name || value.dev === true), 'No Node production runtime dependencies introduced');
for (const theme of ['shared', 'portal']) {
    const config = resolveConfig(require(`../build/tailwind.${theme}.cjs`));
    const css = fs.readFileSync(path.join(root, 'assets/css', `tailwind-${theme}.css`), 'utf8');
    const ast = postcss.parse(css);
    const classes = new Set();
    const rules = [];
    ast.walkRules(rule => {
        selectorParser(selectors => selectors.walkClasses(node => classes.add(node.value))).processSync(rule.selector);
        rules.push(rule);
    });
    check(rules.length > 400 && css.length < 150000, `${theme}: static artifact has utility/preflight rules without a runtime compiler bundle`);
    check(!/https?:\/\/cdn\.tailwindcss\.com|sourceMappingURL/.test(css), `${theme}: no remote compiler or exposed source map`);
    const context = createContext(config);
    const candidates = new Set(defaultExtractor({ tailwindConfig: config })(text));
    const expected = new Set();
    for (const [, rule] of generateRules(candidates, context)) {
        const capture = value => selectorParser(selectors => selectors.walkClasses(node => expected.add(node.value))).processSync(value.selector);
        if (rule.type === 'rule') capture(rule);
        else if (rule.walkRules) rule.walkRules(capture);
    }
    const missing = [...expected].filter(candidate => !classes.has(candidate));
    check(missing.length === 0, `${theme}: every recognized utility in ${sourceFiles.length} shipped PHP/JS templates is compiled (${expected.size} classes; missing ${missing.join(', ')})`);
    for (const name of ['hidden', 'flex', 'grid', 'md:grid-cols-4', 'bg-[#4C1D95]', 'text-rose-700', 'bg-amber-600', 'opacity-100', 'translate-y-0', 'hover:underline']) {
        check(classes.has(name), `${theme}: responsive/dynamic-state utility ${name} is available before user interaction`);
    }
    check(config.theme.fontFamily.sans.join(',') === 'Inter,sans-serif', `${theme}: approved Inter typography preserved`);
    check(config.theme.fontFamily.mono[0] === (theme === 'shared' ? 'JetBrains Mono' : 'IBM Plex Mono'), `${theme}: original shell-specific monospace family preserved`);
    check((theme === 'shared' ? config.theme.colors.primary : config.theme.colors.brand.purple) === '#4C1D95', `${theme}: approved brand purple preserved`);
}
for (const filename of ['index.php', 'login.php', 'logout.php', 'change-password.php']) {
    const source = fs.readFileSync(path.join(root, filename), 'utf8');
    check(source.includes('assets/css/tailwind-portal.css?v=') && !source.includes('tailwind.config'), `${filename}: local cache-revised static portal stylesheet`);
}
const layout = fs.readFileSync(path.join(root, 'app/Views/Layout/AppLayout.php'), 'utf8');
check(layout.includes('assets/css/tailwind-shared.css') && layout.indexOf('tailwind-shared.css') < layout.indexOf('assets/css/design-tokens.css'), 'Shared compiled preflight/utilities retain the original load order before approved design overrides');
console.log(`${checks} production asset checks passed; no HTTP/database connection or student-file access.`);
