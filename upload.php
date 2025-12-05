<?php
session_start();
include "config.php";

// 1. CEK LOGIN & SESSION
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Fitur Auto Logout 50 Menit
$timeout_duration = 3000; 
if (isset($_SESSION['last_activity'])) {
    if ((time() - $_SESSION['last_activity']) > $timeout_duration) {
        session_unset(); session_destroy();
        header("Location: login.php?pesan=timeout");
        exit;
    }
}
$_SESSION['last_activity'] = time();

// 2. PROSES UPLOAD
if(isset($_POST['upload'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);

    // --- BARU: Cek apakah JUDUL sudah ada di database? ---
    $cek_judul = mysqli_query($conn, "SELECT * FROM pdf_files WHERE title='$title'");
    if(mysqli_num_rows($cek_judul) > 0){
        // Jika ketemu, hentikan proses dan beri peringatan
        echo "<script>
            alert('GAGAL: Judul dokumen sudah ada! Harap gunakan judul yang berbeda.');
            window.location.href='upload.php';
        </script>";
        exit;
    }
    // -----------------------------------------------------

    // Ambil info file
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['pdf'];

    if(in_array($fileExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 5000000){ // Max 5MB
                
                // Rename file agar unik (tetap pakai ini untuk nama file fisik)
                $fileNameNew = time() . "_" . uniqid() . "." . $fileExt;
                $fileDestination = 'uploads/' . $fileNameNew;

                if(!is_dir('uploads')){ mkdir('uploads'); }

                if(move_uploaded_file($fileTmp, $fileDestination)){
                    $query = "INSERT INTO pdf_files(title, description, file_path) VALUES('$title', '$desc', '$fileDestination')";
                    mysqli_query($conn, $query);

                    echo "<script>alert('Upload Berhasil!'); window.location.href='admin.php';</script>";
                } else {
                    echo "<script>alert('Gagal upload file.');</script>";
                }
            } else {
                echo "<script>alert('File terlalu besar (Max 5MB).');</script>";
            }
        } else {
            echo "<script>alert('Terjadi error pada file.');</script>";
        }
    } else {
        echo "<script>alert('Hanya format PDF yang diperbolehkan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Dokumen PDF</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .upload-box { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; border-bottom: 2px solid #ddd; padding-bottom: 15px; color: #333; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 20px; font-weight: bold; }
        button:hover { background: #218838; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
<div class="upload-box">
    <h2>Upload Dokumen PDF</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Judul Dokumen:</label>
        <input type="text" name="title" placeholder="Judul harus unik..." required>
        
        <label>Deskripsi:</label>
        <textarea name="desc" rows="3"></textarea>
        
        <label>File PDF:</label>
        <input type="file" name="file" accept="application/pdf" required>
        
        <button type="submit" name="upload">Upload</button>
    </form>
    <a href="admin.php" class="btn-back">&larr; Kembali ke Dashboard</a>
</div>
</body>
</html>