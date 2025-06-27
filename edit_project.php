<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data project berdasarkan ID
$result = mysqli_query($conn, "SELECT * FROM project WHERE id = $id");
if (!$result || mysqli_num_rows($result) == 0) {
    die("Project tidak ditemukan.");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        input[type="text"], textarea, input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Project</h2>
        <form action="proses_edit_project.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <label>Nama Project:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>

            <label>Tanggal Mulai:</label>
            <input type="date" name="tanggal_mulai" value="<?= $data['tanggal_mulai'] ?>" required>

            <label>Tanggal Selesai:</label>
            <input type="date" name="tanggal_selesai" value="<?= $data['tanggal_selesai'] ?>" required>

            <input type="submit" value="Update Project">
        </form>

        <a href="kelola_project.php" class="back-link">← Kembali ke Daftar Project</a>
    </div>
</body>
</html>