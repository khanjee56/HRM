@extends('layouts.hr')

@section('page-title', 'Leave Types')

@section('content')

<h4 class="mb-4">📋 Leave Types</h4>

<div class="row">
    <!-- Add Leave Type Form -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">➕ Add Leave Type</h5>
            </div>
            <div class="card-body">
                <form action="/hr/leave-types" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Leave Type Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Sick Leave" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Days Allowed Per Year</label>
                        <input type="number" name="days_allowed"
                               class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Add Leave Type</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Leave Types List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Leave Type</th>
                            <th>Days Allowed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveTypes as $leaveType)
                            <tr>
                                <td>{{ $leaveType->name }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $leaveType->days_allowed }} days
                                    </span>
                                </td>
                                <td>
                                    <form action="/hr/leave-types/{{ $leaveType->id }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this leave type?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No leave types found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection