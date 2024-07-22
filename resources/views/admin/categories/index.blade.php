@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Manage Categories</h2>
        <p>Here you can add new product categories, update category details, and delete categories.</p>


        <!-- Add Category Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addCategoryModal">
                Add Category
            </button>
        </div>


        <!-- Import Excel Form -->
        <form action="{{ route('categories.importExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Import Excel:</label>
                <input type="file" class="form-control-file" id="file" name="file" required>
                <button type="submit" class="btn btn-primary mt-2">Import</button>
            </div>
        </form>


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
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-form" style="display:inline-block;">
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


    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description"></textarea>
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


    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategoryForm" action="{{ route('categories.update', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editCategoryId" name="editCategoryId">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="editDescription" name="description"></textarea>
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
            var table = $('#categoriesTable').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                order: [],
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Categories'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Categories'
                    }
                ]
            });


            // Edit Category Modal
            $('#editCategoryModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var categoryId = button.data('id');
                var name = button.data('name');
                var description = button.data('description');


                var modal = $(this);
                modal.find('.modal-title').text('Edit Category');
                modal.find('#editCategoryId').val(categoryId);
                modal.find('#editName').val(name);
                modal.find('#editDescription').val(description);
            });


            // Form validation for Add Category
            $('#addCategoryForm').submit(function(e) {
                e.preventDefault();
               
                // Clear previous errors
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();


                var isValid = true;


                // Validate name
                var name = $('#categoryName').val().trim();
                if (name === '') {
                    $('#categoryName').addClass('is-invalid').after('<div class="invalid-feedback">Please input a name.</div>');
                    isValid = false;
                } else if (name.length < 3) {
                    $('#categoryName').addClass('is-invalid').after('<div class="invalid-feedback">Name must be at least 3 characters long.</div>');
                    isValid = false;
                }


                // Validate description
                var description = $('#categoryDescription').val().trim();
                if (description === '') {
                    $('#categoryDescription').addClass('is-invalid').after('<div class="invalid-feedback">Please input a description.</div>');
                    isValid = false;
                }


                if (isValid) {
                    this.submit();
                }
            });


            // Form validation for Edit Category
            $('#editCategoryForm').submit(function(e) {
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
                }


                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endsection


