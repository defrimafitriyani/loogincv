<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM project ORDER BY dibuat_pada DESC");
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Project | Defrima Fitriyani</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #001f3f;
            --gold: #d4af37;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --success: #28a745;
            --info: #17a2b8;
            --danger: #dc3545;
            --primary: #007bff;
            --secondary: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        h1 {
            color: var(--navy);
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            position: relative;
            padding-bottom: 10px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gold);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--navy);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #002b57;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #e6f7ee;
            color: var(--success);
            border-left-color: var(--success);
        }

        .alert-info {
            background-color: #e6f4f7;
            color: var(--info);
            border-left-color: var(--info);
        }

        .alert-danger {
            background-color: #fce8e9;
            color: var(--danger);
            border-left-color: var(--danger);
        }

        .table-container {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--navy);
            color: var(--white);
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
        }

        th {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .project-name {
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 5px;
        }

        .project-desc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: var(--secondary);
            font-size: 14px;
            line-height: 1.5;
        }

        .project-date {
            color: var(--secondary);
            font-size: 14px;
            white-space: nowrap;
        }

        .action-group {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            color: var(--white);
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .view-btn {
            background-color: var(--primary);
        }

        .edit-btn {
            background-color: var(--info);
        }

        .delete-btn {
            background-color: var(--danger);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 5px;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .status-completed {
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .action-group {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                width: 100%;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kelola Project</h1>
            <a href="tambah_project.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Project
            </a>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] == 'tambah_berhasil'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Project berhasil ditambahkan</span>
                </div>
            <?php elseif ($_GET['pesan'] == 'update_berhasil'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Project berhasil diperbarui</span>
                </div>
            <?php elseif ($_GET['pesan'] == 'hapus_berhasil'): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-trash-alt"></i>
                    <span>Project berhasil dihapus</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Project</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        $statusClass = (strtotime($row['tanggal_selesai']) > time()) ? 'status-active' : 'status-completed';
                        $statusText = (strtotime($row['tanggal_selesai']) > time()) ? 'Aktif' : 'Selesai';
                        ?>
                        <tr>
                            <td>
                                <div class="project-name"><?= htmlspecialchars($row['nama']) ?></div>
                            </td>
                            <td>
                                <div class="project-desc"><?= htmlspecialchars($row['deskripsi']) ?></div>
                            </td>
                            <td>
                                <div class="project-date"><?= date('d M Y', strtotime($row['tanggal_mulai'])) ?></div>
                            </td>
                            <td>
                                <div class="project-date"><?= date('d M Y', strtotime($row['tanggal_selesai'])) ?></div>
                            </td>
                            <td>
                                <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="detail_project.php?id=<?= $row['id'] ?>" class="action-btn view-btn" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit_project.php?id=<?= $row['id'] ?>" class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="hapus_project.php?id=<?= $row['id'] ?>" class="action-btn delete-btn" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Confirm before delete
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus project ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>