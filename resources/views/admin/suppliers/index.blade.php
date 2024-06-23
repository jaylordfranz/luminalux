@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Manage Suppliers</h2>
    <p>Here you can add new suppliers, update supplier details, and delete suppliers.</p>

    <!-- Buttons -->
    <div class="mb-3">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mr-2">Add Supplier</a>
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
        var table = $('#suppliersTable').DataTable({
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
                    title: 'Suppliers'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Suppliers'
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
</script>

@endsection
