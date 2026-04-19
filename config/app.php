<?php
/**
 * App config
 */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// 1. Load Env and initialization
require_once BASE_PATH . '/core/Env.php';
Env::load(BASE_PATH . '/.env');

define('BASE_URL', Env::get('APP_URL_PATH', '/challorav2/public'));
define('STORAGE_CV', BASE_PATH . '/storage/cv');
define('STORAGE_DIPLOMA', BASE_PATH . '/storage/diplomas');
define('STORAGE_PHOTO', BASE_PATH . '/storage/photos');

// 2. Secure Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', 1);
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// 3. Security Headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:;");

$autoloadPath = BASE_PATH . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
}

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/core/',
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

require BASE_PATH . '/config/database.php';
require BASE_PATH . '/core/helpers.php';
