@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Inventory</h2>
        <p>Here you can add new inventory entries, update quantities, and manage inventory details.</p>

        <!-- Add Inventory Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#inventoryModal">
                Add Inventory
            </button>
        </div>

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
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#inventoryModal" data-id="{{ $inventory->id }}" data-product-id="{{ $inventory->product_id }}" data-quantity="{{ $inventory->quantity }}">
                                Update
                            </button>
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

    @include('partials.footer')

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
                title: 'Inventory'
            },
            {
                extend: 'pdfHtml5',
                title: 'Inventory'
            }
        ]
    });

    // Edit Inventory Modal
    $('#inventoryModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var inventoryId = button.data('id');
        var productId = button.data('product-id');
        var quantity = button.data('quantity');

        var modal = $(this);
        modal.find('.modal-title').text(inventoryId ? 'Update Inventory' : 'Add Inventory');
        $('#inventoryId').val(inventoryId);
        $('#product_id').val(productId);
        $('#quantity').val(quantity);
        if (inventoryId) {
            $('#inventoryForm').attr('action', '{{ route('inventory.update', '') }}/' + inventoryId);
            $('#inventoryForm').append('<input type="hidden" name="_method" value="PUT">');
        } else {
            $('#inventoryForm').attr('action', '{{ route('inventory.store') }}');
            $('#inventoryForm').find('input[name="_method"]').remove();
        }
    });

    // Form submission and validation
    $('#inventoryForm').submit(function(e) {
        e.preventDefault();

        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var isValid = true;

        // Validate product_id
        var productId = $('#product_id').val();
        if (productId === '') {
            $('#product_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a product.</div>');
            isValid = false;
        }

        // Validate quantity
        var quantity = $('#quantity').val().trim();
        if (quantity === '' || isNaN(quantity) || parseInt(quantity) < 0) {
            $('#quantity').addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid quantity (0 or greater).</div>');
            isValid = false;
        }

        if (isValid) {
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).find('input[name="_method"]').length ? 'PUT' : 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#inventoryModal').modal('hide'); // Hide modal
                    table.ajax.reload(); // Reload the table
                },
                error: function(xhr) {
                    // Handle errors here
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>


@endsection
