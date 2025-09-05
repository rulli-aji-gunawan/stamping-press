<?php

namespace App\Exports;

use App\Models\TableProduction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TableProductionExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query ?: TableProduction::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Date',
            'FY-N',
            'Shift',
            'Line',
            'Group',
            'Reporter',
            'Model Year',
            'Model',
            'Item Name',
            'Start Time',
            'Finish Time',
            'Total Time',
            'SPM',
            'Coil Number',
            'Plan-A',
            'Plan-B',
            'OK-A',
            'OK-B',
            'Rework-A',
            'Rework-B',
            'Scrap-A',
            'Scrap-B',
            'Sample-A',
            'Sample-B',
            'Rework Explanation',
            'Scrap Explanation',
            'Trial Sample Explanation',
        ];
    }

    public function map($row): array
    {
        static $counter = 0;
        $counter++;

        return [
            $counter,
            Carbon::parse($row->date)->format('d-M-Y'),
            $row->fy_n,
            $row->shift,
            $row->line,
            $row->group,
            $row->reporter,
            $row->model_year,
            $row->model,
            $row->item_name,
            Carbon::parse($row->start_time)->format('H:i'),
            Carbon::parse($row->finish_time)->format('H:i'),
            $row->total_prod_time,
            $row->spm,
            $row->coil_no,
            $row->plan_a,
            $row->plan_b,
            $row->ok_a,
            $row->ok_b,
            $row->rework_a,
            $row->rework_b,
            $row->scrap_a,
            $row->scrap_b,
            $row->sample_a,
            $row->sample_b,
            $row->rework_exp,
            $row->scrap_exp,
            $row->trial_sample_exp,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:AB1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1C6D3F']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ],
        ];
    }
}
