<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting direct SQL import...\n";
    
    // Read the SQL file as one string
    $sqlFile = __DIR__ . '/backup_production_data.sql';
    $sql = file_get_contents($sqlFile);
    
    echo "SQL file size: " . strlen($sql) . " characters\n";
    
    // Try a more flexible regex to match INSERT statements
    preg_match_all('/INSERT INTO[^;]*;/s', $sql, $matches);
    $insertStatements = $matches[0];
    
    echo "Found " . count($insertStatements) . " INSERT statements with flexible regex\n";
    
    if (count($insertStatements) > 0) {
        echo "Sample INSERT: " . substr($insertStatements[0], 0, 200) . "...\n";
    }
    
    // If that fails, try splitting by lines and manually find INSERT
    if (count($insertStatements) == 0) {
        echo "Fallback: Looking for INSERT lines manually...\n";
        $lines = explode("\n", $sql);
        foreach ($lines as $line) {
            $line = trim($line);
            if (stripos($line, 'INSERT INTO') === 0) {
                $insertStatements[] = $line;
            }
        }
        echo "Found " . count($insertStatements) . " INSERT statements manually\n";
    }
    
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    $executed = 0;
    
    foreach ($insertStatements as $statement) {
        try {
            // Clean the statement
            $statement = trim($statement);
            
            // Execute the INSERT statement
            DB::statement($statement);
            $executed++;
            
            // Extract table name for feedback
            preg_match('/INSERT INTO `?([^`\s]+)`?/', $statement, $matches);
            $tableName = isset($matches[1]) ? $matches[1] : 'unknown';
            
            echo "Executed INSERT #{$executed} for table: {$tableName}\n";
            
        } catch (Exception $e) {
            echo "Error in statement: " . $e->getMessage() . "\n";
            echo "Statement: " . substr($statement, 0, 100) . "...\n";
        }
    }
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "\nImport completed! Executed {$executed} INSERT statements.\n";
    
    // Check counts
    echo "\nChecking data counts:\n";
    echo "Downtime Categories: " . DB::table('downtime_categories')->count() . "\n";
    echo "Downtime Classifications: " . DB::table('downtime_classifications')->count() . "\n";
    echo "Model Items: " . DB::table('model_items')->count() . "\n";
    echo "Process Names: " . DB::table('process_names')->count() . "\n";
    echo "Table Productions: " . DB::table('table_productions')->count() . "\n";
    echo "Table Downtimes: " . DB::table('table_downtimes')->count() . "\n";
    echo "Table Defects: " . DB::table('table_defects')->count() . "\n";
    echo "Users: " . DB::table('users')->count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
