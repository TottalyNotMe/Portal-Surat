<?php
// Memanggil library FPDF
require('fpdf.php'); // Pastikan file ini ada di folder project Anda

if (isset($_POST['cetak'])) {
    
    // Ambil Data dari Form
    $jenis_surat = $_POST['jenis_surat'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tempat_lahir = $_POST['tempat_lahir'];
    // Format tanggal indonesia
    $tgl_lahir = date("d-m-Y", strtotime($_POST['tgl_lahir'])); 
    $jk = $_POST['jk'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $alamat = $_POST['alamat'];
    $keperluan = $_POST['keperluan'];
    
    // Tanggal hari ini
    $tanggal_surat = date("d F Y");

    // MULAI MEMBUAT PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // --- 1. HEADER / KOP SURAT ---
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'PEMERINTAH KABUPATEN CONTOH', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 7, 'KECAMATAN CONTOH', 0, 1, 'C');
    $pdf->Cell(0, 7, 'DESA SUKAMAJU', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Jl. Raya Desa No. 123, Telp (021) 123456', 0, 1, 'C');
    $pdf->Cell(0, 2, '', 0, 1); // Spasi
    $pdf->Cell(0, 1, '', 1, 1, 'C'); // Garis Bawah Kop
    $pdf->Cell(0, 1, '', 1, 1, 'C'); // Garis double (opsional)

    $pdf->Ln(10); // Jarak ke Judul

    // --- 2. JUDUL SURAT ---
    $pdf->SetFont('Arial', 'BU', 14);
    $pdf->Cell(0, 10, strtoupper($jenis_surat), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 5, 'Nomor: 470 / ... / DS / ' . date('Y'), 0, 1, 'C');

    $pdf->Ln(10);

    // --- 3. ISI SURAT (PEMBUKA) ---
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 7, 'Yang bertanda tangan di bawah ini Kepala Desa Sukamaju, Kecamatan Contoh, Kabupaten Contoh, menerangkan dengan sebenarnya bahwa:');

    $pdf->Ln(5);

    // --- 4. BIODATA (Menggunakan Cell agar rapi) ---
    $h = 7; // Tinggi baris
    $w_label = 50; // Lebar label
    $w_titik = 5;  // Lebar titik dua
    
    // Nama
    $pdf->Cell($w_label, $h, 'Nama Lengkap', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, strtoupper($nama), 0, 1);

    // NIK
    $pdf->Cell($w_label, $h, 'NIK', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, $nik, 0, 1);

    // TTL
    $pdf->Cell($w_label, $h, 'Tempat/Tgl Lahir', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, $tempat_lahir . ', ' . $tgl_lahir, 0, 1);

    // Jenis Kelamin
    $pdf->Cell($w_label, $h, 'Jenis Kelamin', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, $jk, 0, 1);

    // Agama
    $pdf->Cell($w_label, $h, 'Agama', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, $agama, 0, 1);

    // Pekerjaan
    $pdf->Cell($w_label, $h, 'Pekerjaan', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->Cell(0, $h, $pekerjaan, 0, 1);

    // Alamat
    $pdf->Cell($w_label, $h, 'Alamat', 0, 0);
    $pdf->Cell($w_titik, $h, ':', 0, 0);
    $pdf->MultiCell(0, $h, $alamat); // Multicell untuk teks panjang

    $pdf->Ln(5);

    // --- 5. KEPERLUAN ---
    $pdf->MultiCell(0, 7, 'Orang tersebut adalah benar-benar warga Desa Sukamaju. Surat ini dibuat untuk keperluan:');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 7, '"' . $keperluan . '"');
    $pdf->SetFont('Arial', '', 12);

    $pdf->Ln(5);
    $pdf->MultiCell(0, 7, 'Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.');

    $pdf->Ln(20);

    // --- 6. TANDA TANGAN ---
    // Geser posisi ke kanan untuk tanda tangan
    $pdf->Cell(110); // Geser 110mm ke kanan
    $pdf->Cell(0, 5, 'Sukamaju, ' . $tanggal_surat, 0, 1, 'C');
    $pdf->Cell(110);
    $pdf->Cell(0, 5, 'Kepala Desa Sukamaju', 0, 1, 'C');
    
    $pdf->Ln(25); // Ruang untuk tanda tangan
    
    $pdf->Cell(110);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, '( BAPAK KEPALA DESA )', 0, 1, 'C'); // Nama Kades

    // Output PDF ke Browser
    // 'I' artinya Inline (tampil di browser), 'D' artinya Download paksa
    $pdf->Output('I', 'Surat_' . $nik . '.pdf');

} else {
    echo "Akses dilarang.";
}
?>