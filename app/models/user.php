<?php
require_once __DIR__ . '/../core/Database.php';
class User {
    public static function create(string $name, string $email, string $password): int {
        $db = Database::connect();
        $q = $db->prepare('INSERT INTO users(full_name,email,password_hash) VALUES(?,?,?)');
        $q->execute([$name, strtolower(trim($email)), password_hash($password, PASSWORD_DEFAULT)]);
        return (int)$db->lastInsertId();
    }
    public static function findByEmail(string $email): ?array {
        $q = Database::connect()->prepare('SELECT * FROM users WHERE email=?');
        $q->execute([strtolower(trim($email))]);
        return $q->fetch() ?: null;
    }
    public static function find(int $id): ?array {
        $q = Database::connect()->prepare('SELECT id,full_name,email,created_at FROM users WHERE id=?');
        $q->execute([$id]);
        return $q->fetch() ?: null;
    }
    public static function update(int $id, string $name, string $email): void {
        $q = Database::connect()->prepare('UPDATE users SET full_name=?, email=? WHERE id=?');
        $q->execute([$name, strtolower(trim($email)), $id]);
    }
    public static function updatePassword(int $id, string $password): void {
        $q = Database::connect()->prepare('UPDATE users SET password_hash=? WHERE id=?');
        $q->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
    }
}

