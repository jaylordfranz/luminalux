@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Manage Inventory</h2>

    <div class="mb-3">
        <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add Inventory</a>
    </div>

    @if ($inventories->isEmpty())
    <p>No inventory items found.</p>
    @else

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
                <td>{{ $inventory->last_updated }}</td>
                <td>
                    <a href="{{ route('inventory.show', $inventory->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@include('partials.footer')

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

        $('#searchInput').on('keyup', function() {
            table.search($(this).val()).draw();
        });

        $('#exportPDF').click(function() {
            table.button( '1' ).trigger();
        });

        $('#exportExcel').click(function() {
            table.button( '0' ).trigger();
        });
    });
</script>
@endsection
