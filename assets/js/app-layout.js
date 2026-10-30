/** Shared layout interactions; approved notification popover and sidebar remain intact. */
(function () {
    'use strict';
    const script = document.currentScript?.src;
    const base = script ? new URL('../..', script).pathname.replace(/\/$/, '') : '';
    function initLayout() {
        const skipLink=document.querySelector('.vp-skip-link'),main=document.getElementById('vp-main-content');
        if(skipLink&&main)skipLink.addEventListener('click',event=>{event.preventDefault();main.setAttribute('tabindex','-1');main.focus();});
        const container=document.getElementById('vp-notif-container'),button=document.getElementById('vp-notif-btn'),popover=document.getElementById('vp-notif-popover');
        if(!button||!popover)return;
        const body=popover.querySelector('.vp-notif-body');
        if(body)body.textContent='Open to load notifications from the server.';
        const close=()=>{popover.classList.remove('is-open');popover.setAttribute('aria-hidden','true');button.setAttribute('aria-expanded','false');};
        async function load() {
            if(!body)return;body.textContent='Loading notifications…';
            try {
                const response=await fetch(base+'/api/v1/project/notifications',{credentials:'same-origin',headers:{Accept:'application/json'}});
                const result=await response.json();
                if(!response.ok||!result.success||!Array.isArray(result.data))throw new Error(result.error?.message||'Notifications unavailable.');
                body.replaceChildren();
                if(!result.data.length){body.textContent='No notifications';return;}
                result.data.forEach(row=>{
                    const item=document.createElement('article');item.className='p-3 border-b border-border text-xs';
                    const title=document.createElement('strong');title.className='block text-primary';title.textContent=row.title;
                    const message=document.createElement('p');message.textContent=row.message;
                    const time=document.createElement('small');time.className='text-slate-500';time.textContent=row.created_at;
                    item.append(title,message,time);body.append(item);
                });
            }catch(error){body.textContent=error.message;}
        }
        button.addEventListener('click',event=>{
            event.preventDefault();event.stopPropagation();
            if(popover.classList.contains('is-open')){close();return;}
            popover.classList.add('is-open');popover.setAttribute('aria-hidden','false');button.setAttribute('aria-expanded','true');load();
        });
        document.addEventListener('click',event=>{if(container&&!container.contains(event.target))close();});
        document.addEventListener('keydown',event=>{if(event.key==='Escape'&&popover.classList.contains('is-open')){close();button.focus();}});
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',initLayout);else initLayout();
})();
