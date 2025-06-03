<?php
session_start();
unset($_SESSION['user_login']);
unset($_SESSION['login_time']);
header('Location: index.php?page=home');
exit;
?>
