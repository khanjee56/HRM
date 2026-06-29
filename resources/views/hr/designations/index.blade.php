@extends('layouts.hr')

@section('page-title', 'Designations')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>🎯 Designations</h4>
    <a href="/hr/designations/create" class="btn btn-dark">+ Add Designation</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($designations as $designation)
                    <tr>
                        <td>{{ $designation->id }}</td>
                        <td><strong>{{ $designation->name }}</strong></td>
                        <td>{{ $designation->department->name }}</td>
                        <td>
                            <a href="/hr/designations/{{ $designation->id }}/edit"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="/hr/designations/{{ $designation->id }}"
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
                        <td colspan="4" class="text-center">No designations found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection