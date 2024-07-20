<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Summary</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        .checkout-container {
            margin-top: 50px;
        }
        .order-summary, .billing-address, .cart-items {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .summary-label {
            font-weight: bold;
        }
        .item-row {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .item-image {
            width: 80px;
            height: 80px;
            background-size: cover;
            background-position: center;
            margin-right: 20px;
            border-radius: 5px;
        }
        .item-details {
            flex-grow: 1;
        }
        .button-section {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            margin-top: 10px;
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
                <span class="summary-label">Total Amount:</span>
                <span class="summary-value">${{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>

        <!-- Billing Address Section -->
        <div class="billing-address">
            <h4>Billing Address</h4>
            <form action="{{ route('customer.process-checkout') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="billing_address">Select Billing Address:</label>
                    <select name="billing_address" id="billing_address" class="form-control">
                        @foreach($billingAddresses as $address)
                            <option value="{{ $address->id }}">{{ $address->address_name }} - {{ $address->address }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cart Items Section -->
                <div class="cart-items">
                    <h4>Cart Items</h4>
                    @foreach($cartItems as $cartItem)
                        <div class="item-row">
                            <div class="item-image" style="background-image: url('{{ $cartItem->product->image_url }}');"></div>
                            <div class="item-details">
                                <div class="item-name">{{ $cartItem->product->name }}</div>
                                <div class="item-price">${{ number_format($cartItem->product->price, 2) }}</div>
                                <div class="item-quantity">Quantity: {{ $cartItem->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Checkout Buttons -->
                <div class="button-section">
                    <button type="submit" class="btn btn-primary">Confirm Checkout</button>
                    <a href="{{ route('customer.cart') }}" class="btn btn-secondary">Back to Cart</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>