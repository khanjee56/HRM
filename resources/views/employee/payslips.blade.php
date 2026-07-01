@extends('layouts.employee')

@section('page-title', 'My Payslips')

@section('content')

<h4 class="mb-4">💰 My Payslips</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Month/Year</th>
                    <th>Working Days</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Gross Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payslips as $payslip)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::create()->month($payslip->month)->format('F') }}
                            {{ $payslip->year }}
                        </td>
                        <td>{{ $payslip->working_days }}</td>
                        <td>
                            <span class="badge bg-success">{{ $payslip->present_days }}</span>
                        </td>
                        <td>
                            <span class="badge bg-danger">{{ $payslip->absent_days }}</span>
                        </td>
                        <td>Rs. {{ number_format($payslip->gross_salary) }}</td>
                        <td class="text-danger">
                            Rs. {{ number_format($payslip->total_deductions) }}
                        </td>
                        <td class="text-success fw-bold">
                            Rs. {{ number_format($payslip->net_salary) }}
                        </td>
                        <td>
                            <a href="/employee/payslips/{{ $payslip->id }}/download"
                               class="btn btn-sm btn-dark">
                                📥 PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No payslips generated yet!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection