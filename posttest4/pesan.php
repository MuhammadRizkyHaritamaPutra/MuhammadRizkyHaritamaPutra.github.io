<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: gray;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1, h2, p {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pemesanan Obat</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = htmlspecialchars(trim($_POST['nama']));
        $nama_obat = htmlspecialchars(trim($_POST['nama_obat']));
        $jumlah = htmlspecialchars(trim($_POST['jumlah']));
        $tanggal = htmlspecialchars(trim($_POST['tanggal']));

        $error = '';

        if (empty($nama)) {
            $error .= '<p>Nama pemesan harus diisi.</p>';
        }

        if (empty($nama_obat)) {
            $error .= '<p>Nama obat harus diisi.</p>';
        }

        if (!is_numeric($jumlah) || $jumlah <= 0) {
            $error .= '<p>Jumlah obat harus berupa angka positif.</p>';
        }

        if (empty($tanggal)) {
            $error .= '<p>Tanggal pemesanan harus diisi.</p>';
        }

        if (empty($error)) {
            echo '<h2>Detail Pesanan Anda</h2>';
            echo '<p><strong>Nama Pemesan:</strong> ' . $nama . '</p>';
            echo '<p><strong>Nama Obat:</strong> ' . $nama_obat . '</p>';
            echo '<p><strong>Jumlah:</strong> ' . $jumlah . '</p>';
            echo '<p><strong>Tanggal Pemesanan:</strong> ' . $tanggal . '</p>';
            
        } else {
            echo '<div style="color: red;">' . $error . '</div>';
        }
    } else {
    ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Pemesan:</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda">
            </div>

            <div class="form-group">
                <label for="nama_obat">Nama Obat:</label>
                <input type="text" id="nama_obat" name="nama_obat" placeholder="Masukkan nama obat">
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Obat:</label>
                <input type="number" id="jumlah" name="jumlah" min=0 placeholder="Masukkan jumlah obat">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Pemesanan:</label>
                <input type="date" id="tanggal" name="tanggal">
            </div>

            <input type="submit" value="Pesan Sekarang">
        </form>
    <?php
    }
    ?>
</div>

</body>
</html>
