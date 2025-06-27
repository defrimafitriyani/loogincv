<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    include('../admin/config.php');
    
    // Check database connection
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    // Query artikel dengan error handling
    $artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC LIMIT 3");
    if (!$artikel) {
        die("Error query artikel: " . mysqli_error($conn));
    }
    
    // Query project dengan error handling
    $project = mysqli_query($conn, "SELECT * FROM project ORDER BY tanggal_mulai DESC LIMIT 3");
    if (!$project) {
        die("Error query project: " . mysqli_error($conn));
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portofolio | Defrima Fitriyani</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <style>
        :root {
            --navy: #001f3f;
            --light-navy: #2c3e50;
            --gold: #d4af37;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--white);
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            color: var(--navy);
        }
        
        a {
            text-decoration: none;
            color: var(--navy);
            transition: all 0.3s ease;
        }
        
        a:hover {
            color: var(--gold);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background-color: var(--navy);
            color: var(--white);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
        }
        
        .logo span {
            color: var(--gold);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            color: var(--white);
            font-weight: 500;
            position: relative;
        }
        
        nav ul li a:hover {
            color: var(--gold);
        }
        
        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--gold);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
        }
        
        /* Hero Section */
        .hero {
            padding: 180px 0 100px;
            background-color: var(--light-gray);
            position: relative;
            overflow: hidden;
        }
        
        .profile {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .profile-img-container {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid var(--gold);
            overflow: hidden;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--navy);
        }
        
        .hero p {
            font-size: 18px;
            color: var(--gold);
            margin-bottom: 30px;
        }
        
        .quotes-slider {
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .quote-slide {
            padding: 20px;
            text-align: center;
        }
        
        .quote-slide p {
            font-style: italic;
            color: var(--navy);
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .author {
            color: var(--gold);
            font-weight: 600;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--navy);
            color: var(--white);
            border: 2px solid var(--navy);
        }
        
        .btn-primary:hover {
            background-color: transparent;
            color: var(--navy);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--navy);
            border: 2px solid var(--navy);
        }
        
        .btn-secondary:hover {
            background-color: var(--navy);
            color: var(--white);
        }
        
        /* Sections */
        section {
            padding: 100px 0;
        }
        
        section h2 {
            font-size: 36px;
            margin-bottom: 50px;
            text-align: center;
            position: relative;
        }
        
        section h2::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 3px;
            background: var(--gold);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Skills */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .skill-item {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .skill-item:hover {
            transform: translateY(-10px);
        }
        
        .skill-item h3 {
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .skill-item h3 i {
            margin-right: 10px;
            color: var(--gold);
        }
        
        .skill-bar {
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .skill-level {
            height: 100%;
            background: var(--navy);
            border-radius: 10px;
        }
        
        /* Projects */
        .project-item, .artikel-item {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border-left: 4px solid var(--gold);
            transition: transform 0.3s ease;
        }
        
        .project-item:hover, .artikel-item:hover {
            transform: translateY(-5px);
        }
        
        .project-item h3, .artikel-item h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: var(--navy);
        }
        
        .project-item p, .artikel-item p {
            margin-bottom: 15px;
            color: var(--dark-gray);
        }
        
        .artikel-item .read-more {
            display: inline-block;
            color: var(--gold);
            font-weight: 600;
            margin-top: 10px;
        }
        
        .project-item small, .artikel-item small {
            color: #777;
            font-size: 14px;
        }
        
        /* Education */
        .timeline {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            width: 2px;
            background: var(--gold);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -1px;
        }
        
        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
            margin-bottom: 30px;
        }
        
        .timeline-item:nth-child(odd) {
            left: 0;
        }
        
        .timeline-item:nth-child(even) {
            left: 50%;
        }
        
        .timeline-date {
            padding: 8px 15px;
            background: var(--navy);
            color: var(--white);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .timeline-content {
            padding: 20px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .timeline-content h3 {
            margin-bottom: 10px;
        }
        
        .timeline-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            position: absolute;
            right: -30px;
            top: 15px;
            border: 3px solid var(--gold);
            z-index: 1;
            object-fit: cover;
        }
        
        .timeline-item:nth-child(even) .timeline-image {
            left: -30px;
        }
        
        /* Experience */
        .experience-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .experience-card {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .experience-card:hover {
            transform: translateY(-10px);
        }
        
        .experience-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .experience-card h3 i {
            margin-right: 10px;
            color: var(--gold);
        }
        
        .company {
            color: var(--navy);
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .duration {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        /* Organization */
        .org-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .org-card {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .org-card:hover {
            transform: translateY(-10px);
        }
        
        .org-icon {
            width: 70px;
            height: 70px;
            background: var(--navy);
            color: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
        }
        
        .org-card h3 {
            margin-bottom: 15px;
        }
        
        .org-duration {
            display: inline-block;
            padding: 5px 15px;
            background: var(--light-gray);
            color: var(--navy);
            border-radius: 20px;
            font-size: 12px;
            margin-top: 15px;
        }
        
        /* Footer */
        footer {
            background: var(--navy);
            color: var(--white);
            padding: 50px 0 20px;
            text-align: center;
        }
        
        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-logo span {
            color: var(--gold);
        }
        
        .footer-text {
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--white);
            color: var(--navy);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--gold);
            color: var(--white);
            transform: translateY(-5px);
        }
        
        .copyright {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .timeline::before {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item:nth-child(even) {
                left: 0;
            }
            
            .timeline-image {
                left: 0;
                right: auto;
            }
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            nav ul {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: var(--navy);
                flex-direction: column;
                align-items: center;
                padding-top: 30px;
                transition: all 0.3s ease;
            }
            
            nav ul.active {
                left: 0;
            }
            
            nav ul li {
                margin: 15px 0;
            }
            
            .hero h1 {
                font-size: 32px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .profile-img-container {
                width: 180px;
                height: 180px;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
        
        @media (max-width: 576px) {
            section {
                padding: 70px 0;
            }
            
            section h2 {
                font-size: 30px;
                margin-bottom: 40px;
            }
            
            .timeline-item {
                padding-left: 50px;
            }
            
            .timeline-image {
                width: 40px;
                height: 40px;
                top: 20px;
            }
        }
    </style>
</head>
<body>
    <header id="header">
        <div class="container">
            <nav>
                <div class="logo">Defrima <span>Fitriyani</span></div>
                 <ul id="nav-menu">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#skills">Skills</a></li>
                <li><a href="index.php#projects">Projects</a></li>
                <li><a href="index.php#education">Education</a></li>
                <li><a href="index.php#experience">Experience</a></li>
                <li><a href="index.php#organization">Organization</a></li>
                <li><a href="artikel_detail.php">Artikel</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="hero">
            <div class="container">
                <div class="profile">
                    <div class="profile-img-container">
                        <img src="images/rima.jpg" alt="Defrima Fitriyani">
                    </div>
                    <h1>Defrima Fitriyani</h1>
                    <p>Mahasiswa Teknik Informatika | Pengembang Web | Analisis Data</p>
                    
                    <div class="quotes-slider swiper">
                        <div class="swiper-wrapper">
                            <div class="quote-slide swiper-slide">
                                <p>Teknologi adalah alat yang kuat untuk mengubah dunia, tapi yang lebih penting adalah bagaimana kita menggunakannya untuk kebaikan manusia</p>
                                <div class="author">- Defrima Fitriyani</div>
                            </div>
                            <div class="quote-slide swiper-slide">
                                <p>Belajar bukan hanya untuk tahu, tapi untuk memahami. Bukan hanya untuk bisa, tapi untuk menguasai</p>
                                <div class="author">- Defrima Fitriyani</div>
                            </div>
                            <div class="quote-slide swiper-slide">
                                <p>Setiap kode yang kita tulis adalah kesempatan untuk menciptakan solusi dan membuat hidup lebih mudah</p>
                                <div class="author">- Defrima Fitriyani</div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    
                    <div class="hero-buttons">
                        <a href="contact.php" class="btn btn-primary">Hubungi Saya</a>
                        <a href="download.php?file=cv" class="btn btn-secondary">Download CV</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="skills">
            <div class="container">
                <h2>Skill Set</h2>
                <div class="skills-grid">
                    <div class="skill-item">
                        <h3><i class="fas fa-code"></i> Web Development</h3>
                        <div class="skill-bar">
                            <div class="skill-level" style="width: 85%"></div>
                        </div>
                        <p>HTML, CSS, JavaScript, PHP, MySQL, React, Node.js</p>
                    </div>
                    <div class="skill-item">
                        <h3><i class="fas fa-chart-line"></i> Data Analysis</h3>
                        <div class="skill-bar">
                            <div class="skill-level" style="width: 90%"></div>
                        </div>
                        <p>Excel, Python, Power BI, SQL, Tableau, Pandas</p>
                    </div>
                    <div class="skill-item">
                        <h3><i class="fas fa-paint-brush"></i> Design</h3>
                        <div class="skill-bar">
                            <div class="skill-level" style="width: 80%"></div>
                        </div>
                        <p>Figma, Canva, Adobe Photoshop, Illustrator, UI/UX Design</p>
                    </div>
                    <div class="skill-item">
                        <h3><i class="fas fa-microphone"></i> Public Speaking</h3>
                        <div class="skill-bar">
                            <div class="skill-level" style="width: 85%"></div>
                        </div>
                        <p>MC, Presentasi, Moderator, Komunikasi Publik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="projects">
            <div class="container">
                <h2>Projects</h2>
                <?php while($p = mysqli_fetch_assoc($project)): ?>
                <div class="project-item">
                    <h3><?= htmlspecialchars($p['nama']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>
                    <small><?= $p['tanggal_mulai'] ?> – <?= $p['tanggal_selesai'] ?></small>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Education Section -->
        <section id="education" class="education">
            <div class="container">
                <h2>Education</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">2022 - Sekarang</div>
                        
                        <div class="timeline-content">
                            <h3>Universitas Maritim Raja Ali Haji (UMRAH)</h3>
                            <p>Universitas Maritim Raja Ali Haji (UMRAH) adalah perguruan tinggi negeri yang berlokasi di Tanjungpinang, Provinsi Kepulauan Riau. Universitas ini resmi berdiri pada 1 Agustus 2007 berdasarkan Surat Keputusan Menteri Pendidikan Nasional Republik Indonesia Nomor 124/D/O/2007, dan dikukuhkan statusnya sebagai perguruan tinggi negeri melalui Peraturan Presiden Nomor 53 Tahun 2011. UMRAH merupakan satu-satunya universitas negeri di Provinsi Kepulauan Riau dan menjadi pionir dalam pendidikan tinggi berbasis kemaritiman di wilayah perbatasan Indonesia.</p>
                           
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">2019 - 2022</div>
                       
                        <div class="timeline-content">
                            <h3>SMA Negeri 4 Kundur</h3>
                            <p>Jurusan IPA</p>
                            <p>SMAN 4 Kundur (SMA Negeri 4 Kundur) adalah sekolah menengah atas negeri yang berlokasi di Jalan Pendidikan Layang Kobel, Desa Sawang Laut, Kecamatan Kundur Barat, Kabupaten Karimun, Provinsi Kepulauan Riau. Didirikan melalui SK pada tanggal 15 Oktober 2005, sekolah ini berstatus di bawah Pemerintah Daerah dan dikelola oleh Kemendikbudristek </p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">2016 - 2019</div>
                       
                        <div class="timeline-content">
                            <h3>MTs Ummul Quro</h3>
                            <p>MTs Ummul Quro adalah Madrasah Tsanawiyah (tingkat SMP Islam), berstatus swasta, yang berlokasi di Jalan Pendidikan Layang, Desa Sawang Laut, Kecamatan Kundur Barat, Kabupaten Karimun, Provinsi Kepulauan Riau .</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">2010 - 2016</div>
                        
                        <div class="timeline-content">
                            <h3>SD Negeri 006 Kundur Barat</h3>
                            <p>SD Negeri 006 Kundur Barat adalah sekolah dasar negeri yang terletak di Jalan Besar Kobel Darat, Dusun III, Desa Sawang Laut, Kecamatan Kundur Barat, Kabupaten Karimun, Provinsi Kepulauan Riau. Sekolah ini didirikan pada 2 Maret 1978 dan bernaung di bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi. Dengan status negeri dan akreditasi B, SD 006 Kundur Barat telah menjadi lembaga pendidikan dasar yang cukup mapan di wilayahnya. </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience Section -->
        <section id="experience" class="experience">
            <div class="container">
                <h2>Experience</h2>
                <div class="experience-grid">
                    <div class="experience-card">
                        <h3><i class="fas fa-laptop-code"></i> Administrasi Data</h3>
                        <p class="company">Freelance</p>
                        <p class="duration">2022 - Sekarang</p>
                        <p>Mengelola data menggunakan Microsoft Excel, termasuk pembuatan laporan, rekapitulasi data harian/bulanan, penggunaan rumus kompleks, filter, validasi, dan visualisasi data dengan grafik interaktif.</p>
                    </div>
                    <div class="experience-card">
                        <h3><i class="fas fa-microphone-alt"></i> MC (Master of Ceremony)</h3>
                        <p class="company">Berbagai Acara</p>
                        <p class="duration">2016 - Sekarang</p>
                        <p>Berpengalaman sebagai pembawa acara untuk berbagai event formal dan informal dengan kemampuan public speaking yang baik, termasuk acara seminar, pernikahan, dan acara komunitas.</p>
                    </div>
                    <div class="experience-card">
                        <h3><i class="fas fa-store"></i> Bisnis Online</h3>
                        <p class="company">Jualan Baju</p>
                        <p class="duration">2019 - 2022</p>
                        <p>Mengelola bisnis online penjualan pakaian dengan pemasaran melalui media sosial (Instagram, Facebook) dan marketplace (Shopee, Tokopedia), termasuk manajemen stok, customer service, dan pembukuan sederhana.</p>
                    </div>
                    <div class="experience-card">
                        <h3><i class="fas fa-chalkboard-teacher"></i> Guru Les Privat</h3>
                        <p class="company">Freelance</p>
                        <p class="duration">2019 - 2022</p>
                        <p>Mengajar privat matematika dan mengaji untuk siswa SD dan SMP dengan pendekatan yang menyenangkan dan mudah dipahami, termasuk persiapan materi dan evaluasi perkembangan siswa.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organization Section -->
        <section id="organization" class="organization">
            <div class="container">
                <h2>Organisasi & Aktivitas</h2>
                <div class="org-grid">
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>REKOD (Karang Taruna)</h3>
                        <p>Anggota aktif karang taruna desa dengan berbagai kegiatan sosial dan pengembangan masyarakat.</p>
                        <span class="org-duration">2026 - Sekarang</span>
                    </div>
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>LAZIS MU</h3>
                        <p>Relawan aktif dalam program-program sosial dan kemanusiaan yang diselenggarakan oleh LAZIS Muhammadiyah.</p>
                        <span class="org-duration">2024 - Sekarang</span>
                    </div>
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>OSIS</h3>
                        <p>Aktif dalam berbagai kegiatan sekolah dan pengembangan kepemimpinan selama masa sekolah sebagai anggota divisi pendidikan.</p>
                    </div>
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-campground"></i>
                        </div>
                        <h3>Pramuka</h3>
                        <p>Melatih kerja tim, ketangkasan, dan kemampuan bertahan dalam berbagai situasi melalui kegiatan kepramukaan.</p>
                    </div>
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>PMR (Palang Merah Remaja)</h3>
                        <p>Pelatihan dasar pertolongan pertama dan kesehatan remaja, serta partisipasi dalam berbagai kegiatan sosial.</p>
                    </div>
                    <div class="org-card">
                        <div class="org-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <h3>Tim Tari</h3>
                        <p>Menampilkan tarian daerah di berbagai acara sekolah dan masyarakat, melestarikan budaya Indonesia.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Artikel Section -->
        <section id="artikel" class="articles">
            <div class="container">
                <h2>Artikel Terbaru</h2>
                <?php while($a = mysqli_fetch_assoc($artikel)): ?>
                <div class="artikel-item">
                    <h3><?= htmlspecialchars($a['judul']) ?></h3>
                    <p><?= nl2br(htmlspecialchars(substr($a['isi'], 0, 200))) ?>...</p>
                    <a href="artikel_detail.php?id=<?= $a['id'] ?>" class="read-more">Lihat Selengkapnya</a>
                    <small>Dibuat: <?= $a['tanggal'] ?></small>
                </div>
                <?php endwhile; ?>
                <div style="text-align: center; margin-top: 30px;">
                   
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">Defrima <span>Fitriyani</span></div>
                <p class="footer-text">Mahasiswa Teknik Informatika yang passionate tentang pengembangan web, analisis data, dan teknologi untuk solusi sosial.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
                <p class="copyright">&copy; <?= date('Y') ?> Defrima Fitriyani. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking a link
        const navLinks = document.querySelectorAll('#nav-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add shadow to header on scroll
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = 'none';
            }
        });
        
        // Initialize Swiper for quotes slider
        const swiper = new Swiper('.quotes-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>
</html>