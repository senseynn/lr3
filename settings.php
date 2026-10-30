<?php
require 'vendor/autoload.php';
session_start();
use App\Database;
use App\Auth;

Auth::checkRememberMe();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bg = $_POST['bg_color'] ?? '#ffffff';
    $font = $_POST['font_color'] ?? '#000000';

    // Сохраняем в БД
    $stmt = $pdo->prepare("UPDATE users SET bg_color = ?, font_color = ? WHERE id = ?");
    $stmt->execute([$bg, $font, $_SESSION['user_id']]);

    // Обновляем куки
    setcookie('bg_color', $bg, time() + 86400 * 30, '/');
    setcookie('font_color', $font, time() + 86400 * 30, '/');

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Настройки</title></head>
<body>
<h2>Настройки внешнего вида</h2>
<form method="post">
    Цвет фона: <input type="color" name="bg_color" value="<?= $_COOKIE['bg_color'] ?? '#ffffff' ?>"><br><br>
    Цвет шрифта: <input type="color" name="font_color" value="<?= $_COOKIE['font_color'] ?? '#000000' ?>"><br><br>
    <button type="submit">Сохранить настройки</button>
</form>
<p><a href="index.php">Назад на главную</a></p>
</body>
</html>