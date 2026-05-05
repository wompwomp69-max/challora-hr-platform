<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'hr@challora.com';
$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User $email tidak ditemukan.\n";
    exit;
}

echo "Email: " . $user->email . "\n";
echo "Hash: " . $user->password . "\n";
$info = password_get_info($user->password);
echo "Algo: " . $info['algoName'] . "\n";

if ($info['algoName'] !== 'bcrypt') {
    echo "FIXING: Re-hashing password...\n";
    $user->password = Hash::make('password');
    $user->save();
    echo "NEW HASH: " . $user->password . "\n";
    echo "NEW Algo: " . password_get_info($user->password)['algoName'] . "\n";
}
