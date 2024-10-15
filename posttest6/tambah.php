<?php
include('koneksi.php');

$errors = [];
$form_data = [
    'nama' => '',
    'nama_obat' => '',
    'jumlah' => '',
    'tanggal' => '',
    'file' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $form_data = [
        'nama' => trim(htmlspecialchars($_POST['nama'])),
        'nama_obat' => trim(htmlspecialchars($_POST['nama_obat'])),
        'jumlah' => trim(htmlspecialchars($_POST['jumlah'])),
        'tanggal' => trim(htmlspecialchars($_POST['tanggal']))
    ];

    // Validasi input
    if (empty($form_data['nama'])) {
        $errors[] = "Nama pemesan harus diisi";
    }

    if (empty($form_data['nama_obat'])) {
        $errors[] = "Nama obat harus diisi";
    }

    if (empty($form_data['jumlah'])) {
        $errors[] = "Jumlah obat harus diisi";
    } elseif (!is_numeric($form_data['jumlah']) || $form_data['jumlah'] <= 0) {
        $errors[] = "Jumlah obat harus berupa angka positif";
    }

    if (empty($form_data['tanggal'])) {
        $errors[] = "Tanggal pemesanan harus diisi";
    }

    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['name'];
        $ekstensi_diperbolehkan = array('pdf', 'doc', 'docx', 'png', 'jpg'); 
        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['file']['tmp_name'];

        
        if ($_FILES['file']['size'] > 1 * 1024 * 1024) {
            $errors[] = "Ukuran file tidak boleh lebih dari 1MB.";
        }else {
            $tanggal_upload = date('Y-m-d-H-i-s');
            $nama_file_baru = $tanggal_upload . '-' . $file;
        }
 

        if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
            move_uploaded_file($file_tmp, 'files/' . $nama_file_baru);
        } else {
            $errors[] = "Ekstensi file yang boleh hanya pdf, doc, docx, jpg, atau png.";
        }
    }

    
    if (empty($errors)) {
        try {
            $query = "INSERT INTO pemesanan (nama_pemesan, nama_obat, jumlah_obat, tanggal_pemesanan, file) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "ssiss", 
                $form_data['nama'],
                $form_data['nama_obat'],
                $form_data['jumlah'],
                $form_data['tanggal'],
                $nama_file_baru 
            );

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Data telah ditambahkan!');
                        setTimeout(function(){
                            window.location.href = 'data_pesanan.php';
                        }, 1000);
                      </script>";
                exit();
            } else {
                throw new Exception("Gagal menyimpan data");
            }
        } catch (Exception $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #da190b;
        }
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Pesanan</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Pemesan:</label>
                <input type="text" id="nama" name="nama" 
                       value="<?php echo $form_data['nama']; ?>"
                       placeholder="Masukkan nama Anda">
            </div>

            <div class="form-group">
                <label for="nama_obat">Nama Obat:</label>
                <input type="text" id="nama_obat" name="nama_obat"
                       value="<?php echo $form_data['nama_obat']; ?>"
                       placeholder="Masukkan nama obat">
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Obat:</label>
                <input type="number" id="jumlah" name="jumlah"
                       value="<?php echo $form_data['jumlah']; ?>"
                       min="1" placeholder="Masukkan jumlah obat">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Pemesanan:</label>
                <input type="date" id="tanggal" name="tanggal"
                       value="<?php echo $form_data['tanggal']; ?>">
            </div>

            <div class="form-group">
                <label>Upload File:</label>
                <input type="file" name="file">
                <i style="font-size: 11px;color: red">Abaikan jika tidak ada file yang ingin diunggah</i>
            </div>

            <div class="button-group">
                <a href="data_pesanan.php" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-submit">Tambah Sekarang</button>
            </div>
        </form>
    </div>
</body>
</html>
