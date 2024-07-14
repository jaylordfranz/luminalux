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
        <!-- Data will be loaded via AJAX -->
    </tbody>
</table>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul id="pagination" class="pagination justify-content-center">
                <!-- Pagination items will be dynamically inserted here -->
            </ul>
        </nav>
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
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
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
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="{{ asset('js/categories.js') }}"></script>

    <script>
        $(document).ready(function() {
            // DataTable initialization
            var table = $('#categoriesTable').DataTable({
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
                        title: 'Categories'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Categories'
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
            $('#addCategoryForm').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a category name"
                    }
                }
            });

            $('#editCategoryForm').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a category name"
                    }
                }
            });
        });

        $(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#categoriesTable')) {
        $('#categoriesTable').DataTable().destroy();
    }

    $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('categories.index') }}',
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

    </script>
@endpush
