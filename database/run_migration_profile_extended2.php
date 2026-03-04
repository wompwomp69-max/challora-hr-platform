<?php
/**
 * Migration: Tambah kolom profil extended + tabel user_achievements
 * Jalankan: php database/run_migration_profile_extended2.php
 * Atau buka di browser: /challorav2/database/run_migration_profile_extended2.php
 */
$baseDir = dirname(__DIR__);
require $baseDir . '/config/database.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$columns = [
    'gender' => 'VARCHAR(20) DEFAULT NULL',
    'religion' => 'VARCHAR(50) DEFAULT NULL',
    'social_media' => 'VARCHAR(255) DEFAULT NULL',
    'birth_place' => 'VARCHAR(100) DEFAULT NULL',
    'birth_date' => 'DATE DEFAULT NULL',
    'father_job' => 'VARCHAR(150) DEFAULT NULL',
    'mother_job' => 'VARCHAR(150) DEFAULT NULL',
    'father_education' => 'VARCHAR(100) DEFAULT NULL',
    'mother_education' => 'VARCHAR(100) DEFAULT NULL',
    'father_phone' => 'VARCHAR(30) DEFAULT NULL',
    'mother_phone' => 'VARCHAR(30) DEFAULT NULL',
    'address_type' => 'VARCHAR(50) DEFAULT NULL',
    'address_family' => 'TEXT DEFAULT NULL',
    'emergency_name' => 'VARCHAR(100) DEFAULT NULL',
    'emergency_phone' => 'VARCHAR(30) DEFAULT NULL',
    'job_description' => 'TEXT DEFAULT NULL',
];

echo "Running migration profile_extended2...\n";

foreach ($columns as $col => $def) {
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN `$col` $def");
        echo "  + Added column: $col\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "  - Column $col already exists, skip\n";
        } else {
            throw $e;
        }
    }
}

$pdo->exec("
    CREATE TABLE IF NOT EXISTS user_achievements (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        type VARCHAR(50) NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT DEFAULT NULL,
        organizer VARCHAR(255) DEFAULT NULL,
        year VARCHAR(10) DEFAULT NULL,
        rank VARCHAR(100) DEFAULT NULL,
        level VARCHAR(50) DEFAULT NULL,
        certificate_link VARCHAR(500) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");
echo "  + Table user_achievements OK\n";

echo "Migration selesai.\n";
