<?php

// Simple test to read the SQL file and check encoding
$sqlFile = __DIR__ . '/backup_production_data.sql';

echo "File exists: " . (file_exists($sqlFile) ? 'YES' : 'NO') . "\n";
echo "File size: " . filesize($sqlFile) . " bytes\n";

// Read first 20 lines to see what we're dealing with
$lines = file($sqlFile, FILE_IGNORE_NEW_LINES);
echo "Total lines: " . count($lines) . "\n\n";

echo "First 20 lines:\n";
for ($i = 0; $i < min(20, count($lines)); $i++) {
    $line = $lines[$i];
    echo sprintf("%03d: %s\n", $i + 1, substr($line, 0, 80));
}

// Look for lines containing INSERT
echo "\nLines containing 'INSERT':\n";
for ($i = 0; $i < count($lines); $i++) {
    if (stripos($lines[$i], 'INSERT') !== false) {
        echo sprintf("Line %d: %s\n", $i + 1, substr($lines[$i], 0, 100));
    }
}
