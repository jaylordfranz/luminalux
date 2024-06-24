<!-- resources/views/layouts/app.blade.php -->
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
        .top-bar .dropdown-menu a {
            color: #000;
        }
        .top-bar .dropdown-menu a:hover {
            background-color: #f0f0f0;
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
    @include('layouts.topbar')

    <div class="container my-5">
        @yield('content')
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
