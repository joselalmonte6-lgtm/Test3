<?php
// admin/dashboard.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /gamehub/login.php');
    exit;
}
require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2>Admin Dashboard</h2>
  <ul>
    <li><a href="games.php">Manage Games</a></li>
    <li><a href="users.php">View Users</a></li>
  </ul>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
