<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

// Ambil data artikel
$result = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artikel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a365d;
            --primary-light: #2c5282;
            --accent: #d69e2e;
            --accent-light: #ecc94b;
            --light: #f7fafc;
            --light-gray: #edf2f7;
            --medium-gray: #e2e8f0;
            --dark-gray: #4a5568;
            --white: #ffffff;
            --success: #38a169;
            --warning: #dd6b20;
            --danger: #e53e3e;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--primary);
            color: var(--white);
            padding: 2rem 1rem;
            box-shadow: var(--shadow-md);
            position: fixed;
            width: 250px;
            height: 100vh;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
            padding: 0 0.75rem;
        }

        .logo-icon {
            font-size: 1.75rem;
            color: var(--accent);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            padding: 0.75rem;
            border-radius: 0.375rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-item:hover {
            background-color: var(--primary-light);
        }

        .nav-item.active {
            background-color: var(--primary-light);
            position: relative;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--accent);
            border-radius: 4px 0 0 4px;
        }

        .nav-icon {
            width: 1.5rem;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            grid-column: 2;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            color: var(--primary);
            font-weight: 600;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--accent);
            color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-info {
            background-color: rgba(66, 153, 225, 0.1);
            color: #4299e1;
            border-left: 4px solid #4299e1;
        }

        .alert-danger {
            background-color: rgba(229, 62, 62, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert-icon {
            font-size: 1.25rem;
        }

        /* Article Table Styles */
        .card {
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .article-table {
            width: 100%;
            border-collapse: collapse;
        }

        .article-table thead {
            background-color: var(--primary);
            color: var(--white);
        }

        .article-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 500;
        }

        .article-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--medium-gray);
            vertical-align: middle;
        }

        .article-table tr:last-child td {
            border-bottom: none;
        }

        .article-table tr:hover td {
            background-color: rgba(214, 158, 46, 0.05);
        }

        .article-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .article-preview {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: var(--dark-gray);
            font-size: 0.875rem;
        }

        .article-date {
            color: var(--dark-gray);
            font-size: 0.875rem;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: var(--transition);
        }

        .action-btn.view {
            background-color: var(--primary);
            color: var(--white);
        }

        .action-btn.edit {
            background-color: var(--accent);
            color: var(--primary);
        }

        .action-btn.delete {
            background-color: var(--danger);
            color: var(--white);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* Empty State */
        .empty-state {
            padding: 3rem;
            text-align: center;
            color: var(--dark-gray);
        }

        .empty-state-icon {
            font-size: 3rem;
            color: var(--medium-gray);
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 1rem;
            }

            .logo {
                margin-bottom: 1.5rem;
            }

            .nav-menu {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .main-content {
                grid-column: 1;
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .action-group {
                flex-direction: column;
            }

            .article-table td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
   

        <!-- Main Content Area -->
        <main class="main-content">
            <div class="header">
                <h1 class="page-title">Manajemen Artikel</h1>
                <a href="tambah_artikel.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Artikel Baru
                </a>
            </div>

            <!-- Notifications -->
            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] == 'update_berhasil'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span>Artikel berhasil diperbarui</span>
                    </div>
                <?php elseif ($_GET['pesan'] == 'tambah_berhasil'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span>Artikel baru berhasil ditambahkan</span>
                    </div>
                <?php elseif ($_GET['pesan'] == 'hapus_berhasil'): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span>Artikel berhasil dihapus</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Articles Table -->
            <div class="card">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="article-table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pratinjau Isi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td>
                                            <div class="article-title"><?= htmlspecialchars($row['judul']) ?></div>
                                        </td>
                                        <td>
                                            <div class="article-preview"><?= htmlspecialchars($row['isi']) ?></div>
                                        </td>
                                        <td>
                                            <div class="article-date"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <a href="detail_artikel.php?id=<?= $row['id'] ?>" class="action-btn view">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="action-btn edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="hapus_artikel.php?id=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-file-alt empty-state-icon"></i>
                        <h3 class="empty-state-title">Belum ada artikel</h3>
                        <p>Mulailah dengan membuat artikel pertama Anda</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>