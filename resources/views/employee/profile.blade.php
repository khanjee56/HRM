@extends('layouts.employee')

@section('page-title', 'My Profile')

@section('content')

<h4 class="mb-4">👤 My Profile</h4>

<div class="row">
    <!-- Left: Photo + Basic Info -->
    <div class="col-md-4">
        <div class="card text-center mb-4">
            <div class="card-body py-4">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}"
                         class="rounded-circle mb-3"
                         style="width:120px; height:120px; object-fit:cover;">
                @else
                    <div style="width:120px; height:120px; border-radius:50%;
                                background:#0f3460; color:white; font-size:40px;
                                display:flex; align-items:center;
                                justify-content:center; margin:0 auto 15px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif

                <h5>{{ $employee->user->name }}</h5>
                <p class="text-muted">{{ $employee->designation->name }}</p>
                <span class="badge bg-primary">{{ $employee->employee_code }}</span>
                <br><br>
                <span class="badge bg-success">{{ ucfirst($employee->status) }}</span>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0">Work Information</h6>
            </div>
            <div class="card-body">
                <p><strong>Department:</strong><br>{{ $employee->department->name }}</p>
                <p><strong>Employment Type:</strong><br>{{ ucfirst($employee->employment_type) }}</p>
                <p><strong>Joining Date:</strong><br>{{ $employee->joining_date }}</p>
                @if($employee->salary)
                    <p class="mb-0">
                        <strong>Net Salary:</strong><br>
                        <span class="text-success fw-bold">
                            Rs. {{ number_format($employee->salary->net_salary) }}
                        </span>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Edit Form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="/employee/profile" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $employee->user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control"
                               value="{{ $employee->user->email }}" disabled>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ $employee->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"
                                  rows="3">{{ $employee->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="photo" class="form-control">
                        @if($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                 width="60" class="mt-2 rounded">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-dark">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection