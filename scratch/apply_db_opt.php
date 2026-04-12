<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

$commands = [
    'ALTER TABLE applications ADD INDEX idx_status (status)',
    'ALTER TABLE jobs ADD INDEX idx_deadline (deadline)',
    'ALTER TABLE jobs ADD INDEX idx_job_type (job_type)',
    'ALTER TABLE jobs ADD INDEX idx_is_urgent (is_urgent)'
];

foreach ($commands as $sql) {
    try {
        echo "Executing: $sql\n";
        $db->exec($sql);
        echo "Success.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
            echo "Index already exists. Skipping.\n";
        } else {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
echo "Database optimization completed.\n";
