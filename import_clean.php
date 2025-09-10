<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting import from clean INSERT file...\n";
    
    // Read the clean INSERT file
    $sqlFile = __DIR__ . '/insert_statements_only.sql';
    
    if (!file_exists($sqlFile)) {
        echo "Clean INSERT file not found!\n";
        exit(1);
    }
    
    $lines = file($sqlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    echo "Found " . count($lines) . " INSERT statements\n";
    
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    $executed = 0;
    $errors = 0;
    
    foreach ($lines as $lineNumber => $statement) {
        $statement = trim($statement);
        
        if (!empty($statement) && stripos($statement, 'INSERT INTO') === 0) {
            try {
                // Execute the INSERT statement
                DB::statement($statement);
                $executed++;
                
                // Extract table name for feedback
                preg_match('/INSERT INTO `([^`]+)`/', $statement, $matches);
                $tableName = isset($matches[1]) ? $matches[1] : 'unknown';
                
                echo "✓ Executed INSERT #{$executed} for table: {$tableName}\n";
                
            } catch (Exception $e) {
                $errors++;
                echo "✗ Error at line " . ($lineNumber + 1) . ": " . $e->getMessage() . "\n";
                echo "Statement: " . substr($statement, 0, 100) . "...\n";
            }
        }
    }
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "\n=== IMPORT SUMMARY ===\n";
    echo "Total statements executed: {$executed}\n";
    echo "Errors encountered: {$errors}\n";
    
    // Check counts
    echo "\n=== DATA VERIFICATION ===\n";
    $tables = [
        'downtime_categories',
        'downtime_classifications', 
        'model_items',
        'process_names',
        'table_productions',
        'table_downtimes',
        'table_defects',
        'sessions',
        'migrations'
    ];
    
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "✓ {$table}: {$count} records\n";
        } catch (Exception $e) {
            echo "✗ {$table}: Error - " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Fatal error: " . $e->getMessage() . "\n";
}
