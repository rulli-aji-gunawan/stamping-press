<?php
<?php
echo "<h1>Database Connection Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<pre>";
echo "Checking environment variables:\n";
echo "MYSQLHOST: " . (getenv('MYSQLHOST') ?: 'Not set') . "\n";
echo "MYSQLUSER: " . (getenv('MYSQLUSER') ?: 'Not set') . "\n";
echo "MYSQLPORT: " . (getenv('MYSQLPORT') ?: 'Not set') . "\n";
echo "MYSQLDATABASE: " . (getenv('MYSQLDATABASE') ?: 'Not set') . "\n";
echo "MYSQLPASSWORD: " . (substr(getenv('MYSQLPASSWORD') ?: 'Not set', 0, 3) . '****') . "\n";

try {
    $host = getenv('MYSQLHOST') ?: '127.0.0.1';
    $dbname = getenv('MYSQLDATABASE') ?: 'railway';
    $username = getenv('MYSQLUSER') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: '';
    $port = getenv('MYSQLPORT') ?: '3306';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    echo "\nTrying to connect with: $dsn, user=$username\n";
    
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
echo "</pre>";