<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'employee_id', 'salary_id', 'month', 'year',
        'gross_salary', 'total_deductions', 'net_salary',
        'working_days', 'present_days', 'absent_days',
        'leave_days', 'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
}