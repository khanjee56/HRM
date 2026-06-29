@extends('layouts.hr')

@section('page-title', 'Employees')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>👥 All Employees</h4>
    <a href="/hr/employees/create" class="btn btn-dark">+ Add Employee</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}"
                                     width="40" height="40"
                                     style="border-radius:50%; object-fit:cover;">
                            @else
                                <div style="width:40px; height:40px; border-radius:50%;
                                            background:#0f3460; color:white;
                                            display:flex; align-items:center;
                                            justify-content:center; font-weight:bold;">
                                    {{ substr($employee->user->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $employee->employee_code }}</span></td>
                        <td><strong>{{ $employee->user->name }}</strong></td>
                        <td>{{ $employee->department->name }}</td>
                        <td>{{ $employee->designation->name }}</td>
                        <td>{{ ucfirst($employee->employment_type) }}</td>
                        <td>
                            @if($employee->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($employee->status == 'inactive')
                                <span class="badge bg-warning">Inactive</span>
                            @else
                                <span class="badge bg-danger">Terminated</span>
                            @endif
                        </td>
                        <td>
                            <a href="/hr/employees/{{ $employee->id }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/hr/employees/{{ $employee->id }}/edit"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/hr/employees/{{ $employee->id }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this employee?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No employees found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection