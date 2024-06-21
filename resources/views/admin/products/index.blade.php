@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Products</h2>
        <p>Here you can add new products, update product details, and delete products.</p>

        <!-- Buttons -->
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary mr-2">Add Product</a>
        </div>

        <!-- Search Bar with Magnifying Glass -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div>

        <!-- DataTable with Search Bar and Pagination -->
        <table id="productsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>{{ $product->category->name }}</td> <!-- Ensure category name is fetched correctly -->
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
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
            {{ $products->links() }}
        </div>
    </div>

    @include('partials.footer')

    <script>
        // DataTable initialization with search functionality
        $(document).ready(function() {
            var table = $('#productsTable').DataTable({
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
