<?php
// admin/games.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /gamehub/login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM games ORDER BY created_at DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2>Manage Games</h2>
  <p><a href="game_form.php">Add New Game</a></p>
  <table class="table">
    <thead><tr><th>Title</th><th>Genre</th><th>Platform</th><th>Release</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($games as $g): ?>
        <tr>
          <td><?=htmlspecialchars($g['title'])?></td>
          <td><?=htmlspecialchars($g['genre'])?></td>
          <td><?=htmlspecialchars($g['platform'])?></td>
          <td><?=htmlspecialchars($g['release_date'])?></td>
          <td>
            <a href="game_form.php?id=<?=$g['id']?>">Edit</a> |
            <a href="delete_game.php?id=<?=$g['id']?>" onclick="return confirm('Delete this game?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
