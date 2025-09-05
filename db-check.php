<?php
try {
    $user = 'root';
    $password = 'HhftTRKangKgHOZsEeuNyUAFCaiDMTrf';
    $host = $_ENV['RAILWAY_PRIVATE_DOMAIN'] ?? 'localhost';
    $port = '3306';
    $database = 'railway';

    $dsn = "mysql:host=$host;port=$port;dbname=$database";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Database connection successful!";
    echo "<br>PHP Version: " . phpversion();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
