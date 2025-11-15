<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

$games = $pdo->query("SELECT * FROM games ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Games</title>

<style>
    body { background-color: #f3f4f6; font-family: Arial, sans-serif; }
    .container {
        max-width: 900px; margin: 50px auto;
        background: #fff; padding: 25px;
        border-radius: 10px; box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    h2 { font-size: 24px; font-weight: 600; margin-bottom: 20px; text-align:center; }
    table {
        width: 100%; border-collapse: collapse; margin-bottom: 20px;
    }
    th, td {
        padding: 12px; text-align: center; border-bottom: 1px solid #ddd;
    }
    th {
        background: #2563eb; color: white;
        font-weight: 500;
    }
    .btn {
        padding: 8px 12px; border-radius: 6px;
        color: #fff; border: none;
        text-decoration: none; cursor: pointer;
        font-size: 14px;
    }
    .btn-primary { background-color: #2563eb; }
    .btn-edit { background-color: #059669; }
    .btn-delete { background-color: #dc2626; }
    .top-bar {
        display:flex; justify-content:space-between; margin-bottom:15px;
    }
</style>
</head>

<body>
<div class="container">
    
    <div class="top-bar">
        <a href="dashboard.php" class="btn btn-primary">Back</a>
        <a href="game_form.php" class="btn btn-primary">Add Game</a>
    </div>

    <h2>Manage Games</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Game Title</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>

        <?php foreach($games as $game): ?>
        <tr>
            <td><?= $game["id"] ?></td>
            <td><?= htmlspecialchars($game["title"]) ?></td>
            <td><?= htmlspecialchars($game["genre"]) ?></td>
            <td>
                <a href="edit_game.php?id=<?= $game["id"] ?>" class="btn btn-edit">Edit</a>
                <a href="delete_game.php?id=<?= $game["id"] ?>" class="btn btn-delete"
                   onclick="return confirm('Delete game?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>
</body>
</html>
