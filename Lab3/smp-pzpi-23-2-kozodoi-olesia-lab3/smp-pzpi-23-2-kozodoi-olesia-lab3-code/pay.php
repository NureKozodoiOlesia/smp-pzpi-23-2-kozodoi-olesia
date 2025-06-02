<?php
include 'functions.php';

$cart = get_cart();

if (empty($cart)) {
    header('Location: products.php');
    exit;
}

clear_cart();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Оплата успішна</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav style="text-align: center;">
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a> |
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <main style="text-align: center; padding: 20px;">
        <h1>Дякуємо за покупку!</h1>
        <p>Ваше замовлення успішно оформлено.</p>
        <p><a href="products.php">Повернутися до покупок</a></p>
    </main>

    <footer>
        <hr>
        <nav style="text-align: center;">
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a> |
            <a href="cart.php">Cart</a> |
            <a href="#">About Us</a>
        </nav>
    </footer>
</body>
</html>
