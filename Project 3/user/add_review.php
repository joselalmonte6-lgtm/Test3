<?php
// user/add_review.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) {
    header('Location: /gamehub/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$game_id = intval($_POST['game_id'] ?? 0);
$rating = intval($_POST['rating'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($game_id <= 0 || $rating < 1 || $rating > 10 || $comment === '') {
    // minimal validation; return to game page
    header("Location: view_game.php?id={$game_id}");
    exit;
}

$stmt = $pdo->prepare("INSERT INTO reviews (game_id, user_id, rating, comment) VALUES (?,?,?,?)");
$stmt->execute([$game_id, $_SESSION['user_id'], $rating, $comment]);

header("Location: view_game.php?id={$game_id}");
exit;
