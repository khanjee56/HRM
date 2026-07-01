@extends('layouts.hr')

@section('page-title', 'Leave Requests')

@section('content')

<h4 class="mb-4">🌴 Leave Requests</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                    <tr>
                        <td><strong>{{ $leave->employee->user->name }}</strong></td>
                        <td>{{ $leave->leaveType->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                        <td><span class="badge bg-info">{{ $leave->total_days }}</span></td>
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
                        <td>
                            @if($leave->status == 'pending')
                                <form action="/hr/leaves/{{ $leave->id }}/approve"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        ✅ Approve
                                    </button>
                                </form>

                                <!-- Reject with Notes -->
                                <button class="btn btn-sm btn-danger"
                                        onclick="showRejectForm({{ $leave->id }})">
                                    ❌ Reject
                                </button>

                                <!-- Reject Form (hidden) -->
                                <div id="rejectForm{{ $leave->id }}" style="display:none;" class="mt-2">
                                    <form action="/hr/leaves/{{ $leave->id }}/reject" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="hr_notes" class="form-control mb-2"
                                                  placeholder="Reason for rejection..." rows="2"></textarea>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Confirm Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No leave requests!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function showRejectForm(id) {
        const form = document.getElementById('rejectForm' + id);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

@endsection