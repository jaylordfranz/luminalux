@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina Lux - Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        .cart-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .item-row {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            background-color: #fff;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item-image {
            width: 120px;
            height: 120px;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 15px;
        }

        .item-details {
            flex: 1;
            padding: 0 10px;
        }

        .item-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .item-price {
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        .item-quantity {
            font-size: 14px;
            color: #777;
        }

        .item-actions {
            margin-top: 10px;
        }

        .btn-remove {
            color: #dc3545;
            font-size: 14px;
            margin-right: 10px;
            border: none;
            background: none;
        }

        .btn-update {
            color: #28a745;
            font-size: 14px;
            border: none;
            background: none;
        }

        .btn-checkout {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background-color: #0056b3;
        }

        .btn-remove:hover, .btn-update:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container cart-container">
        <h2>Your Shopping Cart</h2>

        @forelse($cartItems as $cartItem)
        <div class="item-row">
            <div class="item-image" style="background-image: url('{{ $cartItem->product->image_url }}');"></div>
            <div class="item-details">
                <div class="item-name">{{ $cartItem->product->name }}</div>
                <div class="item-price">${{ number_format($cartItem->product->price, 2) }}</div>
                <div class="item-quantity">Quantity: {{ $cartItem->quantity }}</div>
                <div class="item-actions">
                    <form action="{{ route('customer.remove-from-cart', $cartItem->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-remove"><i class="fas fa-trash-alt"></i> Remove</button>
                    </form>
                    <a href="{{ route('customer.update-cart', $cartItem->id) }}" class="btn btn-update"><i class="fas fa-sync-alt"></i> Update</a>
                </div>
            </div>
        </div>
        @empty
        <p>Your cart is empty.</p>
        @endforelse

        <button class="btn btn-primary btn-checkout"><i class="fas fa-shopping-cart"></i> Checkout</button>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
