@extends('layouts.hr')

@section('page-title', 'Attendance')

@section('content')

<h4 class="mb-4">📅 Attendance Management</h4>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form action="/hr/attendance" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-control">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ $selectedEmployee == $employee->id ? 'selected' : '' }}>
                            {{ $employee->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Month</label>
                <select name="month" class="form-control">
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}"
                            {{ $selectedMonth == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <select name="year" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}"
                            {{ $selectedYear == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-dark w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center" style="background:#28a745; color:white;">
            <div class="card-body py-3">
                <h3>{{ $totalPresent }}</h3>
                <p class="mb-0">Present</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center" style="background:#ffc107; color:white;">
            <div class="card-body py-3">
                <h3>{{ $totalLate }}</h3>
                <p class="mb-0">Late</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center" style="background:#dc3545; color:white;">
            <div class="card-body py-3">
                <h3>{{ $totalAbsent }}</h3>
                <p class="mb-0">Absent</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center" style="background:#17a2b8; color:white;">
            <div class="card-body py-3">
                <h3>{{ $totalHalfDay }}</h3>
                <p class="mb-0">Half Day</p>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>
                            <strong>{{ $attendance->employee->user->name }}</strong>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                        </td>
                        <td>
                            {{ $attendance->check_in ?
                                \Carbon\Carbon::parse($attendance->check_in)->format('h:i A')
                                : '-' }}
                        </td>
                        <td>
                            {{ $attendance->check_out ?
                                \Carbon\Carbon::parse($attendance->check_out)->format('h:i A')
                                : '-' }}
                        </td>
                        <td>
                            @if($attendance->status == 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif($attendance->status == 'late')
                                <span class="badge bg-warning">Late</span>
                            @elseif($attendance->status == 'half-day')
                                <span class="badge bg-info">Half Day</span>
                            @else
                                <span class="badge bg-danger">Absent</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            No attendance records found!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection