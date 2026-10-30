/**
 * VOSTOKPRIBOR AI Engineering Range
 * Auto-Collapsing Sidebar, Floating Tooltips & Accessible Mobile Drawer Controller
 */

(function () {
    'use strict';

    function initSidebar() {
        const sidebar = document.getElementById('vp-sidebar');
        const backdrop = document.getElementById('vp-sidebar-backdrop');
        const toggleBtn = document.getElementById('vp-sidebar-toggle');
        const closeBtn = document.getElementById('vp-sidebar-close');
        const mainContent = document.getElementById('vp-main-content');

        if (!sidebar) return;

        let hoverTimer = null;

        // ======================================================================
        // 1. Desktop Hover & Focus Expansion
        // ======================================================================
        sidebar.addEventListener('mouseenter', () => {
            if (window.innerWidth >= 1024) {
                clearTimeout(hoverTimer);
                sidebar.classList.add('is-hovered');
                hideFloatingTooltip();
            }
        });

        sidebar.addEventListener('mouseleave', () => {
            if (window.innerWidth >= 1024) {
                hoverTimer = setTimeout(() => {
                    sidebar.classList.remove('is-hovered');
                }, 80);
            }
        });

        sidebar.addEventListener('focusin', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('is-hovered');
                hideFloatingTooltip();
            }
        });

        sidebar.addEventListener('focusout', (e) => {
            if (window.innerWidth >= 1024) {
                if (!sidebar.contains(e.relatedTarget)) {
                    sidebar.classList.remove('is-hovered');
                }
            }
        });

        // ======================================================================
        // 2. Floating Unclipped Tooltip for Collapsed State (Phase 10)
        // ======================================================================
        let tooltipEl = document.getElementById('vp-sidebar-floating-tooltip');
        if (!tooltipEl) {
            tooltipEl = document.createElement('div');
            tooltipEl.id = 'vp-sidebar-floating-tooltip';
            tooltipEl.className = 'vp-floating-tooltip';
            tooltipEl.setAttribute('role', 'tooltip');
            tooltipEl.setAttribute('aria-hidden', 'true');
            document.body.appendChild(tooltipEl);
        }

        function showFloatingTooltip(item) {
            if (window.innerWidth < 1024) return;
            // Only show if sidebar is in collapsed mode (width <= 100px)
            if (sidebar.offsetWidth > 100 || sidebar.classList.contains('is-hovered')) return;

            const text = item.getAttribute('data-tooltip') || item.getAttribute('title') || '';
            if (!text) return;

            tooltipEl.textContent = text;
            const rect = item.getBoundingClientRect();
            const top = rect.top + (rect.height / 2) - 14;
            const left = rect.right + 12;

            tooltipEl.style.top = top + 'px';
            tooltipEl.style.left = left + 'px';
            tooltipEl.classList.add('is-visible');
        }

        function hideFloatingTooltip() {
            if (tooltipEl) {
                tooltipEl.classList.remove('is-visible');
            }
        }

        const navItems = sidebar.querySelectorAll('.vp-sidebar-item');
        navItems.forEach((item) => {
            item.addEventListener('mouseenter', () => showFloatingTooltip(item));
            item.addEventListener('mouseleave', hideFloatingTooltip);
            item.addEventListener('focus', () => showFloatingTooltip(item));
            item.addEventListener('blur', hideFloatingTooltip);
        });

        // ======================================================================
        // 3. Accessible Mobile Drawer (Phase 11)
        // ======================================================================
        function getFocusableElements(container) {
            return container.querySelectorAll(
                'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
            );
        }

        function openDrawer() {
            sidebar.classList.add('is-mobile-open');
            if (backdrop) backdrop.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
            if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
            if (mainContent) mainContent.setAttribute('aria-hidden', 'true');

            // Move focus into the drawer
            const focusables = getFocusableElements(sidebar);
            if (focusables.length > 0) {
                const activeItem = sidebar.querySelector('.vp-sidebar-item.is-active') || focusables[0];
                setTimeout(() => activeItem.focus(), 50);
            }
        }

        function closeDrawer() {
            sidebar.classList.remove('is-mobile-open');
            if (backdrop) backdrop.classList.remove('is-visible');
            document.body.style.overflow = '';
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.focus();
            }
            if (mainContent) mainContent.removeAttribute('aria-hidden');
            hideFloatingTooltip();
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

        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                closeDrawer();
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeDrawer);
        }

        // Keyboard Trap & Escape handler
        document.addEventListener('keydown', (e) => {
            if (!sidebar.classList.contains('is-mobile-open')) return;

            if (e.key === 'Escape') {
                e.preventDefault();
                closeDrawer();
                return;
            }

            // Focus trap within mobile drawer
            if (e.key === 'Tab') {
                const focusables = getFocusableElements(sidebar);
                if (focusables.length === 0) return;

                const firstEl = focusables[0];
                const lastEl = focusables[focusables.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === firstEl) {
                        e.preventDefault();
                        lastEl.focus();
                    }
                } else {
                    if (document.activeElement === lastEl) {
                        e.preventDefault();
                        firstEl.focus();
                    }
                }
            }
        });

        // Close mobile drawer when clicking any navigation link
        navItems.forEach((item) => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeDrawer();
                }
            });
        });

        // Auto close when resizing to desktop
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
