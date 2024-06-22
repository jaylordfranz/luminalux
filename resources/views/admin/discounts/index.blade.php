@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Discounts</h2>
        <p>Here you can view, edit, and delete discounts.</p>

        <!-- Buttons -->
        <div class="mb-3">
            <a href="{{ route('discounts.create') }}" class="btn btn-primary mr-2">Add Discount</a>
        </div>

        <!-- Search Bar with Magnifying Glass -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div>

        <!-- DataTable with Search Bar and Pagination -->
        <table id="discountsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Discount Percentage</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $discount)
                    <tr>
                        <td>{{ $discount->id }}</td>
                        <td>{{ $discount->code }}</td>
                        <td>{{ $discount->description }}</td>
                        <td>{{ $discount->discount_percentage }}%</td>
                        <td>{{ $discount->valid_from->format('Y-m-d') }}</td>
                        <td>{{ $discount->valid_to->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('discounts.show', $discount->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" style="display:inline-block;">
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
            {{ $discounts->links() }}
        </div>
    </div>

    @include('partials.footer')

    <script>
        // DataTable initialization with search functionality
        $(document).ready(function() {
            var table = $('#discountsTable').DataTable({
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
    </script>
@endsection
