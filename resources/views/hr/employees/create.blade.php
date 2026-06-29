@extends('layouts.hr')

@section('page-title', 'Add Employee')

@section('content')

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">➕ Add New Employee</h5>
    </div>
    <div class="card-body">
        <form action="/hr/employees" method="POST" enctype="multipart/form-data">
            @csrf

            <h6 class="mb-3 text-muted">Account Information</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email (Login)</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <hr>
            <h6 class="mb-3 text-muted">Employee Information</h6>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Employee Code</label>
                    <input type="text" name="employee_code" class="form-control"
                           placeholder="EMP004" required>
                    @error('employee_code') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">-- Select --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Designation</label>
                    <select name="designation_id" class="form-control" required>
                        <option value="">-- Select --</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Employment Type</label>
                    <select name="employment_type" class="form-control" required>
                        <option value="full-time">Full Time</option>
                        <option value="part-time">Part Time</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <hr>
            <h6 class="mb-3 text-muted">Salary Structure</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Basic Salary (Rs.)</label>
                    <input type="number" name="basic_salary" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">House Allowance (Rs.)</label>
                    <input type="number" name="house_allowance" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Transport Allowance (Rs.)</label>
                    <input type="number" name="transport_allowance" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Medical Allowance (Rs.)</label>
                    <input type="number" name="medical_allowance" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tax Deduction (Rs.)</label>
                    <input type="number" name="tax_deduction" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Other Deduction (Rs.)</label>
                    <input type="number" name="other_deduction" class="form-control" value="0">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/hr/employees" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark btn-lg">Add Employee</button>
            </div>

        </form>
    </div>
</div>

@endsection