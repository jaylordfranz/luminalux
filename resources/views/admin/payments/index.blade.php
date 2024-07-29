@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Payment Verification</h2>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search payments...">
    </div>

    <div class="mb-3">
        <button class="btn btn-primary mr-2" onclick="handleAdd()">Add</button>
        <button class="btn btn-success" onclick="handleExportPDF()">Export PDF</button>
    </div>

    <table id="paymentsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->customer_id }}</td> <!-- Replace with customer name if needed -->
                <td>${{ $payment->total_amount }}</td>
                <td>{{ $payment->payment_status }}</td>
                <td>{{ $payment->checkout_date }}</td>
                <td>
                    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-info btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#paymentsTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": []
        });
    });

    function handleAdd() {
        alert('Add button clicked');
    }

    function handleExportPDF() {
        alert('Export PDF button clicked');
    }

    function editPayment(paymentId) {
        window.location.href = '{{ url('admin/payments/edit') }}/' + paymentId;
    }

    function deletePayment(paymentId) {
        alert('Delete Payment ID ' + paymentId);
    }
</script>
@endsection