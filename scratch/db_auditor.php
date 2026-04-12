<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::get();

try {
    $tables = ['applications'];
    foreach ($tables as $table) {
        echo "========================================\n";
        echo "TABLE: $table\n";
        echo "========================================\n";
        
        // Schema
        $desc = $db->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
        printf("%-20s | %-15s | %-5s | %-3s | %-10s | %s\n", "Field", "Type", "Null", "Key", "Default", "Extra");
        echo str_repeat("-", 80) . "\n";
        foreach ($desc as $row) {
            printf("%-20s | %-15s | %-5s | %-3s | %-10s | %s\n", 
                $row['Field'], $row['Type'], $row['Null'], $row['Key'], (string)$row['Default'], $row['Extra']);
        }
        
        // Indexes
        echo "\nINDEXES:\n";
        $indexes = $db->query("SHOW INDEX FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        printf("%-15s | %-15s | %-15s | %s\n", "Key_name", "Column_name", "Non_unique", "Index_type");
        foreach ($indexes as $idx) {
            printf("%-15s | %-15s | %-15s | %s\n", 
                $idx['Key_name'], $idx['Column_name'], $idx['Non_unique'], $idx['Index_type']);
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
