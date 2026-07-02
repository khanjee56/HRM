<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use PDF;
use App\Models\Payslip;
class EmployeeController extends Controller
{
    // Employee Dashboard
    public function dashboard()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $todayAttendance = Attendance::where('employee_id', $employee->id)
                            ->where('date', today())
                            ->first();

        $totalPresent = Attendance::where('employee_id', $employee->id)
                            ->whereMonth('date', now()->month)
                            ->where('status', '!=', 'absent')
                            ->count();

        return view('employee.dashboard', compact('employee', 'todayAttendance', 'totalPresent'));
    }

    // ===== ATTENDANCE (Self-Service) =====

    // Check In
    public function checkIn()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        // Check if already checked in today
        $existing = Attendance::where('employee_id', $employee->id)
                    ->where('date', today())
                    ->first();

        if($existing) {
            return back()->with('error', 'You have already checked in today!');
        }

        $currentTime = now();
        $officeStartTime = today()->setTime(9, 0); // Office starts at 9:00 AM

        // Determine status based on check-in time
        $status = $currentTime->gt($officeStartTime) ? 'late' : 'present';

        Attendance::create([
            'employee_id' => $employee->id,
            'date'        => today(),
            'check_in'    => $currentTime->format('H:i:s'),
            'status'      => $status,
        ]);

        return back()->with('success', 'Checked in successfully at ' . $currentTime->format('h:i A') . '!');
    }

    // Check Out
    public function checkOut()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $attendance = Attendance::where('employee_id', $employee->id)
                        ->where('date', today())
                        ->first();

        if(!$attendance) {
            return back()->with('error', 'You need to check in first!');
        }

        if($attendance->check_out) {
            return back()->with('error', 'You have already checked out today!');
        }

        $attendance->update([
            'check_out' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Checked out successfully at ' . now()->format('h:i A') . '!');
    }

    // My Attendance History
    public function myAttendance()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $attendances = Attendance::where('employee_id', $employee->id)
                        ->orderBy('date', 'desc')
                        ->get();

        return view('employee.attendance', compact('attendances'));
    }


// My Leaves
public function myLeaves()
{
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    $leaves = Leave::with('leaveType')
                ->where('employee_id', $employee->id)
                ->latest()
                ->get();

    return view('employee.leaves', compact('leaves'));
}

// Show Apply Leave Form
public function applyLeaveForm()
{
    $leaveTypes = LeaveType::all();
    return view('employee.apply-leave', compact('leaveTypes'));
}

// Submit Leave Application
public function applyLeave(Request $request)
{
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    $request->validate([
        'leave_type_id' => 'required',
        'start_date'    => 'required|date|after_or_equal:today',
        'end_date'      => 'required|date|after_or_equal:start_date',
        'reason'        => 'required|string',
    ]);

    // Calculate total days
    $startDate  = \Carbon\Carbon::parse($request->start_date);
    $endDate    = \Carbon\Carbon::parse($request->end_date);
    $totalDays  = $startDate->diffInDays($endDate) + 1;

    Leave::create([
        'employee_id'   => $employee->id,
        'leave_type_id' => $request->leave_type_id,
        'start_date'    => $request->start_date,
        'end_date'      => $request->end_date,
        'total_days'    => $totalDays,
        'reason'        => $request->reason,
        'status'        => 'pending',
    ]);

    return redirect('/employee/leaves')->with('success', 'Leave application submitted successfully!');
}

// My Payslips
public function myPayslips()
{
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    $payslips = Payslip::where('employee_id', $employee->id)
                ->latest()
                ->get();

    return view('employee.payslips', compact('payslips'));
}

// Download Payslip PDF
public function downloadPayslip($id)
{
    $payslip = Payslip::with('employee.user', 'employee.department',
                             'employee.designation', 'employee.salary')
                ->findOrFail($id);

    $months = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $pdf = PDF::loadView('employee.payslip-pdf', compact('payslip', 'months'));
    return $pdf->download('payslip-' . $months[$payslip->month] . '-' . $payslip->year . '.pdf');
}
}