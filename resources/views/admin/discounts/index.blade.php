@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Manage Discounts</h2>
        <p>Here you can view, edit, and delete discounts.</p>

        <!-- Add Discount Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addDiscountModal">
                Add Discount
            </button>
        </div>

        <!-- DataTable with Search Bar and Pagination -->
        <table id="discountsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Discount Percentage</th>
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
                        <td>{{ $discount->discount_percentage }}%</td>
                        <td>{{ $discount->valid_from->format('Y-m-d') }}</td>
                        <td>{{ $discount->valid_to->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('discounts.show', $discount->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" style="display:inline-block;">
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

    @include('partials.footer')

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
                <form action="{{ route('discounts.store') }}" method="POST">
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
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" required>
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

            $('#searchInput').on('keyup', function() {
                table.search($(this).val()).draw();
            });
        });
    </script>
@endsection
