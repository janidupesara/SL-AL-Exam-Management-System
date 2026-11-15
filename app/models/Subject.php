<?php
require_once __DIR__ . '/../core/Database.php';
class Subject {
    public static function all(int $userId): array {
        $q=Database::connect()->prepare('SELECT * FROM subjects WHERE user_id=? ORDER BY id');
        $q->execute([$userId]); return $q->fetchAll();
    }
    public static function create(int $userId, string $name, float $target, string $color): void {
        $q=Database::connect()->prepare('INSERT INTO subjects(user_id,subject_name,target_hours,chart_color) VALUES(?,?,?,?)');
        $q->execute([$userId,$name,$target,$color]);
    }
    public static function findOwned(int $id, int $userId): ?array {
        $q=Database::connect()->prepare('SELECT * FROM subjects WHERE id=? AND user_id=?');
        $q->execute([$id,$userId]); return $q->fetch() ?: null;
    }
    public static function updateTarget(int $id, int $userId, float $target): void {
    $q = Database::connect()->prepare(
        'UPDATE subjects SET target_hours = ? WHERE id = ? AND user_id = ?'
    );

    $q->execute([$target, $id, $userId]);
}
}

