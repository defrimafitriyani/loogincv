<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Artikel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #34495e;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            padding: 8px 14px;
            border-radius: 6px;
            border: 1px solid #3498db;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Artikel</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>

        <label for="isi">Isi:</label>
        <textarea id="isi" name="isi" rows="8" required><?= htmlspecialchars($data['isi']) ?></textarea>

        <input type="submit" value="Update">
    </form>

    <a href="artikel.php" class="back-link">← Kembali ke Daftar Artikel</a>
</div>
</body>
</html>
