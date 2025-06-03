<?php
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
        update_cart($validItems);
        header('Location: index.php?page=cart');
        exit;
    } else {
        $error = "Помилка! Визначте правильну кількість.";
    }
}
?>

<h1>Оберіть товари</h1>

<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="index.php?page=products">
    <table style="margin: 0 auto;">
        <?php foreach ($products as $id => $product): ?>
            <tr>
                <td><img src="https://via.placeholder.com/50"></td>
                <td><strong><?= htmlspecialchars($product['name']) ?></strong></td>
                <td>
                    <input type="number" name="<?= $id ?>" value="<?= isset($cart[$id]) ? $cart[$id] : 0 ?>" min="0" style="width: 60px;">
                    <?php if (isset($cart[$id])): ?>
                        <br><small style="color: #28a745;">В кошику: <?= $cart[$id] ?></small>
                    <?php endif; ?>
                </td>
                <td><?= $product['price'] ?> грн</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <button type="submit">Додати до кошика</button>
</form>
