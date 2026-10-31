(function () {
function initWorkspaceForms() {
    document.querySelectorAll('form[data-soc-api]').forEach(form => {
        if (form.dataset.socBound === 'true') return;
        form.dataset.socBound = 'true';
        form.addEventListener('submit', async event => {
            if (!window.RangeClient) return;
            event.preventDefault();
            if (form.dataset.saving === 'true') return;
            const buttons=[...form.querySelectorAll('button[type="submit"],button:not([type])')].map(button=>({button,disabled:button.disabled,text:button.textContent}));
            form.dataset.saving='true';
            buttons.forEach(({button})=>{button.disabled=true;button.textContent='Saving…';});
            try {
                const payload=Object.fromEntries(new FormData(form).entries());
                // CSRF is sent in the shared transport header, not the business JSON.
                delete payload.csrf_token;
                const result=await window.RangeClient.request(form.dataset.socApi,{method:form.dataset.socMethod||'POST',body:JSON.stringify(payload)});
                if (!result?.success) throw new Error(result?.error?.message||'Request failed. No save was confirmed.');
                window.RangeClient.showToast(result.message||'Persisted successfully.');
                location.reload();
            } catch (error) {
                window.RangeClient.showToast(error.message||'No save was confirmed. Check the server before retrying.','error');
            } finally {
                form.dataset.saving='false';
                buttons.forEach(({button,disabled,text})=>{button.disabled=disabled;button.textContent=text;});
            }
        });
    });
}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',initWorkspaceForms);else initWorkspaceForms();
})();
