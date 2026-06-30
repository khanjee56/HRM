@extends('layouts.employee')

@section('page-title', 'My Attendance')

@section('content')

<h4 class="mb-4">📅 My Attendance History</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td>
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                        </td>
                        <td>
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                        </td>
                        <td>
                            @if($attendance->status == 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif($attendance->status == 'late')
                                <span class="badge bg-warning">Late</span>
                            @elseif($attendance->status == 'half-day')
                                <span class="badge bg-info">Half Day</span>
                            @else
                                <span class="badge bg-danger">Absent</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No attendance records yet!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection