<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../app/models/Job.php';
require_once __DIR__ . '/../app/models/Application.php';

// Mock session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['user_id'] = 3;
$_SESSION['role'] = 'hr';

$jobModel = new Job();
$appModel = new Application();

$start = microtime(true);

echo "Running HR Dashboard Index Logic (Optimized)...\n";

$filter = 'all';
$page = 1;
$perPage = 20;

$totalJobs = $jobModel->countAllFiltered($filter);
$list = $jobModel->findAllPaginatedWithStats($page, $perPage, $filter);
$stats = $appModel->getCountsByHrJobs();

$end = microtime(true);

echo "Total Jobs: $totalJobs\n";
echo "Jobs Fetched: " . count($list) . "\n";
echo "Stats: Total={$stats['total']}, Accepted={$stats['accepted']}, Rejected={$stats['rejected']}, Pending={$stats['pending']}\n";
echo "Execution Time: " . round(($end - $start) * 1000, 2) . "ms\n";

if (count($list) > 0) {
    $first = $list[0];
    echo "\nSample Job Stats (ID: {$first['id']}):\n";
    echo "  Title: {$first['title']}\n";
    echo "  Applicant Count: {$first['applicant_count']}\n";
    echo "  Accepted: {$first['applicant_accepted']}\n";
    echo "  Rejected: {$first['applicant_rejected']}\n";
}
