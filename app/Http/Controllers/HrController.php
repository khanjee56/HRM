<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Payslip;
use App\Models\Attendance;
use App\Exports\EmployeeExport;
use App\Exports\AttendanceExport;
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;

class HrController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $totalEmployees   = Employee::count();
        $activeEmployees  = Employee::where('status', 'active')->count();
        $totalDepartments = Department::count();
        $newJoining       = Employee::whereMonth('joining_date', now()->month)->count();

        return view('hr.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'totalDepartments',
            'newJoining'
        ));
    }

    // ===== DEPARTMENTS =====
    public function departments()
    {
        $departments = Department::withCount('employees')->latest()->get();
        return view('hr.departments.index', compact('departments'));
    }

    public function createDepartment()
    {
        return view('hr.departments.create');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:departments|max:255',
            'description' => 'nullable',
        ]);

        Department::create($request->only('name', 'description'));
        return redirect('/hr/departments')->with('success', 'Department added successfully!');
    }

    public function editDepartment($id)
    {
        $department = Department::findOrFail($id);
        return view('hr.departments.edit', compact('department'));
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $request->validate([
            'name'        => 'required|max:255|unique:departments,name,' . $id,
            'description' => 'nullable',
        ]);
        $department->update($request->only('name', 'description'));
        return redirect('/hr/departments')->with('success', 'Department updated!');
    }

    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return redirect('/hr/departments')->with('success', 'Department deleted!');
    }

    // ===== DESIGNATIONS =====
    public function designations()
    {
        $designations = Designation::with('department')->latest()->get();
        return view('hr.designations.index', compact('designations'));
    }

    public function createDesignation()
    {
        $departments = Department::all();
        return view('hr.designations.create', compact('departments'));
    }

    public function storeDesignation(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'department_id' => 'required',
        ]);
        Designation::create($request->only('name', 'department_id'));
        return redirect('/hr/designations')->with('success', 'Designation added successfully!');
    }

    public function editDesignation($id)
    {
        $designation = Designation::findOrFail($id);
        $departments = Department::all();
        return view('hr.designations.edit', compact('designation', 'departments'));
    }

    public function updateDesignation(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $request->validate([
            'name'          => 'required|max:255',
            'department_id' => 'required',
        ]);
        $designation->update($request->only('name', 'department_id'));
        return redirect('/hr/designations')->with('success', 'Designation updated!');
    }

    public function destroyDesignation($id)
    {
        Designation::findOrFail($id)->delete();
        return redirect('/hr/designations')->with('success', 'Designation deleted!');
    }

    // ===== EMPLOYEES =====
    public function employees()
    {
        $employees = Employee::with('user', 'department', 'designation')->latest()->get();
        return view('hr.employees.index', compact('employees'));
    }

    public function createEmployee()
    {
        $departments  = Department::all();
        $designations = Designation::all();
        return view('hr.employees.create', compact('departments', 'designations'));
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:6',
            'department_id'    => 'required',
            'designation_id'   => 'required',
            'employee_code'    => 'required|unique:employees',
            'phone'            => 'nullable',
            'address'          => 'nullable',
            'date_of_birth'    => 'nullable|date',
            'joining_date'     => 'required|date',
            'employment_type'  => 'required',
            'basic_salary'     => 'required|numeric',
            'photo'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create user account
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'employee',
        ]);

        // Handle photo
        $photoPath = null;
        if($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        // Create employee profile
        $employee = Employee::create([
            'user_id'         => $user->id,
            'department_id'   => $request->department_id,
            'designation_id'  => $request->designation_id,
            'employee_code'   => $request->employee_code,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'date_of_birth'   => $request->date_of_birth,
            'joining_date'    => $request->joining_date,
            'employment_type' => $request->employment_type,
            'basic_salary'    => $request->basic_salary,
            'photo'           => $photoPath,
            'status'          => 'active',
        ]);

        // Create salary structure
        Salary::create([
            'employee_id'         => $employee->id,
            'basic_salary'        => $request->basic_salary,
            'house_allowance'     => $request->house_allowance ?? 0,
            'transport_allowance' => $request->transport_allowance ?? 0,
            'medical_allowance'   => $request->medical_allowance ?? 0,
            'tax_deduction'       => $request->tax_deduction ?? 0,
            'other_deduction'     => $request->other_deduction ?? 0,
        ]);

        return redirect('/hr/employees')->with('success', 'Employee added successfully!');
    }

    public function showEmployee($id)
    {
        $employee = Employee::with('user', 'department', 'designation', 'salary')->findOrFail($id);
        return view('hr.employees.show', compact('employee'));
    }

    public function editEmployee($id)
    {
        $employee     = Employee::with('user')->findOrFail($id);
        $departments  = Department::all();
        $designations = Designation::all();
        return view('hr.employees.edit', compact('employee', 'departments', 'designations'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'department_id'   => 'required',
            'designation_id'  => 'required',
            'phone'           => 'nullable',
            'address'         => 'nullable',
            'employment_type' => 'required',
            'status'          => 'required',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user name
        $employee->user->update(['name' => $request->name]);

        // Handle photo
        $photoPath = $employee->photo;
        if($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        $employee->update([
            'department_id'   => $request->department_id,
            'designation_id'  => $request->designation_id,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'employment_type' => $request->employment_type,
            'status'          => $request->status,
            'photo'           => $photoPath,
        ]);

        return redirect('/hr/employees')->with('success', 'Employee updated successfully!');
    }

    public function destroyEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->user->delete();
        return redirect('/hr/employees')->with('success', 'Employee deleted!');
    }

// View All Leave Requests
public function leaves()
{
    $leaves = Leave::with('employee.user', 'leaveType')
                ->latest()
                ->get();

    return view('hr.leaves.index', compact('leaves'));
}

// Approve Leave
public function approveLeave($id)
{
    $leave = Leave::findOrFail($id);
    $leave->update(['status' => 'approved']);
    return redirect('/hr/leaves')->with('success', 'Leave approved successfully!');
}

// Reject Leave
public function rejectLeave(Request $request, $id)
{
    $leave = Leave::findOrFail($id);
    $leave->update([
        'status'   => 'rejected',
        'hr_notes' => $request->hr_notes,
    ]);
    return redirect('/hr/leaves')->with('success', 'Leave rejected!');
}

// Leave Types Management
public function leaveTypes()
{
    $leaveTypes = LeaveType::all();
    return view('hr.leave-types.index', compact('leaveTypes'));
}

public function storeLeaveType(Request $request)
{
    $request->validate([
        'name'         => 'required|unique:leave_types',
        'days_allowed' => 'required|numeric',
    ]);

    LeaveType::create($request->only('name', 'days_allowed'));
    return redirect('/hr/leave-types')->with('success', 'Leave type added!');
}

public function destroyLeaveType($id)
{
    LeaveType::findOrFail($id)->delete();
    return redirect('/hr/leave-types')->with('success', 'Leave type deleted!');
}


// Show Payroll Page
public function payroll()
{
    $employees = Employee::with('user', 'salary')->where('status', 'active')->get();
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $payslips = Payslip::with('employee.user')->latest()->get();

    return view('hr.payroll.index', compact('employees', 'months', 'payslips'));
}

// Generate Payslip
public function generatePayslip(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
        'month'       => 'required|integer|between:1,12',
        'year'        => 'required|integer',
    ]);

    $employee = Employee::with('salary')->findOrFail($request->employee_id);

    // Check if payslip already generated
    $existing = Payslip::where('employee_id', $employee->id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();

    if($existing) {
        return redirect('/hr/payroll')->with('error', 'Payslip already generated for this month!');
    }

    // Get working days in that month
    $daysInMonth = \Carbon\Carbon::create($request->year, $request->month)->daysInMonth;

    // Get attendance for that month
    $presentDays = Attendance::where('employee_id', $employee->id)
                    ->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year)
                    ->whereIn('status', ['present', 'late'])
                    ->count();

    $leaveDays = \App\Models\Leave::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->whereMonth('start_date', $request->month)
                    ->whereYear('start_date', $request->year)
                    ->sum('total_days');

    $absentDays = $daysInMonth - $presentDays - $leaveDays;
    $absentDays = max(0, $absentDays); // Never negative

    // Calculate salary
    $salary = $employee->salary;
    $perDaySalary = $salary->basic_salary / $daysInMonth;
    $absentDeduction = $perDaySalary * $absentDays;

    $grossSalary = $salary->gross_salary;
    $totalDeductions = $salary->total_deductions + $absentDeduction;
    $netSalary = $grossSalary - $totalDeductions;

    // Create Payslip
    Payslip::create([
        'employee_id'      => $employee->id,
        'salary_id'        => $salary->id,
        'month'            => $request->month,
        'year'             => $request->year,
        'gross_salary'     => $grossSalary,
        'total_deductions' => $totalDeductions,
        'net_salary'       => $netSalary,
        'working_days'     => $daysInMonth,
        'present_days'     => $presentDays,
        'absent_days'      => $absentDays,
        'leave_days'       => $leaveDays,
        'status'           => 'generated',
    ]);

    return redirect('/hr/payroll')->with('success', 'Payslip generated successfully!');
}

