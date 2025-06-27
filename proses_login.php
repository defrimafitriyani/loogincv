<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = md5($_POST['password']); // cocokkan dengan hash di database

$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $_SESSION['login'] = true;
    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>alert('Login gagal! Username atau password salah');window.location.href='login.html';</script>";
}
?>
