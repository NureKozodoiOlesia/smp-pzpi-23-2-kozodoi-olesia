<?php
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
        header('Location: index.php?page=products');
        exit;
    }
    elseif (isset($_POST['pay'])) {
        $cart = get_cart();
        if (!empty($cart)) {
            clear_cart();
            echo '<h1>Дякуємо за покупку!</h1>';
            echo '<p>Ваше замовлення успішно оформлено.</p>';
            echo '<p><a href="index.php?page=products">Повернутися до покупок</a></p>';
            return;
        }
    }
}

$cart = get_cart();
?>

<h1>Кошик</h1>

<?php if (empty($cart)): ?>
    <p style="font-size: 1.2em;">Кошик порожній</p>
    <p style="font-size: 1.2em;"><a href="index.php?page=products">Перейти до покупок</a></p>
<?php else: ?>
    <?= render_cart_table($cart, $products) ?>
    <div style="margin-top: 20px;">
        <form action="index.php?page=cart" method="post" style="display: inline;">
            <input type="hidden" name="clear_cart" value="1">
            <button type="submit">Скасувати</button>
        </form>
        <form action="index.php?page=cart" method="post" style="display: inline;">
            <input type="hidden" name="pay" value="1">
            <button type="submit">Оплатити</button>
        </form>
    </div>
<?php endif; ?>
