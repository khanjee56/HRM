@extends('layouts.hr')

@section('page-title', 'Edit Department')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">✏️ Edit Department</h5>
            </div>
            <div class="card-body">
                <form action="/hr/departments/{{ $department->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $department->name }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                                  rows="3">{{ $department->description }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/hr/departments" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection