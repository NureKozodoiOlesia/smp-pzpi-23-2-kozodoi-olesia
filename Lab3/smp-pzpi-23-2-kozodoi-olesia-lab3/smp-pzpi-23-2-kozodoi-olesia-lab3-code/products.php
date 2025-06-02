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
$cart = get_cart();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $validItems = validateCartData($_POST, $products);
    if (!empty($validItems) && array_sum($validItems) > 0) {
        // Використовуємо update_cart замість add_to_cart для оновлення кількості
        update_cart($validItems);
        header('Location: cart.php');
        exit;
    } else {
        $error = "Помилка! Визначте правильну кількість.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Web-магазин - Товари</title>
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
        <h1>Оберіть товари</h1>

        <?php if ($error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="products.php">
            <table>
                <?php foreach ($products as $id => $product): ?>
                    <tr>
                        <td><img src="https://via.placeholder.com/50" alt="<?= htmlspecialchars($product['name']) ?>"></td>
                        <td><strong><?= htmlspecialchars($product['name']) ?></strong></td>
                        <td>
                            <!-- Змінено: тепер показуємо поточну кількість з кошика -->
                            <input type="number" name="<?= $id ?>" value="<?= isset($cart[$id]) ? $cart[$id] : 0 ?>" min="0">
                            <?php if (isset($cart[$id])): ?>
                                <br><small style="color: #28a745;">В кошику: <?= $cart[$id] ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= $product['price'] ?> грн</td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <button type="submit">Оновити кошик</button>
        </form>
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
