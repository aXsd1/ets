<?php
require 'db.php';
$stmt = $pdo->query('SELECT * FROM projects ORDER BY id DESC LIMIT 5');
$projects = $stmt->fetchAll();
if (!$projects) {
    echo '<p>Henüz proje eklenmemiş.</p>';
    exit();
}
foreach ($projects as $project): ?>
    <div class="project-card" style="background-image:url('<?php echo htmlspecialchars($project['thumbnail_path']); ?>')">
        <!-- <div class="project-info-bg">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
            <p><strong>Start:</strong> <?php echo htmlspecialchars($project['start_date']); ?> &ndash; <strong>Finish:</strong> <?php echo htmlspecialchars($project['finish_date']); ?></p>
        </div> -->
    </div>
<?php endforeach; ?>
<a href="all.php" style="display:block;text-decoration:none;">
<div class="project-card" style="display:flex;justify-content:center;align-items:center;min-height:280px;background:linear-gradient(135deg,var(--primary-color),var(--secondary-color));color:#fff;font-size:1.45rem;text-align:center;font-weight:600;box-shadow:var(--shadow-md);border-radius:1rem;transition:box-shadow .2s;cursor:pointer;">
  <span style="display:block;width:100%;"><span style="font-size:2.5em;line-height:1;display:block;margin-bottom:14px;">&#128065;</span> Tüm Projeleri Gör</span>
</div>
</a>
