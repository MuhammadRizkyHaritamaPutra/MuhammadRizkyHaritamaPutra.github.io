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
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="file"] {
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
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pemesanan Obat</h1>
    <?php
    include 'koneksi.php'; 

    $nama = $nama_obat = $jumlah = $tanggal = '';
    $error = '';

    
    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = htmlspecialchars(trim($_POST['nama']));
        $nama_obat = htmlspecialchars(trim($_POST['nama_obat']));
        $jumlah = htmlspecialchars(trim($_POST['jumlah']));
        $tanggal = htmlspecialchars(trim($_POST['tanggal']));

        
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file = $_FILES['file']['name'];
            $ekstensi_diperbolehkan = array('pdf', 'doc', 'docx', 'png', 'jpg'); 
            $x = explode('.', $file);
            $ekstensi = strtolower(end($x));
            $file_tmp = $_FILES['file']['tmp_name'];

            
            if ($_FILES['file']['size'] > 1 * 1024 * 1024) {
                $error .= '<p>Ukuran file tidak boleh lebih dari 1MB.</p>';
            } else {
                $tanggal_upload = date('Y-m-d-H-i-s');
                $nama_file_baru = $tanggal_upload . '-' . $file;
            }

                if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
                    move_uploaded_file($file_tmp, 'files/' . $nama_file_baru); 
                    $file = $nama_file_baru; 
                } else {
                    $error .= '<p>Ekstensi file yang boleh hanya pdf, doc, docx, jpg, atau png.</p>';
                }
            }
        }

        
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
            $query = "INSERT INTO pemesanan (nama_pemesan, nama_obat, jumlah_obat, tanggal_pemesanan, file) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            
            if ($stmt === false) {
                die("Error preparing statement: " . mysqli_error($koneksi));
            }

            mysqli_stmt_bind_param($stmt, "ssiss", $nama, $nama_obat, $jumlah, $tanggal, $file);

            if (mysqli_stmt_execute($stmt)) {
                echo '<script>
                        alert("Pesanan telah ditambahkan.");
                        window.location.href = "index.html"; // Ganti dengan URL halaman utama Anda
                      </script>';
                exit();
            } else {
                echo '<div class="error-message">Gagal menyimpan data: ' . mysqli_stmt_error($stmt) . '</div>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<div class="error-message">' . $error . '</div>';
        }
    }
    ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama Pemesan:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama Anda" required>
        </div>

        <div class="form-group">
            <label for="nama_obat">Nama Obat:</label>
            <input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat; ?>" placeholder="Masukkan nama obat" required>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah Obat:</label>
            <input type="number" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" min="1" placeholder="Masukkan jumlah obat" required>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Pemesanan:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required>
        </div>

        <div class="form-group">
            <label for="file">Upload File:</label>
            <input type="file" id="file" name="file">
        </div>

        <input type="submit" value="Pesan Sekarang">
    </form>
</div>

</body>
</html>
