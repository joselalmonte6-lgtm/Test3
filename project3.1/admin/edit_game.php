<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

if (!isset($_GET["id"])) {
    header("Location: manage_games.php");
    exit;
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$game) {
    header("Location: manage_games.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $genre = trim($_POST["genre"]);

    if (empty($title) || empty($genre)) {
        $error = "All fields are required";
    } else {
        $update = $pdo->prepare("UPDATE games SET title=?, genre=? WHERE id=?");
        if ($update->execute([$title, $genre, $id])) {
            $success = "Game updated successfully!";
        } else {
            $error = "Failed to update game";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Game</title>

<style>
    body { background: #f3f4f6; font-family: Arial, sans-serif; }
    .container {
        max-width: 500px;
        margin: 60px auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        text-align: center;
    }
    h2 { margin-bottom: 20px; font-weight: 600; }
    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 10px;
        color: #fff;
    }
    .primary { background: #2563eb; }
    .gray { background: #6b7280; }
    .error { color:red; margin-bottom:10px; }
    .success { color:green; margin-bottom:10px; }
</style>

</head>
<body>

<div class="container">

    <h2>Edit Game</h2>

    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($game["title"]) ?>" placeholder="Game Title" required>
        <input type="text" name="genre" value="<?= htmlspecialchars($game["genre"]) ?>" placeholder="Genre" required>

        <button type="submit" class="primary">Update Game</button>
        <button type="button" class="gray" onclick="location.href='games.php'">Back</button>
    </form>

</div>

</body>
</html>
