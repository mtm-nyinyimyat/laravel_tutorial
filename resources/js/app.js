document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toast]').forEach((toast) => {
        window.setTimeout(() => {
            toast.classList.add('opacity-0');

            window.setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    });

    const dialog = document.getElementById('confirm-delete-dialog');
    const message = document.getElementById('confirm-delete-message');

    if (! dialog || ! message) {
        return;
    }

    const askForConfirmation = (text) => new Promise((resolve) => {
        message.textContent = text;

        const onClose = () => {
            dialog.removeEventListener('close', onClose);
            resolve(dialog.returnValue === 'confirm');
        };

        dialog.addEventListener('close', onClose);
        dialog.returnValue = 'cancel';
        dialog.showModal();
    });

    document.addEventListener('submit', async (event) => {
        const form = event.target.closest('form[data-confirm-delete]');

        if (! form || form.dataset.confirmed === 'true') {
            return;
        }

        event.preventDefault();

        const confirmed = await askForConfirmation(
            form.dataset.confirmDelete || 'Are you sure you want to delete this?',
        );

        if (! confirmed) {
            return;
        }

        form.dataset.confirmed = 'true';
        form.requestSubmit();
    });
});
