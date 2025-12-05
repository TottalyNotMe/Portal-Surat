<?php
session_start();
include "config.php";
// auto logout
$timeout_duration = 3000;

if (isset($_SESSION['last_activity'])) {
    // Hitung selisih waktu sekarang dengan waktu terakhir aktivitas
    $duration = time() - $_SESSION['last_activity'];
    
    // Jika durasi lebih lama dari 50 menit
    if ($duration > $timeout_duration) {
        session_unset();     // Hapus variabel session
        session_destroy();   // Hancurkan session
        header("Location: login.php?pesan=timeout"); // Redirect ke login
        exit;
    }
}

// Update waktu aktivitas terakhir menjadi SEKARANG
$_SESSION['last_activity'] = time();
//Cek jika Admin login atau tidak
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
// 1. Ambil data PDF yang sudah diupload
$query_pdf = mysqli_query($conn, "SELECT * FROM pdf_files ORDER BY id DESC");

// 2. Ambil data Request dari user (jika tabel requests sudah dibuat)
$query_req = mysqli_query($conn, "SELECT * FROM requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #333; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 4px; font-size: 12px; }
        .btn-add { background: #28a745; font-size: 14px; padding: 5px 15px; }
        .btn-tambah { background: #17a2b8; font-size: 14px; padding: 5px 15px; }
        .btn-del { background: #dc3545; }
        .btn-logout { float: right; background: #555; }
        .section { margin-bottom: 40px; }
    </style>
</head>
<body>

<div class="container">
    <a href="logout.php" class="btn btn-logout">Logout</a>
    <h2>Panel Admin - Hallo, <?php echo $_SESSION['admin']; ?></h2>

    <div class="section">
        <h3>📂 Kelola File PDF</h3>
        <a href="upload.php" class="btn btn-add">+ Upload PDF Baru</a>
        <a href="tambah_admin.php" class="btn btn-tambah">+ Admin Baru</a>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if(mysqli_num_rows($query_pdf) > 0):
                    while($row = mysqli_fetch_assoc($query_pdf)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td><a href="<?= $row['file_path']; ?>" target="_blank">Lihat PDF</a></td>
                    <td>
                        <a href="delete.php?id=<?= $row['id']; ?>&type=pdf&file=<?= urlencode($row['file_path']); ?>" 
                           class="btn btn-del" 
                           onclick="return confirm('Yakin hapus file ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5">Belum ada file PDF diupload.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>✉️ Request Surat Masuk</h3>
        <table>
            <thead>
                <tr>
                    <th>Pengirim</th>
                    <th>Kontak</th>
                    <th>Pesan Request</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Cek apakah query berhasil (antisipasi kalau tabel belum dibuat)
                if($query_req && mysqli_num_rows($query_req) > 0):
                    while($req = mysqli_fetch_assoc($query_req)): 
                ?>
                <tr>
                    <td><?= htmlspecialchars($req['nama_pengirim']); ?></td>
                    <td><?= htmlspecialchars($req['kontak']); ?></td>
                    <td><?= htmlspecialchars($req['pesan']); ?></td>
                    <td><?= $req['created_at']; ?></td>
                    <td>
                        <a href="delete.php?id=<?= $req['id']; ?>&type=req" 
                           class="btn btn-del"
                           onclick="return confirm('Hapus request ini?')">Hapus / Selesai</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5">Tidak ada request surat baru.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <hr>
</div>

</body>
</html>