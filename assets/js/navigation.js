/**
 * VOSTOKPRIBOR AI Engineering Range
 * Navigation & Authoritative Active Route Controller (Phase 13)
 */

(function () {
    'use strict';

    function initNavigation() {
        const sidebarLinks = Array.from(document.querySelectorAll('.vp-sidebar-item'));
        if (sidebarLinks.length === 0) return;

        // Check if server already provided an authoritative active state
        const serverActive = sidebarLinks.find((link) => link.classList.contains('is-active'));
        if (serverActive) {
            // Ensure aria-current is properly set and no other link is active
            sidebarLinks.forEach((link) => {
                if (link === serverActive) {
                    link.setAttribute('aria-current', 'page');
                } else {
                    link.classList.remove('is-active');
                    link.removeAttribute('aria-current');
                }
            });
            return;
        }

        // Otherwise resolve client-side filename with alias support
        let currentFile = window.location.pathname.split('/').pop().toLowerCase();
        if (!currentFile || currentFile === '') {
            currentFile = 'index.php';
        }

        // Aliases mapping
        const aliases = {
            'scenariomanagement.php': 'ticketsandscenarios.php',
            'scenarios.php': 'ticketsandscenarios.php'
        };
        const targetFile = aliases[currentFile] || currentFile;

        let matched = false;
        sidebarLinks.forEach((link) => {
            const href = (link.getAttribute('href') || '').toLowerCase();
            const linkFile = href.split('?')[0].split('#')[0].split('/').pop();

            if (!matched && (linkFile === targetFile || linkFile === currentFile)) {
                link.classList.add('is-active');
                link.setAttribute('aria-current', 'page');
                matched = true;
            } else {
                link.classList.remove('is-active');
                link.removeAttribute('aria-current');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavigation);
    } else {
        initNavigation();
    }
})();
