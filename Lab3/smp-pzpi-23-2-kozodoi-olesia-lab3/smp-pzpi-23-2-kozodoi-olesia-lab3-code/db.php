<?php
function getPDO() {
    try {
        $pdo = new PDO('sqlite:shop.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->exec("CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price DECIMAL(10,2) NOT NULL
        )");
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM products");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $pdo->exec("INSERT INTO products (name, price) VALUES 
                ('Молоко пастеризоване', 12),
                ('Хліб чорний', 9),
                ('Сир білий', 21),
                ('Сметана 20%', 25),
                ('Кефір 1%', 19),
                ('Вода газована', 18),
                ('Печиво \"Весна\"', 14)
            ");
        }
        
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>
