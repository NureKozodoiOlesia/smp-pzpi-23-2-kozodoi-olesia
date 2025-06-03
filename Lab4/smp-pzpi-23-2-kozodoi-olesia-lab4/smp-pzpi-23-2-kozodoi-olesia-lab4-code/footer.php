<footer>
        <hr>
        <nav style="text-align: center; padding: 10px 0;">
            <a href="index.php?page=home">Головна</a> |
            <?php if ($isLoggedIn): ?>
                <a href="index.php?page=products">Товари</a> |
                <a href="index.php?page=cart">Кошик</a> |
                <a href="index.php?page=profile">Профіль</a> |
            <?php endif; ?>
            <a href="#">Про нас</a>
        </nav>
    </footer>
</body>
</html>
