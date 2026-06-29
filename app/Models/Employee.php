<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'designation_id',
        'employee_code', 'phone', 'address', 'date_of_birth',
        'joining_date', 'employment_type', 'status',
        'photo', 'basic_salary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }
}