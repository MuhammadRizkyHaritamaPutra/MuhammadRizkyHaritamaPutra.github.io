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
      .logout {
        background-color: gray;
        color: black;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 14px;
        border-radius: 4px;
        display: inline-block;
        margin: 5px;
        transition: background-color 0.3s;
      }
      .logout:hover {
        background-color: darkgray; 
      }
      .search-form {
        text-align: center;
        margin-bottom: 20px;
      }
      .search-input {
        padding: 10px;
        font-size: 14px;
        border-radius: 4px;
        border: 1px solid #ddd;
        width: 250px;
      }
      .search-btn {
        background-color: rgb(64, 64, 183);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
      }
      .search-btn:hover {
        background-color: rgb(50, 50, 150);
      }
    </style>
</head>
<body>
  <div class="search-form">
      <h1>Data Pemesan</h1>
      <form method="GET" action="">
          <input type="text" name="search" class="search-input" placeholder="CARI" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          <button type="submit" class="search-btn">Cari</button>
      </form>
  </div>
  
    <div class="container">
        <div style="text-align: center;">
            <a class="logout" href="index.php" class="btn">Logout</a>
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
                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
                $query = "SELECT * FROM pemesanan";
                if ($search) {
                    $query .= " WHERE nama_pemesan LIKE '%$search%'";
                }
                $query .= " ORDER BY id ASC";
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
                echo '<tr><td colspan="7" class="alert alert-danger">Error: ' . $e->getMessage() . '</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
