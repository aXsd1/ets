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
    <link rel="stylesheet" href="styles.css">
    <style>
    .modern-project-card {
        background: white;
        border-radius: 1.2em;
        box-shadow: 0 6px 32px #0001, 0 1.5px 4px #0002;
        display: flex;
        gap: 0;
        overflow: hidden;
        margin-bottom: 2.5rem;
        min-height: 320px;
        max-width: 840px;
        margin-left: auto;
        margin-right: auto;
    }
    .modern-project-images { flex: 2 1 0; display: flex; flex-direction: column; align-items: center; min-width: 0; background: #f5f6ff; justify-content: center; }
    .modern-project-thumb {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
        background: #ddd;
        transition: box-shadow 0.3s;
        margin-bottom: 1.1em;
        border-radius: 0 0 0 16px;
        display: block;
        max-width: 370px;
    }
    .modern-gallery { display: flex; gap: 7px; padding-bottom: 5px; }
    .modern-gallery-img {
        width: 54px; height: 54px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 1.5px 8px #0001;
        cursor: pointer;
        border: 2px solid #fff;
        background: #f6f6f6;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .modern-gallery-img.active, .modern-gallery-img:hover {
        border-color: var(--primary-color);
        box-shadow: 0 2px 12px #6366f133, 0 0px 0px #0000;
        z-index: 2;
    }
    .modern-project-info { flex: 1 1 240px; background: #fafbfc; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; min-width: 180px; padding: 34px 23px 30px 23px; border-left: 1px solid #eceaff; }
    .modern-project-info p {
        color: #444;
        margin-bottom: 0.7em;
        font-size: 1.09em;
        word-break: break-word;
    }
    .modern-project-info strong { color: var(--primary-color); }
    @media(max-width: 800px) {
      .modern-project-card { flex-direction: column; max-width: 98vw; }
      .modern-project-info { border-left: none; border-top: 1px solid #eceaff; width: 100%; padding: 19px 11px 18px 11px; }
      .modern-project-images { width: 100%; }
      .modern-project-thumb { max-width: 99vw; border-radius: 0; }
      .modern-gallery { justify-content: flex-start; }
    }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">ETS</div>
                <ul class="nav-menu">
                    <li><a href="index.html">Home</a></li>
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
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
                    <p><strong>Start:</strong> <?php echo htmlspecialchars($project['start_date']); ?> &ndash; <strong>Finish:</strong> <?php echo htmlspecialchars($project['finish_date']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
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
