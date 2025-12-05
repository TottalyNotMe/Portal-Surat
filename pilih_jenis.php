<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Surat</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('blobscene.svg');
            background-repeat: no-repeat;
            background-size: cover; 
            background-attachment: fixed;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Container utama */
        .container {
            width: 90%;
            max-width: 800px;
            margin-top: 40px;
            text-align: center;
        }

        /* Grid Layout 2x2 */
        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 Kolom */
            gap: 40px; /* Jarak antar kartu */
            margin-bottom: 50px;
        }

        /* Kartu Pilihan */
        .card-option {
            background: white;
            padding: 40px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 4px solid transparent; /* Border transparan default */
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 150px;
        }

        /* Typography dalam kartu */
        .card-option h3 {
            font-size: 24px;
            margin: 0 0 10px 0;
            color: #000;
        }
        .card-option p {
            font-size: 14px;
            color: #333;
            margin: 0;
        }

        /* Efek Hover */
        .card-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        /* State ACTIVE (Saat dipilih) - Warna Hijau Neon */
        .card-option.active {
            border-color: #66ff99; /* Hijau terang */
            box-shadow: 0 0 15px rgba(102, 255, 153, 0.4);
        }

        /* Tombol Select di bawah */
        .btn-select {
            background: white;
            color: black;
            border: none;
            padding: 15px 60px;
            font-size: 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .btn-select:hover {
            background: #f0f0f0;
        }
        .btn-select:disabled {
            background: #ccc;
            color: #888;
            cursor: not-allowed;
        }

        /* Responsif untuk HP (jadi 1 kolom) */
        @media (max-width: 600px) {
            .options-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>
<body>

    <?php include "navbar.php"; ?>

    <div class="container">
        
        <form action="form_request.php" method="GET" id="selectionForm">
            <input type="hidden" name="jenis_surat" id="selectedInput" required>
            
            <div class="options-grid">
                <div class="card-option" onclick="selectOption(this, 'Surat Pengantar')">
                    <h3>Surat Pengantar</h3>
                    <p>Surat pengantar untuk keperluan</p>
                </div>

                <div class="card-option" onclick="selectOption(this, 'Surat Domisili')">
                    <h3>Surat Domisili</h3>
                    <p>Keterangan tempat tinggal</p>
                </div>

                <div class="card-option" onclick="selectOption(this, 'Legalisir Dokumen')">
                    <h3>Legalisir Dokumen</h3>
                    <p>Pengesahan fotokopi dokumen</p>
                </div>

                <div class="card-option" onclick="selectOption(this, 'Permohonan Lain')">
                    <h3>Permohonan Lain</h3>
                    <p>Surat keterangan lainnya</p>
                </div>
            </div>

            <button type="button" class="btn-select" id="selectBtn" onclick="submitForm()" disabled>Select</button>
        </form>
    </div>

    <script>
        function selectOption(element, value) {
            // 1. Hapus kelas 'active' dari semua kartu
            let cards = document.querySelectorAll('.card-option');
            cards.forEach(card => card.classList.remove('active'));

            // 2. Tambahkan kelas 'active' ke kartu yang diklik
            element.classList.add('active');

            // 3. Masukkan nilai ke input tersembunyi
            document.getElementById('selectedInput').value = value;

            // 4. Aktifkan tombol Select
            document.getElementById('selectBtn').disabled = false;
        }

        function submitForm() {
            // Kirim form ke halaman pengisian data
            document.getElementById('selectionForm').submit();
        }
    </script>

</body>
</html>