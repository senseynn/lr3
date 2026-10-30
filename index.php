<?php
require 'vendor/autoload.php';
session_start();
use App\Auth;

Auth::checkRememberMe();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Применяем цвета из кук
$bg = $_COOKIE['bg_color'] ?? '#ffffff';
$font = $_COOKIE['font_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Главная</title>
    <style>
        body { background-color: <?= $bg ?>; color: <?= $font ?>; font-family: sans-serif; }
    </style>
</head>
<body>
<h1>Добро пожаловать в систему!</h1>
<p>Вы успешно авторизованы.</p>
<a href="settings.php">⚙ Настройки</a> | <a href="logout.php">Выйти</a>
</body>
</html>