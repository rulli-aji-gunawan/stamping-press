<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportProductionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Read the SQL file
        $sqlFile = base_path('backup_production_data.sql');
        
        if (!File::exists($sqlFile)) {
            $this->command->error("SQL file not found: {$sqlFile}");
            return;
        }
        
        $sql = File::get($sqlFile);
        
        // Remove DROP TABLE statements to avoid conflicts
        $sql = preg_replace('/DROP TABLE IF EXISTS.*?;/i', '', $sql);
        
        // Remove CREATE TABLE statements to avoid conflicts  
        $sql = preg_replace('/CREATE TABLE.*?;/s', '', $sql);
        
        // Remove all LOCK/UNLOCK statements
        $sql = preg_replace('/LOCK TABLES.*?;/i', '', $sql);
        $sql = preg_replace('/UNLOCK TABLES;/i', '', $sql);
        
        // Remove ALTER TABLE statements
        $sql = preg_replace('/ALTER TABLE.*?;/i', '', $sql);
        
        // Remove SET statements at the beginning
        $sql = preg_replace('/SET.*?;/i', '', $sql);
        
        // Remove comments
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        $sql = preg_replace('/--.*$/m', '', $sql);
        
        // Split into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($statements as $statement) {
            if (!empty($statement) && stripos($statement, 'INSERT INTO') !== false) {
                try {
                    DB::unprepared($statement . ';');
                    $this->command->info("Executed: " . substr($statement, 0, 50) . "...");
                } catch (\Exception $e) {
                    $this->command->warn("Skipped statement due to error: " . $e->getMessage());
                    $this->command->warn("Statement: " . substr($statement, 0, 100) . "...");
                }
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Data import completed!');
    }
}
