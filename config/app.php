<?php
/**
 * App config: base path, session, defaults
 */
session_start();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// Base URL untuk link (sesuaikan jika deploy di subfolder)
define('BASE_URL', '/challorav2/public');
define('STORAGE_CV', BASE_PATH . '/storage/cv');

// Autoload app classes (Controllers, Models)
spl_autoload_register(function ($class) {
    $paths = [APP_PATH . '/controllers/', APP_PATH . '/models/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

require BASE_PATH . '/config/database.php';
require APP_PATH . '/helpers.php';
