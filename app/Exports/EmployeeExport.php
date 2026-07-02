<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Employee::with('user', 'department', 'designation', 'salary')
            ->get()
            ->map(function($employee) {
                return [
                    'Employee Code'    => $employee->employee_code,
                    'Name'             => $employee->user->name,
                    'Email'            => $employee->user->email,
                    'Department'       => $employee->department->name,
                    'Designation'      => $employee->designation->name,
                    'Employment Type'  => ucfirst($employee->employment_type),
                    'Status'           => ucfirst($employee->status),
                    'Joining Date'     => $employee->joining_date,
                    'Basic Salary'     => $employee->salary ? $employee->salary->basic_salary : 0,
                    'Net Salary'       => $employee->salary ? $employee->salary->net_salary : 0,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Name',
            'Email',
            'Department',
            'Designation',
            'Employment Type',
            'Status',
            'Joining Date',
            'Basic Salary',
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