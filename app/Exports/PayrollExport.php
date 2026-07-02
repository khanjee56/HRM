<?php

namespace App\Exports;

use App\Models\Payslip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromCollection, WithHeadings, WithStyles
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
        return Payslip::with('employee.user', 'employee.department')
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->get()
            ->map(function($payslip) {
                return [
                    'Employee Code'    => $payslip->employee->employee_code,
                    'Employee Name'    => $payslip->employee->user->name,
                    'Department'       => $payslip->employee->department->name,
                    'Working Days'     => $payslip->working_days,
                    'Present Days'     => $payslip->present_days,
                    'Absent Days'      => $payslip->absent_days,
                    'Leave Days'       => $payslip->leave_days,
                    'Gross Salary'     => $payslip->gross_salary,
                    'Total Deductions' => $payslip->total_deductions,
                    'Net Salary'       => $payslip->net_salary,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Department',
            'Working Days',
            'Present Days',
            'Absent Days',
            'Leave Days',
            'Gross Salary',
            'Total Deductions',
            'Net Salary',
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