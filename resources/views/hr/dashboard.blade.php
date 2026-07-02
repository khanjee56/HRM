@extends('layouts.hr')

@section('page-title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #0f3460, #16213e);">
            <div class="card-body text-center">
                <h2>{{ $totalEmployees }}</h2>
                <p class="mb-0">Total Employees</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
            <div class="card-body text-center">
                <h2>{{ $activeEmployees }}</h2>
                <p class="mb-0">Active Employees</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #fd7e14, #ffc107);">
            <div class="card-body text-center">
                <h2>{{ $totalDepartments }}</h2>
                <p class="mb-0">Departments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">
            <div class="card-body text-center">
                <h2>{{ $newJoining }}</h2>
                <p class="mb-0">New This Month</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-2">
    <div class="col-md-4 mb-3">
        <a href="/hr/employees/create" class="btn btn-dark w-100 py-3">
            <i class="fas fa-user-plus"></i> Add New Employee
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/hr/attendance" class="btn btn-dark w-100 py-3">
            <i class="fas fa-calendar-check"></i> Mark Attendance
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/hr/leaves" class="btn btn-dark w-100 py-3">
            <i class="fas fa-umbrella-beach"></i> Leave Requests
        </a>
    </div>
</div>
<div class="col-md-3 mb-4">
    <div class="card stat-card" style="background: linear-gradient(135deg, #e83e8c, #6f42c1); color:white;">
        <div class="card-body text-center">
            @php
                $todayPresent = \App\Models\Attendance::whereDate('date', today())
                    ->where('status', '!=', 'absent')->count();
            @endphp
            <h2>{{ $todayPresent }}</h2>
            <p class="mb-0">Present Today</p>
        </div>
    </div>
</div>
<div class="col-md-3 mb-4">
    <div class="card stat-card" style="background: linear-gradient(135deg, #20c997, #0dcaf0); color:white;">
        <div class="card-body text-center">
            @php
                $pendingLeaves = \App\Models\Leave::where('status', 'pending')->count();
            @endphp
            <h2>{{ $pendingLeaves }}</h2>
            <p class="mb-0">Pending Leaves</p>
        </div>
    </div>
</div>

@endsection