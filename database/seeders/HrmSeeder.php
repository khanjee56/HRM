<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Salary;
use Illuminate\Support\Facades\Hash;

class HrmSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Create Super Admin =====
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@hrm.com',
            'password' => Hash::make('123456'),
            'role'     => 'superadmin',
        ]);

        // ===== Create HR Manager =====
        $hrUser = User::create([
            'name'     => 'HR Manager',
            'email'    => 'hr@hrm.com',
            'password' => Hash::make('123456'),
            'role'     => 'hr',
        ]);

        // ===== Create Departments =====
        $it = Department::create([
            'name'        => 'Information Technology',
            'description' => 'Handles all IT related work',
        ]);

        $hr = Department::create([
            'name'        => 'Human Resources',
            'description' => 'Manages employee relations',
        ]);

        $finance = Department::create([
            'name'        => 'Finance',
            'description' => 'Handles company finances',
        ]);

        // ===== Create Designations =====
        $seniorDev = Designation::create([
            'name'          => 'Senior Developer',
            'department_id' => $it->id,
        ]);

        $juniorDev = Designation::create([
            'name'          => 'Junior Developer',
            'department_id' => $it->id,
        ]);

        $hrOfficer = Designation::create([
            'name'          => 'HR Officer',
            'department_id' => $hr->id,
        ]);

        $accountant = Designation::create([
            'name'          => 'Accountant',
            'department_id' => $finance->id,
        ]);

        // ===== Create Leave Types =====
        LeaveType::create(['name' => 'Sick Leave',     'days_allowed' => 10]);
        LeaveType::create(['name' => 'Annual Leave',   'days_allowed' => 15]);
        LeaveType::create(['name' => 'Emergency Leave','days_allowed' => 5]);
        LeaveType::create(['name' => 'Maternity Leave','days_allowed' => 90]);

        // ===== Create Sample Employees =====

        // Employee 1
        $empUser1 = User::create([
            'name'     => 'Ali Hassan',
            'email'    => 'ali@hrm.com',
            'password' => Hash::make('123456'),
            'role'     => 'employee',
        ]);

        $emp1 = Employee::create([
            'user_id'          => $empUser1->id,
            'department_id'    => $it->id,
            'designation_id'   => $seniorDev->id,
            'employee_code'    => 'EMP001',
            'phone'            => '03001234567',
            'address'          => 'Karachi, Pakistan',
            'date_of_birth'    => '1995-05-15',
            'joining_date'     => '2022-01-01',
            'employment_type'  => 'full-time',
            'status'           => 'active',
            'basic_salary'     => 80000,
        ]);

        Salary::create([
            'employee_id'        => $emp1->id,
            'basic_salary'       => 80000,
            'house_allowance'    => 15000,
            'transport_allowance'=> 5000,
            'medical_allowance'  => 3000,
            'tax_deduction'      => 5000,
            'other_deduction'    => 0,
        ]);

        // Employee 2
        $empUser2 = User::create([
            'name'     => 'Sara Ahmed',
            'email'    => 'sara@hrm.com',
            'password' => Hash::make('123456'),
            'role'     => 'employee',
        ]);

        $emp2 = Employee::create([
            'user_id'          => $empUser2->id,
            'department_id'    => $hr->id,
            'designation_id'   => $hrOfficer->id,
            'employee_code'    => 'EMP002',
            'phone'            => '03009876543',
            'address'          => 'Lahore, Pakistan',
            'date_of_birth'    => '1998-08-20',
            'joining_date'     => '2023-03-01',
            'employment_type'  => 'full-time',
            'status'           => 'active',
            'basic_salary'     => 60000,
        ]);

        Salary::create([
            'employee_id'        => $emp2->id,
            'basic_salary'       => 60000,
            'house_allowance'    => 10000,
            'transport_allowance'=> 3000,
            'medical_allowance'  => 2000,
            'tax_deduction'      => 3000,
            'other_deduction'    => 0,
        ]);

        // Employee 3
        $empUser3 = User::create([
            'name'     => 'Bilal Khan',
            'email'    => 'bilal@hrm.com',
            'password' => Hash::make('123456'),
            'role'     => 'employee',
        ]);

        $emp3 = Employee::create([
            'user_id'          => $empUser3->id,
            'department_id'    => $finance->id,
            'designation_id'   => $accountant->id,
            'employee_code'    => 'EMP003',
            'phone'            => '03331234567',
            'address'          => 'Islamabad, Pakistan',
            'date_of_birth'    => '1993-12-10',
            'joining_date'     => '2021-06-15',
            'employment_type'  => 'full-time',
            'status'           => 'active',
            'basic_salary'     => 70000,
        ]);

        Salary::create([
            'employee_id'        => $emp3->id,
            'basic_salary'       => 70000,
            'house_allowance'    => 12000,
            'transport_allowance'=> 4000,
            'medical_allowance'  => 2500,
            'tax_deduction'      => 4000,
            'other_deduction'    => 0,
        ]);
    }
}