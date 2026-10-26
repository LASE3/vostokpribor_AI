/**
 * VOSTOKPRIBOR AI Engineering Range
 * Navigation & Active State Controller
 */

(function () {
    'use strict';

    function initNavigation() {
        const currentFile = window.location.pathname.split('/').pop().toLowerCase();
        const sidebarLinks = document.querySelectorAll('.vp-sidebar-item');

        sidebarLinks.forEach((link) => {
            const href = (link.getAttribute('href') || '').toLowerCase();
            const linkFile = href.split('?')[0].split('/').pop();

            if (linkFile === currentFile) {
                link.classList.add('is-active');
                link.setAttribute('aria-current', 'page');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavigation);
    } else {
        initNavigation();
    }
})();
