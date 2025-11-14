<?php
// register.php
session_start();
require_once __DIR__ . '/config/db.php';

$errors = [];
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password required.';
    } elseif ($password !== $password2) {
        $errors[] = 'Passwords do not match.';
    } else {
        // check duplicate username
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hash]);
            $success = true;
        }
    }
}
require 'header.php';
?>
<div class="container">
  <h2>Register</h2>
  <?php if ($success): ?>
    <p class="success">Account created. <a href="login.php">Login</a></p>
  <?php else: ?>
    <?php foreach ($errors as $e): ?><p class="error"><?=htmlspecialchars($e)?></p><?php endforeach; ?>
    <form method="post">
      <label>Username: <input name="username" required></label><br>
      <label>Password: <input name="password" type="password" required></label><br>
      <label>Confirm: <input name="password2" type="password" required></label><br>
      <button type="submit">Register</button>
    </form>
  <?php endif; ?>
</div>
<?php require 'footer.php'; ?>
