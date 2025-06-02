<?php
session_start();

function validateCartData($postData, $productList) {
    $validItems = [];

    foreach ($productList as $key => $product) {
        if (isset($postData[$key]) && is_numeric($postData[$key])) {
            $quantity = (int)$postData[$key];
            if ($quantity >= 0) { // Змінено: тепер дозволяємо 0
                $validItems[$key] = $quantity;
            }
        }
    }

    return $validItems;
}

function add_to_cart($newItems) {
    // Отримуємо існуючий кошик або створюємо новий
    $existingCart = $_SESSION['cart'] ?? [];
    
    // Додаємо нові товари до існуючого кошика
    foreach ($newItems as $productId => $quantity) {
        if (isset($existingCart[$productId])) {
            // Якщо товар вже є в кошику, збільшуємо кількість
            $existingCart[$productId] += $quantity;
        } else {
            // Якщо товару немає, додаємо його
            $existingCart[$productId] = $quantity;
        }
    }
    
    // Зберігаємо оновлений кошик
    $_SESSION['cart'] = $existingCart;
}

// Нова функція для оновлення кількості товарів в кошику
function update_cart($items) {
    // Отримуємо існуючий кошик або створюємо новий
    $cart = $_SESSION['cart'] ?? [];
    
    // Оновлюємо кількість товарів
    foreach ($items as $productId => $quantity) {
        if ($quantity == 0) {
            // Якщо кількість 0, видаляємо товар з кошика
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
            }
        } else {
            // Інакше встановлюємо нову кількість
            $cart[$productId] = $quantity;
        }
    }
    
    // Зберігаємо оновлений кошик
    $_SESSION['cart'] = $cart;
}

function get_cart() {
    return $_SESSION['cart'] ?? [];
}

function remove_from_cart($id) {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

function clear_cart() {
    unset($_SESSION['cart']);
}

function render_cart_table($cart, $products) {
    $html = '<table border="1" cellpadding="10" cellspacing="0" style="margin: 0 auto;">';
    $html .= '<tr><th>ID</th><th>Назва</th><th>Ціна</th><th>Кількість</th><th>Сума</th><th>Дія</th></tr>';

    $total = 0;
    foreach ($cart as $id => $count) {
        if (!isset($products[$id])) continue;

        $name = htmlspecialchars($products[$id]['name']);
        $price = $products[$id]['price'];
        $sum = $price * $count;
        $total += $sum;

        $html .= "<tr>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$price} грн</td>
                    <td>{$count}</td>
                    <td>{$sum} грн</td>
                    <td>
                        <form method='POST' style='display:inline'>
                            <input type='hidden' name='remove_id' value='{$id}'>
                            <button type='submit'>🗑️</button>
                        </form>
                    </td>
                  </tr>";
    }

    $html .= "<tr>
                <td colspan='4'><strong>Усього</strong></td>
                <td><strong>{$total} грн</strong></td>
                <td></td>
              </tr>";
    $html .= '</table>';

    return $html;
}
?>
