<?php
include 'functions.php';
require_once 'db.php';

// Отримуємо продукти з бази даних
$pdo = getPDO();
$stmt = $pdo->query('SELECT * FROM products');
$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[$row['id']] = [
        'name' => $row['name'],
        'price' => $row['price']
    ];
}

$error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $validItems = validateCartData($_POST, $products);

    if (!empty($validItems)) {
        add_to_cart($validItems);
        header('Location: cart.php');
        exit;
    } else {
        $error = "Перевірте будь ласка введені дані";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Web-магазин - Головна</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Шапка -->
    <header>
        <nav>
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a> |
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <!-- Тіло -->
    <main>
        <h1>Ласкаво просимо до веб-магазину "Весна"</h1>
        <p><a href="products.php">Перейти до покупок</a></p>
    </main>

    <!-- Підвал -->
    <footer>
        <hr>
        <nav>
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a> |
            <a href="cart.php">Cart</a> |
            <a href="#">About Us</a>
        </nav>
    </footer>
</body>
</html>
