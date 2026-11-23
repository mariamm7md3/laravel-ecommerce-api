document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('change', function (e) {
        if (!e.target.classList.contains('toggle-status')) return;

        const el = e.target;
        const url = el.dataset.url;
        const isCheckbox = el.type === 'checkbox';

        // نحفظ الحالة القديمة عشان نرجعها لو فشل الطلب
        const previousValue = isCheckbox ? el.checked : el.value;

        const options = {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        };

        // للـ select بس: نبعت القيمة الجديدة المختارة كـ body
        if (!isCheckbox) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify({ status: el.value });
        }

        fetch(url, options)
            .then(response => {
                if (!response.ok) throw new Error('Request failed');
                return response.json();
            })
            .then(data => {
                // خاص بـ sales (badge منفصلة عن الـ checkbox)
                const targetId = el.dataset.badgeTarget;
                if (targetId && data.badge_html) {
                    const badgeCell = document.getElementById(targetId);
                    if (badgeCell) badgeCell.innerHTML = data.badge_html;
                }

                // خاص بـ orders: نستبدل الـ select نفسه بالكامل
                if (data.dropdown_html) {
                    el.outerHTML = data.dropdown_html;
                }
            })
            .catch(() => {
                if (isCheckbox) {
                    el.checked = !previousValue;
                } else {
                    el.value = previousValue;
                }
                alert('حدث خطأ، حاولي مرة أخرى');
            });
    });
});
