<?php
namespace App;

use PDO;

class Database {
    public static function getConnection(): PDO {
        // Внимание: IP 127.0.1.30, как мы выяснили ранее!
        $host = '127.0.1.30';
        $db   = 'php_lr3';
        $user = 'root';
        $pass = '';

        return new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}