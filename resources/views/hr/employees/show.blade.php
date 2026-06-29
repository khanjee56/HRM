@extends('layouts.hr')

@section('page-title', 'Employee Profile')

@section('content')

<div class="row">
    <!-- Left: Photo + Basic Info -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}"
                         class="rounded-circle mb-3"
                         style="width:120px; height:120px; object-fit:cover;">
                @else
                    <div style="width:120px; height:120px; border-radius:50%;
                                background:#0f3460; color:white; font-size:40px;
                                display:flex; align-items:center; justify-content:center;
                                margin: 0 auto 15px;">
                        {{ substr($employee->user->name, 0, 1) }}
                    </div>
                @endif
                <h5>{{ $employee->user->name }}</h5>
                <p class="text-muted">{{ $employee->designation->name }}</p>
                <span class="badge bg-primary">{{ $employee->employee_code }}</span>
                <br><br>
                @if($employee->status == 'active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">{{ ucfirst($employee->status) }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Details -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">Personal Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $employee->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
                        <p><strong>Date of Birth:</strong> {{ $employee->date_of_birth ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Department:</strong> {{ $employee->department->name }}</p>
                        <p><strong>Employment Type:</strong> {{ ucfirst($employee->employment_type) }}</p>
                        <p><strong>Joining Date:</strong> {{ $employee->joining_date }}</p>
                    </div>
                </div>
                <p><strong>Address:</strong> {{ $employee->address ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Salary Info -->
        @if($employee->salary)
        <div class="card">
            <div class="card-header bg-dark text-white">Salary Structure</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Basic Salary:</strong> Rs. {{ number_format($employee->salary->basic_salary) }}</p>
                        <p><strong>House Allowance:</strong> Rs. {{ number_format($employee->salary->house_allowance) }}</p>
                        <p><strong>Transport Allowance:</strong> Rs. {{ number_format($employee->salary->transport_allowance) }}</p>
                        <p><strong>Medical Allowance:</strong> Rs. {{ number_format($employee->salary->medical_allowance) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tax Deduction:</strong> Rs. {{ number_format($employee->salary->tax_deduction) }}</p>
                        <p><strong>Other Deduction:</strong> Rs. {{ number_format($employee->salary->other_deduction) }}</p>
                        <hr>
                        <p><strong>Gross Salary:</strong> Rs. {{ number_format($employee->salary->gross_salary) }}</p>
                        <p><strong class="text-success">Net Salary: Rs. {{ number_format($employee->salary->net_salary) }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="mt-3">
    <a href="/hr/employees" class="btn btn-outline-dark">← Back</a>
    <a href="/hr/employees/{{ $employee->id }}/edit" class="btn btn-warning">✏️ Edit</a>
</div>

@endsection