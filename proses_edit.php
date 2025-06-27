<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

$id = $_POST['id'];
$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$isi = mysqli_real_escape_string($conn, $_POST['isi']);

$query = "UPDATE artikel SET judul = '$judul', isi = '$isi' WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: artikel.php?pesan=update_berhasil");
} else {
    echo "Gagal mengupdate artikel: " . mysqli_error($conn);
}
?>