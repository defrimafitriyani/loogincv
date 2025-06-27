<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

// Ambil data project
$result = mysqli_query($conn, "SELECT * FROM project ORDER BY tanggal_mulai DESC");
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Project</title>
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
            background-color: var(--light);
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            background-color: var(--primary);
            color: var(--white);
            padding: 1.5rem 0;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--white);
        }

        .add-button {
            background-color: var(--accent);
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .add-button:hover {
            background-color: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Notification Styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
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

        .alert i {
            font-size: 1.25rem;
        }

        /* Card and Table Styles */
        .card {
            background-color: var(--white);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 0.75rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--primary);
            color: var(--white);
        }

        th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 500;
        }

        td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: rgba(214, 158, 46, 0.05);
        }

        .project-name {
            font-weight: 600;
            color: var(--primary);
        }

        .project-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: var(--dark-gray);
            font-size: 0.9375rem;
        }

        .project-date {
            color: var(--dark-gray);
            font-size: 0.9375rem;
            white-space: nowrap;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
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
            font-size: 1.25rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .add-button {
                width: 100%;
                justify-content: center;
            }
            
            .action-group {
                flex-direction: column;
            }
            
            th, td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="page-title">Kelola Project</h1>
            <a href="tambah_project.php" class="add-button">
                <i class="fas fa-plus"></i> Tambah Project
            </a>
        </div>
    </header>

    <div class="container">
        <!-- Notifikasi -->
        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] == 'tambah_berhasil'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Project berhasil ditambahkan</span>
                </div>
            <?php elseif ($_GET['pesan'] == 'edit_berhasil'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Project berhasil diperbarui</span>
                </div>
            <?php elseif ($_GET['pesan'] == 'hapus_berhasil'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Project berhasil dihapus</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="card">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Project</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>
                                        <div class="project-name"><?= htmlspecialchars($row['nama']) ?></div>
                                    </td>
                                    <td>
                                        <div class="project-description"><?= htmlspecialchars($row['deskripsi']) ?></div>
                                    </td>
                                    <td class="project-date"><?= date('d M Y', strtotime($row['tanggal_mulai'])) ?></td>
                                    <td class="project-date">
                                        <?= $row['tanggal_selesai'] ? date('d M Y', strtotime($row['tanggal_selesai'])) : '-' ?>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="detail_project.php?id=<?= $row['id'] ?>" class="action-btn view">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <a href="edit_project.php?id=<?= $row['id'] ?>" class="action-btn edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="hapus_project.php?id=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus project ini?')">
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
                    <i class="fas fa-folder-open empty-state-icon"></i>
                    <h3 class="empty-state-title">Belum ada project</h3>
                    <p>Mulai dengan menambahkan project baru</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>