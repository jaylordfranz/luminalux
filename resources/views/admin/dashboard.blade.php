@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Inventory Chart</h2>
        <canvas id="categoryProductChart" width="400" height="200"></canvas>
        
        <h2>User Activity Chart</h2>
        <canvas id="userActivityChart" width="400" height="200"></canvas>
        
        <h2>Checkout Chart</h2>
        <canvas id="checkoutChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch and render the inventory data
            fetch('/inventory-data')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.product_name);
                    const quantities = data.map(item => item.total_quantity);

                    const ctx = document.getElementById('categoryProductChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Product Quantity',
                                data: quantities,
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
                });

            // Fetch and render the user activity data
            fetch('/user-activity-data')
                .then(response => response.json())
                .then(data => {
                    const activeUserNames = data.active.map(user => user.name);
                    const inactiveUserNames = data.inactive.map(user => user.name);

                    const ctx = document.getElementById('userActivityChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Active Users', 'Inactive Users'],
                            datasets: [{
                                data: [data.active.length, data.inactive.length],
                                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            const label = tooltipItem.label + ': ' + tooltipItem.raw;
                                            if (tooltipItem.label === 'Active Users') {
                                                return label + '\n' + activeUserNames.join(', ');
                                            } else {
                                                return label + '\n' + inactiveUserNames.join(', ');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    });
                });

            // Fetch and render the checkout data
            fetch('/checkout-data')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => `Order ${item.order_id}`);
                    const amounts = data.map(item => item.total_amount);

                    const ctx = document.getElementById('checkoutChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Amount',
                                data: amounts,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    ticks: {
                                        autoSkip: false, // Show all labels
                                        maxRotation: 90,
                                        minRotation: 45
                                    }
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endsection
