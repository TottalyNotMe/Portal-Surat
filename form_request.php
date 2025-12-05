<?php 
session_start(); 
$jenis_surat = isset($_GET['jenis_surat']) ? $_GET['jenis_surat'] : 'Surat Keterangan';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Isi Data Surat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fafafa; margin:0;}
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #333; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { background: #008000; color: white; padding: 12px; border: none; width: 100%; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px;}
        .btn-submit:hover { background: #006400; }
        .info { background: #e7f3fe; border-left: 6px solid #2196F3; margin-bottom: 15px; padding: 10px; font-size: 13px; }
    </style>
</head>
<body>

    <?php include "navbar.php"; ?>

    <div class="container">
        <h2>Formulir <?= htmlspecialchars($jenis_surat); ?></h2>
        
        <div class="info">
            <strong>Info:</strong> Pastikan data yang Anda masukkan sesuai dengan KTP.
        </div>

        <form action="cetak_surat.php" method="POST" target="_blank">
            
            <input type="hidden" name="jenis_surat" value="<?= $jenis_surat; ?>">

            <div class="form-group">
                <label>NIK</label>
                <input type="number" name="nik" placeholder="Contoh: 3275000..." required>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Sesuai KTP" required>
            </div>

            <div class="form-group" style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required>
                </div>
                <div style="flex:1;">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" required>
                </div>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jk">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Agama</label>
                <select name="agama">
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>

            <div class="form-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" required>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label>Keperluan Surat</label>
                <textarea name="keperluan" rows="2" placeholder="Contoh: Pengurusan KTP, Melamar Kerja, dll." required></textarea>
            </div>

            <button type="submit" name="cetak" class="btn-submit">Simpan & Cetak PDF</button>
        </form>
    </div>

</body>
</html>