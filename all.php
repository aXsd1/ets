<?php
require 'db.php';

// Get all photos with their project info
$stmt = $pdo->query('
    SELECT pp.*, p.description, p.start_date, p.finish_date, p.thumbnail_path, p.id as project_id
    FROM project_photos pp 
    JOIN projects p ON pp.project_id = p.id 
    ORDER BY p.id DESC, pp.id ASC
');
$photos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Projeler - ETS</title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link rel="stylesheet" href="src/css/all.css">
</head>
<body class="all-page">
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

    <div class="container" style="padding-top: 100px;">
        <h2 class="gallery-title">Tüm Projeler</h2>
    </div>
    
    <div class="photo-grid-wrapper">
        <div class="photo-grid">
            <?php foreach($photos as $index => $photo): ?>
            <div class="photo-item" 
                 data-index="<?php echo $index; ?>"
                 data-photo="<?php echo htmlspecialchars($photo['photo_path']); ?>"
                 data-description="<?php echo htmlspecialchars($photo['description']); ?>"
                 data-start="<?php echo htmlspecialchars($photo['start_date']); ?>"
                 data-finish="<?php echo htmlspecialchars($photo['finish_date']); ?>">
                <img src="<?php echo htmlspecialchars($photo['photo_path']); ?>" alt="Proje Fotoğrafı" loading="lazy">
                <div class="photo-overlay">
                    <span class="view-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                            <path d="M11 8v6"></path>
                            <path d="M8 11h6"></path>
                        </svg>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-backdrop"></div>
        <div class="lightbox-content">
            <button class="lightbox-close" id="lightbox-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
            <div class="lightbox-image-container">
                <img src="" alt="Büyük Görsel" id="lightbox-img">
            </div>
            <div class="lightbox-info" id="lightbox-info">
                <h3>Proje Bilgileri</h3>
                <p id="lightbox-description"></p>
                <div class="lightbox-dates">
                    <span><strong>Başlangıç:</strong> <span id="lightbox-start"></span></span>
                    <span><strong>Bitiş:</strong> <span id="lightbox-finish"></span></span>
                </div>
            </div>
            <div class="lightbox-nav">
                <button class="lightbox-nav-btn" id="lightbox-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                </button>
                <button class="lightbox-nav-btn" id="lightbox-next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            </div>
        </div>
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
    (function() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxDescription = document.getElementById('lightbox-description');
        const lightboxStart = document.getElementById('lightbox-start');
        const lightboxFinish = document.getElementById('lightbox-finish');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxBackdrop = document.querySelector('.lightbox-backdrop');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');
        
        const photoItems = document.querySelectorAll('.photo-item');
        let currentIndex = 0;
        
        function openLightbox(index) {
            currentIndex = index;
            const item = photoItems[index];
            
            lightboxImg.src = item.dataset.photo;
            lightboxDescription.textContent = item.dataset.description || 'Açıklama yok';
            lightboxStart.textContent = item.dataset.start || '-';
            lightboxFinish.textContent = item.dataset.finish || '-';
            
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        function navigate(direction) {
            currentIndex = currentIndex + direction;
            if (currentIndex < 0) currentIndex = photoItems.length - 1;
            if (currentIndex >= photoItems.length) currentIndex = 0;
            openLightbox(currentIndex);
        }
        
        // Event listeners
        photoItems.forEach((item, index) => {
            item.addEventListener('click', () => openLightbox(index));
        });
        
        lightboxClose.addEventListener('click', closeLightbox);
        lightboxBackdrop.addEventListener('click', closeLightbox);
        lightboxPrev.addEventListener('click', () => navigate(-1));
        lightboxNext.addEventListener('click', () => navigate(1));
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') navigate(-1);
            if (e.key === 'ArrowRight') navigate(1);
        });
    })();
    </script>
</body>
</html>
