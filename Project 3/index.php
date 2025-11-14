<?php
// index.php
session_start();
if (!empty($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: user/dashboard.php');
    }
    exit;
}
require 'header.php';
?>
<div class="container">
  <h2>Welcome to GameHub</h2>
  <p>A simple game catalog where admins manage games and users add reviews.</p>
  <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>
</div>
<?php require 'footer.php'; ?>
