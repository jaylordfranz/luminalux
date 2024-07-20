@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .order-item {
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease-in-out;
        }
        .order-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        .order-info {
            margin-bottom: 15px;
        }
        .order-total {
            margin-bottom: 15px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Order History</h5>
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <p>No orders found.</p>
            @else
                @foreach($orders as $order)
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-id">Order ID: {{ $order->id }}</div>
                            <div class="order-date">Order Date: {{ $order->checkout_date->format('F j, Y') }}</div>
                        </div>
                        <div class="order-total">Total: ${{ number_format($order->total_amount, 2) }}</div>
                        <div class="order-status">Status: {{ $order->checkout_status }}</div>
                        <div class="payment-status">Payment Status: {{ $order->payment_status }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap and jQuery JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
