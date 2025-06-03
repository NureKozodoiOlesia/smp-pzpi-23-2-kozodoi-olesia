<?php
include 'functions.php';
require_once 'db.php';

$pdo = getPDO();
$stmt = $pdo->query('SELECT * FROM products');
$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[$row['id']] = [
        'name' => $row['name'],
        'price' => $row['price']
    ];
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
    <header>
        <nav>
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a> |
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <main>
        <h1>Ласкаво просимо до веб-магазину "Весна"</h1>
        <p><a href="products.php">Перейти до покупок</a></p>
    </main>

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
