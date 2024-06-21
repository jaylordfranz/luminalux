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

        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Popular</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Flash Deals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Free Shipping</a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown mr-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                    <a class="dropdown-item" href="#">Skincare</a>
                    <a class="dropdown-item" href="#">Makeup</a>
                    <a class="dropdown-item" href="#">Haircare</a>
                    <a class="dropdown-item" href="#">Bodycare</a>
                </div>
            </div>
            <a class="nav-link" href="#"><i class="fas fa-heart"></i></a>
            <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
            <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </nav>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
