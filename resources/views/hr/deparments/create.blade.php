@extends('layouts.hr')

@section('page-title', 'Add Department')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">➕ Add Department</h5>
            </div>
            <div class="card-body">
                <form action="/hr/departments" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Information Technology" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/hr/departments" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection