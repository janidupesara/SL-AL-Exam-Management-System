<?php
class Database {
    private static ?PDO $connection = null;
    public static function connect(): PDO {
        if (self::$connection === null) {
            $host = 'localhost';
            $dbname = 'sl_al_exam_management';
            $username = 'root';
            $password = ''; // Change this if your MySQL root account has a password.
            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        }
        return self::$connection;
    }
}


