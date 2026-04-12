<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

try {
    $db->exec('ALTER TABLE users ADD COLUMN kota VARCHAR(100) NULL AFTER address, ADD COLUMN provinsi VARCHAR(100) NULL AFTER kota');
    echo "Columns 'kota' and 'provinsi' added successfully.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Columns already exist.\n";
    } else {
        echo "Error adding columns: " . $e->getMessage() . "\n";
    }
}
