# Compiled utility assets

The PHP installation serves committed `assets/css/tailwind-shared.css` and `tailwind-portal.css`. Node and npm are build tools only; Apache never invokes them. Google Fonts and Material Symbols remain external HTTPS font/style dependencies allowed by the application security policy.

The compiler is pinned to Tailwind **3.4.17**, exactly the version observed behind the previous `https://cdn.tailwindcss.com` redirect. The two build configurations preserve the original shared and portal themes, including JetBrains Mono versus IBM Plex Mono. Existing layout CSS, colors and markup remain authoritative; compiled utilities load before those overrides.

From the project root, install only the reviewed lockfile and rebuild:

```powershell
npm.cmd ci --ignore-scripts
npm.cmd run build:css
npm.cmd run check:css
npm.cmd run test:assets
```

`check:css` compiles into a newly allocated OS temporary directory, compares both outputs byte for byte and removes only its own temporary files. It never accesses a database or private student storage. `test:assets` checks all recognized utility selectors in shipped PHP/JS templates, both themes, interaction states and load order. Run the real HTTP/browser regression after a build change.

Content roots are explicit in `tailwind.content.cjs`; private uploads, notebook source, logs, SQL exports, tests and generated verification are never scanned. Current state-dependent utility classes are complete literals inside source conditionals, so the scanner includes both states. Add complete literal classes or an explicitly reviewed safelist when implementing a new dynamically constructed class. User-authored text must never be treated as arbitrary UI CSS.

Five obsolete system-specific `js/tailwind.config.js` files had no loader/import references and used alternate unused themes. They were removed only after the active themes and reference graph were verified; their historical versions remain in Git. No active PHP service, layout stylesheet or business feature was removed.

The source ZIP includes the generated styles, lockfile, build configurations, tests and this guide. It excludes `node_modules`, caches and verification output. Tailwind's MIT notice is retained in `assets/css/TAILWIND_LICENSE.txt`. Transitive build packages are not redistributed as a vendor bundle; lockfile license metadata and integrity hashes identify the build inputs.
