/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Application Layout Master Script
 */

(function () {
    'use strict';

    function initLayout() {
        // Accessibility: ensure skip-to-content works smoothly
        const skipLink = document.querySelector('.vp-skip-link');
        const mainContent = document.getElementById('vp-main-content');
        if (skipLink && mainContent) {
            skipLink.addEventListener('click', (e) => {
                e.preventDefault();
                mainContent.setAttribute('tabindex', '-1');
                mainContent.focus();
            });
        }

        // Notification button click handler
        const notifBtn = document.getElementById('vp-notif-btn');
        if (notifBtn) {
            notifBtn.addEventListener('click', (e) => {
                // If on a page with notifications table (e.g. Student Profile / Dashboard), smooth scroll or toast
                const notifSection = document.getElementById('notifications-section') || document.querySelector('[data-path="notifications"]');
                if (notifSection) {
                    e.preventDefault();
                    notifSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLayout);
    } else {
        initLayout();
    }
})();
