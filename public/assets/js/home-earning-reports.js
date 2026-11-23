document.addEventListener('DOMContentLoaded', function () {
    const data = window.earningReportsChart;
    if (!data) return;

    const colors = {
        orders: '#696cff',
        sales: '#03c3ec',
        profit: '#ffab00',
    };

    function buildConfig(seriesData, color) {
        return {
            chart: {
                height: 300,
                type: 'bar',
                toolbar: { show: false },
                parentHeightOffset: 0,
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '40%',
                },
            },
            dataLabels: { enabled: false },
            series: [{ name: 'Total', data: seriesData }],
            xaxis: {
                categories: data.months,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#a1a5b7',
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: (val) => Math.round(val),
                    style: {
                        colors: '#a1a5b7',
                    },
                },
            },
            colors: [color],
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.08)',
                strokeDashArray: 4,
            },
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'dark',
            },
        };
    }

    const charts = {};

    function renderChartIfNeeded(key, elId, seriesData, color) {
        if (charts[key]) return;

        const el = document.querySelector(elId);
        if (!el) return;

        const chart = new ApexCharts(el, buildConfig(seriesData, color));
        chart.render();
        charts[key] = chart;
    }


    renderChartIfNeeded('orders', '#earningReportsTabsOrders', data.orders, colors.orders);


    document.querySelectorAll('[data-bs-target="#navs-sales-id"]').forEach((tabBtn) => {
        tabBtn.addEventListener('shown.bs.tab', function () {
            renderChartIfNeeded('sales', '#earningReportsTabsSales', data.sales, colors.sales);
        });
    });

    document.querySelectorAll('[data-bs-target="#navs-profit-id"]').forEach((tabBtn) => {
        tabBtn.addEventListener('shown.bs.tab', function () {
            renderChartIfNeeded('profit', '#earningReportsTabsProfit', data.profit, colors.profit);
        });
    });
});
