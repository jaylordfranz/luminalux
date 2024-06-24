// Import Chart.js at the beginning of your file
import Chart from 'chart.js/auto';

// Use jQuery to wait until the document is fully loaded
$(document).ready(function() {
    // Perform AJAX request to fetch data
    $.ajax({
        type: "GET",
        url: "/admin/dashboard/category-product-chart",
        dataType: "json",
        success: function(data) {
            // Extract labels and counts from data
            const labels = data.map(category => category.name);
            const counts = data.map(category => category.products_count);

            // Get the canvas element where the chart will be rendered
            const ctx = document.getElementById('categoryProductChart').getContext('2d');

            // Initialize Chart.js to create a bar chart
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of Products',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
});