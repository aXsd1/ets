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
    
    // Upload photos first, use first photo as thumbnail
    $photos = $_FILES['photos'] ?? null;
    if (!$photos || !isset($photos['tmp_name']) || empty($photos['tmp_name'][0])) {
        echo 'En az bir fotoğraf yüklemelisiniz.';
        exit();
    }
    
    $tmp_names = is_array($photos['tmp_name']) ? $photos['tmp_name'] : [$photos['tmp_name']];
    $names = is_array($photos['name']) ? $photos['name'] : [$photos['name']];
    $errors = is_array($photos['error']) ? $photos['error'] : [$photos['error']];
    
    // First photo will be used as thumbnail
    $thumbPath = '';
    $photoPaths = [];
    
    foreach ($tmp_names as $idx => $tmpName) {
        if ($tmpName === '' || !isset($errors[$idx]) || $errors[$idx] !== 0) continue;
        $photoPath = 'uploads/' . uniqid('photo_') . basename($names[$idx]);
        if (move_uploaded_file($tmpName, $photoPath)) {
            if ($thumbPath === '') {
                $thumbPath = $photoPath; // First photo is thumbnail
            }
            $photoPaths[] = $photoPath;
        }
    }
    
    if (empty($thumbPath)) {
        echo 'Fotoğraf yüklenirken hata oluştu.';
        exit();
    }
    
    // Insert project
    $stmt = $pdo->prepare('INSERT INTO projects (thumbnail_path, description, start_date, finish_date) VALUES (?, ?, ?, ?)');
    $stmt->execute([$thumbPath, $description, $start_date, $finish_date]);
    $project_id = $pdo->lastInsertId();
    
    // Insert photo records
    foreach ($photoPaths as $photoPath) {
        $stmt = $pdo->prepare('INSERT INTO project_photos (project_id, photo_path) VALUES (?, ?)');
        $stmt->execute([$project_id, $photoPath]);
    }
    echo 'Project uploaded successfully!';
    exit();
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
