<?php

namespace App\Http\Controllers;

use App\Models\TableDefect;
use App\Models\TableDowntime;
use App\Models\TableProduction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data Non Productive Time dari table Downtime
        $nonProductiveTimeData = TableDowntime::where(function ($query) {
            $query->where('downtime_type', 'Non Productive Time')
                ->orWhere('dt_category', 'trial');
        })
            ->select(
                'fy_n',
                'model',
                'item_name',
                'date',
                'shift',
                'line',
                'group',
                DB::raw('SUM(total_time) as total_non_productive_downtime')
            )
            ->groupBy('fy_n', 'date', 'shift', 'model', 'item_name', 'line', 'group')
            ->get()
            ->keyBy(function ($item) {
                return "{$item->fy_n}_{$item->date}_{$item->shift}_{$item->model}_{$item->item_name}_{$item->line}_{$item->group}";
            });

        // Ambil data Non Productive Time dari table Downtime
        $downTimeData = TableDowntime::where(function ($query) {
            $query->where('downtime_type', 'Downtime');
        })
            ->select(
                'fy_n',
                'model',
                'item_name',
                'date',
                'shift',
                'line',
                'group',
                DB::raw('SUM(total_time) as total_downtime')
            )
            ->groupBy('fy_n', 'date', 'shift', 'model', 'item_name', 'line', 'group')
            ->get()
            ->keyBy(function ($item) {
                return "{$item->fy_n}_{$item->date}_{$item->shift}_{$item->model}_{$item->item_name}_{$item->line}_{$item->group}";
            });

        $defectData = TableDefect::select(
            'fy_n',
            'model',
            'item_name',
            'date',
            'shift',
            'line',
            'group',
            'defect_category',
            'defect_name',
            DB::raw('SUM(COALESCE(defect_qty_a, 0) + COALESCE(defect_qty_b, 0)) as total_defect')
        )
            ->when(request('fy'), function ($query, $fy) {
                return $query->where('fy_n', 'like', $fy . '%');
            })
            ->when(request('model'), function ($query, $model) {
                return $query->where('model', $model);
            })
            ->when(request('item'), function ($query, $item) {
                return $query->where('item_name', $item);
            })
            ->whereNotNull('defect_category')
            ->groupBy('fy_n', 'model', 'item_name', 'date', 'shift', 'line', 'group', 'defect_category', 'defect_name')
            ->orderBy(DB::raw('SUM(COALESCE(defect_qty_a, 0) + COALESCE(defect_qty_b, 0))'), 'desc')
            ->get();

        // Logging untuk debug defect data
        if (count($defectData) > 0) {
            Log::info("Sample defect data: " . json_encode($defectData[0]));
            Log::info("Total defect records: " . count($defectData));

            // Periksa nilai defect_category dan total_defect
            foreach ($defectData as $defect) {
                if (empty($defect->defect_category)) {
                    Log::warning("Found defect with empty category: " . json_encode($defect));
                }
                if (!is_numeric($defect->total_defect) || $defect->total_defect <= 0) {
                    Log::warning("Found defect with invalid quantity: " . json_encode($defect));
                }
            }
        } else {
            Log::warning("No defect data found");
        }

        // Ambil data dengan semua field yang diperlukan untuk filter
        $chartData = TableProduction::select(
            'fy_n',
            'model',
            'item_name',
            'date',
            'shift',
            'line',
            'group'
        )
            ->selectRaw('
                SUM(ok_a) as total_ok_a,
                SUM(rework_a) as total_rework_a,
                SUM(scrap_a) as total_ng_a,
                SUM(ok_b) as total_ok_b,
                SUM(rework_b) as total_rework_b,
                SUM(scrap_b) as total_ng_b,
                SUM(total_prod_time) as total_minutes
            ')
            ->groupBy('fy_n', 'date', 'shift', 'model', 'item_name', 'line', 'group')
            ->orderBy('fy_n')
            ->get()
            ->map(function ($row) use ($nonProductiveTimeData, $downTimeData) {
                $total_minutes = floatval($row->total_minutes); // Konversi menit ke jam
                $total_hours = $total_minutes / 60; // Konversi menit ke jam
                $total_stroke = $row->total_ok_a + $row->total_rework_a + $row->total_ng_a;
                $sph = $total_hours > 0 ? round($total_stroke / $total_hours, 2) : 0;

                $total_ok = $row->total_ok_a + $row->total_ok_b;
                $total_rework = $row->total_rework_a + $row->total_rework_b;
                $total_ng = $row->total_ng_a + $row->total_ng_b;
                $total_qty = $total_ok + $total_rework + $total_ng;

                // Extract year and month dari fy_n
                list($year, $month) = explode('-', $row->fy_n);
                $yearShort = substr($year, -2); // Ambil 2 digit terakhir dari tahun

                // Konversi bulan fiskal ke nama bulan
                $monthNames = ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"];
                $monthIndex = ((int)$month - 1) % 12;
                $monthName = $monthNames[$monthIndex];

                // Get downtime for this production record
                $key = "{$row->fy_n}_{$row->date}_{$row->shift}_{$row->model}_{$row->item_name}_{$row->line}_{$row->group}";
                $nonProductiveTime = isset($nonProductiveTimeData[$key]) ? $nonProductiveTimeData[$key]->total_non_productive_downtime : 0;
                $downtime = isset($downTimeData[$key]) ? $downTimeData[$key]->total_downtime : 0;

                // Calculate effective production time (total_prod_time - non-productive downtime)
                $effective_minutes = max(0, $row->total_minutes - $nonProductiveTime);
                $effective_hours = $effective_minutes / 60;

                // Calculate effective SPH based on effective hours
                $effective_sph = $effective_hours > 0 ? round($total_stroke / $effective_hours, 2) : 0;

                // Menghitung waktu press time murni (total_hours - downtime)
                $press_time = max(0, $total_minutes - $downtime - $nonProductiveTime);

                // Calculate effective OR based on effective hours
                $effective_or = $effective_minutes > 0 ? ($press_time / $effective_minutes) : 2;

                // Menghitung FTC
                $ftc = $total_qty > 0 ? ($total_ok / $total_qty) : 2;

                // Menghitung Rework Ratio
                $rework_ratio = $total_qty > 0 ? ($total_rework / $total_qty) : 2;

                // Menghitung NG Ratio
                $scrap_ratio = $total_qty > 0 ? ($total_ng / $total_qty) : 2;

                return [
                    'fy_n' => $row->fy_n,
                    'year' => $year,
                    'year_short' => $yearShort,
                    'month' => $month,
                    'month_name' => $monthName,
                    'date' => $row->date,
                    'shift' => $row->shift,
                    'model' => $row->model,
                    'item_name' => $row->item_name,
                    'line' => $row->line,
                    'group' => $row->group,
                    'sph' => $sph,
                    'total_stroke' => $total_stroke,
                    'total_hours' => $total_hours,
                    'non_productive_downtime' => $nonProductiveTime,
                    'downtime' => $downtime,
                    'press_time' => $press_time,
                    'effective_minutes' => $effective_minutes,
                    'effective_hours' => $effective_hours,
                    'effective_sph' => $effective_sph,
                    'effective_or' => $effective_or,
                    'total_ok' => $total_ok,
                    'total_rework' => $total_rework,
                    'total_ng' => $total_ng,
                    'total_qty' => $total_qty,
                    'ftc' => $ftc,
                    'rework_ratio' => $rework_ratio,
                    'scrap_ratio' => $scrap_ratio,
                ];
            });

        // Logging untuk debug
        if (count($chartData) > 0) {
            Log::info("Sample chart data: " . json_encode($chartData[0]));
            Log::info("Total chart records: " . count($chartData));
        } else {
            Log::warning("No chart data found");
        }

        // Determine current fiscal year
        $now = now();
        $fyYear = $now->month < 4 ? $now->year - 1 : $now->year;
        $currentFY = 'FY' . substr($fyYear, -2);

        return view('users.dashboard', compact('chartData', 'defectData', 'currentFY'));
    }
}
