<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina Lux</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        .top-bar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
        }
        .top-bar .navbar-nav .nav-link {
            margin-right: 15px;
        }
        .top-bar .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .top-bar .dropdown-menu a {
            color: #000;
            padding: 10px 20px;
        }
        .top-bar .dropdown-menu a:hover {
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .search-form {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        .search-input {
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 8px 20px;
            margin-right: 10px;
            width: 250px;
        }
        .search-icon {
            color: #aaa;
        }
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
        .product-name {
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        .product-price {
            font-weight: bold;
            font-size: 1.4em;
            color: #28a745;
            margin-bottom: 10px;
        }
        .product-btn {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light top-bar">
        <!-- Home Icon Link -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
            <i class="fas fa-home mr-2"></i>
            Lumina Lux
        </a>

        <!-- Search form -->
        <form class="form-inline search-form">
            <input class="form-control mr-sm-2 search-input" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0 search-icon" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">
            <div class="dropdown mr-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter"></i> Categories
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
        
                    <a class="dropdown-item" href="{{ route('customer.skincare') }}">Skincare</a>
                    <a class="dropdown-item" href="{{ route('customer.makeup') }}">Makeup</a>
                    <a class="dropdown-item" href="{{ route('customer.haircare') }}">Haircare</a>
                    <a class="dropdown-item" href="{{ route('customer.bodycare') }}">Bodycare</a>
                </div>
            </div>
            <a class="nav-link" href="#"><i class="fas fa-heart"></i></a>
            <a class="nav-link" href="{{ route('customer.profile') }}"><i class="fas fa-user"></i> Customer Profile</a>
            <a class="nav-link" href="{{ route('customer.cart') }}"><i class="fas fa-shopping-cart"></i> Shopping Cart</a>
            <a class="nav-link" href="{{ route('customer.orders') }}"><i class="fas fa-history"></i> Order History</a>
            <a class="nav-link" href="{{ route('customer.reviews') }}"><i class="fas fa-star"></i> Product Reviews</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <img src="https://via.placeholder.com/200" alt="Product Image">
                    <div class="product-name">Sample Product 1</div>
                    <div class="product-price">$XX.XX</div>
                    <button class="btn btn-primary product-btn">Add to Cart</button>
                </div>
            </div>
            <!-- Add more product cards here -->
            <!-- Example:
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <img src="https://via.placeholder.com/200" alt="Product Image">
                    <div class="product-name">Sample Product 2</div>
                    <div class="product-price">$XX.XX</div>
                    <button class="btn btn-primary product-btn">Add to Cart</button>
                </div>
            </div>
            -->
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
