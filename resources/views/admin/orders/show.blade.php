@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="container">
    <h2>Order Details</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Order #{{ $order->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Checkout Date:</strong> {{ \Carbon\Carbon::parse($order->checkout_date)->format('F j, Y') }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Checkout Status:</strong> {{ $order->checkout_status }}</p>
            <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
            <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>

            <h4>Customer Details</h4>
            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>

            <h4>Cart Details</h4>
            <!-- Display cart details -->
            <!-- For example, you can display cart items here if needed -->
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back to Orders</a>
</div>

@include('partials.footer')
@endsection
