<?php
// setup.php - run once to create an admin account
session_start();
require_once __DIR__ . '/config/db.php';

$created = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    if ($u === '' || $p === '') {
        $message = 'Username and password are required.';
    } else {
        // check duplicate
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$u]);
        if ($stmt->fetch()) {
            $message = 'Username already exists.';
        } else {
            $hash = password_hash($p, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
            $stmt->execute([$u, $hash]);
            $created = true;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>GameHub Setup - Create Admin</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>GameHub — Setup (Create Admin)</h1>
    <?php if ($created): ?>
      <p class="success">Admin account created. <a href="login.php">Go to login</a></p>
    <?php else: ?>
      <?php if ($message): ?><p class="error"><?=htmlspecialchars($message)?></p><?php endif; ?>
      <form method="post">
        <label>Admin username: <input name="username" required></label><br>
        <label>Admin password: <input name="password" type="password" required></label><br>
        <button type="submit">Create Admin</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
