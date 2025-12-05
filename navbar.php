<style>

    nav {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 20px 0;
        margin-bottom: 20px;
    }
    .nav-container {
        display: flex;
        gap: 15px;
        padding: 10px 25px;
        background: #f66b6bff;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        align-items: center;
    }
    .nav-container a {
        text-decoration: none;
        color: #333;
        font-family: Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 15px;
        transition: 0.3s;
    }
    .nav-container a:hover {
        background-color: #e0e0e0;
    }

    .btn-green {
        background: #519851ff;
        color: white !important;
    }
    .btn-green:hover {
        background: #006400;
        color: #000000ff;
    }
</style>

<nav>
    <div class="nav-container">
        <a href="index.php">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        <a href="#">Test</a>

        <?php 
        // Cek status session agar aman (jika session belum start, kita abaikan warning)
        if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['admin'])) {
            // Jika sudah login, arahkan ke Admin Panel
            echo '<a href="admin.php" class="btn-green">Dashboard Admin</a>';
        } else {
            // Jika belum login, arahkan ke Login
            echo '<a href="login.php" class="btn-green">Login Admin</a>';
        }
        ?>
    </div>
</nav>