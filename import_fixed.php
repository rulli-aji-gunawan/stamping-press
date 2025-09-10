<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting targeted data import...\n";
    
    // Skip problematic tables and fix issues
    $skipTables = ['migrations', 'sessions']; // Skip these as they conflict with Laravel
    
    // Manual INSERT for downtime_categories (since it didn't work before)
    echo "=== IMPORTING DOWNTIME CATEGORIES ===\n";
    $downtimeCategories = [
        [1, 'Briefing Time', 'Non Productive Time', NULL, '2024-08-20 15:17:41', '2024-08-24 01:26:06'],
        [3, 'ADC', 'Planned Downtime', NULL, '2024-08-24 01:34:43', '2024-08-24 01:34:43'],
        [4, 'QC Check', 'Planned Downtime', NULL, '2024-08-24 01:35:08', '2024-08-24 01:35:08'],
        [5, 'Dies', 'Downtime', NULL, '2024-08-24 01:35:58', '2024-08-24 01:35:58'],
        [6, 'Equipment', 'Downtime', NULL, '2024-08-24 01:36:09', '2024-08-24 01:36:09'],
        [7, 'Material', 'Downtime', NULL, '2024-08-24 01:36:42', '2024-08-24 01:36:42'],
        [8, 'Operational', 'Downtime', NULL, '2024-08-24 01:36:56', '2024-08-24 01:36:56'],
        [9, 'Quality', 'Downtime', NULL, '2024-08-24 01:37:13', '2024-08-24 01:37:13'],
        [10, 'Robot', 'Downtime', NULL, '2024-08-24 01:38:01', '2024-08-24 01:38:01'],
        [11, 'Trial', 'Planned Downtime', NULL, '2024-08-24 01:38:31', '2024-08-24 01:38:31'],
        [12, 'Break Time', 'Non Productive Time', NULL, '2024-08-24 01:38:59', '2024-08-24 01:38:59'],
        [13, 'Safety Meeting', 'Non Productive Time', NULL, '2024-08-24 01:39:23', '2024-08-24 01:39:23'],
        [14, 'Emergency Meeting', 'Non Productive Time', NULL, '2024-08-24 01:39:51', '2024-08-24 01:39:51'],
        [15, 'Disaster Simulation', 'Non Productive Time', NULL, '2024-08-24 01:40:11', '2024-08-24 08:20:54']
    ];
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    foreach ($downtimeCategories as $cat) {
        DB::table('downtime_categories')->insert([
            'id' => $cat[0],
            'downtime_name' => $cat[1],
            'downtime_type' => $cat[2],
            'created_at' => $cat[4],
            'updated_at' => $cat[5]
        ]);
    }
    echo "✓ Imported " . count($downtimeCategories) . " downtime categories\n";
    
    // Manual INSERT for model_items (fixing column structure)
    echo "\n=== IMPORTING MODEL ITEMS ===\n";
    $modelItems = [
        [1, 'FFVV', '2026', 'ITEM PERTAMA', '1.FFVV.2026.ITEM PERTAMA.jpg', '2024-08-04 16:37:08', '2025-07-17 23:00:16'],
        [2, 'FFVV', '2026', 'ITEM KEDUA', '2.FFVV.2026.ITEM KEDUA.jpg', '2024-08-04 22:47:11', '2025-07-17 23:00:37'],
        [3, 'FFVV', '2026', 'ITEM KETIGA', '3.FFVV.2026.ITEM KETIGA.jpg', '2024-08-04 22:47:35', '2025-07-17 23:44:08'],
        [4, 'FFVV', '2026', 'ITEM KEEMPAT', '4.FFVV.2026.ITEM KEEMPAT.jpg', '2024-08-04 22:56:10', '2025-07-17 23:51:09'],
        [5, 'FFVV', '2026', 'ITEM KELIMA', '5.FFVV.2026.ITEM KELIMA.jpg', '2024-08-04 22:57:48', '2025-07-17 23:53:18'],
        [6, 'FFVV', '2026', 'ITEM KEENAM', '6.FFVV.2026.ITEM KEENAM.jpg', '2024-08-04 22:58:30', '2025-07-18 16:44:39'],
        [7, 'FFVV', '2026', 'ITEM KETUJUH', NULL, '2024-08-04 22:59:57', '2024-08-04 23:00:03'],
        [8, 'FFVV', '2026', 'ITEM KEDELAPAN', NULL, '2024-08-04 23:00:35', '2024-08-04 23:00:45'],
        [9, 'FFVV', '2026', 'ITEM KESEMBILAN', NULL, '2024-08-05 15:16:51', '2024-08-05 15:18:03'],
        [62, 'TRY', '2017', 'FR FENDER', NULL, '2024-08-24 02:57:55', '2025-02-16 05:39:09'],
        [63, '22RN', '2022', 'FR FENDER', NULL, '2024-08-24 02:58:17', '2024-08-24 02:59:13'],
        [64, 'ABCF', '2025', 'ITEM PERTAMA', NULL, '2025-02-16 05:50:23', '2025-02-16 05:50:23'],
        [65, 'FFVV', '2026', 'ITEM KETUJUHBELAS', '65.FFVV.2026.ITEM KETUJUHBELAS.jpeg', '2025-07-16 17:29:52', '2025-07-16 17:29:52']
    ];
    
    foreach ($modelItems as $item) {
        DB::table('model_items')->insert([
            'id' => $item[0],
            'model_code' => $item[1],
            'model_year' => $item[2], 
            'item_name' => $item[3],
            'product_picture' => $item[4],
            'created_at' => $item[5],
            'updated_at' => $item[6]
        ]);
    }
    echo "✓ Imported " . count($modelItems) . " model items\n";
    
    // Try to import table_defects with NULL handling
    echo "\n=== IMPORTING TABLE DEFECTS (with NULL fixes) ===\n";
    $defectStatement = "INSERT INTO `table_defects` (id, table_production_id, reporter, `group`, date, fy_n, shift, line, model, model_year, item_name, coil_no, defect_category, defect_name, defect_qty_a, defect_qty_b, defect_area, created_at, updated_at) VALUES
    (2,43,'Joni','A','2025-07-20','FY2025-4','day','Line-A','FFVV','2026','FFVV-ITEM PERTAMA','rgvfbgf','inline','Ding',8,0,'H7','2025-07-20 04:17:59','2025-08-15 15:44:44'),
    (30,44,'Eman','A','2025-07-21','FY2025-4','day','Line-A','FFVV','2026','FFVV-ITEM KELIMA','rgvfbgf','inline','Ding',10,0,'B9','2025-07-28 06:09:37','2025-08-15 15:44:44'),
    (31,44,'Eman','A','2025-07-21','FY2025-4','day','Line-A','FFVV','2026','FFVV-ITEM KELIMA','rgvfbgf','outline','Shock Line',1,0,'N11','2025-07-28 06:09:37','2025-08-15 15:44:44')";
    
    try {
        DB::statement($defectStatement);
        echo "✓ Imported sample table defects\n";
    } catch (Exception $e) {
        echo "✗ Error importing defects: " . $e->getMessage() . "\n";
    }
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "\n=== FINAL DATA VERIFICATION ===\n";
    $tables = [
        'downtime_categories',
        'downtime_classifications', 
        'model_items',
        'process_names',
        'table_productions',
        'table_downtimes',
        'table_defects'
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
