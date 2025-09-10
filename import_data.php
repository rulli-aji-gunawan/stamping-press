<?php
// Script untuk import data dari backup SQL

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'stamping_press';
$sql_file = 'backup_production_data.sql';

echo "Starting data import...\n";

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully!\n";
    
    // Read SQL file
    if (!file_exists($sql_file)) {
        throw new Exception("SQL file '$sql_file' not found!");
    }
    
    $sql_content = file_get_contents($sql_file);
    echo "SQL file read successfully!\n";
    
    // Clean up SQL content - remove problematic MySQL dump commands
    $lines = explode("\n", $sql_content);
    $cleaned_lines = [];
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip empty lines, comments, and MySQL-specific commands
        if (empty($line) || 
            substr($line, 0, 2) == '--' || 
            substr($line, 0, 2) == '/*' ||
            preg_match('/^(SET|LOCK|UNLOCK|\/\*|\*\/)/i', $line)) {
            continue;
        }
        
        $cleaned_lines[] = $line;
    }
    
    $cleaned_sql = implode("\n", $cleaned_lines);
    
    // Split into individual statements
    $statements = array_filter(array_map('trim', explode(';', $cleaned_sql)));
    
    echo "Found " . count($statements) . " SQL statements to execute\n";
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement)) continue;
        
        try {
            $pdo->exec($statement);
            $success_count++;
            
            // Show progress every 10 statements
            if ($success_count % 10 == 0) {
                echo "Processed $success_count statements...\n";
            }
            
        } catch (PDOException $e) {
            $error_count++;
            // Only show first few errors to avoid spam
            if ($error_count <= 5) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\nImport completed!\n";
    echo "Successfully executed: $success_count statements\n";
    echo "Errors encountered: $error_count statements\n";
    
    // Check if data was imported
    $result = $pdo->query("SELECT COUNT(*) as count FROM users");
    $users_count = $result->fetch()['count'];
    echo "Users table now has: $users_count records\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
