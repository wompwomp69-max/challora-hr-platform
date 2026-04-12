<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

$queries = [
    "EXPLAIN SELECT status, COUNT(*) FROM applications GROUP BY status",
    "EXPLAIN SELECT * FROM jobs WHERE deadline >= CURDATE() AND job_type = 'Full-time'",
    "EXPLAIN SELECT * FROM jobs WHERE is_urgent = 1",
    "EXPLAIN SELECT status FROM applications WHERE status = 'accepted'"
];

foreach ($queries as $sql) {
    echo "Query: $sql\n";
    $stmt = $db->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        print_r($row);
    }
    echo str_repeat("-", 40) . "\n";
}
