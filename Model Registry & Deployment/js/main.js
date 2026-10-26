// Registry mutations use authenticated server forms. No fabricated inference or traffic telemetry.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(form => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (button) button.setAttribute('aria-busy', 'true');
        });
    });
});
