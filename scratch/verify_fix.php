<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/Application.php';

$appModel = new Application();

try {
    $regions = $appModel->getTopRegions(5);
    echo "Top Regions Query successful!\n";
    print_r($regions);
} catch (Exception $e) {
    echo "Query failed: " . $e->getMessage() . "\n";
}
