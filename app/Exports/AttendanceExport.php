<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function collection()
    {
        return Attendance::with('employee.user')
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->get()
            ->map(function($attendance) {
                return [
                    'Employee Code' => $attendance->employee->employee_code,
                    'Employee Name' => $attendance->employee->user->name,
                    'Date'          => $attendance->date,
                    'Check In'      => $attendance->check_in ?? '-',
                    'Check Out'     => $attendance->check_out ?? '-',
                    'Status'        => ucfirst($attendance->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Date',
            'Check In',
            'Check Out',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a1a2e']],
            ],
        ];
    }
}