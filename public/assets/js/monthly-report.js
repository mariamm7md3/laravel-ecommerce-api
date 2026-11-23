document.addEventListener('DOMContentLoaded', function () {
    const data = window.monthlyReportChart;
    if (!data) return;

    const el = document.querySelector('#monthlyReportChart');
    if (!el) return;

    const chart = new ApexCharts(el, {
        chart: {
            height: 300,
            type: 'line',
            toolbar: { show: false },
            parentHeightOffset: 0,
        },
        stroke: {
            width: [0, 3],
            curve: 'smooth',
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '50%',
            },
        },
        dataLabels: { enabled: false },
        series: [
            { name: 'Orders', type: 'column', data: data.orders },
            { name: 'Sales', type: 'line', data: data.sales },
        ],
        xaxis: {
            categories: data.days,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { colors: '#a1a5b7' },
            },
        },
        yaxis: [
            {
                title: { text: 'Orders', style: { color: '#a1a5b7' } },
                labels: {
                    style: { colors: '#a1a5b7' },
                    formatter: (val) => Math.round(val),
                },
            },
            {
                opposite: true,
                title: { text: 'Sales', style: { color: '#a1a5b7' } },
                labels: {
                    style: { colors: '#a1a5b7' },
                    formatter: (val) => Math.round(val),
                },
            },
        ],
        colors: ['#696cff', '#71dd37'],
        grid: {
            borderColor: 'rgba(255, 255, 255, 0.08)',
            strokeDashArray: 4,
        },
        tooltip: {
            shared: true,
            intersect: false,
            theme: 'dark',
        },
    });

    chart.render();
});
