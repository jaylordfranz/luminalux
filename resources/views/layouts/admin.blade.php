<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina Lux-Admin Dashboard</title>
    <link rel="icon" href="https://drive.google.com/file/d/1hpYb-Ru7AO4OUnNtLHuME_b4InxAYQHN/view?usp=sharing" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            overflow-x: hidden;
            transition: width 0.5s;
            color: white;
            font-size: 16px;
        }
        .sidebar.collapsed {
            width: 80px; /* Collapsed width */
            transition: width 0.5s;
        }
        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            transition: background-color 0.3s;
            color: white; /* Text color */
        }
        .sidebar a:hover {
            background-color: #575d63; /* Hover background color */
        }
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .sidebar .toggle-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: #343a40;
            color: white;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 8px;
            border-radius: 4px;
            font-size: 20px;
        }
        .sidebar .toggle-btn:hover {
            background-color: #575d63;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.5s;
            background-color: #fff; /* Main content background color */
        }
        .main-content.collapsed {
            margin-left: 80px; /* Adjust margin-left when sidebar is collapsed */
            transition: margin-left 0.5s;
        }
        .sidebar.collapsed a span {
            display: none;
        }
    </style>
    @yield('styles') <!-- Additional styles section for blade file-specific styles -->
</head>
<body>

    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-angle-double-left"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> 
            <span class="menu-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.users') }}">
            <i class="fas fa-users"></i> 
            <span class="menu-text">User Management</span>
        </a>
        <a href="{{ route('categories.index') }}">
            <i class="fas fa-tags"></i> 
            <span class="menu-text">Category Management</span>
        </a>
        <a href="{{ route('admin.suppliers.index') }}">
            <i class="fas fa-box"></i> 
            <span class="menu-text">Supplier Management</span>
        </a>
        <a href="{{ route('admin.products.index') }}">
            <i class="fas fa-box-open"></i> 
            <span class="menu-text">Product Management</span>
        </a>
        <a href="{{ route('admin.inventory.index') }}">
            <i class="fas fa-warehouse"></i> 
            <span class="menu-text">Inventory Management</span>
        </a>
        <a href="{{ route('admin.payments') }}">
            <i class="fas fa-money-bill-wave"></i> 
            <span class="menu-text">Payment Verification</span>
        </a>
        <a href="{{ route('discounts.index') }}">
            <i class="fas fa-percentage"></i> 
            <span class="menu-text">Discount Management</span>
        </a>
        <a href="{{ route('admin.orders') }}">
            <i class="fas fa-shopping-cart"></i> 
            <span class="menu-text">Order Management</span>
        </a>
        <a href="{{ route('admin.reviews') }}">
            <i class="fas fa-star"></i> 
            <span class="menu-text">Review Management</span>
        </a>
    </div>

    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    @include('partials.footer')

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Additional scripts section for blade file-specific scripts -->
    @yield('scripts')

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        }
    </script>
</body>
</html>
