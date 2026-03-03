<?php
/**
 * Database configuration - PDO single connection
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'challora_recruitment');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    return Database::get();
}
