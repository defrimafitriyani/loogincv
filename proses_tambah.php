<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$isi = mysqli_real_escape_string($conn, $_POST['isi']);

$query = "INSERT INTO artikel (judul, isi) VALUES ('$judul', '$isi')";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: artikel.php");
} else {
    echo "Gagal menambahkan artikel: " . mysqli_error($conn);
}
?>