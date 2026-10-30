/* Dataset forms share RangeClient and the same services as their PHP POST fallback. */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-dataset-api]').forEach(form => {
        form.addEventListener('submit', async event => {
            if (!window.RangeClient) return; // The protected PHP form remains functional without JS.
            event.preventDefault();
            if (form.dataset.saving === 'true') return;
            const fields = new FormData(form);
            let endpoint = form.dataset.datasetApi;
            if (endpoint.includes('{dataset_id}')) {
                const id = String(fields.get('dataset_id') || '');
                if (!/^[1-9][0-9]*$/.test(id)) {
                    window.RangeClient.showToast('Choose a dataset.', 'error');
                    return;
                }
                endpoint = endpoint.replace('{dataset_id}', id);
            }
            const button = form.querySelector('button[type="submit"]');
            const original = button?.textContent;
            form.dataset.saving = 'true';
            if (button) { button.disabled = true; button.textContent = 'Saving…'; }
            let status = form.querySelector('[data-save-status]');
            if (!status) {
                status = document.createElement('p');
                status.dataset.saveStatus = 'true';
                status.setAttribute('role', 'status');
                status.className = 'text-xs text-slate-600';
                form.appendChild(status);
            }
            status.textContent = 'Saving to the server…';
            try {
                let result;
                if (form.enctype === 'multipart/form-data') result = await window.RangeClient.upload(endpoint, fields);
                else {
                    const payload = Object.fromEntries(fields.entries());
                    delete payload.action;
                    const method = form.dataset.datasetMethod || 'POST';
                    result = method === 'PATCH'
                        ? await window.RangeClient.patch(endpoint, payload)
                        : await window.RangeClient.post(endpoint, payload);
                }
                if (!result || result.success !== true) throw new Error(result?.error?.message || 'No changes were confirmed by the server.');
                status.textContent = result.message || 'Changes saved.';
                window.RangeClient.showToast(status.textContent);
                const id = result.data?.dataset_id || fields.get('dataset_id') || fields.get('source_dataset_id') || result.data?.id;
                const next = new URL(location.href);
                if (id && /^[1-9][0-9]*$/.test(String(id))) next.searchParams.set('id', String(id));
                else next.searchParams.delete('id');
                next.searchParams.delete('version_id');
                location.assign(next.href);
            } catch (error) {
                status.textContent = error.message || 'Saving failed; your input has been preserved.';
                window.RangeClient.showToast(status.textContent, 'error');
            } finally {
                form.dataset.saving = 'false';
                if (button) { button.disabled = false; button.textContent = original; }
            }
        });
    });
    // Display filtering only; rows were already authorized on the server.
    document.querySelectorAll('[data-range-search]').forEach(input => {
        input.addEventListener('input', () => {
            const term = input.value.trim().toLocaleLowerCase();
            document.querySelectorAll('main tbody tr').forEach(row => { row.hidden = !!term && !row.textContent.toLocaleLowerCase().includes(term); });
        });
    });
});
