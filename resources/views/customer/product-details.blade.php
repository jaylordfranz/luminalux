<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            width: 30%;
            text-align: left;
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-secondary:hover {
            background-color: #495057;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-details">
            <h1>{{ $product->name }}</h1>
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            <p>{{ $product->description }}</p>
            <p>Price: ${{ number_format($product->price, 2) }}</p>
            
            <form id="addToCartForm">
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#addToCartForm').on('submit', function(e) {
        e.preventDefault();

        var quantity = $('#quantity').val();
        var customerId = {{ Auth::id() }};
        var productId = {{ $product->id }};

        $.ajax({
            url: '{{ route('api.carts.store') }}',
            method: 'POST',
            data: {
                customer_id: customerId,
                product_id: productId,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Success:', response);
                alert(response.message);
                window.location.href = '{{ route('customer.cart') }}';
            },
            error: function(xhr, status, error) {
                console.error('Error adding to cart:', error);
                console.log('Response:', xhr.responseText);
                alert('Error adding to cart');
            }
        });
    });
});
    </script>
</body>
</html>