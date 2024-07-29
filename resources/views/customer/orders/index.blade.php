@extends('layouts.app')

@section('title', 'Order History')

@push('styles')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .order-history-container {
            margin-top: 50px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container order-history-container">
        <h2>Order History</h2>
        @if ($orders->isEmpty())
            <div class="alert alert-info" role="alert">
                No orders found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Checkout Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr id="order-row-{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->checkout_status }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>
                                    <a href="{{ route('reviews.show', $order->id) }}" class="btn btn-primary">Review</a>
                                    @if ($order->payment_status === 'Verified')
                                        <button class="btn btn-success print-receipt-btn" data-order-id="{{ $order->id }}">Print Receipt</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @stack('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printButtons = document.querySelectorAll('.print-receipt-btn');

            printButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const orderId = this.getAttribute('data-order-id');
                    printReceipt(orderId);
                });
            });
        });

        async function printReceipt(orderId) {
            try {
                // Fetch order details from your backend
                const response = await fetch(`/orders/${orderId}/receipt`);
                const order = await response.json();

                // Fetch the receipt HTML content
                const receiptResponse = await fetch(`/orders/${orderId}/receipt-view`);
                const receiptHtml = await receiptResponse.text();

                // Create a temporary div element to hold the receipt HTML
                const receiptElement = document.createElement('div');
                receiptElement.innerHTML = receiptHtml;

                // Use html2pdf.js to generate and save the PDF
                html2pdf().from(receiptElement).save(`receipt_${orderId}.pdf`);
            } catch (error) {
                console.error('Error printing receipt:', error);
            } 
        }
    </script>
@endsection
