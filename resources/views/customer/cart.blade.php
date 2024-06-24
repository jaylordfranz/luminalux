
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
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        .item-row {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .item-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #000;
        }
        .item-details {
            margin-left: 20px;
        }
        .item-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .item-price {
            font-size: 16px;
            color: #777;
            margin-bottom: 5px;
        }
        .item-quantity {
            font-size: 14px;
            color: #555;
        }
        .item-actions {
            margin-top: 10px;
        }
        .btn-remove {
            color: red;
            font-size: 14px;
            margin-right: 10px;
        }
        .btn-update {
            color: green;
            font-size: 14px;
        }
        .btn-checkout {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container cart-container">
        <h2>Your Shopping Cart</h2>
        <div class="item-row">
            <div class="item-image" style="background-color: #ccc;"></div>
            <div class="item-details">
                <div class="item-name">COSRX Low pH Good Morning Gel Cleanser</div>
                <div class="item-price">$12.00</div>
                <div class="item-quantity">Quantity: 2</div>
                <div class="item-actions">
                    <button class="btn btn-remove"><i class="fas fa-trash-alt"></i> Remove</button>
                    <button class="btn btn-update"><i class="fas fa-sync-alt"></i> Update</button>
                </div>
            </div>
        </div>
        <div class="item-row">
            <div class="item-image" style="background-color: #ccc;"></div>
            <div class="item-details">
                <div class="item-name">COSRX Advanced Snail 96 Mucin Power Essence</div>
                <div class="item-price">$21.00</div>
                <div class="item-quantity">Quantity: 1</div>
                <div class="item-actions">
                    <button class="btn btn-remove"><i class="fas fa-trash-alt"></i> Remove</button>
                    <button class="btn btn-update"><i class="fas fa-sync-alt"></i> Update</button>
                </div>
            </div>
        </div>
        <div class="item-row">
            <div class="item-image" style="background-color: #ccc;"></div>
            <div class="item-details">
                <div class="item-name">COSRX Acne Pimple Master Patch</div>
                <div class="item-price">$5.00</div>
                <div class="item-quantity">Quantity: 3</div>
                <div class="item-actions">
                    <button class="btn btn-remove"><i class="fas fa-trash-alt"></i> Remove</button>
                    <button class="btn btn-update"><i class="fas fa-sync-alt"></i> Update</button>
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn-checkout"><i class="fas fa-shopping-cart"></i> Checkout</button>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
