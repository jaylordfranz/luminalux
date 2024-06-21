@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Manage Categories</h2>
    <p>Here you can add new product categories, update category details, and delete categories.</p>

    <!-- Buttons -->
    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary mr-2">Add Category</a>
    </div>

    <!-- Search Bar with Magnifying Glass -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
    </div>

    <!-- DataTable with Search Bar and Pagination -->
    <table id="categoriesTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
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
        {{ $categories->links() }}
    </div>
</div>

@include('partials.footer')

<script>
    $(document).ready(function() {
        var table = $('#categoriesTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": [],
            "language": {
                "search": "",
                "searchPlaceholder": "Search..."
            }
        });

        $('#searchInput').on('keyup', function() {
            table.search($(this).val()).draw();
        });
    });
</script>
@endsection