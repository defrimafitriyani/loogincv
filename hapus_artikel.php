<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

$id = $_GET['id'];
$query = "DELETE FROM artikel WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: artikel.php?pesan=hapus_berhasil");
} else {
    echo "Gagal menghapus artikel: " . mysqli_error($conn);
}
?>