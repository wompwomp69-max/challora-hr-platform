<?php
/**
 * Replace all job listings with rows from database/Fake Postings.csv
 *
 * Uses config/database.php (XAMPP MySQL). Ensures an HR user exists for created_by.
 *
 * Run: php database/import_fake_postings.php
 * Optional: php database/import_fake_postings.php --csv=C:\path\to\file.csv
 */
declare(strict_types=1);

$baseDir = dirname(__DIR__);
require $baseDir . '/config/database.php';

$csvPath = __DIR__ . DIRECTORY_SEPARATOR . 'Fake Postings.csv';
foreach ($argv ?? [] as $arg) {
    if (is_string($arg) && str_starts_with($arg, '--csv=')) {
        $csvPath = substr($arg, 6);
        break;
    }
}
if (!is_readable($csvPath)) {
    fwrite(STDERR, "CSV not found or not readable: {$csvPath}\n");
    exit(1);
}

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
$pdo = new PDO($dsn, DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

function mapEmploymentType(string $raw): string
{
    $t = strtolower(trim($raw));
    if (str_contains($t, 'voluntary') || str_contains($t, 'volunteer')) {
        return 'voluntary';
    }
    if (str_contains($t, 'freelance')) {
        return 'freelance';
    }
    if (str_contains($t, 'kontrak')) {
        return 'contract';
    }
    if (str_contains($t, 'full')) {
        return 'full_time';
    }
    if (str_contains($t, 'part')) {
        return 'part_time';
    }
    if (str_contains($t, 'intern')) {
        return 'internship';
    }
    if (str_contains($t, 'contract')) {
        return 'contract';
    }
    if (str_contains($t, 'temp') || str_contains($t, 'temporary')) {
        return 'contract';
    }
    return 'full_time';
}

function parseSalaryNumbers(string $salaryRange): array
{
    $clean = str_replace([',', ' '], '', $salaryRange);
    $min = $max = null;
    if (preg_match('/\$?(\d+)\s*-\s*\$?(\d+)/', $clean, $m)) {
        $min = (int) $m[1];
        $max = (int) $m[2];
    }
    return [$min, $max];
}

function truncate(string $s, int $max): string
{
    if (function_exists('mb_substr')) {
        return mb_strlen($s) <= $max ? $s : mb_substr($s, 0, $max);
    }
    return strlen($s) <= $max ? $s : substr($s, 0, $max);
}

// Ensure HR user for created_by
$hrId = (int) $pdo->query("SELECT id FROM users WHERE role = 'hr' ORDER BY id ASC LIMIT 1")->fetchColumn();
if ($hrId < 1) {
    $hash = '$2y$10$4oRFX8dxR0zUx9eC2QvQeu2ZrOkb.a7pR2tVAwREUab2Fda8kk8cC'; // password123
    $pdo->prepare(
        'INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)'
    )->execute([
        'hr_csv_import_1_dummy',
        'hr_csv_import_1_dummy@mail.com',
        $hash,
        'hr',
    ]);
    $hrId = (int) $pdo->lastInsertId();
    fwrite(STDOUT, "Created HR user id={$hrId} (hr_csv_import_1_dummy@mail.com, password123)\n");
} else {
    fwrite(STDOUT, "Using HR user id={$hrId}\n");
}

$pdo->exec('SET FOREIGN_KEY_CHECKS=0');
$pdo->exec('DELETE FROM job_skills');
$pdo->exec('DELETE FROM job_benefits');
$pdo->exec('DELETE FROM saved_jobs');
$pdo->exec('DELETE FROM applications');
$pdo->exec('DELETE FROM jobs');
$pdo->exec('SET FOREIGN_KEY_CHECKS=1');

$sql = 'INSERT INTO jobs (
    title, short_description, description, location, salary_range, min_salary, max_salary,
    job_type, min_education, is_urgent, provinsi, kota, kecamatan,
    deadline, max_applicants, skills_json, benefits_json, created_by, is_dummy
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)';

