@extends('layouts.hr')

@section('page-title', 'Reports')

@section('content')

<h4 class="mb-4">📊 Reports & Exports</h4>

<div class="row">

    <!-- Employee Report -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">👥 Employee Report</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Export complete list of all employees with
                    their department, designation and salary details.
                </p>
                <ul class="text-muted small">
                    <li>Employee Code & Name</li>
                    <li>Department & Designation</li>
                    <li>Employment Type & Status</li>
                    <li>Basic & Net Salary</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="/hr/reports/employees" class="btn btn-dark w-100">
                    📥 Download Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Attendance Report -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📅 Attendance Report</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Export monthly attendance records for
                    all employees with check-in/out times.
                </p>
                <form action="/hr/reports/attendance" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control" required>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}"
                                    {{ $num == now()->month ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control" required>
                            @for($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}"
                                    {{ $y == now()->year ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        📥 Download Excel
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Payroll Report -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">💰 Payroll Report</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Export monthly payroll summary with
                    gross salary, deductions and net salary.
                </p>
                <form action="/hr/reports/payroll" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control" required>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}"
                                    {{ $num == now()->month ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control" required>
                            @for($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}"
                                    {{ $y == now()->year ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        📥 Download Excel
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection