// Notebook editing is local only until the explicit authenticated form POST succeeds.
document.addEventListener('DOMContentLoaded', () => {
    const add = document.getElementById('add-notebook-cell');
    const cells = document.getElementById('notebook-cells');
    const template = document.getElementById('notebook-cell-template');
    if (add && cells && template) {
        if (add.dataset.cellsBound === 'true') return;
        add.dataset.cellsBound = 'true';
        add.addEventListener('click', () => {
            cells.append(template.content.cloneNode(true));
            cells.lastElementChild.querySelector('textarea').focus();
        });
        cells.addEventListener('click', event => {
            const remove = event.target.closest('[data-remove-cell]');
            if (remove) remove.closest('[data-notebook-cell]').remove();
        });
    }
    const editor = document.getElementById('notebook-editor');
    if (!editor || editor.dataset.saveBound === 'true' || editor.elements.expected_version?.disabled) return;
    editor.dataset.saveBound = 'true';
    const readCells = () => [...editor.querySelectorAll('[data-notebook-cell]')].map(cell => ({
        source: cell.querySelector('textarea[name="source[]"]').value,
        cell_type: cell.querySelector('select[name="cell_type[]"]').value
    }));
    editor.addEventListener('submit', async event => {
        if (!window.RangeClient) return; // Protected version-aware HTML POST fallback.
        event.preventDefault();
        if (editor.dataset.saving === 'true') return;
        const status = editor.querySelector('[data-notebook-save-status]');
        const buttons = [...editor.querySelectorAll('button')].map(button => ({button, disabled:button.disabled}));
        editor.dataset.saving = 'true';
        buttons.forEach(({button}) => { button.disabled = true; });
        try {
            const version = Number(editor.elements.expected_version.value);
            if (!Number.isInteger(version) || version < 1) throw new Error('Copy your code, then reload the notebook to obtain its saved version.');
            const snapshot = readCells();
            if (status) status.textContent = 'Saving notebook snapshot…';
            const result = await window.RangeClient.patch('workbench/notebooks/' + Number(editor.elements.notebook_id.value), {cells:snapshot, expected_version:version});
            if (!result.success) throw new Error(result.error?.code === 'CONFLICT'
                ? 'Another editor changed this notebook. Your code is preserved. Copy your changes, then reload the latest notebook before saving again.'
                : result.error?.message || 'No notebook save was confirmed.');
            const savedVersion = Number(result.data?.version);
            if (!Number.isInteger(savedVersion) || savedVersion < 1) throw new Error('Save was confirmed, but its new version is unavailable. Copy your changes and reload before saving again.');
            editor.elements.expected_version.value = savedVersion;
            const label = document.querySelector('[data-notebook-version-label]');
            if (label) label.textContent = 'Version ' + savedVersion + (result.data.status ? ' · ' + result.data.status : '');
            const updated = document.querySelector('[data-notebook-updated]');
            if (updated && result.data.updated_at) updated.textContent = 'Last persisted: ' + result.data.updated_at;
            if (status) status.textContent = JSON.stringify(readCells()) === JSON.stringify(snapshot)
                ? 'Notebook saved. Isolated execution unavailable.' : 'Snapshot saved. Your newer edits still need saving.';
            window.RangeClient.showToast('Notebook snapshot saved.');
        } catch (error) {
            if (status) status.textContent = error.message;
            window.RangeClient.showToast(error.message, 'error');
        } finally {
            editor.dataset.saving = 'false';
            buttons.forEach(({button,disabled}) => { button.disabled = disabled; });
        }
    });
});
