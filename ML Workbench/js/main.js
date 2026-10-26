// Notebook editing is local only until the explicit authenticated form POST succeeds.
document.addEventListener('DOMContentLoaded', () => {
    const add = document.getElementById('add-notebook-cell');
    const cells = document.getElementById('notebook-cells');
    const template = document.getElementById('notebook-cell-template');
    if (add && cells && template) {
        add.addEventListener('click', () => {
            cells.append(template.content.cloneNode(true));
            cells.lastElementChild.querySelector('textarea').focus();
        });
        cells.addEventListener('click', event => {
            const remove = event.target.closest('[data-remove-cell]');
            if (remove) remove.closest('[data-notebook-cell]').remove();
        });
    }
});
