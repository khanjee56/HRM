@extends('layouts.hr')

@section('page-title', 'Edit Designation')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">✏️ Edit Designation</h5>
            </div>
            <div class="card-body">
                <form action="/hr/designations/{{ $designation->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Designation Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $designation->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-control" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $designation->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/hr/designations" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Update Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection