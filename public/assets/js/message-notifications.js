document.addEventListener('DOMContentLoaded', function () {

    if (typeof window.Echo === 'undefined') {
        console.warn('Echo not initialized yet, retrying...');
        return;
    }

    const labels = window.messageNotificationLabels || {
        new_message: 'New Message',
    };

    // Truncate long message bodies so the toast stays a fixed, readable size.
    function truncate(text, maxLength) {
        if (!text) return '';
        return text.length > maxLength
            ? text.slice(0, maxLength).trim() + '...'
            : text;
    }

    window.Echo
        .private('admin-message-sent')
        .listen('.message.sent', function (data) {

            // Re-check dark mode and RTL on every toast, not just once
            // on page load, so a theme/direction toggle stays in sync.
            const isDark = document.documentElement.classList.contains('dark-style');
            const isRtl = document.documentElement.dir === 'rtl';

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 7000,
                timerProgressBar: true,

                background: isDark ? '#2b2c40' : '#ffffff',
                color: isDark ? '#d7d7f0' : '#566a7f',

                customClass: {
                    popup: 'order-toast-rect' + (isDark ? ' order-toast-dark' : ''),
                    htmlContainer: 'order-toast-text',
                    timerProgressBar: 'order-toast-progress',
                },

                showClass: {
                    popup: 'animate__animated animate__' + (isRtl ? 'fadeInLeft' : 'fadeInRight') + ' animate__faster',
                },

                hideClass: {
                    popup: 'animate__animated animate__' + (isRtl ? 'fadeOutLeft' : 'fadeOutRight') + ' animate__faster',
                },

                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                html: `
                    <div class="order-toast-body">
                        <div class="order-toast-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                                <path d="M4 4h16v14H5.17L4 19.17V4z" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 9h8M8 13h5" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div class="order-toast-content">
                            <div class="order-toast-top">
                                <p class="order-toast-title">${labels.new_message}</p>
                                <span class="order-toast-badge">
                                    <span class="dot"></span> NEW
                                </span>
                            </div>

                            <p class="order-toast-customer">${data.sender_name}</p>

                            <p class="order-toast-amount" style="font-size: 0.95rem;">
                                ${truncate(data.body, 60)}
                            </p>
                        </div>
                    </div>
                `,
            });

        });

});
