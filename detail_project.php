<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

if (!isset($_GET['id'])) {
    echo "ID project tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM project WHERE id = $id");

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Project tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #555;
            margin-top: 15px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }
        .action-buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-edit { background-color: #3498db; }
        .btn-delete { background-color: #e74c3c; }
        .btn-edit:hover,
        .btn-delete:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($data['nama']) ?></h2>

    <p class="label">Tanggal Mulai:</p>
    <p><?= $data['tanggal_mulai'] ?></p>

    <p class="label">Tanggal Selesai:</p>
    <p><?= $data['tanggal_selesai'] ?></p>

    <p class="label">Deskripsi:</p>
    <p><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>

    <div class="action-buttons">
        <a href="edit_project.php?id=<?= $data['id'] ?>" class="btn btn-edit">✏️ Edit</a>
        <a href="hapus_project.php?id=<?= $data['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus project ini?')">🗑️ Hapus</a>
    </div>

    <a class="back-link" href="kelola_project.php">← Kembali ke Daftar Project</a>
</div>
</body>
</html>
