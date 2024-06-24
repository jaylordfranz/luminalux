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
        .item-list {
            margin-bottom: 15px;
        }
        .order-total {
            margin-bottom: 15px;
            font-weight: bold;
            color: #007bff;
        }
        .order-actions {
            margin-top: 15px;
        }
        .item-image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #dee2e6;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .item-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .item-price {
            font-size: 16px;
            color: #777;
        }
        .item-quantity {
            font-size: 14px;
            color: #555;
        }
        .btn-view {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-view:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #c82333;
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
                @for ($i = 1; $i <= 10; $i++)
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-id">Order ID: {{ $i }}</div>
                        <div class="order-date">Order Date: June {{ $i }}, 2024</div>
                    </div>
                    <div class="item-list">
                        <div class="item">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="https://via.placeholder.com/100" alt="Product Image" class="item-image">
                                </div>
                                <div class="col-md-7">
                                    <div class="item-name">Product {{ $i }}</div>
                                    <div class="item-price">$10.00</div>
                                    <div class="item-quantity">Quantity: {{ $i }}</div>
                                </div>
                            </div>
                        </div>
                        <!-- Additional items can be added here -->
                    </div>
                    <div class="order-total">Total: ${{ $i * 10 }}.00</div>
                    <div class="order-actions">
                        <a href="#" class="btn btn-primary btn-view"><i class="fas fa-eye"></i> View</a>
                        <a href="#" class="btn btn-warning btn-edit"><i class="fas fa-edit"></i> Edit</a>
                        <button class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection