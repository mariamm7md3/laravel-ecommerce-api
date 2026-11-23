document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function (e) {
        const form = e.target.closest('.delete-form');
        if (!form) return;

        e.preventDefault();

        const message = form.dataset.message || 'Are you sure you want to delete this item?';

        Swal.fire({
            html: `
                <div class="swal-delete-icon-wrapper">
                    <i class="ti ti-trash"></i>
                </div>
                <h3 class="swal-delete-title">${message}</h3>
                <p class="swal-delete-text mb-0">This action cannot be undone.</p>
            `,

            showCancelButton: true,
            reverseButtons: true,

            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',

            buttonsStyling: false,

            customClass: {
                popup: 'swal-delete-popup',
                actions: 'swal-delete-actions',
                confirmButton: 'swal-delete-confirm-btn',
                cancelButton: 'swal-delete-cancel-btn',
            },

            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster',
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster',
            },

        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
