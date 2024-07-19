<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .checkout-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .order-summary {
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .order-summary h4 {
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        .summary-label {
            font-weight: bold;
        }
        .summary-value {
            font-size: 1.1em;
        }
        .cart-items {
            margin-bottom: 30px;
        }
        .cart-items h4 {
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        .item-row {
            display: flex;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            align-items: center;
        }
        .item-image {
            width: 100px;
            height: 100px;
            background-color: #ddd;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
        }
        .item-details {
            margin-left: 15px;
        }
        .item-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .item-price {
            color: #555;
        }
        .item-quantity {
            color: #777;
        }
        .button-section {
            text-align: center;
        }
        .button-section .btn {
            margin: 5px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container checkout-container">
    <h2>Checkout Summary</h2>

    <!-- Order Summary Section -->
    <div class="order-summary">
        <h4>Order Details</h4>
        <div class="summary-row">
            <span class="summary-label">Checkout Date:</span>
            <span class="summary-value">{{ \Carbon\Carbon::now()->format('F j, Y') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Billing Address:</span>
            <span class="summary-value">123 Main St, Anytown, USA</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Amount:</span>
            <span class="summary-value">$100.00</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Checkout Status:</span>
            <span class="summary-value">Processing</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Payment Status:</span>
            <span class="summary-value">Pending</span>
        </div>
    </div>

    <!-- Cart Items Section -->
    <div class="cart-items">
        <h4>Items in Your Cart</h4>

        <!-- Default cart items -->
        <div class="item-row">
            <div class="item-image" style="background-image: url('https://via.placeholder.com/100');"></div>
            <div class="item-details">
                <div class="item-name">Product 1</div>
                <div class="item-price">$30.00</div>
                <div class="item-quantity">Quantity: 2</div>
            </div>
        </div>
        <div class="item-row">
            <div class="item-image" style="background-image: url('https://via.placeholder.com/100');"></div>
            <div class="item-details">
                <div class="item-name">Product 2</div>
                <div class="item-price">$20.00</div>
                <div class="item-quantity">Quantity: 1</div>
            </div>
        </div>
        <div class="item-row">
            <div class="item-image" style="background-image: url('https://via.placeholder.com/100');"></div>
            <div class="item-details">
                <div class="item-name">Product 3</div>
                <div class="item-price">$50.00</div>
                <div class="item-quantity">Quantity: 1</div>
            </div>
        </div>
    </div>

    <!-- Button Section -->
    <div class="button-section">
        <a href="{{ route('customer.orders') }}" class="btn btn-primary">View Order History</a>
        <a href="{{ route('customer.cart') }}" class="btn btn-secondary">Return to Cart</a>
    </div>
</div>
</body>
</html>
