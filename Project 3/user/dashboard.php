<?php
// user/dashboard.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) {
    header('Location: /gamehub/login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM games ORDER BY created_at DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2>Game Catalog</h2>
  <ul>
    <?php foreach ($games as $g): ?>
      <li>
        <a href="view_game.php?id=<?=$g['id']?>"><?=htmlspecialchars($g['title'])?></a>
        (<?=htmlspecialchars($g['platform'])?>, <?=htmlspecialchars($g['genre'])?>)
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
