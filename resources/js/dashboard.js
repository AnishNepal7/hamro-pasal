import Chart from 'chart.js';

document.addEventListener('DOMContentLoaded', () => {
    const salesChartElement = document.getElementById('sales-chart');
    if (salesChartElement) {
        new Chart(salesChartElement, {
            type: 'line',
            data: {
                labels: window.chartLabels,
                datasets: [{
                    label: 'Daily Sales',
                    data: window.salesData,
                    borderColor: '#4c51bf',
                    backgroundColor: 'rgba(76, 81, 191, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true }
        });
    }
});