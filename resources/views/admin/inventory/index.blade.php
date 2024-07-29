@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Manage Inventory</h2>


        <!-- Add Inventory Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#inventoryModal">
                Add Inventory
            </button>
        </div>

         <!-- Import Excel Form -->
         <form action="{{ route('inventories.importExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Import Excel:</label>
                <input type="file" class="form-control-file" id="file" name="file" required>
                <button type="submit" class="btn btn-primary mt-2">Import</button>
            </div>
        </form>


        <!-- DataTable with Search Bar and Pagination -->
        <table id="inventoryTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->id }}</td>
                        <td>{{ $inventory->product->name }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>{{ $inventory->updated_at->format('Y-m-d H:i:s') }}</td>
                        <!-- <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#inventoryModal" data-id="{{ $inventory->id }}" data-product-id="{{ $inventory->product_id }}" data-quantity="{{ $inventory->quantity }}">
                                Update
                            </button>
                        </td> -->
                        <td>
                    <a href="{{ route('inventory.show', $inventory->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" style="display:inline-block;">
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
            {{ $inventories->links() }}
        </div>
    </div>


    <!-- Inventory Modal -->
    <div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryModalLabel">Add Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="inventoryForm" action="{{ route('inventory.store') }}" method="POST">


                    @csrf
                    <input type="hidden" id="inventoryId" name="inventory_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select class="form-control" id="product_id" name="product_id">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="inventorySubmit" class="btn btn-primary">Save</button>
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
    var table = $('#inventoryTable').DataTable({
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
                title: 'Inventory'
            },
            {
                extend: 'pdfHtml5',
                title: 'Inventory'
            }
        ]
    });

    // Edit Inventory Modal
    $('#editInventoryModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var description = button.data('description');
        var quantity = button.data('quantity');

        var modal = $(this);
        modal.find('#editInventoryId').val(id);
        modal.find('#editName').val(name);
        modal.find('#editDescription').val(description);
        modal.find('#editQuantity').val(quantity);
        var action = "{{ route('inventories.update', ':id') }}".replace(':id', id);
        modal.find('form').attr('action', action);
    });

    // Form validation for Add Inventory
    $('#addInventoryForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var isValid = true;
        var fields = {
            'name': '#inventoryName',
            'description': '#inventoryDescription',
            'quantity': '#inventoryQuantity'
        };

        $.each(fields, function(key, selector) {
            var value = $(selector).val().trim();
            if (value === '' || (key === 'quantity' && value <= 0)) {
                $(selector).addClass('is-invalid').after(`<div class="invalid-feedback">${key.charAt(0).toUpperCase() + key.slice(1)} is required and must be greater than 0.</div>`);
                isValid = false;
            }
        });

        if (isValid) {
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addInventoryModal').modal('hide');
                    table.ajax.reload(); // Reload the table data
                },
                error: function(response) {
                    // Handle server-side validation errors
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, errorMessages) {
                        var fieldSelector = key === 'quantity' ? '#inventoryQuantity' : '#inventoryName';
                        $(fieldSelector).addClass('is-invalid').after(`<div class="invalid-feedback">${errorMessages.join(' ')}</div>`);
                    });
                }
            });
        }
    });

    // Form validation for Edit Inventory
    $('#editInventoryForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var isValid = true;
        var fields = {
            'name': '#editName',
            'description': '#editDescription',
            'quantity': '#editQuantity'
        };

        $.each(fields, function(key, selector) {
            var value = $(selector).val().trim();
            if (value === '' || (key === 'quantity' && value <= 0)) {
                $(selector).addClass('is-invalid').after(`<div class="invalid-feedback">${key.charAt(0).toUpperCase() + key.slice(1)} is required and must be greater than 0.</div>`);
                isValid = false;
            }
        });

        if (isValid) {
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editInventoryModal').modal('hide');
                    table.ajax.reload(); // Reload the table data
                },
                error: function(response) {
                    // Handle server-side validation errors
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, errorMessages) {
                        var fieldSelector = key === 'quantity' ? '#editQuantity' : '#editName';
                        $(fieldSelector).addClass('is-invalid').after(`<div class="invalid-feedback">${errorMessages.join(' ')}</div>`);
                    });
                }
            });
        }
    });

    // Handle delete actions
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = $(this);

        if (confirm('Are you sure you want to delete this inventory item?')) {
            $.ajax({
                url: form.attr('action'),
                method: 'DELETE',
                data: form.serialize(),
                success: function(response) {
                    table.ajax.reload(); // Reload the table data
                },
                error: function(response) {
                    // Handle errors
                }
            });
        }
    });
});
</script>



@endsection
