<?php
session_start();

function add_to_cart($newItems) {
    $existingCart = $_SESSION['cart'] ?? [];
    
    foreach ($newItems as $productId => $quantity) {
        if (isset($existingCart[$productId])) {
            $existingCart[$productId] += $quantity;
        } else {
            $existingCart[$productId] = $quantity;
        }
    }
    
    $_SESSION['cart'] = $existingCart;
}

function update_cart($items) {
    $cart = $_SESSION['cart'] ?? [];
    
    foreach ($items as $productId => $quantity) {
        if ($quantity == 0) {
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
            }
        } else {
            $cart[$productId] = $quantity;
        }
    }
    
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

function validateCartData($postData, $productList) {
    $validItems = [];

    foreach ($productList as $key => $product) {
        if (isset($postData[$key]) && is_numeric($postData[$key])) {
            $quantity = (int)$postData[$key];
            if ($quantity >= 0) {
                $validItems[$key] = $quantity;
            }
        }
    }

    return $validItems;
}
?>
