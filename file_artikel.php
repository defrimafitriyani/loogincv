<?php
// Gunakan path relatif yang benar ke config.php
include('admin/config.php');

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query database
$query = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
if(!$query || mysqli_num_rows($query) == 0) {
    header("Location: artikel.php");
    exit();
}

$artikel = mysqli_fetch_assoc($query);

// Query artikel terkait
$related_query = mysqli_query($conn, "SELECT * FROM artikel WHERE id != $id ORDER BY tanggal DESC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artikel['judul']) ?> | Defrima Fitriyani</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <section class="article-detail">
        <div class="container">
            <article>
                <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
                
                <div class="article-meta">
                    <span><i class="far fa-calendar"></i> <?= date('d M Y', strtotime($artikel['tanggal'])) ?></span>
                    <span><i class="far fa-clock"></i> <?= ceil(str_word_count($artikel['isi'])/200) ?> menit baca</span>
                </div>
                
                <?php if(!empty($artikel['gambar'])): ?>
                <div class="article-image">
                    <img src="admin/uploads/<?= htmlspecialchars($artikel['gambar']) ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>">
                </div>
                <?php endif; ?>
                
                <div class="article-content">
                    <?= nl2br(htmlspecialchars($artikel['isi'])) ?>
                </div>
                
                <div class="article-footer">
                    <a href="artikel.php" class="btn"><i class="fas fa-arrow-left"></i> Kembali ke Artikel</a>
                </div>
            </article>
            
            <?php if(mysqli_num_rows($related_query) > 0): ?>
            <div class="related-articles">
                <h3>Artikel Terkait</h3>
                <div class="related-grid">
                    <?php while($related = mysqli_fetch_assoc($related_query)): ?>
                    <div class="related-item">
                        <h4><?= htmlspecialchars($related['judul']) ?></h4>
                        <p><?= nl2br(htmlspecialchars(substr($related['isi'], 0, 100))) ?>...</p>
                        <a href="detail_artikel.php?id=<?= $related['id'] ?>" class="read-more">Baca Selengkapnya</a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include('footer.php'); ?>
</body>
</html>