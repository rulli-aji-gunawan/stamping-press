<?php
// Script untuk setup database MySQL

$host = '127.0.0.1';
$port = 3306;
$username = 'root';
$password = '';
$database_name = 'stamping_press';
$sql_file = 'backup_production_data.sql';

echo "Setting up database...\n";

try {
    // Connect to MySQL server (without selecting database)
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL server successfully!\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$database_name' created successfully!\n";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database '$database_name'!\n";
    
    // Read and execute SQL file
    if (file_exists($sql_file)) {
        echo "Reading SQL file: $sql_file\n";
        $sql_content = file_get_contents($sql_file);
        
        // Split SQL into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql_content)));
        
        $count = 0;
        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^(--|\/\*)/', $statement)) {
                try {
                    $pdo->exec($statement);
                    $count++;
                } catch (PDOException $e) {
                    // Skip problematic statements (like SET commands)
                    if (strpos($e->getMessage(), 'syntax error') === false) {
                        echo "Warning: " . $e->getMessage() . "\n";
                    }
                }
            }
        }
        
        echo "Executed $count SQL statements successfully!\n";
        echo "Database setup completed!\n";
        
    } else {
        echo "Error: SQL file '$sql_file' not found!\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nPossible solutions:\n";
    echo "1. Make sure Laragon MySQL service is running\n";
    echo "2. Check if MySQL credentials are correct\n";
    echo "3. Try starting Laragon services manually\n";
}
?>
