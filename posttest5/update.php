<?php
include('koneksi.php');

$errors = [];
$form_data = [
    'nama' => '',
    'nama_obat' => '',
    'jumlah' => '',
    'tanggal' => ''
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: data_pesanan.php");
    exit();
}

try {
    $query = "SELECT * FROM pemesanan WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $form_data = [
            'nama' => $row['nama_pemesan'],
            'nama_obat' => $row['nama_obat'],
            'jumlah' => $row['jumlah_obat'],
            'tanggal' => $row['tanggal_pemesanan']
        ];
    } else {
        die("Data tidak ditemukan");
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $form_data = [
        'nama' => trim(htmlspecialchars($_POST['nama'])),
        'nama_obat' => trim(htmlspecialchars($_POST['nama_obat'])),
        'jumlah' => trim(htmlspecialchars($_POST['jumlah'])),
        'tanggal' => trim(htmlspecialchars($_POST['tanggal']))
    ];

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

    if (empty($errors)) {
        try {
            $query = "UPDATE pemesanan 
                     SET nama_pemesan = ?, 
                         nama_obat = ?, 
                         jumlah_obat = ?, 
                         tanggal_pemesanan = ?
                     WHERE id = ?";
            
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "ssisi", 
                $form_data['nama'],
                $form_data['nama_obat'],
                $form_data['jumlah'],
                $form_data['tanggal'],
                $id
            );

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Data telah diupdate!');
                        window.location.href = 'data_pesanan.php';
                      </script>";
                exit();
            } else {
                throw new Exception("Gagal mengupdate data");
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
    <title>Update Pemesan</title>
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
        input[type="date"] {
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
        input[type="date"]:focus {
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
        <h1>Update pemesan</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nama">Nama Pemesan:</label>
                <input type="text" id="nama" name="nama" 
                       value="<?php echo htmlspecialchars($form_data['nama']); ?>"
                       placeholder="Masukkan nama Anda">
            </div>

            <div class="form-group">
                <label for="nama_obat">Nama Obat:</label>
                <input type="text" id="nama_obat" name="nama_obat"
                       value="<?php echo htmlspecialchars($form_data['nama_obat']); ?>"
                       placeholder="Masukkan nama obat">
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Obat:</label>
                <input type="number" id="jumlah" name="jumlah"
                       value="<?php echo htmlspecialchars($form_data['jumlah']); ?>"
                       min="1" placeholder="Masukkan jumlah obat">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Pemesanan:</label>
                <input type="date" id="tanggal" name="tanggal"
                       value="<?php echo htmlspecialchars($form_data['tanggal']); ?>">
            </div>

            <div class="button-group">
                <a href="data_pesanan.php" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-submit">Update Pesanan</button>
            </div>
        </form>
    </div>
</body>
</html>
