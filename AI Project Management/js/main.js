document.addEventListener('DOMContentLoaded', () => {
  const current = location.pathname.split('/').pop().toLowerCase();
  document.querySelectorAll('aside nav a').forEach(a => {
    if ((a.getAttribute('href') || '').toLowerCase() === current) a.setAttribute('aria-current', 'page');
    else a.removeAttribute('aria-current');
  });
});
