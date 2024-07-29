<!-- resources/views/layouts/topbar.blade.php -->
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
        <a class="nav-link" href="{{ route('customer.profile') }}"><i class="fas fa-user"></i> Customer Profile</a>
        <a class="nav-link" href="{{ route('customer.cart') }}"><i class="fas fa-shopping-cart"></i> Shopping Cart</a>
        <a class="nav-link" href="{{ route('customer.checkout') }}"><i class="fas fa-credit-card"></i> Checkout</a>
        <a class="nav-link" href="{{ route('customer.orders.index') }}"><i class="fas fa-history"></i> Order History</a>
    </div>
</nav>
