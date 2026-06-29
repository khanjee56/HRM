@extends('layouts.hr')

@section('page-title', 'Add Designation')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">➕ Add Designation</h5>
            </div>
            <div class="card-body">
                <form action="/hr/designations" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Designation Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Senior Developer" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-control" required>
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/hr/designations" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Add Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection