@extends('layouts.employee')

@section('page-title', 'My Leaves')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>🌴 My Leave Applications</h4>
    <a href="/employee/leaves/apply" class="btn btn-dark">+ Apply Leave</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>HR Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                    <tr>
                        <td>{{ $leave->leaveType->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                        <td><span class="badge bg-info">{{ $leave->total_days }} days</span></td>
                        <td>{{ $leave->reason }}</td>
                        <td>
                            @if($leave->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $leave->hr_notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No leave applications yet!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection