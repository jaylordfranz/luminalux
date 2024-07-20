@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Order Management</h2>
    <p>Here you can view and manage all customer orders. Update order statuses, handle cancellations, and returns.</p>

    <!-- Search Bar with Magnifying Glass Icon -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search orders...">
    </div>

    <!-- Table Summary with DataTable -->
    <table id="ordersTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Checkout Date</th>
                <th>Total Amount</th>
                <th>Checkout Status</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->checkout_date }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->checkout_status }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('partials.footer')

<script>
    // DataTable initialization
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            "paging": true, // Enable pagination
            "ordering": true, // Enable sorting
            "info": true, // Enable table information
            "searching": true, // Enable search bar
            "order": [] // No initial ordering
        });
    });

    // Functions for buttons
    function handleExportPDF() {
        // Implement functionality for Export PDF button
        alert('Export PDF button clicked');
    }
</script>
@endsection
