<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

// Target HR Admin (ID 3)
$targetHrId = 3;

// Update all jobs belonging to user 5 (a 'user') to user 3 ('hr')
// Also update jobs with no 'created_by' if any
$stmt = $db->prepare('UPDATE jobs SET created_by = ? WHERE created_by = 5 OR created_by IS NULL');
$stmt->execute([$targetHrId]);
$affectedJobs = $stmt->rowCount();

echo "Reassigned $affectedJobs jobs to HR Admin (ID: $targetHrId).\n";

// Update applications too, if they were tied to jobs via creative logic, 
// though applications are usually tied to job_id which is fine.
// But let's check roles to be sure.
$stmt = $db->query("UPDATE users SET role = 'hr' WHERE id = 5"); // Optional: set user 5 to hr if they were supposed to be one
$affectedUsers = $stmt->rowCount();
echo "Updated roles for $affectedUsers users.\n";
