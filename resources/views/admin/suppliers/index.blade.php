@extends('layouts.admin')


@section('content')
@include('partials.header')


<div class="main-content">
    <h2>Manage Suppliers</h2>


    <!-- Add Supplier Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addSupplierModal">
            Add Supplier
        </button>
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


<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSupplierForm" action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="supplierName">Name</label>
                        <input type="text" class="form-control" id="supplierName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="supplierContact">Contact Info</label>
                        <input type="text" class="form-control" id="supplierContact" name="contact_info" required>
                    </div>
                    <div class="form-group">
                        <label for="supplierAddress">Address</label>
                        <textarea class="form-control" id="supplierAddress" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="supplierImages">Images</label>
                        <input type="file" class="form-control-file" id="supplierImages" name="images[]" multiple>
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
        var table = $('#suppliersTable').DataTable({
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
                    title: 'Suppliers'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Suppliers'
                }
            ]
        });


        // Form validation
        $('#addSupplierForm').submit(function(e) {
            e.preventDefault();


            // Clear previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();


            var isValid = true;


            // Validate name
            var name = $('#supplierName').val().trim();
            if (name === '') {
                $('#supplierName').addClass('is-invalid').after('<div class="invalid-feedback">Please input a name.</div>');
                isValid = false;
            } else if (name.length < 3) {
                $('#supplierName').addClass('is-invalid').after('<div class="invalid-feedback">Name must be at least 3 characters long.</div>');
                isValid = false;
            }


            // Validate contact info
            var contactInfo = $('#supplierContact').val().trim();
            if (contactInfo === '' || contactInfo.length !== 11) {
                $('#supplierContact').addClass('is-invalid').after('<div class="invalid-feedback">Contact Info must be exactly 11 digits.</div>');
                isValid = false;
            }


            // Validate address
            var address = $('#supplierAddress').val().trim();
            if (address === '') {
                $('#supplierAddress').addClass('is-invalid').after('<div class="invalid-feedback">Please input an address.</div>');
                isValid = false;
            } else if (address.length < 3) {
                $('#supplierAddress').addClass('is-invalid').after('<div class="invalid-feedback">Address must be at least 3 characters long.</div>');
                isValid = false;
            }


            if (isValid) {
                this.submit(); // Submit the form if all fields are valid
            }
        });
    });
</script>
@endsection



