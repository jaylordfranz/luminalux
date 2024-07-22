@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Category Product Chart</h2>
        <canvas id="categoryProductChart" width="400" height="200"></canvas>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
});

    </script> <!-- Include your custom JavaScript file here -->
@endsection
