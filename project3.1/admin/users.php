<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

$users = $pdo->query("SELECT id, username, role FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>

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
    .btn-delete { background-color: #dc2626; }
    .top-bar {
        margin-bottom:15px; display:flex; justify-content:flex-start;
    }
</style>
</head>

<body>
<div class="container">

    <div class="top-bar">
        <a href="dashboard.php" class="btn btn-primary">Back</a>
    </div>

    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>

        <?php foreach($users as $u): ?>
        <tr>
            <td><?= $u["id"] ?></td>
            <td><?= htmlspecialchars($u["username"]) ?></td>
            <td><?= $u["role"] ?></td>
            <td>
                <?php if ($u["role"] !== "admin"): ?>
                    <a href="delete_user.php?id=<?= $u["id"] ?>" class="btn btn-delete"
                       onclick="return confirm('Delete this user?')">Delete</a>
                <?php else: ?>
                    <span style="color:#999;">Protected</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>
</body>
</html>
