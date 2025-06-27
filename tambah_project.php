<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $query = "INSERT INTO project (nama, deskripsi, tanggal_mulai, tanggal_selesai) 
              VALUES ('$nama', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: kelola_project.php?pesan=tambah_berhasil");
        exit;
    } else {
        echo "Gagal menambahkan project: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Project Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #001f3f;
            --light-navy: #2c3e50;
            --gold: #d4af37;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            color: var(--navy);
            font-weight: 600;
        }
        
        a {
            text-decoration: none;
            color: var(--navy);
            transition: var(--transition);
        }
        
        a:hover {
            color: var(--gold);
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h2 {
            font-size: 28px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .form-header h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: var(--gold);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--navy);
        }
        
        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: var(--transition);
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--gold);
            color: var(--navy);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-align: center;
            transition: var(--transition);
            width: 100%;
            font-size: 16px;
        }
        
        .btn:hover {
            background-color: var(--navy);
            color: var(--gold);
            transform: translateY(-2px);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--navy);
            font-weight: 500;
            transition: var(--transition);
        }
        
        .back-link i {
            margin-right: 8px;
        }
        
        .back-link:hover {
            color: var(--gold);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="form-header">
                <h2>Tambah Project Baru</h2>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama">Nama Project</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Project</label>
                    <textarea id="deskripsi" name="deskripsi" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Simpan Project
                </button>
            </form>
        </div>
        
        <a href="kelola_project.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Project
        </a>
    </div>
</body>
</html>