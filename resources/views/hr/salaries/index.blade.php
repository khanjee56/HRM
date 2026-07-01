@extends('layouts.hr')

@section('page-title', 'Salary Structure')

@section('content')

<h4 class="mb-4">💵 Salary Structure</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Employee</th>
                    <th>Basic Salary</th>
                    <th>Allowances</th>
                    <th>Deductions</th>
                    <th>Gross</th>
                    <th>Net Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    @if($employee->salary)
                    <tr>
                        <td>
                            <strong>{{ $employee->user->name }}</strong><br>
                            <small class="text-muted">{{ $employee->employee_code }}</small>
                        </td>
                        <td>Rs. {{ number_format($employee->salary->basic_salary) }}</td>
                        <td class="text-success">
                            Rs. {{ number_format($employee->salary->total_allowances) }}
                        </td>
                        <td class="text-danger">
                            Rs. {{ number_format($employee->salary->total_deductions) }}
                        </td>
                        <td>Rs. {{ number_format($employee->salary->gross_salary) }}</td>
                        <td class="fw-bold text-success">
                            Rs. {{ number_format($employee->salary->net_salary) }}
                        </td>
                        <td>
                            <a href="/hr/salaries/{{ $employee->id }}/edit"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No employees found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection