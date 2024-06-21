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

    <!-- Buttons -->
    <div class="mb-3">
        <button class="btn btn-primary mr-2" onclick="handleAdd()">Add</button>
        <button class="btn btn-success" onclick="handleExportPDF()">Export PDF</button>
    </div>

    <!-- Table Summary with DataTable -->
    <table id="ordersTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Replace this section with dynamic data from backend -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>Product A</td>
                <td>2</td>
                <td>Processing</td>
                <td>$120.00</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewOrderDetails(1)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editOrder(1)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteOrder(1)">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>Product B</td>
                <td>1</td>
                <td>Shipped</td>
                <td>$75.00</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewOrderDetails(2)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editOrder(2)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteOrder(2)">Delete</button>
                </td>
            </tr>
            <!-- End of demo data -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
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
    function handleAdd() {
        // Implement functionality for Add button
        alert('Add button clicked');
    }

    function handleExportPDF() {
        // Implement functionality for Export PDF button
        alert('Export PDF button clicked');
    }

    function viewOrderDetails(orderId) {
        // Implement functionality to view order details
        alert('View details for Order ID ' + orderId);
    }

    function editOrder(orderId) {
        // Implement functionality to edit order
        alert('Edit Order ID ' + orderId);
    }

    function deleteOrder(orderId) {
        // Implement functionality to delete order
        alert('Delete Order ID ' + orderId);
    }
</script>
@endsection
