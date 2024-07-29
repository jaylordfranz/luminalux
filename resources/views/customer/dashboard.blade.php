
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
         /* Footer Styles */
         .footer {
            background-color: #ffffff;
            color: #343a40;
            padding: 20px 0;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        .footer .footer-logo {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .footer .footer-logo i {
            color: #28a745;
        }
        .footer p {
            margin: 0;
            color: #6c757d;
        }
        .pagination {
            justify-content: center;
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
        <form class="form-inline search-form" id="searchForm">
            <input id="searchInput" class="form-control mr-sm-2 search-input" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0 search-icon" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">
            <a class="nav-link" href="{{ route('customer.profile') }}"><i class="fas fa-user"></i> Customer Profile</a>
            <a class="nav-link" href="{{ route('customer.cart') }}"><i class="fas fa-shopping-cart"></i> Shopping Cart</a>
            <a class="nav-link" href="{{ route('customer.orders.index') }}"><i class="fas fa-history"></i> Order History</a>
            <a class="nav-link" href="{{ route('customer.checkout') }}"><i class="fas fa-credit-card"></i> Checkout</a>
        </div>
    </nav>

    <div class="container my-5" id="product-list">
        <!-- Products will be dynamically added here -->
        <div class="row" id="products-container">
            <!-- Product cards will be inserted here -->
        </div>
    </div>

    <!-- Modal for inputting quantity -->
    <div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quantityModalLabel">Enter Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Product details section -->
                    <div class="product-details">
                        <img id="productImage" src="" alt="Product Image" class="img-fluid mb-3">
                        <h5 id="productName"></h5>
                        <p id="productPrice" class="text-muted"></p>
                    </div>
                    <form id="quantityForm">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        let selectedProductId = null;
        let currentPage = 1;

        function fetchProducts(page = 1) {
            $.ajax({
                url: '{{ route('api.customer.products') }}',
                method: 'GET',
                data: {
                    page: page
                },
                success: function(response) {
                    var products = response.data.data;
                    var pagination = response.data.links;

                    $('#products-container').empty();
                    $('#pagination-controls .pagination').empty();

                    // Append products
                    products.forEach(function(product) {
                        appendProductCard(product);
                    });

                    // Append pagination controls
                    if (pagination.length > 1) {
                        pagination.forEach(function(link) {
                            if (link.url) {
                                $('#pagination-controls .pagination').append(`
                                    <li class="page-item ${link.active ? 'active' : ''}">
                                        <a class="page-link" href="${link.url}">${link.label}</a>
                                    </li>
                                `);
                            }
                        });

                        // Add click event for pagination links
                        $('#pagination-controls .page-link').on('click', function(event) {
                            event.preventDefault();
                            let url = $(this).attr('href');
                            let page = new URL(url).searchParams.get('page');
                            fetchProducts(page);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching products:', error);
                }
            });
        }

        function appendProductCard(product) {
            var formattedPrice = parseFloat(product.price).toFixed(2);

            var productCard = `
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card">
                        <img src="https://via.placeholder.com/150" alt="${product.name} Image">
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">$${formattedPrice}</div>
                        <button class="btn btn-primary product-btn" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${formattedPrice}" data-product-image="${product.image_url}">Add to Cart</button>
                    </div>
                </div>
            `;

            $('#products-container').append(productCard);
        }

        $(document).on('click', '.product-btn', function() {
            selectedProductId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            var productImage = $(this).data('product-image');

            $('#productName').text(productName);
            $('#productPrice').text('$' + productPrice);
            $('#productImage').attr('src', productImage);

            $('#quantityModal').modal('show');
        });

        $('#quantityForm').submit(function(event) {
            event.preventDefault();

            var quantity = $('#quantity').val();

            $.ajax({
                url: '{{ route('customer.add-to-cart') }}',
                method: 'POST',
                data: {
                    product_id: selectedProductId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                success: function(response) {
                    $('#quantityModal').modal('hide');
                    alert('Product added to cart successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Error adding to cart:', error);
                    alert('Failed to add product to cart. Please try again.');
                }
            });
        });

        $('#searchForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var query = $('#searchInput').val();

            // Perform search via AJAX
            $.ajax({
                url: '{{ route('search') }}',
                dataType: 'json',
                data: {
                    query: query
                },
                success: function(data) {
                    // Clear existing products
                    $('#products-container').empty();

                    // Check if search result is empty
                    if (data.length === 0) {
                        $('#products-container').append('<p>No products found.</p>');
                    } else {
                        // Append new products based on search results
                        data.forEach(function(product) {
                            appendProductCard(product);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error performing search:', error);
                }
            });
        });

        // Initial fetch
        fetchProducts();
    });
    </script>
</body>
<footer class="footer">
    <!-- Pagination Controls -->
    <div class="container">
        <nav id="pagination-controls" aria-label="Product pagination">
            <ul class="pagination justify-content-center">
                <!-- Pagination links will be inserted here -->
            </ul>
        </nav>
    </div>
</footer>
</html>
