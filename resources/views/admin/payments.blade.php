@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Payment Verification</h2>
    <p>Here you can review and verify payment transactions.</p>

    <!-- Search Bar with Magnifying Glass Icon -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search payments...">
    </div>

    <!-- Buttons -->
    <div class="mb-3">
        <button class="btn btn-primary mr-2" onclick="handleAdd()">Add</button>
        <button class="btn btn-success" onclick="handleExportPDF()">Export PDF</button>
    </div>

    <!-- Table Summary with DataTable -->
    <table id="paymentsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Replace this section with dynamic data from backend -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>$120.00</td>
                <td>Verified</td>
                <td>2024-06-18</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewPaymentDetails(1)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editPayment(1)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deletePayment(1)">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>$75.00</td>
                <td>Pending</td>
                <td>2024-06-17</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewPaymentDetails(2)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editPayment(2)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deletePayment(2)">Delete</button>
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
        $('#paymentsTable').DataTable({
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

    function viewPaymentDetails(paymentId) {
        // Implement functionality to view payment details
        alert('View details for Payment ID ' + paymentId);
    }

    function editPayment(paymentId) {
        // Implement functionality to edit payment
        alert('Edit Payment ID ' + paymentId);
    }

    function deletePayment(paymentId) {
        // Implement functionality to delete payment
        alert('Delete Payment ID ' + paymentId);
    }
</script>
@endsection
