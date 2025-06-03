<?php
require_once 'credentials.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = trim($_POST['userName'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($userName) || empty($password)) {
        $error = 'Будь ласка, заповніть всі поля';
    } elseif ($userName === $credentials['userName'] && $password === $credentials['password']) {
        $_SESSION['user_login'] = $userName;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        header('Location: index.php?page=products');
        exit;
    } else {
        $error = 'Неправильне ім\'я користувача або пароль';
    }
}
?>

<h1>Вхід до системи</h1>

<?php if ($error): ?>
    <div style="color: #d9534f; background-color: #f2dede; border: 1px solid #ebccd1; padding: 15px; border-radius: 5px; margin: 20px auto; max-width: 400px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <table style="margin: 0 auto; width: 100%;">
        <tr>
            <td style="padding: 10px; text-align: right;"><label for="userName">Ім'я користувача:</label></td>
            <td style="padding: 10px;">
                <input type="text" id="userName" name="userName" 
                       value="<?= htmlspecialchars($_POST['userName'] ?? '') ?>" 
                       style="width: 150px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px; text-align: right;"><label for="password">Пароль:</label></td>
            <td style="padding: 10px;">
                <input type="password" id="password" name="password" 
                       style="width: 150px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding-top: 20px;">
                <button type="submit" style="padding: 10px 25px; font-size: 16px;">Увійти</button>
            </td>
        </tr>
    </table>
</form>

