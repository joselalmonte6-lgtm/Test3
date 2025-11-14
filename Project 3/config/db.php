<?php
// config/db.php
// Database connection file for GameHub (CIS4004 Project 3)

$DB_HOST = '127.0.0.1';
$DB_PORT = '3305';          // current MySQL port shown in XAMPP
$DB_NAME = 'gamehub';
$DB_USER = 'root';
$DB_PASS = 'root'; // your MySQL password

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    exit("Database connection failed: " . $e->getMessage());
}
?>
