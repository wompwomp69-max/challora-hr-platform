<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

$tables = ['applications', 'saved_jobs', 'user_achievements', 'user_work_experiences', 'password_resets', 'jobs'];

foreach ($tables as $table) {
    echo "========================================\n";
    echo "CREATE TABLE: $table\n";
    echo "========================================\n";
    $create = $db->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
    echo $create['Create Table'] . "\n\n";
}
