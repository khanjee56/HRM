@extends('layouts.hr')

@section('page-title', 'Departments')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>🏢 Departments</h4>
    <a href="/hr/departments/create" class="btn btn-dark">+ Add Department</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Employees</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td><strong>{{ $department->name }}</strong></td>
                        <td>{{ $department->description ?? 'N/A' }}</td>
                        <td><span class="badge bg-primary">{{ $department->employees_count }}</span></td>
                        <td>
                            <a href="/hr/departments/{{ $department->id }}/edit"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="/hr/departments/{{ $department->id }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No departments found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection