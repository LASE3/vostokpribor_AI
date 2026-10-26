// This filter only changes navigation visibility; no work records are persisted in the browser.
document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('system-search');
    if (!search) return;
    search.addEventListener('input', () => {
        const term = search.value.toLocaleLowerCase().trim();
        document.querySelectorAll('#systems-grid > div').forEach(card => {
            card.hidden = Boolean(term) && !card.textContent.toLocaleLowerCase().includes(term);
        });
    });
});
