@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Review Management</h2>
    <p>Here you can monitor and manage customer reviews.</p>

    <!-- Buttons -->
    <div class="mb-3">
        <button class="btn btn-primary mr-2" onclick="handleAdd()">Add Review</button>
        <button class="btn btn-success" onclick="handleExportPDF()">Export PDF</button>
    </div>

    <!-- Search Bar with Magnifying Glass -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
    </div>

    <!-- DataTable with Search Bar and Pagination -->
    <table id="reviewsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Customer Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Replace with Blade directives to loop through reviews -->
            <tr>
                <td>1</td>
                <td>Product A</td>
                <td>John Doe</td>
                <td>4.5</td>
                <td>Great product, fast shipping!</td>
                <td>2024-06-25</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewReviewDetails(1)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editReview(1)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteReview(1)">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Product B</td>
                <td>Jane Smith</td>
                <td>5.0</td>
                <td>Excellent service and quality!</td>
                <td>2024-06-26</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewReviewDetails(2)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editReview(2)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteReview(2)">Delete</button>
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
    // DataTable initialization with search functionality
    $(document).ready(function() {
        var table = $('#reviewsTable').DataTable({
            "paging": true, // Enable pagination
            "ordering": true, // Enable sorting
            "info": true, // Enable table information
            "searching": true, // Enable search bar
            "order": [], // No initial ordering
            "language": {
                "search": "", // Clear default search text
                "searchPlaceholder": "Search..." // Placeholder for search input
            }
        });

        // Apply search functionality to search input
        $('#searchInput').on('keyup', function() {
            table.search($(this).val()).draw();
        });
    });

    // Functions for buttons
    function handleAdd() {
        // Implement functionality for Add Review button
        alert('Add Review button clicked');
    }

    function handleExportPDF() {
        // Implement functionality for Export PDF button
        alert('Export PDF button clicked');
    }

    function viewReviewDetails(reviewId) {
        // Implement functionality to view review details
        alert('View details for Review ID ' + reviewId);
    }

    function editReview(reviewId) {
        // Implement functionality to edit review
        alert('Edit Review ID ' + reviewId);
    }

    function deleteReview(reviewId) {
        // Implement functionality to delete review
        alert('Delete Review ID ' + reviewId);
    }
</script>
@endsection
