@extends('layouts.admin')

@section('content')
@include('partials.header')

<div id="userManagement">
    <h2>User Management</h2>
    <canvas id="userChart" width="400" height="200"></canvas>
</div>

<div id="productManagement" class="mt-4">
    <h2>Product Management</h2>
    <canvas id="productChart" width="400" height="200"></canvas>
</div>

<div id="paymentVerification" class="mt-4">
    <h2>Payment Verification</h2>
    <canvas id="paymentChart" width="400" height="200"></canvas>
</div>

<div id="orderManagement" class="mt-4">
    <h2>Order Management</h2>
    <canvas id="orderChart" width="400" height="200"></canvas>
</div>

<div id="reviewManagement" class="mt-4">
    <h2>Review Management</h2>
    <canvas id="reviewChart" width="400" height="200"></canvas>
</div>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart data arrays (example data)
    var chartData = {
        userChart: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(129, 162, 99, 0.6)', // #81A263 with opacity
            borderColor: 'rgba(129, 162, 99, 1)', // #81A263
            type: 'bar'
        },
        productChart: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            data: [5, 15, 10, 20, 30, 40],
            backgroundColor: 'rgba(253, 155, 99, 0.6)', // #FD9B63 with opacity
            borderColor: 'rgba(253, 155, 99, 1)', // #FD9B63
            type: 'line'
        },
        paymentChart: {
            labels: ['Verified', 'Pending', 'Failed'],
            data: [10, 5, 3],
            backgroundColor: [
                'rgba(253, 155, 99, 0.6)', // #FD9B63 with opacity
                'rgba(129, 162, 99, 0.6)', // #81A263 with opacity
                'rgba(231, 211, 127, 0.6)' // Default color with opacity
            ],
            borderColor: [
                'rgba(253, 155, 99, 1)', // #FD9B63
                'rgba(129, 162, 99, 1)', // #81A263
                'rgba(231, 211, 127, 1)' // Default color
            ],
            type: 'pie'
        },
        orderChart: {
            labels: ['Processing', 'Shipped', 'Delivered'],
            data: [12, 9, 7],
            backgroundColor: [
                'rgba(129, 162, 99, 0.6)', // #81A263 with opacity
                'rgba(253, 155, 99, 0.6)', // #FD9B63 with opacity
                'rgba(75, 192, 192, 0.6)' // Default color with opacity
            ],
            borderColor: [
                'rgba(129, 162, 99, 1)', // #81A263
                'rgba(253, 155, 99, 1)', // #FD9B63
                'rgba(75, 192, 192, 1)' // Default color
            ],
            type: 'doughnut'
        },
        reviewChart: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            data: [8, 10, 5, 7, 6, 9],
            backgroundColor: 'rgba(253, 155, 99, 0.6)', // #FD9B63 with opacity
            borderColor: 'rgba(253, 155, 99, 1)', // #FD9B63
            type: 'bar'
        }
    };

    // Function to create Chart.js instances for each chart
    function createCharts() {
        Object.keys(chartData).forEach(function(chartId) {
            var ctx = document.getElementById(chartId).getContext('2d');
            var chart = new Chart(ctx, {
                type: chartData[chartId].type,
                data: {
                    labels: chartData[chartId].labels,
                    datasets: [{
                        label: chartId,
                        data: chartData[chartId].data,
                        backgroundColor: chartData[chartId].backgroundColor,
                        borderColor: chartData[chartId].borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    }

    // Initialize the charts
    createCharts();
</script>
@endsection
