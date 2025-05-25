<?php
include "products.php";
function showMainMenu()
{
    echo "################################\n";
    echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
    echo "################################\n";
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
    echo "Введіть команду: ";
}
$cart = [];
while (true) {
    showMainMenu();
    $cmd = trim(fgets(STDIN));
    echo "\n";
    switch ($cmd) {
        case "1":
            selectProducts($products, $cart);
            break;
        case "2":
            showReceipt($products, $cart);
            break;
        case "3":
            setupProfile();
            break;
        case "0":
            exit;
        default:
            echo "ПОМИЛКА! Невідома команда. Спробуйте ще раз\n";
    }
    echo "\n";
}
function selectProducts($products, &$cart)
{
    $maxNameLength = 0;
    foreach ($products as $item) {
        preg_match_all('/./us', $item['name'], $matches);
        $length = count($matches[0]);
        if ($length > $maxNameLength) $maxNameLength = $length;
    }
    while (true) {
        echo "\n№  НАЗВА" . str_repeat(" ", $maxNameLength - 5 + 2) . "ЦІНА\n";
        foreach ($products as $num => $item) {
            preg_match_all('/./us', $item['name'], $matches);
            $length = count($matches[0]);
            $padding = str_repeat(" ", $maxNameLength - $length + 2);
            printf("%-2d %s%s%d\n", $num, $item['name'], $padding, $item['price']);
        }
        echo "   -----------\n";
        echo "0  ПОВЕРНУТИСЯ\n";
        echo "Виберіть товар: ";
        $choice = trim(fgets(STDIN));
        if (!ctype_digit($choice)) {
            echo "ПОМИЛКА! ВВЕДІТЬ НОМЕР ТОВАРУ\n\n";
            continue;
        }
        $index = (int)$choice;
        if ($index === 0) break;
        if (!isset($products[$index])) {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
            continue;
        }
        $product = $products[$index];
        echo "Вибрано: {$product['name']}\n";
        echo "Введіть кількість, штук: ";
        $quantity = (int)trim(fgets(STDIN));
        if ($quantity < 0 || $quantity >= 100) {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНУ КІЛЬКІСТЬ ТОВАРУ\n\n";
            continue;
        }
        if ($quantity === 0) {
            unset($cart[$index]);
            echo "ВИДАЛЯЮ З КОШИКА\n";
        } else {
            $cart[$index] = $quantity;
        }
        echo "У КОШИКУ:\nНАЗВА" . str_repeat(" ", $maxNameLength - 5 + 2) . "КІЛЬКІСТЬ\n";
        foreach ($cart as $num => $qty) {
            $name = $products[$num]['name'];
            preg_match_all('/./us', $name, $matches);
            $length = count($matches[0]);
            $padding = str_repeat(" ", $maxNameLength - $length + 2);
            echo $name . $padding . $qty . "\n";
        }
        echo "\n";
    }
}
function showReceipt($products, $cart)
{
    if (empty($cart)) {
        echo "КОШИК ПОРОЖНІЙ\n";
        return;
    }
    $maxNameLen = 5;
    $maxPriceLen = 4;
    $maxQtyLen = 9;
    $maxSumLen = 8;
    foreach ($cart as $num => $qty) {
        $name = $products[$num]['name'];
        $price = $products[$num]['price'];
        $sum = $price * $qty;
        preg_match_all('/./us', $name, $matches);
        $nameLen = count($matches[0]);
        $maxNameLen = max($maxNameLen, $nameLen);
        $maxPriceLen = max($maxPriceLen, strlen((string)$price));
        $maxQtyLen = max($maxQtyLen, strlen((string)$qty));
        $maxSumLen = max($maxSumLen, strlen((string)$sum));
    }
    echo "№  НАЗВА"
        . str_repeat(" ", $maxNameLen - 5 + 2)
        . "ЦІНА" . str_repeat(" ", $maxPriceLen - 4 + 2)
        . "КІЛЬКІСТЬ" . str_repeat(" ", $maxQtyLen - 9 + 2)
        . "ВАРТІСТЬ\n";

    $i = 1;
    $total = 0;
    foreach ($cart as $num => $qty) {
        $name = $products[$num]['name'];
        $price = $products[$num]['price'];
        $sum = $price * $qty;
        $total += $sum;
        preg_match_all('/./us', $name, $matches);
        $nameLen = count($matches[0]);
        $namePad = str_repeat(" ", $maxNameLen - $nameLen + 2);
        $pricePad = str_repeat(" ", $maxPriceLen - strlen((string)$price) + 2);
        $qtyPad = str_repeat(" ", $maxQtyLen - strlen((string)$qty) + 2);
        echo "$i  $name$namePad$price$pricePad$qty$qtyPad$sum\n";
        $i++;
    }
    echo "РАЗОМ ДО СПЛАТИ: $total\n";
}

function setupProfile()
{
    while (true) {
        echo "Ваше імʼя: ";
        $name = trim(fgets(STDIN));
        $validCharacters = preg_match("/^[А-Яа-яЁёЇїІіЄєҐґA-Za-z'’\- ]+$/u", $name);
        $containsLetter = preg_match("/[А-Яа-яЁёЇїІіЄєҐґA-Za-z]/u", $name);
        if ($validCharacters && $containsLetter) break;
        echo "ПОМИЛКА! Імʼя може містити лише літери, апостроф «'», дефіс «-», пробіл\n";
    }
    while (true) {
        echo "Ваш вік: ";
        $ageInput = trim(fgets(STDIN));
        if (!is_numeric($ageInput)) {
            echo "ПОМИЛКА! Вік має бути числом\n";
            continue;
        }
        $age = (int)$ageInput;
        if ($age >= 7 && $age <= 150) break;
        echo "ПОМИЛКА! Користувач повинен мати вік від 7 та до 150 років\n";
    }
    echo "\n";
}