$insert = $pdo->prepare($sql);

$fh = fopen($csvPath, 'rb');
if ($fh === false) {
    fwrite(STDERR, "Cannot open CSV\n");
    exit(1);
}

$header = fgetcsv($fh);
if ($header === false) {
    fwrite(STDERR, "Empty CSV\n");
    exit(1);
}
$header = array_map(static fn ($h) => strtolower(trim((string) $h)), $header);
$idx = array_flip($header);

$required = ['title', 'description', 'requirements', 'company_profile', 'location', 'salary_range', 'employment_type', 'industry', 'benefits', 'fraudulent'];
foreach ($required as $col) {
    if (!isset($idx[$col])) {
        fwrite(STDERR, "Missing CSV column: {$col}\n");
        exit(1);
    }
}

$pdo->beginTransaction();
$imported = 0;
try {
    while (($row = fgetcsv($fh)) !== false) {
        if (count($row) < count($header)) {
            continue;
        }

        $title = trim((string) $row[$idx['title']]);
        if ($title === '') {
            continue;
        }

        $description = trim((string) $row[$idx['description']]);
        $requirements = trim((string) $row[$idx['requirements']]);
        $company = trim((string) $row[$idx['company_profile']]);
        $location = trim((string) $row[$idx['location']]);
        $salaryRangeRaw = trim((string) $row[$idx['salary_range']]);
        $employmentType = mapEmploymentType((string) $row[$idx['employment_type']]);
        $industry = trim((string) $row[$idx['industry']]);
        $benefits = trim((string) $row[$idx['benefits']]);
        $fraudulent = trim((string) $row[$idx['fraudulent']]);

        $fullDescription = $description;
        if ($requirements !== '') {
            $fullDescription .= "\n\nRequirements:\n" . $requirements;
        }
        if ($company !== '') {
            $fullDescription .= "\n\nCompany profile:\n" . $company;
        }
        if ($industry !== '') {
            $fullDescription .= "\n\nIndustry: " . $industry;
        }
        $fullDescription .= "\n\n[Datasource: Fake Postings.csv; fraudulent=" . $fraudulent . ']';

        $shortBase = $company !== '' ? $company : (preg_replace('/\s+/u', ' ', $description) ?: $title);
        $short = truncate(trim($shortBase), 255);

        $isDummy = ((int) $fraudulent) === 1 ? 1 : 0;

        [$minSal, $maxSal] = parseSalaryNumbers($salaryRangeRaw);
        $salaryRangeStored = truncate($salaryRangeRaw, 50);

        $skillsJson = $industry !== '' ? json_encode([$industry], JSON_UNESCAPED_UNICODE) : null;
        $benefitsJson = $benefits !== '' ? json_encode([$benefits], JSON_UNESCAPED_UNICODE) : null;

        $insert->execute([
            truncate($title, 200),
            $short === '' ? null : $short,
            $fullDescription,
            $location === '' ? null : truncate($location, 100),
            $salaryRangeStored === '' ? null : $salaryRangeStored,
            $minSal,
            $maxSal,
            $employmentType,
            null,
            0,
            null,
            null,
            null,
            null,
            null,
            $skillsJson,
            $benefitsJson,
            $hrId,
            $isDummy,
        ]);
        $imported++;
    }
    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, 'Import failed: ' . $e->getMessage() . "\n");
    exit(1);
} finally {
    fclose($fh);
}

fwrite(STDOUT, "Imported rows: {$imported}\n");

$total = (int) $pdo->query('SELECT COUNT(*) FROM jobs')->fetchColumn();
fwrite(STDOUT, "jobs COUNT(*): {$total}\n");

$sample = $pdo->query('SELECT id, title, job_type, location, salary_range, min_salary, max_salary, created_by, is_dummy FROM jobs ORDER BY id LIMIT 3')->fetchAll(PDO::FETCH_ASSOC);
fwrite(STDOUT, "Sample:\n" . json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n");