// Show Salary Structure Management
public function salaries()
{
    $employees = Employee::with('user', 'salary')->get();
    return view('hr.salaries.index', compact('employees'));
}

// Edit Salary
public function editSalary($id)
{
    $employee = Employee::with('user', 'salary')->findOrFail($id);
    return view('hr.salaries.edit', compact('employee'));
}

// Update Salary
public function updateSalary(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $request->validate([
        'basic_salary'        => 'required|numeric',
        'house_allowance'     => 'required|numeric',
        'transport_allowance' => 'required|numeric',
        'medical_allowance'   => 'required|numeric',
        'tax_deduction'       => 'required|numeric',
        'other_deduction'     => 'required|numeric',
    ]);

    $employee->salary->update($request->only(
        'basic_salary', 'house_allowance', 'transport_allowance',
        'medical_allowance', 'tax_deduction', 'other_deduction'
    ));

    return redirect('/hr/salaries')->with('success', 'Salary updated successfully!');
}


// Reports Page
public function reports()
{
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December'
    ];

    return view('hr.reports.index', compact('months'));
}

// Export Employee Report
public function exportEmployees()
{
    return Excel::download(new EmployeeExport, 'employees-' . now()->format('Y-m-d') . '.xlsx');
}

// Export Attendance Report
public function exportAttendance(Request $request)
{
    $request->validate([
        'month' => 'required',
        'year'  => 'required',
    ]);

    return Excel::download(
        new AttendanceExport($request->month, $request->year),
        'attendance-' . $request->month . '-' . $request->year . '.xlsx'
    );
}

// Export Payroll Report
public function exportPayroll(Request $request)
{
    $request->validate([
        'month' => 'required',
        'year'  => 'required',
    ]);

    return Excel::download(
        new PayrollExport($request->month, $request->year),
        'payroll-' . $request->month . '-' . $request->year . '.xlsx'
    );
}
}