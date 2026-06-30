@extends('layouts.employee')

@section('page-title', 'My Dashboard')

@section('content')

<h4 class="mb-4">Welcome, {{ auth()->user()->name }}! 👋</h4>

<!-- Clock In/Out Card -->
<div class="card mb-4" style="border-left: 5px solid #0f3460;">
    <div class="card-body text-center py-4">
        <h2 id="liveClock">00:00:00</h2>
        <p class="text-muted">Work Timer</p>

        @if(!$todayAttendance)
            <form action="/employee/attendance/check-in" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-sign-in-alt"></i> Check In
                </button>
            </form>
        @elseif($todayAttendance && !$todayAttendance->check_out)
            <div class="alert alert-info d-inline-block">
                Checked in at {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}
                @if($todayAttendance->status == 'late')
                    <span class="badge bg-warning">Late</span>
                @endif
            </div>
            <br>
            <form action="/employee/attendance/check-out" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg px-5">
                    <i class="fas fa-sign-out-alt"></i> Check Out
                </button>
            </form>
       @else
    <div class="alert alert-success">
        ✅ Today's attendance completed!<br>
        Check In: {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }} —
        Check Out: {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') }}
    </div>
@endif
    </div>
</div>

<!-- Stats -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center" style="background: linear-gradient(135deg, #0f3460, #16213e); color:white;">
            <div class="card-body">
                <h3>{{ $totalPresent }}</h3>
                <p class="mb-0">Days Present This Month</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center" style="background: linear-gradient(135deg, #28a745, #20c997); color:white;">
            <div class="card-body">
                <h3>{{ $employee->department->name }}</h3>
                <p class="mb-0">Department</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); color:white;">
            <div class="card-body">
                <h3>{{ $employee->designation->name }}</h3>
                <p class="mb-0">Designation</p>
            </div>
        </div>
    </div>
</div>
<script>
    let timerInterval;
    let secondsElapsed = {{ $todayAttendance && !$todayAttendance->check_out ? (int) \Carbon\Carbon::parse($todayAttendance->check_in)->diffInSeconds(now()) : 0 }};

    @if($todayAttendance && !$todayAttendance->check_out)
        startTimer();
    @endif

    function startTimer() {
        updateTimerDisplay();
        timerInterval = setInterval(() => {
            secondsElapsed++;
            updateTimerDisplay();
        }, 1000);
    }

    function updateTimerDisplay() {
        const hours = Math.floor(secondsElapsed / 3600);
        const minutes = Math.floor((secondsElapsed % 3600) / 60);
        const seconds = secondsElapsed % 60;

        document.getElementById('liveClock').textContent =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
    }
</script>

@endsection