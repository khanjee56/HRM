@extends('layouts.hr')

@section('page-title', 'Edit Salary')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    💵 Edit Salary — {{ $employee->user->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="/hr/salaries/{{ $employee->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="text-muted mb-3">Basic + Allowances</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Basic Salary (Rs.)</label>
                            <input type="number" name="basic_salary"
                                   class="form-control"
                                   value="{{ $employee->salary->basic_salary }}"
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">House Allowance (Rs.)</label>
                            <input type="number" name="house_allowance"
                                   class="form-control"
                                   value="{{ $employee->salary->house_allowance }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transport Allowance (Rs.)</label>
                            <input type="number" name="transport_allowance"
                                   class="form-control"
                                   value="{{ $employee->salary->transport_allowance }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Medical Allowance (Rs.)</label>
                            <input type="number" name="medical_allowance"
                                   class="form-control"
                                   value="{{ $employee->salary->medical_allowance }}">
                        </div>
                    </div>

                    <h6 class="text-muted mb-3">Deductions</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tax Deduction (Rs.)</label>
                            <input type="number" name="tax_deduction"
                                   class="form-control"
                                   value="{{ $employee->salary->tax_deduction }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Other Deduction (Rs.)</label>
                            <input type="number" name="other_deduction"
                                   class="form-control"
                                   value="{{ $employee->salary->other_deduction }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/hr/salaries" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Update Salary</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection