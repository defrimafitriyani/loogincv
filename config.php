<?php
$host = "localhost";
$user = "root"; // default XAMPP
$pass = "";     // kosong kalau tidak ada password
$dbname = "portfolio_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
