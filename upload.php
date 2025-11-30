<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project - ETS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="upload.css">
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
    <div class="upload-container">
        <h2 class="upload-title">Upload New Project</h2>
        <form id="upload-form" action="upload_project.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="thumbnail">Project Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="photos">Project Photos</label>
                <input type="file" id="photos" name="photos" accept="image/*" multiple required>
            </div>
            <div class="form-group">
                <label for="description">Project Description</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <label for="start-date">Project Start Date</label>
                    <input type="date" id="start-date" name="start-date" required>
                </div>
                <div class="form-group">
                    <label for="finish-date">Project Finish Date</label>
                    <input type="date" id="finish-date" name="finish-date" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Upload Project</button>
        </form>
    </div>
    <script src="upload.js"></script>
</body>
</html>
