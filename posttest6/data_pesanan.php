<?php
  include('koneksi.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesanan Obat</title>
    <style type="text/css">
      * {
        font-family: "Trebuchet MS";
      }
      h1 {
        text-transform: uppercase;
        color: rgb(64, 64, 183);
        text-align: center;
      }
      table {
        border: 1px solid #ddd;
        border-collapse: collapse;
        border-spacing: 0;
        width: 80%;
        margin: 20px auto;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
      }
      table thead th {
        background-color: rgb(64, 64, 183);
        border: 1px solid #ddd;
        color: white;
        padding: 12px;
        text-align: left;
        text-shadow: none;
      }
      table tbody td {
        border: 1px solid #ddd;
        color: #333;
        padding: 12px;
      }
      table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
      }
      .btn {
        background-color: rgb(64, 64, 183);
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 14px;
        border-radius: 4px;
        display: inline-block;
        margin: 5px;
        transition: background-color 0.3s;
      }
      .btn:hover {
        background-color: rgb(50, 50, 150);
      }
      .btn-delete {
        background-color: #dc3545;
      }
      .btn-delete:hover {
        background-color: #c82333;
      }
      .container {
        width: 90%;
        margin: 0 auto;
        padding: 20px;
      }
      .action-column {
        white-space: nowrap;
      }
      .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
      }
      .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
      }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Pemesan</h1>
        <div style="text-align: center;">
            <a href="index.html" class="btn">Back to Home</a>
            <a href="tambah.php" class="btn">+ Tambah Pemesan</a>
        </div>

        <?php
        if (isset($error)) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Nama Obat</th>
                    <th>Jumlah Obat</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            try {
                $query = "SELECT * FROM pemesanan ORDER BY id ASC";
                $result = mysqli_query($koneksi, $query);

                if (!$result) {
                    throw new Exception(mysqli_error($koneksi));
                }

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    $tanggal = isset($row['tanggal_pemesanan']) ? htmlspecialchars($row['tanggal_pemesanan']) : 'Tidak ada tanggal';
            ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pemesan']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_obat']); ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah_obat']); ?></td>
                        <td><?php echo $tanggal; ?></td>
                        <td style="text-align: center;"><img src="files/<?php echo $row['file']; ?>" style="width: 120px;"></td>
                        <td class="action-column">
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn">Update</a>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Anda yakin akan menghapus data ini?')" 
                               class="btn btn-delete">Hapus</a>
                        </td>
                    </tr>
            <?php
                    $no++;
                }
            } catch (Exception $e) {
                echo '<tr><td colspan="6" class="alert alert-danger">Error: ' . $e->getMessage() . '</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>