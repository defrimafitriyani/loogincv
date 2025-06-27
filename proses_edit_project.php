<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

$id = $_POST['id'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];

$query = "UPDATE project 
            SET nama = '$nama',
                deskripsi = '$deskripsi',
                tanggal_mulai = '$tanggal_mulai',
                tanggal_selesai = '$tanggal_selesai'
            WHERE id = $id";

$result = mysqli_query($conn, $query);

if ($result) {
    // Redirect ke halaman kelola project dengan notifikasi
    header("Location: kelola_project.php?pesan=update_berhasil");
} else {
    echo "Gagal memperbarui data project: " . mysqli_error($conn);
}
?>