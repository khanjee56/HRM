<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'employee_id', 'basic_salary', 'house_allowance',
        'transport_allowance', 'medical_allowance',
        'tax_deduction', 'other_deduction'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    // Calculate total allowances
    public function getTotalAllowancesAttribute()
    {
        return $this->house_allowance +
               $this->transport_allowance +
               $this->medical_allowance;
    }

    // Calculate total deductions
    public function getTotalDeductionsAttribute()
    {
        return $this->tax_deduction + $this->other_deduction;
    }

    // Calculate gross salary
    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary + $this->total_allowances;
    }

    // Calculate net salary
    public function getNetSalaryAttribute()
    {
        return $this->gross_salary - $this->total_deductions;
    }
}