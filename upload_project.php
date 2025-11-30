<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    http_response_code(403);
    echo 'Unauthorized';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle input
    $description = $_POST['description'] ?? '';
    $start_date = $_POST['start-date'] ?? '';
    $finish_date = $_POST['finish-date'] ?? '';
    // Upload thumbnail
    $thumbFile = $_FILES['thumbnail'] ?? null;
    if (!$thumbFile || $thumbFile['error'] !== 0) {
        echo 'Error uploading thumbnail.';
        exit();
    }
    $thumbPath = 'uploads/' . uniqid('thumb_') . basename($thumbFile['name']);
    if (!move_uploaded_file($thumbFile['tmp_name'], $thumbPath)) {
        echo 'Failed to move thumbnail.';
        exit();
    }
    // Insert project
    $stmt = $pdo->prepare('INSERT INTO projects (thumbnail_path, description, start_date, finish_date) VALUES (?, ?, ?, ?)');
    $stmt->execute([$thumbPath, $description, $start_date, $finish_date]);
    $project_id = $pdo->lastInsertId();
    // Upload and insert photos
    $photos = $_FILES['photos'] ?? null;
    if ($photos && isset($photos['tmp_name'])) {
        $tmp_names = is_array($photos['tmp_name']) ? $photos['tmp_name'] : [$photos['tmp_name']];
        $names = is_array($photos['name']) ? $photos['name'] : [$photos['name']];
        foreach ($tmp_names as $idx => $tmpName) {
            if ($tmpName === '') continue;
            $photoPath = 'uploads/' . uniqid('photo_') . basename($names[$idx]);
            if (move_uploaded_file($tmpName, $photoPath)) {
                $stmt = $pdo->prepare('INSERT INTO project_photos (project_id, photo_path) VALUES (?, ?)');
                $stmt->execute([$project_id, $photoPath]);
            }
        }
    }
    echo 'Project uploaded successfully!';
    exit();
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
