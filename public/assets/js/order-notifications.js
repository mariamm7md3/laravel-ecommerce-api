document.addEventListener('DOMContentLoaded', function () {

    if (typeof window.Echo === 'undefined') {
        console.warn('Echo not initialized yet, retrying...');
        return;
    }

    const labels = window.orderNotificationLabels || {
        new_order: 'New Order',
        currency: 'EGP',
    };

    window.Echo
        .private('admin-orders')
        .listen('.order.created', function (data) {

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
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M4 12.5L9.5 18L20 6" stroke="#fff" stroke-width="3"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="order-toast-content">
                            <div class="order-toast-top">
                                <p class="order-toast-title">${labels.new_order} #${data.order_id}</p>
                                <span class="order-toast-badge">
                                    <span class="dot"></span> NEW
                                </span>
                            </div>

                            <p class="order-toast-customer">${data.customer_name}</p>

                            <div class="order-toast-amount">
                                ${data.total} <span>${labels.currency}</span>
                            </div>

                            <span class="order-toast-branch">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/>
                                    <circle cx="12" cy="10" r="2.5"/>
                                </svg>
                                ${data.branch_name}
                            </span>
                        </div>
                    </div>
                `,
            });

        });

});
