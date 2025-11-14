<?php
// admin/game_form.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /gamehub/login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$edit = $id > 0;
$errors = [];

if ($edit) {
    $stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
    $stmt->execute([$id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$game) { exit('Not found'); }
} else {
    $game = ['title'=>'','genre'=>'','platform'=>'','description'=>'','release_date'=>''];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $platform = trim($_POST['platform'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $release_date = $_POST['release_date'] ?? null;

    if ($title === '') $errors[] = 'Title is required.';

    if (empty($errors)) {
        if ($edit) {
            $stmt = $pdo->prepare("UPDATE games SET title=?, genre=?, platform=?, description=?, release_date=? WHERE id=?");
            $stmt->execute([$title,$genre,$platform,$description,$release_date,$id]);
            header('Location: games.php');
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO games (title,genre,platform,description,release_date) VALUES (?,?,?,?,?)");
            $stmt->execute([$title,$genre,$platform,$description,$release_date]);
            header('Location: games.php');
            exit;
        }
    }
}

require_once __DIR__ . '/../header.php';
?>
<div class="container">
  <h2><?= $edit ? 'Edit' : 'Add' ?> Game</h2>
  <?php foreach ($errors as $e): ?><p class="error"><?=htmlspecialchars($e)?></p><?php endforeach; ?>
  <form method="post">
    <label>Title: <input name="title" value="<?=htmlspecialchars($game['title'])?>" required></label><br>
    <label>Genre: <input name="genre" value="<?=htmlspecialchars($game['genre'])?>"></label><br>
    <label>Platform: <input name="platform" value="<?=htmlspecialchars($game['platform'])?>"></label><br>
    <label>Release Date: <input type="date" name="release_date" value="<?=htmlspecialchars($game['release_date'])?>"></label><br>
    <label>Description:<br>
      <textarea name="description" rows="6"><?=htmlspecialchars($game['description'])?></textarea>
    </label><br>
    <button type="submit"><?= $edit ? 'Save Changes' : 'Add Game' ?></button>
    <a href="games.php">Cancel</a>
  </form>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
