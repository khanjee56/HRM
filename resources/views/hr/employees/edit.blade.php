@extends('layouts.hr')

@section('page-title', 'Edit Employee')

@section('content')

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">✏️ Edit Employee — {{ $employee->user->name }}</h5>
    </div>
    <div class="card-body">
        <form action="/hr/employees/{{ $employee->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $employee->user->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control"
                           value="{{ $employee->user->email }}" disabled>
                    <small class="text-muted">Email cannot be changed</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-control" required>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Designation</label>
                    <select name="designation_id" class="form-control" required>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}"
                                {{ $employee->designation_id == $designation->id ? 'selected' : '' }}>
                                {{ $designation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Employment Type</label>
                    <select name="employment_type" class="form-control" required>
                        <option value="full-time" {{ $employee->employment_type == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ $employee->employment_type == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ $employee->employment_type == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ $employee->phone }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Change Photo</label>
                    <input type="file" name="photo" class="form-control">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}"
                             width="50" class="mt-2 rounded">
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ $employee->address }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/hr/employees" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Update Employee</button>
            </div>

        </form>
    </div>
</div>

@endsection