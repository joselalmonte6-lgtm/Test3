<?php
// user/view_game.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) {
    header('Location: /gamehub/login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$game) { exit('Game not found'); }

$stmt = $pdo->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON u.id = r.user_id WHERE r.game_id = ? ORDER BY r.created_at DESC");
$stmt->execute([$id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2><?=htmlspecialchars($game['title'])?></h2>
  <p><strong>Platform:</strong> <?=htmlspecialchars($game['platform'])?> |
     <strong>Genre:</strong> <?=htmlspecialchars($game['genre'])?> |
     <strong>Release:</strong> <?=htmlspecialchars($game['release_date'])?></p>
  <div class="game-desc"><?=nl2br(htmlspecialchars($game['description']))?></div>

  <h3>Reviews</h3>
  <?php if (empty($reviews)): ?><p>No reviews yet. Be the first to review!</p><?php endif; ?>
  <?php foreach ($reviews as $r): ?>
    <div class="review">
      <strong><?=htmlspecialchars($r['username'])?></strong> —
      Rating: <?= intval($r['rating']) ?>/10
      <p><?=nl2br(htmlspecialchars($r['comment']))?></p>
      <small><?=htmlspecialchars($r['created_at'])?></small>
    </div>
  <?php endforeach; ?>

  <h3>Add Your Review</h3>
  <form method="post" action="add_review.php">
    <input type="hidden" name="game_id" value="<?=$game['id']?>">
    <label>Rating (1-10): <input type="number" name="rating" min="1" max="10" required></label><br>
    <label>Comment:<br><textarea name="comment" rows="4" required></textarea></label><br>
    <button type="submit">Submit Review</button>
  </form>

  <p><a href="dashboard.php">Back to catalog</a></p>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
