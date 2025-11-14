<?php
// login.php
session_start();
require_once __DIR__ . '/config/db.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $err = 'Both fields required.';
    } else {
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            // redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: user/dashboard.php');
            }
            exit;
        } else {
            $err = 'Invalid credentials.';
        }
    }
}
require 'header.php';
?>
<div class="container">
  <h2>Login</h2>
  <?php if ($err): ?><p class="error"><?=htmlspecialchars($err)?></p><?php endif; ?>
  <form method="post">
    <label>Username: <input name="username" required></label><br>
    <label>Password: <input name="password" type="password" required></label><br>
    <button type="submit">Login</button>
  </form>
  <p>New user? <a href="register.php">Register here</a>.</p>
</div>
<?php require 'footer.php'; ?>
