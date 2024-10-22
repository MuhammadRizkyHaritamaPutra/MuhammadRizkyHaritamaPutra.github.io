<?php 
include 'koneksi.php';

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
$id = $_GET["id"];

    
    $query = "DELETE FROM pemesanan WHERE id='$id' ";
    $hasil_query = mysqli_query($koneksi, $query);

    
    if(!$hasil_query) {
        die ("Gagal menghapus data: ".mysqli_errno($koneksi).
            " - ".mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data berhasil dihapus.');window.location='data_pesanan.php';</script>";
    }