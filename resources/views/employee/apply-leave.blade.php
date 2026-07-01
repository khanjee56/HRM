@extends('layouts.employee')

@section('page-title', 'Apply Leave')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">🌴 Apply for Leave</h5>
            </div>
            <div class="card-body">
                <form action="/employee/leaves/apply" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select name="leave_type_id" class="form-control" required>
                            <option value="">-- Select Leave Type --</option>
                            @foreach($leaveTypes as $leaveType)
                                <option value="{{ $leaveType->id }}">
                                    {{ $leaveType->name }}
                                    ({{ $leaveType->days_allowed }} days allowed)
                                </option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date"
                                   class="form-control"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('start_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date"
                                   class="form-control"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Auto Calculate Days -->
                    <div class="alert alert-info" id="daysInfo" style="display:none;">
                        Total Days: <strong id="totalDays">0</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea name="reason" class="form-control"
                                  rows="3" required
                                  placeholder="Explain why you need this leave..."></textarea>
                        @error('reason')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/employee/leaves" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Submit Application</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto calculate days when dates change
    document.querySelector('[name="start_date"]').addEventListener('change', calculateDays);
    document.querySelector('[name="end_date"]').addEventListener('change', calculateDays);

    function calculateDays() {
        const startDate = document.querySelector('[name="start_date"]').value;
        const endDate = document.querySelector('[name="end_date"]').value;

        if(startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            document.getElementById('totalDays').textContent = diffDays;
            document.getElementById('daysInfo').style.display = 'block';
        }
    }
</script>

@endsection