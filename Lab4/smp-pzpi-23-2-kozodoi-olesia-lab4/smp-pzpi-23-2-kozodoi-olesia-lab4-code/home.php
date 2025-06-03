<h1>Ласкаво просимо до веб-магазину "Весна"</h1>

<?php if (isset($_SESSION['user_login'])): ?>
    <p style="font-size: 1.2em;">Привіт, <?= htmlspecialchars($_SESSION['user_login']) ?>!</p>
    <p><a href="index.php?page=products">Перейти до покупок</a></p>
<?php else: ?>
    <p style="font-size: 1.2em;">Для перегляду товарів, будь ласка, увійдіть до системи</p>
    <p><a href="index.php?page=login">Увійти</a></p>
<?php endif; ?>
