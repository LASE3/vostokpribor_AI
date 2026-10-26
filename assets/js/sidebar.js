/**
 * VOSTOKPRIBOR AI Engineering Range
 * Auto-Collapsing Sidebar & Responsive Drawer Controller
 */

(function () {
    'use strict';

    function initSidebar() {
        const sidebar = document.getElementById('vp-sidebar');
        const backdrop = document.getElementById('vp-sidebar-backdrop');
        const toggleBtn = document.getElementById('vp-sidebar-toggle');

        if (!sidebar) return;

        let hoverTimer = null;

        // Desktop Smooth Hover Handling (prevents flicker on fast mouse motion)
        sidebar.addEventListener('mouseenter', () => {
            if (window.innerWidth >= 1024) {
                clearTimeout(hoverTimer);
                sidebar.classList.add('is-hovered');
            }
        });

        sidebar.addEventListener('mouseleave', () => {
            if (window.innerWidth >= 1024) {
                hoverTimer = setTimeout(() => {
                    sidebar.classList.remove('is-hovered');
                }, 80);
            }
        });

        // Keyboard Focus Accessibility (expands sidebar when tabbing inside)
        sidebar.addEventListener('focusin', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('is-hovered');
            }
        });

        sidebar.addEventListener('focusout', (e) => {
            if (window.innerWidth >= 1024) {
                // If the newly focused element is not inside the sidebar, collapse
                if (!sidebar.contains(e.relatedTarget)) {
                    sidebar.classList.remove('is-hovered');
                }
            }
        });

        // Mobile / Tablet Drawer Toggle
        function openDrawer() {
            sidebar.classList.add('is-mobile-open');
            if (backdrop) backdrop.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
            if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
        }

        function closeDrawer() {
            sidebar.classList.remove('is-mobile-open');
            if (backdrop) backdrop.classList.remove('is-visible');
            document.body.style.overflow = '';
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.focus();
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (sidebar.classList.contains('is-mobile-open')) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeDrawer);
        }

        // Close on Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('is-mobile-open')) {
                closeDrawer();
            }
        });

        // Close mobile drawer when clicking any navigation link
        sidebar.querySelectorAll('.vp-sidebar-item').forEach((item) => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeDrawer();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && sidebar.classList.contains('is-mobile-open')) {
                closeDrawer();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
})();
