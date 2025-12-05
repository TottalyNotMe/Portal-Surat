<?php
session_start();
include "config.php";

$error = "";

// 1. Cek Pesan Timeout
if(isset($_GET['pesan']) && $_GET['pesan'] == "timeout"){
    $error = "Sesi Anda telah berakhir. Silakan login kembali.";
}

// 2. Logika Login
if(isset($_POST['login'])){
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE nama='$nama'");

    // Cek nama
    if(mysqli_num_rows($query) === 1){
        $data = mysqli_fetch_assoc($query);

        // Cek password
        if($password === $data['password']){
            $_SESSION['admin'] = $data['nama'];
            
            // Set waktu login awal untuk fitur auto-logout
            $_SESSION['last_activity'] = time(); 
            
            header("Location: admin.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Nama tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body { font-family: Arial; background:#fafafa; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
        .login-box { background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px rgba(0,0,0,0.1); width:300px;}
        input { width:100%; box-sizing: border-box; padding:10px; margin:5px 0 15px; border:1px solid #ccc; border-radius:5px;}
        button { width:100%; padding:10px; background:#000; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:bold;}
        button:hover { background:#333; }
        .error { color:red; margin-bottom:10px; font-size:14px; text-align:center;}
        h2 { text-align: center; margin-top: 0; }

        /* Tambahan CSS untuk Tombol Kembali */
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-back:hover {
            color: #000;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="login">Login</button>
    </form>

    <a href="index.php" class="btn-back">&larr; Kembali ke Halaman Utama</a>
</div>

</body>
</html>