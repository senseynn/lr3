<?php
namespace App;

class Auth {
    // Регистрация
    public static function register($login, $password) {
        $pdo = Database::getConnection();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
        return $stmt->execute([$login, $hash]);
    }

    // Вход
    public static function login($login, $password, $remember = false) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            // Куки настроек
            setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
            setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');

            // Автовход
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->execute([$token, $user['id']]);
                setcookie('remember_token', $token, time() + 86400 * 30, '/');
            }
            return true;
        }
        return false;
    }

    // Проверка автовхода по кукам
    public static function checkRememberMe() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
            $stmt->execute([$_COOKIE['remember_token']]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
                setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');
            }
        }
    }

    // Выход
    public static function logout() {
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        setcookie('bg_color', '', time() - 3600, '/');
        setcookie('font_color', '', time() - 3600, '/');
        header("Location: login.php");
        exit;
    }
}