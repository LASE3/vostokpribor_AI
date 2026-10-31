/** Shared layout interactions; approved notification popover and sidebar remain intact. */
(function () {
    'use strict';
    const script = document.currentScript?.src;
    const base = script ? new URL('../..', script).pathname.replace(/\/$/, '') : '';
    function initLayout() {
        const skipLink=document.querySelector('.vp-skip-link'),main=document.getElementById('vp-main-content');
        if(skipLink&&main&&skipLink.dataset.layoutBound!=='true'){skipLink.dataset.layoutBound='true';skipLink.addEventListener('click',event=>{event.preventDefault();main.setAttribute('tabindex','-1');main.focus();});}
        const container=document.getElementById('vp-notif-container'),button=document.getElementById('vp-notif-btn'),popover=document.getElementById('vp-notif-popover');
        if(!button||!popover)return;
        if(button.dataset.layoutBound==='true')return;
        button.dataset.layoutBound='true';
        const body=popover.querySelector('.vp-notif-body');
        if(body)body.textContent='Open to load notifications from the server.';
        let sequence=0,currentController=null;
        const close=()=>{sequence++;currentController?.abort();currentController=null;popover.classList.remove('is-open');popover.setAttribute('aria-hidden','true');button.setAttribute('aria-expanded','false');};
        async function load() {
            if(!body)return;
            currentController?.abort();
            const controller=new AbortController(),requestId=++sequence;
            currentController=controller;
            const current=()=>requestId===sequence&&popover.classList.contains('is-open');
            const configured=Number(window.VOSTOK_API_TIMEOUT_MS),timeoutMs=Number.isFinite(configured)&&configured>0?Math.min(600000,configured):15000;
            let timedOut=false,onAbort;
            const cancelled=new Promise((_,reject)=>{onAbort=()=>reject(new Error(timedOut?'Notifications timed out. Open the panel to try again.':'Request cancelled.'));controller.signal.addEventListener('abort',onAbort,{once:true});});
            const timer=setTimeout(()=>{timedOut=true;controller.abort();},timeoutMs);
            body.textContent='Loading notifications…';
            try {
                // Some legacy layout pages omit RangeClient; keep their existing
                // read-only transport bounded without adding another API client.
                const transport=window.RangeClient
                    ?window.RangeClient.get('project/notifications',{}, {signal:controller.signal,timeoutMs})
                    :(async()=>{const response=await fetch(base+'/api/v1/project/notifications',{credentials:'same-origin',headers:{Accept:'application/json'},signal:controller.signal,redirect:'error'});const result=await response.json();if(!response.ok)throw new Error(result.error?.message||'Notifications unavailable.');return result;})();
                const result=await Promise.race([transport,cancelled]);
                if(!current())return;
                if(!result.success||!Array.isArray(result.data))throw new Error(result.error?.message||'Notifications unavailable.');
                body.replaceChildren();
                if(!result.data.length){body.textContent='No notifications';return;}
                result.data.forEach(row=>{
                    const item=document.createElement('article');item.className='p-3 border-b border-border text-xs';
                    const title=document.createElement('strong');title.className='block text-primary';title.textContent=row.title;
                    const message=document.createElement('p');message.textContent=row.message;
                    const time=document.createElement('small');time.className='text-slate-500';time.textContent=row.created_at;
                    item.append(title,message,time);body.append(item);
                });
            }catch(error){if(current())body.textContent=error.message||'Notifications unavailable.';}
            finally{clearTimeout(timer);controller.signal.removeEventListener('abort',onAbort);if(currentController===controller)currentController=null;}
        }
        button.addEventListener('click',event=>{
            event.preventDefault();event.stopPropagation();
            if(popover.classList.contains('is-open')){close();return;}
            popover.classList.add('is-open');popover.setAttribute('aria-hidden','false');button.setAttribute('aria-expanded','true');load();
        });
        document.addEventListener('click',event=>{if(container&&!container.contains(event.target))close();});
        document.addEventListener('keydown',event=>{if(event.key==='Escape'&&popover.classList.contains('is-open')){close();button.focus();}});
        window.addEventListener?.('pagehide',close);
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',initLayout);else initLayout();
})();
