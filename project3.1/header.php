<?php
// header.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>GameHub</title>
  <link rel="stylesheet" href="/gamehub/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1><a href="/gamehub/index.php">GameHub</a></h1>
      <nav>
        <?php if (!empty($_SESSION['username'])): ?>
          <span>Hi, <?=htmlspecialchars($_SESSION['username'])?></span>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="/gamehub/admin/dashboard.php">Admin</a>
          <?php else: ?>
            <a href="/gamehub/user/dashboard.php">My Games</a>
          <?php endif; ?>
          <a href="/gamehub/logout.php">Logout</a>
        <?php else: ?>
          <a href="/gamehub/login.php">Login</a>
          <a href="/gamehub/register.php">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <main>
