<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../app/models/Job.php';

$jobModel = new Job();
$allJobs = $jobModel->all();

echo "Total jobs in database: " . count($allJobs) . "\n";
foreach ($allJobs as $job) {
    echo "ID: {$job['id']}, Title: {$job['title']}, Created By: {$job['created_by']}, Created At: {$job['created_at']}\n";
}
