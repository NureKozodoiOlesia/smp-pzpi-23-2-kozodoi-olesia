<?php
include 'functions.php';
require_once 'db.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM products");
$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[$row['id']] = [
        'name' => $row['name'],
        'price' => $row['price']
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_id'])) {
        remove_from_cart($_POST['remove_id']);
    } 
    elseif (isset($_POST['clear_cart'])) {
        clear_cart();
        header('Location: products.php');
        exit;
    }
}
$cart = get_cart();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик</title>
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
        <h1>Кошик</h1>
        
        <?php if (empty($cart)): ?>
            <p style="font-size: 1.2em;">Кошик порожній</a></p>
            <p style="font-size: 1.2em;"><a href="products.php">Перейти до покупок</a></p>
        <?php else: ?>
            <?= render_cart_table($cart, $products) ?>
            <div style="margin-top: 20px;">
                <form action="" method="post" style="display: inline;">
                    <input type="hidden" name="clear_cart" value="1">
                    <button type="submit">Скасувати</button>
                </form>
                <form action="pay.php" method="post" style="display: inline;">
                    <button type="submit">Оплатити</button>
                </form>
            </div>
        <?php endif; ?>
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
