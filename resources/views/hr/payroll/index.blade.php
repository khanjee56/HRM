@extends('layouts.hr')

@section('page-title', 'Payroll')

@section('content')

<h4 class="mb-4">💰 Payroll Management</h4>

<div class="row">
    <!-- Generate Payslip Form -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Generate Payslip</h5>
            </div>
            <div class="card-body">
                <form action="/hr/payroll/generate" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->user->name }}
                                    ({{ $employee->employee_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control" required>
                            <option value="">-- Select Month --</option>
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
                        Generate Payslip
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Generated Payslips List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Generated Payslips</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Month/Year</th>
                            <th>Gross</th>
                            <th>Deductions</th>
                            <th>Net Salary</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payslips as $payslip)
                            <tr>
                                <td>{{ $payslip->employee->user->name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::create()->month($payslip->month)->format('F') }}
                                    {{ $payslip->year }}
                                </td>
                                <td>Rs. {{ number_format($payslip->gross_salary) }}</td>
                                <td class="text-danger">
                                    Rs. {{ number_format($payslip->total_deductions) }}
                                </td>
                                <td class="text-success fw-bold">
                                    Rs. {{ number_format($payslip->net_salary) }}
                                </td>
                                <td>
                                    @if($payslip->status == 'generated')
                                        <span class="badge bg-warning">Generated</span>
                                    @else
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No payslips generated yet!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection