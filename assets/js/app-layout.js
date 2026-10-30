/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Application Layout Master Script
 */

(function () {
    'use strict';
    const script = document.currentScript?.src;
    const base = script ? new URL('../..', script).pathname.replace(/\/$/, '') : '';

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
<<<<<<< Updated upstream
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
=======
>>>>>>> Stashed changes
                }
                e.preventDefault();
                let dialog = document.getElementById('vp-notification-dialog');
                if (!dialog) {
                    dialog = document.createElement('dialog');
                    dialog.id = 'vp-notification-dialog';
                    dialog.className = 'vp-card w-full max-w-lg max-h-[80vh] overflow-auto';
                    const heading = document.createElement('h2');
                    heading.className = 'vp-card-title'; heading.textContent = 'Notifications';
                    const close = document.createElement('button');
                    close.className = 'vp-btn vp-btn-secondary float-right';close.textContent = 'Close';close.onclick = () => dialog.close();
                    const list = document.createElement('div');list.dataset.notificationList='';list.className='space-y-4 mt-4';
                    dialog.append(close,heading,list);document.body.append(dialog);
                }
                dialog.showModal();
                const list=dialog.querySelector('[data-notification-list]');list.textContent='Loading notifications…';
                fetch(base+'/api/v1/project/notifications',{credentials:'same-origin',headers:{Accept:'application/json'}})
                    .then(async response=>{const json=await response.json();if(!response.ok||!json.success)throw new Error(json.error?.message||'Notifications unavailable.');return json.data;})
                    .then(rows=>{list.textContent='';if(!rows.length){list.textContent='No notifications';return;}rows.forEach(row=>{const item=document.createElement('article');item.className='p-3 rounded-lg border border-[#F5DEB3]';const title=document.createElement('strong');title.textContent=row.title;const body=document.createElement('p');body.textContent=row.message;const time=document.createElement('small');time.textContent=row.created_at;item.append(title,body,time);list.append(item);});})
                    .catch(error=>{list.textContent=error.message;});
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLayout);
    } else {
        initLayout();
    }
})();
