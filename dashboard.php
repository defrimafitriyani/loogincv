<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Defrima Fitriyani</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #001f3f;
            --gold: #d4af37;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --red: #e74c3c;
            --blue: #3498db;
            --green: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light-gray);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .dashboard {
            width: 100%;
            max-width: 600px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .dashboard-header {
            background: var(--navy);
            color: var(--white);
            padding: 25px;
            text-align: center;
            position: relative;
        }

        .dashboard-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .dashboard-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .dashboard-content {
            padding: 30px;
        }

        .menu-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--gold);
            transition: all 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .menu-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .menu-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--gold);
            font-size: 18px;
        }

        .menu-title h2 {
            font-size: 18px;
            color: var(--navy);
        }

        .menu-description {
            color: var(--dark-gray);
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .menu-button {
            display: block;
            text-align: center;
            padding: 12px;
            background-color: var(--navy);
            color: var(--white);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .menu-button:hover {
            background-color: var(--gold);
            color: var(--navy);
        }

        .logout-button {
            display: block;
            text-align: center;
            padding: 12px;
            background-color: var(--red);
            color: var(--white);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 30px;
            transition: all 0.3s ease;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        @media (max-width: 480px) {
            .dashboard {
                margin: 10px;
            }
            
            .dashboard-content {
                padding: 20px;
            }
            
            .menu-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang di panel administrasi</p>
        </div>
        
        <div class="dashboard-content">
            <div class="menu-card">
                <div class="menu-title">
                    <div class="menu-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h2>Kelola Artikel</h2>
                </div>
                <p class="menu-description">
                    Kelola semua artikel blog Anda. Tambah, edit, atau hapus artikel yang telah dipublikasikan.
                </p>
                <a href="artikel.php" class="menu-button">
                    <i class="fas fa-arrow-right"></i> Buka Artikel
                </a>
            </div>
            
            <div class="menu-card">
                <div class="menu-title">
                    <div class="menu-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h2>Kelola Project</h2>
                </div>
                <p class="menu-description">
                    Kelola portofolio project Anda. Tambahkan project baru atau perbarui yang sudah ada.
                </p>
                <a href="project.php" class="menu-button">
                    <i class="fas fa-arrow-right"></i> Buka Project
                </a>
            </div>
            
            <a href="logout.php" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</body>
</html>