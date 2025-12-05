<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pusat Dokumen & Surat Desa</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f8;
        color: #333;
    }

    /* Hero Section (Banner Atas) */
    .hero-section {
        text-align: center;
        padding: 60px 20px;
        background: white;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .hero-section h1 { margin: 0 0 10px 0; color: #2c3e50; font-size: 2.5rem; }
    .hero-section p { color: #666; margin-bottom: 30px; font-size: 1.1rem; }
    .btn-cta {
        background: #dc3545;
        color: white;
        padding: 12px 30px;
        text-decoration: none;
        border-radius: 50px;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    }
    .btn-cta:hover { background: #ffac8eff; transform: translateY(-2px); }

    /* Judul Bagian Dokumen */
    .section-title {
        text-align: center;
        margin-top: 20px;
        font-size: 1.5rem;
        color: #444;
        border-bottom: 2px solid #ddd;
        display: inline-block;
        padding-bottom: 5px;
        /* Trik centering inline-block */
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 20px;
    }

    /* Grid Layout */
    .wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 30px;
        padding: 20px 60px 60px 60px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Card Design */
    .card {
        background: #fff;
        padding: 30px 20px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        text-align: center;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #eee;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: #b3d7ff;
    }
    .card img {
        width: 70px;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    .card h4 {
        margin: 10px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        line-height: 1.4;
        /* Membatasi panjang judul agar tidak merusak layout */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card .desc {
        font-size: 12px; 
        color: #777; 
        margin-bottom: 20px;
    }
    
    /* Tombol Download di dalam Card */
    .btn-download {
        font-size: 13px;
        text-decoration: none;
        color: white;
        background-color: #dc3545; /* Merah PDF */
        padding: 8px 20px;
        border-radius: 20px;
        transition: 0.2s;
        width: 80%;
    }
    .btn-download:hover {
        background-color: #c82333;
    }

    /* Pesan Kosong */
    .empty-msg {
        grid-column: 1 / -1;
        text-align: center;
        color: #888;
        padding: 50px;
        font-style: italic;
    }
</style>
</head>
<body>

<?php include "navbar.php"; ?>

<div class="hero-section">
    <h1>Layanan Desa Digital</h1>
    <p>Unduh dokumen resmi atau ajukan surat keterangan dari rumah.</p>
    <a href="pilih_jenis.php" class="btn-cta">Buat Surat Baru &rarr;</a>
</div>

<h3 class="section-title">Dokumen & Arsip Publik</h3>

<div class="wrapper">

    <?php
    // Query mengambil data dari database, diurutkan dari yang terbaru (DESC)
    $query = mysqli_query($conn, "SELECT * FROM pdf_files ORDER BY id DESC");

    // Cek apakah ada data
    if(mysqli_num_rows($query) > 0){
        // Looping data
        while($row = mysqli_fetch_assoc($query)){
            $judul = htmlspecialchars($row['title']);
            $deskripsi = htmlspecialchars($row['description']); // Opsional, kalau mau ditampilkan
            $file_path = $row['file_path'];
    ?>
    
            <div class="card">
        <!--change the img later-->
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" alt="PDF Icon" />
                
                <h4><?= $judul; ?></h4>
                
                <a href="<?= $file_path; ?>" target="_blank" class="btn-download">Lihat / Download</a>
            </div>

    <?php 
        } // Tutup While
    } else {
        // Jika Database Kosong
        echo '<div class="empty-msg">Belum ada dokumen publik yang diunggah oleh admin.</div>';
    }
    ?>

</div>

</body>
</html>