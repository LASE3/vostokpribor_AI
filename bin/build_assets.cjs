#!/usr/bin/env node
'use strict';

// Build tools never run in PHP requests. Committed CSS is sufficient on XAMPP.
const fs = require('node:fs');
const os = require('node:os');
const path = require('node:path');
const crypto = require('node:crypto');
const { spawnSync } = require('node:child_process');
const root = path.resolve(__dirname, '..');
const check = process.argv.includes('--check');
if (process.argv.slice(2).some(arg => arg !== '--check')) {
    console.error('Usage: node bin/build_assets.cjs [--check]');
    process.exit(2);
}
const compiler = require('tailwindcss/package.json');
if (compiler.version !== '3.4.17') throw new Error('Install the reviewed lockfile with npm ci --ignore-scripts.');
const temporary = fs.mkdtempSync(path.join(os.tmpdir(), 'vostok-assets-'));
const outputs = [];
try {
    // Compile both variants before changing either committed artifact.
    for (const theme of ['shared', 'portal']) {
        const output = path.join(temporary, `tailwind-${theme}.css`);
        const args = [require.resolve('tailwindcss/lib/cli.js'), '-c', `build/tailwind.${theme}.cjs`, '-i', 'build/tailwind.input.css', '-o', output, '--minify'];
        const result = spawnSync(process.execPath, args, { cwd: root, encoding: 'utf8', timeout: 120000 });
        if (result.error || result.status !== 0) throw new Error(`Tailwind ${theme} failed: ${result.error?.message || result.stderr}`);
        const bytes = fs.readFileSync(output);
        const target = path.join(root, 'assets', 'css', `tailwind-${theme}.css`);
        outputs.push({ target, bytes, theme });
    }
    for (const output of outputs) {
        if (check) {
            if (!fs.existsSync(output.target) || !fs.readFileSync(output.target).equals(output.bytes)) {
                throw new Error(`Stale compiled ${output.theme} CSS. Run npm run build:css and review the visual changes.`);
            }
        } else {
            fs.writeFileSync(output.target, output.bytes);
        }
        console.log(`${check ? 'PASS current' : 'BUILT'} ${path.relative(root, output.target)} ${output.bytes.length} bytes SHA256 ${crypto.createHash('sha256').update(output.bytes).digest('hex')}`);
    }
} finally {
    // Remove only files created under this invocation's newly allocated temp dir.
    for (const item of fs.readdirSync(temporary)) fs.unlinkSync(path.join(temporary, item));
    fs.rmdirSync(temporary);
}
