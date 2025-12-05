<?php
session_start();
include "config.php";

// Cek sesi login (Hanya admin yang bisa tambah admin lain)
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$msg = "";

if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = $_POST['password']; 
    // Catatan: Sebaiknya password di-hash pakai password_hash(), 
    // tapi karena database Anda plain text, kita pakai plain text dulu sesuai request.

    // 1. Cek apakah nama sudah ada?
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE nama='$nama'");
    
    if(mysqli_num_rows($cek) > 0){
        $msg = "<p style='color:red;'>Gagal: Nama Admin '$nama' sudah terpakai!</p>";
    } else {
        // 2. Jika belum ada, masukkan data
        $insert = mysqli_query($conn, "INSERT INTO admin (nama, password) VALUES ('$nama', '$password')");
        if($insert){
            echo "<script>alert('Admin baru berhasil ditambahkan!'); window.location.href='admin.php';</script>";
        } else {
            $msg = "<p style='color:red;'>Terjadi kesalahan sistem.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Admin Baru</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; }
        h2 { text-align: center; margin-top: 0; border-bottom: 2px solid #333; padding-bottom: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        button:hover { background: #0056b3; }
        .btn-back { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #555; }
    </style>
</head>
<body>

<div class="box">
    <h2>Tambah Admin</h2>
    <?= $msg; ?>
    
    <form method="POST">
        <label>Username Baru:</label>
        <input type="text" name="nama" placeholder="Masukkan nama admin baru" required>
        
        <label>Password:</label>
        <input type="password" name="password" placeholder="Masukkan password" required>
        
        <button type="submit" name="tambah">Simpan Admin</button>
    </form>

    <a href="admin.php" class="btn-back">Kembali ke Dashboard</a>
</div>

</body>
</html>