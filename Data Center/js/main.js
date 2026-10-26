document.addEventListener('DOMContentLoaded', () => {
  const current = location.pathname.split('/').pop().toLowerCase();
  document.querySelectorAll('aside nav a').forEach(a => {
    if ((a.getAttribute('href') || '').toLowerCase() === current) a.setAttribute('aria-current', 'page');
    else a.removeAttribute('aria-current');
  });
});
// Filter only rows already authorized and rendered by the server; this does not execute SQL.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-range-search]').forEach(input => {
    input.addEventListener('input', () => {
      const term = input.value.toLocaleLowerCase().trim();
      document.querySelectorAll('main tbody tr').forEach(row => {
        row.hidden = Boolean(term) && !row.textContent.toLocaleLowerCase().includes(term);
      });
    });
  });
});
