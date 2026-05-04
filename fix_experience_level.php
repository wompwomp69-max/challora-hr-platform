<?php
// Fix corrupt experience_level values (underscore -> dash)
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$fixed = 0;
$map = ['0_1' => '0-1', '1_3' => '1-3', '3_5' => '3-5', '5_plus' => '5+'];

foreach ($map as $bad => $good) {
    $count = \Illuminate\Support\Facades\DB::table('job_postings')
        ->where('experience_level', $bad)
        ->update(['experience_level' => $good]);
    if ($count > 0) {
        echo "Fixed {$count} row(s): '{$bad}' => '{$good}'\n";
        $fixed += $count;
    }
}

if ($fixed === 0) {
    echo "No corrupt rows found.\n";
} else {
    echo "Total fixed: {$fixed} row(s).\n";
}
