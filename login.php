<?php
require 'vendor/autoload.php';
session_start();
use App\Auth;

Auth::checkRememberMe();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (Auth::login($login, $password, $remember)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Вход</title></head>
<body>
<h2>Вход</h2>
<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
    Логин: <input type="text" name="login" required><br><br>
    Пароль: <input type="password" name="password" required><br><br>
    <label><input type="checkbox" name="remember"> Запомнить меня</label><br><br>
    <button type="submit">Войти</button>
</form>
<p><a href="register.php">Нет аккаунта? Зарегистрироваться</a></p>
</body>
</html>