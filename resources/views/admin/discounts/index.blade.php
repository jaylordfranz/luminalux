@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Discounts</h2>

        <!-- Add Discount Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addDiscountModal">
                Add Discount
            </button>
        </div>

        <!-- Import Excel Form -->
        <form action="{{ route('discounts.importExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Import Excel:</label>
                <input type="file" class="form-control-file" id="file" name="file" required>
                <button type="submit" class="btn btn-primary mt-2">Import</button>
            </div>
        </form>

        <!-- DataTable with Search Bar and Pagination -->
        <table id="discountsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Percentage</th>
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
                        <td>{{ $discount->discount_percentage }}</td>
                        <td>{{ $discount->valid_from->format('Y-m-d') }}</td>
                        <td>{{ $discount->valid_to->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('discounts.show', $discount->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" class="delete-form" style="display:inline-block;">
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

    <!-- Add Discount Modal -->
    <div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDiscountModalLabel">Add Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addDiscountForm" action="{{ route('discounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="discount_percentage">Discount Percentage</label>
                            <input type="text" class="form-control" id="discount_percentage" name="discount_percentage" required>
                        </div>
                        <div class="form-group">
                            <label for="valid_from">Valid From</label>
                            <input type="date" class="form-control" id="valid_from" name="valid_from" required>
                        </div>
                        <div class="form-group">
                            <label for="valid_to">Valid To</label>
                            <input type="date" class="form-control" id="valid_to" name="valid_to" required>
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

    <!-- Edit Discount Modal -->
    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDiscountModalLabel">Edit Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editDiscountForm" action="{{ route('discounts.update', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editDiscountId" name="editDiscountId">
                        <div class="form-group">
                            <label for="editCode">Code</label>
                            <input type="text" class="form-control" id="editCode" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="editDescription" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editDiscountPercentage">Discount Percentage</label>
                            <input type="text" class="form-control" id="editDiscountPercentage" name="discount_percentage" required>
                        </div>
                        <div class="form-group">
                            <label for="editValidFrom">Valid From</label>
                            <input type="date" class="form-control" id="editValidFrom" name="valid_from" required>
                        </div>
                        <div class="form-group">
                            <label for="editValidTo">Valid To</label>
                            <input type="date" class="form-control" id="editValidTo" name="valid_to" required>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap4.min.css">
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
    <script src="{{ asset('js/discounts.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#discountsTable').DataTable({
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
                        title: 'Discounts'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Discounts'
                    }
                ]
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

    
    // Form submission and validation
    $('#addDiscountModal form').submit(function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var isValid = true;

        // Validate code
        var code = $('#code').val().trim();
        var codePattern = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/;
        if (code === '') {
            $('#code').addClass('is-invalid').after('<div class="invalid-feedback">Please input a code.</div>');
            isValid = false;
        } else if (!codePattern.test(code)) {
            $('#code').addClass('is-invalid').after('<div class="invalid-feedback">Code must be a mix of letters and numbers.</div>');
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

        // Validate discount percentage
        var discountPercentage = $('#discount_percentage').val().trim();
        if (discountPercentage === '') {
            $('#discount_percentage').addClass('is-invalid').after('<div class="invalid-feedback">Please input a discount percentage.</div>');
            isValid = false;
        }

        // Validate valid from date
        var validFrom = $('#valid_from').val().trim();
        if (validFrom === '') {
            $('#valid_from').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid from date.</div>');
            isValid = false;
        }

        // Validate valid to date
        var validTo = $('#valid_to').val().trim();
        if (validTo === '') {
            $('#valid_to').addClass('is-invalid').after('<div class="invalid-feedback">Please input a valid to date.</div>');
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });


    </script>
@endsection

@push('scripts')
    <script src="{{ asset('js/discounts.js') }}"></script>
@endpush
