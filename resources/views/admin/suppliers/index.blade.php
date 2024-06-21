@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Manage Suppliers</h2>
    <p>Here you can add new suppliers, update supplier details, and delete suppliers.</p>

    <!-- Buttons -->
    <div class="mb-3">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mr-2">Add Supplier</a>
    </div>

    <!-- Search Bar with Magnifying Glass -->
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by ID...">
        <div class="input-group-append">
            <button id="searchButton" class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- DataTable with Search Bar and Pagination -->
    <table id="suppliersTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Info</th>
                <th>Address</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->contact_info }}</td>
                <td>{{ $supplier->address }}</td>
                <td>
                    @foreach($supplier->images as $image)
                        <img src="{{ asset('storage/' . $image) }}" width="100" alt="Supplier Image">
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
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
        {{ $suppliers->links() }}
    </div>
</div>

@include('partials.footer')

<script>
    $(document).ready(function() {
        var table = $('#suppliersTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": [],
            "language": {
                "search": "",
                "searchPlaceholder": "Search by ID..."
            }
        });

        $('#searchButton').on('click', function() {
            var value = $('#searchInput').val().trim();
            if (value) {
                table.columns().every(function(index) {
                    if (index === 0) { // Search in the first column (ID)
                        this.search('^' + value + '$', true, false).draw();
                    }
                });
            } else {
                table.columns().every(function() {
                    this.search('').draw();
                });
            }
        });
    });
</script>

@endsection
