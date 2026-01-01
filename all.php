<?php
require 'db.php';
$stmt = $pdo->query('SELECT * FROM projects ORDER BY id DESC');
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects - ETS</title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link rel="stylesheet" href="src/css/all.css">

</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">ETS</div>
                <ul class="nav-menu">
                    <li><a href="index.html">Ana sayfa</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>All Projects</h2>
        <div style="margin-top:2.2rem;"></div>
        <?php foreach($projects as $project): ?>
            <?php
            // Get all photos for this project
            $photos_stmt = $pdo->prepare('SELECT * FROM project_photos WHERE project_id = ?');
            $photos_stmt->execute([$project['id']]);
            $photos = $photos_stmt->fetchAll();
            ?>
            <div class="modern-project-card">
                <div class="modern-project-images">
                    <img src="<?php echo htmlspecialchars($project['thumbnail_path']); ?>" alt="Thumbnail" class="modern-project-thumb" />
                    <?php if ($photos): ?>
                    <div class="modern-gallery">
                        <?php $i = 0; foreach ($photos as $img) : ?>
                        <img src="<?php echo htmlspecialchars($img['photo_path']); ?>" alt="Project Photo" class="modern-gallery-img<?php echo $i == 0 ? ' active' : ''; ?>" style="" data-parent-id="pg<?php echo $project['id']; ?>" />
                        <?php $i++; endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="modern-project-info">
                    <p><strong>Proje hakkında:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
                    <p><strong>Başlangıç:</strong> <?php echo htmlspecialchars($project['start_date']); ?> &ndash; <strong>Bitiş:</strong> <?php echo htmlspecialchars($project['finish_date']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-background"></div>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="logo"><img id="logo_img" src="src/img/logo.png" alt="logo" srcset=""></div>
                    <img src="https://www.winsa.com.tr/sitefile/images/logo.svg" alt="">
                    <p>yazı yazı yazı</p>
                </div>
                <div class="footer-section">
                    <h4>Kısa Yollar</h4>
                    <ul>
                        <li><a href="index.html#home">Ana Sayfa</a></li>
                        <li><a href="index.html#about">Hakkımızda</a></li>
                        <li><a href="index.html#services">Hizmetler</a></li>
                        <li><a href="index.html#portfolio">Projeler</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Bizi Takip Edin</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook">Facebook</a>
                        <a href="#" aria-label="Twitter">Twitter</a>
                        <a href="#" aria-label="Instagram">Instagram</a>
                        <a href="#" aria-label="LinkedIn">LinkedIn</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ETS. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    <script>
    document.querySelectorAll('.modern-gallery').forEach(function(gallery) {
      var bigImg = gallery.closest('.modern-project-images').querySelector('.modern-project-thumb');
      var thumbs = Array.from(gallery.querySelectorAll('.modern-gallery-img'));
      thumbs.forEach(function(img, i) {
        img.addEventListener('click', function() {
          thumbs.forEach(t => t.classList.remove('active'));
          img.classList.add('active');
          bigImg.src = img.src;
        });
      });
    });
    </script>
</body>
</html>
