// Registry mutations use authenticated server forms. No fabricated inference or traffic telemetry.
document.addEventListener('DOMContentLoaded', () => {
    let initialized = false;
    document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(form => {
        if (form.dataset.uploadBound === 'true') return;
        form.dataset.uploadBound = 'true';
        initialized = true;
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (button) button.setAttribute('aria-busy', 'true');
        });
    });
    if (initialized) window.addEventListener('pageshow', () => document.querySelectorAll('button[aria-busy="true"]').forEach(button => button.removeAttribute('aria-busy')));
});
