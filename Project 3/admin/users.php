<?php
// admin/users.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /gamehub/login.php');
    exit;
}

$stmt = $pdo->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2>Registered Users</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Created</th></tr></thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?=$u['id']?></td>
          <td><?=htmlspecialchars($u['username'])?></td>
          <td><?=htmlspecialchars($u['role'])?></td>
          <td><?=htmlspecialchars($u['created_at'])?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
