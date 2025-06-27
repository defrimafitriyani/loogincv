<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

// Pastikan parameter ID ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lakukan query delete
    $query = "DELETE FROM project WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: kelola_project.php?pesan=hapus_berhasil");
    } else {
        echo "Gagal menghapus project: " . mysqli_error($conn);
    }
} else {
    echo "ID project tidak ditemukan.";
}
?>