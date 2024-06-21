@section('content')
@include('partials.topbar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .product-status {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .product-name {
            margin-bottom: 5px;
            font-size: 1.1em;
        }
        .product-price {
            font-weight: bold;
            font-size: 1.2em;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row">
            @php
                $products = [
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 1', 'price' => 1000],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'New Arrival', 'name' => 'Product 2', 'price' => 1500],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Recommended', 'name' => 'Product 3', 'price' => 1200],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 4', 'price' => 1800],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'New Arrival', 'name' => 'Product 5', 'price' => 1600],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Recommended', 'name' => 'Product 6', 'price' => 1100],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 7', 'price' => 1300],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'New Arrival', 'name' => 'Product 8', 'price' => 1400],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Recommended', 'name' => 'Product 9', 'price' => 1250],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 10', 'price' => 1700],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'New Arrival', 'name' => 'Product 11', 'price' => 1350],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Recommended', 'name' => 'Product 12', 'price' => 1900],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 13', 'price' => 1150],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'New Arrival', 'name' => 'Product 14', 'price' => 1450],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Recommended', 'name' => 'Product 15', 'price' => 1650],
                    ['image_url' => 'https://via.placeholder.com/200', 'status' => 'Top Selling', 'name' => 'Product 16', 'price' => 1750],
                ];

                $productsPerPage = 16;
                $currentPage = request()->get('page', 1);
                $totalPages = ceil(count($products) / $productsPerPage);
                $start = ($currentPage - 1) * $productsPerPage;
                $currentProducts = array_slice($products, $start, $productsPerPage);
            @endphp

            @foreach ($currentProducts as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="{{ $product['image_url'] }}" alt="Product Image">
                        <div class="product-status">{{ $product['status'] }}</div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-price">₱{{ number_format($product['price'], 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </nav>
        </div>
    </div>

    @include('partials.footer')

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
