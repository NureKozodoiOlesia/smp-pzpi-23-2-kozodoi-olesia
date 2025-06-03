<?php
include 'functions.php';
require_once 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_login']) && isset($_SESSION['login_time']);
$page = $_GET['page'] ?? 'home';

// Перевірка авторизації для захищених сторінок
$protectedPages = ['products', 'cart', 'profile'];
if (in_array($page, $protectedPages) && !$isLoggedIn) {
    $page = 'page404';
}

require_once 'header.php';

echo '<main style="text-align: center; padding: 20px;">';

switch ($page) {
    case "cart":
        $pageTitle = "Кошик";
        require_once "cart.php";
        break;
    case "profile":
        $pageTitle = "Профіль";
        require_once "profile.php";
        break;
    case "products":
        $pageTitle = "Товари";
        require_once "products.php";
        break;
    case "login":
        $pageTitle = "Вхід";
        require_once "login.php";
        break;
    case "home":
        $pageTitle = "Головна";
        require_once "home.php";
        break;
    default:
        $pageTitle = "404";
        require_once "page404.php";
        break;
}

echo '</main>';

require_once 'footer.php';
?>
