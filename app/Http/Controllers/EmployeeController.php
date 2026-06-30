<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;

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
}