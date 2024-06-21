<!-- resources/views/partials/header.blade.php -->

<header class="header navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="https://drive.google.com/file/d/1hpYb-Ru7AO4OUnNtLHuME_b4InxAYQHN/view?usp=sharing" alt="Lumina Lux" height="30">
        Lumina Lux
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <div class="navbar-nav">
            <!-- Remove the static navigation links -->
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="profileButton"
                    aria-haspopup="true" aria-expanded="false" onclick="toggleProfileMenu()">
                    <span>Hi, Jaylord Franz!</span> <!-- Demo user name -->
                    <i class="fas fa-user-circle"></i>
                </button>
                <div id="profileMenu" class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>
            <div class="nav-item">
                <span class="nav-link"><span id="clock">{{ now()->format('H:i:s') }}</span></span>
            </div>
        </div>
    </div>
</header>

<style>
    /* Example styles for the header */
    .navbar-brand {
        display: flex;
        align-items: center;
        font-weight: bold;
        color: #333333;
    }

    .navbar-brand img {
        margin-right: 10px;
    }

    .navbar-nav .nav-link {
        margin-left: 10px;
    }

    .dropdown-menu {
        min-width: 150px;
    }
</style>

<script>
    // Real-time clock update
    setInterval(() => {
        const now = new Date();
        const clock = document.getElementById('clock');
        clock.textContent = now.toLocaleTimeString();
    }, 1000);

    // Toggle profile menu
    function toggleProfileMenu() {
        const profileMenu = document.getElementById('profileMenu');
        profileMenu.classList.toggle('show');
    }
</script>
