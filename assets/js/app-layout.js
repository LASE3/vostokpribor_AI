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

        // Notification Popover Controller (Phase 12)
        const notifContainer = document.getElementById('vp-notif-container');
        const notifBtn = document.getElementById('vp-notif-btn');
        const notifPopover = document.getElementById('vp-notif-popover');

        function openPopover() {
            if (!notifPopover) return;
            notifPopover.classList.add('is-open');
            notifPopover.setAttribute('aria-hidden', 'false');
            if (notifBtn) notifBtn.setAttribute('aria-expanded', 'true');
        }

        function closePopover() {
            if (!notifPopover) return;
            notifPopover.classList.remove('is-open');
            notifPopover.setAttribute('aria-hidden', 'true');
            if (notifBtn) notifBtn.setAttribute('aria-expanded', 'false');
        }

        if (notifBtn && notifPopover) {
            notifBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                // If on a page with embedded notifications table (e.g. Student Profile), also scroll
                const notifSection = document.getElementById('notifications-section') || document.querySelector('[data-path="notifications"]');
                if (notifSection && window.location.hash === '#notifications') {
                    notifSection.scrollIntoView({ behavior: 'smooth' });
                    return;
                }

                if (notifPopover.classList.contains('is-open')) {
                    closePopover();
                } else {
                    openPopover();
                }
            });

            // Close on click outside
            document.addEventListener('click', (e) => {
                if (notifContainer && !notifContainer.contains(e.target)) {
                    closePopover();
                }
            });

            // Close on Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && notifPopover.classList.contains('is-open')) {
                    closePopover();
                    notifBtn.focus();
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
