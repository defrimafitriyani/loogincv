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
    <title>Detail Artikel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
        }

        small {
            color: #7f8c8d;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        .article-content {
            font-size: 17px;
            line-height: 1.7;
            color: #2d3436;
            white-space: pre-wrap;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
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
        <h2><?= htmlspecialchars($data['judul']) ?></h2>
        <p><small>Dibuat pada: <?= $data['tanggal'] ?></small></p>
        <hr>
        <div class="article-content">
            <?= nl2br(htmlspecialchars($data['isi'])) ?>
        </div>
        <a class="back-link" href="artikel.php">← Kembali ke Daftar Artikel</a>
    </div>
</body>
</html>
