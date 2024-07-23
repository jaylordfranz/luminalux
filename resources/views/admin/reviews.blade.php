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
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->product->name }}</td> <!-- Assuming there is a relationship for product -->
                    <td>{{ $review->customer->name }}</td> <!-- Assuming there is a relationship for customer -->
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->created_at->format('Y-m-d') }}</td>
                    <td>
                        <!-- Add delete form -->
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $reviews->links() }} <!-- Pagination links -->
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
</script>
@endsection
