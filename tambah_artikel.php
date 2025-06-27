<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Artikel</h1>
        <form action="proses_tambah.php" method="POST">
            <label>Judul:</label>
            <input type="text" name="judul" required>

            <label>Isi:</label>
            <textarea name="isi" rows="8" required></textarea>

            <button type="submit">Simpan</button>
        </form>
        <a href="artikel.php">← Kembali</a>
    </div>
</body>
</html>
