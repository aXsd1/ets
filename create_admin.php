<?php
require 'db.php';
$username = 'admin';
$password = 'sinop5757';
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT IGNORE INTO admins (username, password_hash) VALUES (?, ?)");
$stmt->execute([$username, $password_hash]);
echo "Admin account setup done.";
