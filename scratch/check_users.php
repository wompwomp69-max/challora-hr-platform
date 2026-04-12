<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();
$stmt = $db->query('SELECT id, name, email, role FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Users in database:\n";
foreach ($users as $u) {
    echo "ID: {$u['id']}, Name: {$u['name']}, Email: {$u['email']}, Role: {$u['role']}\n";
}
