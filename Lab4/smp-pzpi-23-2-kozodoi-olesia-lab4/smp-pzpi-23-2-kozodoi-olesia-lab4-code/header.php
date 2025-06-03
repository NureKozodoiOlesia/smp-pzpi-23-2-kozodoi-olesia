<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_login']) && isset($_SESSION['login_time']);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle : 'Web-магазин "Весна"' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1 style="margin: 0; padding: 10px 0;">Web-магазин "Весна"</h1>
        <nav style="text-align: center; padding: 10px 0;">
            <a href="index.php?page=home">Головна</a> |
            <?php if ($isLoggedIn): ?>
                <a href="index.php?page=products">Товари</a> |
                <a href="index.php?page=cart">Кошик</a> |
                <a href="index.php?page=profile">Профіль</a> |
                <a href="logout.php">Вихід (<?= htmlspecialchars($_SESSION['user_login']) ?>)</a>
            <?php else: ?>
                <a href="index.php?page=login">Вхід</a>
            <?php endif; ?>
        </nav>
    </header>
