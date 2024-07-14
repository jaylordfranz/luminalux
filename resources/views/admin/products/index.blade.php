@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Products</h2>
        <p>Here you can add new products, update product details, and delete products.</p>

        <!-- Add Product Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addProductModal">
                Add Product
            </button>
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

    @include('partials.footer')

    <!-- Add Product Modal -->
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
    <script src="{{ asset('js/products.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
            // DataTable initialization
            var table = $('#productsTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "order": [],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search..."
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Products'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Products'
                    }
                ]
            });

            // Search functionality
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

            // Form validation
            $('#addProductForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    stock_quantity: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    category_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a product name"
                    },
                    description: {
                        required: "Please enter a description"
                    },
                    price: {
                        required: "Please enter a price",
                        number: "Please enter a valid price",
                        min: "Price must be at least 0"
                    },
                    stock_quantity: {
                        required: "Please enter a stock quantity",
                        number: "Please enter a valid quantity",
                        min: "Quantity must be at least 0"
                    },
                    category_id: {
                        required: "Please select a category"
                    }
                }
            });

            $('#editProductForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    stock_quantity: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    category_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a product name"
                    },
                    description: {
                        required: "Please enter a description"
                    },
                    price: {
                        required: "Please enter a price",
                        number: "Please enter a valid price",
                        min: "Price must be at least 0"
                    },
                    stock_quantity: {
                        required: "Please enter a stock quantity",
                        number: "Please enter a valid quantity",
                        min: "Quantity must be at least 0"
                    },
                    category_id: {
                        required: "Please select a category"
                    }
                }
            });
        });
    </script>

@endsection

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush
