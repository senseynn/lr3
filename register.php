<?php
require 'vendor/autoload.php';
use App\Auth;

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (strlen($login) < 3 || strlen($password) < 3) {
        $error = "Логин и пароль должны быть не менее 3 символов";
    } else {
        try {
            Auth::register($login, $password);
            header("Location: login.php");
            exit;
        } catch (Exception $e) {
            $error = "Ошибка: такой логин уже существует";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Регистрация</title></head>
<body>
<h2>Регистрация</h2>
<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
    Логин: <input type="text" name="login" required><br><br>
    Пароль: <input type="password" name="password" required><br><br>
    <button type="submit">Зарегистрироваться</button>
</form>
<p><a href="login.php">Уже есть аккаунт? Войти</a></p>
</body>
</html>