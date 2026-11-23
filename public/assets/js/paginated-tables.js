document.addEventListener('DOMContentLoaded', function () {

    // Loop over every table that follows the pagination convention.
    // Each table gets its own isolated state (rows, pagination, currentPage)
    // so multiple tables on the same page never interfere with each other.
    document.querySelectorAll('.paginated-table').forEach(function (table) {

        // Look for the pagination <ul> inside the same card as the table.
        const card = table.closest('.card');
        const paginationWrapper = card ? card.querySelector('.paginated-nav') : null;

        if (!paginationWrapper) {
            return;
        }

        const rows = Array.from(table.querySelectorAll('.paginated-row'));

        if (rows.length === 0) {
            return;
        }

        const totalPages = Math.max(...rows.map(row => parseInt(row.dataset.page, 10)));
        let currentPage = 1;

        function showPage(page) {
            currentPage = page;

            rows.forEach(row => {
                const rowPage = parseInt(row.dataset.page, 10);

                if (rowPage === page) {
                    row.style.display = '';
                    row.classList.remove('popular-fade-in');
                    // force reflow so the animation restarts every time
                    void row.offsetWidth;
                    row.classList.add('popular-fade-in');
                } else {
                    row.style.display = 'none';
                }
            });

            paginationWrapper.querySelectorAll('[data-page-link]').forEach(item => {
                const itemPage = parseInt(item.dataset.pageLink, 10);
                item.classList.toggle('active', itemPage === page);
            });

            const prevItem = paginationWrapper.querySelector('[data-action="prev"]');
            const nextItem = paginationWrapper.querySelector('[data-action="next"]');

            if (prevItem) prevItem.classList.toggle('disabled', page === 1);
            if (nextItem) nextItem.classList.toggle('disabled', page === totalPages);
        }

        paginationWrapper.querySelectorAll('[data-page-link]').forEach(item => {
            const link = item.querySelector('.page-link');
            if (!link) return;

            link.addEventListener('click', function (e) {
                e.preventDefault();
                const page = parseInt(item.dataset.pageLink, 10);
                if (page !== currentPage) {
                    showPage(page);
                }
            });
        });

        const prevItem = paginationWrapper.querySelector('[data-action="prev"]');
        const nextItem = paginationWrapper.querySelector('[data-action="next"]');

        if (prevItem) {
            prevItem.querySelector('.page-link').addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            });
        }

        if (nextItem) {
            nextItem.querySelector('.page-link').addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    showPage(currentPage + 1);
                }
            });
        }

        // initial state
        showPage(1);
    });
});
