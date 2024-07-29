@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Manage Products</h2>


        <!-- Add Product Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addProductModal">
                Add Product
            </button>
        </div>

        <!-- Import Excel Form -->
        <form action="{{ route('products.importExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Import Excel:</label>
                <input type="file" class="form-control-file" id="file" name="file" required>
                <button type="submit" class="btn btn-primary mt-2">Import</button>
            </div>
        </form>


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
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <a href="{{ route('admin.products.shows', $product->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" style="display:inline-block;">
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


    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addProductForm" action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">


                        <!-- Validation Errors Summary -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editProductForm" action="{{ route('products.update', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Validation Errors Summary -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <input type="hidden" id="editProductId" name="editProductId">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editPrice">Price</label>
                            <input type="number" class="form-control" id="editPrice" name="price" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="editStockQuantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="editStockQuantity" name="stock_quantity" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="editCategoryId">Category</label>
                            <select class="form-control" id="editCategoryId" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    searchPlaceholder: "Search products..."
                },
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });


            // Event listener for delete button
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this product?')) {
                    $(this).unbind('submit').submit();
                }
            });
        });


        // Populate edit modal with product data
    // Form validation
    $(document).ready(function() {
                $(document).ready(function() {
    $('#addProductForm').submit(function(e) {
        e.preventDefault();
       
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();


        var isValid = true;


        // Validate name
        var name = $('#name').val().trim();
        if (name === '') {
            $('#name').addClass('is-invalid').after('<div class="invalid-feedback">Please input a name.</div>');
            isValid = false;
        } else if (name.length < 3) {
            $('#name').addClass('is-invalid').after('<div class="invalid-feedback">Name must be at least 3 characters long.</div>');
            isValid = false;
        }


        // Validate description
        var description = $('#description').val().trim();
        if (description === '') {
            $('#description').addClass('is-invalid').after('<div class="invalid-feedback">Please input a description.</div>');
            isValid = false;
        } else if (description.length < 3) {
            $('#description').addClass('is-invalid').after('<div class="invalid-feedback">Description must be at least 3 characters long.</div>');
            isValid = false;
        }


        // Validate price
        var price = $('#price').val().trim();
        if (price === '' || isNaN(price) || parseFloat(price) <= 0) {
            $('#price').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid price (greater than 0).</div>');
            isValid = false;
        }


        // Validate stock quantity
        var stockQuantity = $('#stock_quantity').val().trim();
        if (stockQuantity === '' || isNaN(stockQuantity) || parseInt(stockQuantity) < 0) {
            $('#stock_quantity').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid stock quantity (0 or greater).</div>');
            isValid = false;
        }


        // Validate category
        var categoryId = $('#category_id').val();
        if (categoryId === '') {
            $('#category_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a category.</div>');
            isValid = false;
        }


        if (isValid) {
            this.submit(); // Submit the form if all fields are valid
        }
    });


    $('#editProductForm').submit(function(e) {
        e.preventDefault();
       
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();


        var isValid = true;


        // Validate name
        var name = $('#editName').val().trim();
        if (name === '') {
            $('#editName').addClass('is-invalid').after('<div class="invalid-feedback">Please input a name.</div>');
            isValid = false;
        } else if (name.length < 3) {
            $('#editName').addClass('is-invalid').after('<div class="invalid-feedback">Name must be at least 3 characters long.</div>');
            isValid = false;
        }


        // Validate description
        var description = $('#editDescription').val().trim();
        if (description === '') {
            $('#editDescription').addClass('is-invalid').after('<div class="invalid-feedback">Please input a description.</div>');
            isValid = false;
        } else if (description.length < 3) {
            $('#editDescription').addClass('is-invalid').after('<div class="invalid-feedback">Description must be at least 3 characters long.</div>');
            isValid = false;
        }


        // Validate price
        var price = $('#editPrice').val().trim();
        if (price === '' || isNaN(price) || parseFloat(price) <= 0) {
            $('#editPrice').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid price (greater than 0).</div>');
            isValid = false;
        }


        // Validate stock quantity
        var stockQuantity = $('#editStockQuantity').val().trim();
        if (stockQuantity === '' || isNaN(stockQuantity) || parseInt(stockQuantity) < 0) {
            $('#editStockQuantity').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid stock quantity (0 or greater).</div>');
            isValid = false;
        }


        // Validate category
        var categoryId = $('#editCategoryId').val();
        if (categoryId === '') {
            $('#editCategoryId').addClass('is-invalid').after('<div class="invalid-feedback">Please select a category.</div>');
            isValid = false;
        }


        if (isValid) {
            this.submit(); // Submit the form if all fields are valid
        }
    });
});


        });
    </script>






@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush
