document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-soc-api]').forEach(form => {
        form.addEventListener('submit', async event => {
            event.preventDefault();
            const button=form.querySelector('button[type="submit"],button:not([type])');
            const original=button?.textContent;
            if(button){button.disabled=true;button.textContent='Saving…';}
            const payload=Object.fromEntries(new FormData(form).entries());
            const result=await window.RangeClient.request(form.dataset.socApi,{method:form.dataset.socMethod||'POST',body:JSON.stringify(payload)});
            if(result?.success){window.RangeClient.showToast(result.message||'Persisted successfully.');location.reload();}
            else{window.RangeClient.showToast(result?.error?.message||'Request failed. Nothing was reported as saved.','error');if(button){button.disabled=false;button.textContent=original;}}
        });
    });
});
