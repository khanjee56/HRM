<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; font-size: 13px; }
        .header { text-align: center; border-bottom: 2px solid #1a1a2e; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { color: #1a1a2e; margin: 0; }
        .header p { color: #666; margin: 5px 0 0; }
        .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-box { width: 48%; }
        .info-box table { width: 100%; }
        .info-box td { padding: 4px 0; }
        .info-box td:first-child { color: #666; width: 45%; }
        .info-box td:last-child { font-weight: bold; }
        .salary-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .salary-table th { background: #1a1a2e; color: white; padding: 8px; text-align: left; }
        .salary-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .salary-table tr:nth-child(even) { background: #f9f9f9; }
        .total-row { background: #f0f0f0 !important; font-weight: bold; }
        .net-salary { background: #1a1a2e; color: white; padding: 15px; text-align: center; margin-top: 20px; border-radius: 5px; }
        .net-salary h3 { margin: 0; }
        .attendance-section { margin-top: 20px; }
        .attendance-boxes { display: flex; gap: 10px; }
        .att-box { flex: 1; text-align: center; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .att-box h4 { margin: 0; color: #1a1a2e; }
        .att-box p { margin: 5px 0 0; font-size: 11px; color: #666; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 11px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>👔 HRM System</h2>
        <p>Salary Slip — {{ $months[$payslip->month] }} {{ $payslip->year }}</p>
    </div>

    <!-- Employee & Payslip Info -->
    <div class="info-section">
        <div class="info-box">
            <h6 style="color:#1a1a2e; border-bottom:1px solid #eee; padding-bottom:5px;">
                Employee Information
            </h6>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>{{ $payslip->employee->user->name }}</td>
                </tr>
                <tr>
                    <td>Employee Code:</td>
                    <td>{{ $payslip->employee->employee_code }}</td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td>{{ $payslip->employee->department->name }}</td>
                </tr>
                <tr>
                    <td>Designation:</td>
                    <td>{{ $payslip->employee->designation->name }}</td>
                </tr>
            </table>
        </div>
        <div class="info-box">
            <h6 style="color:#1a1a2e; border-bottom:1px solid #eee; padding-bottom:5px;">
                Payslip Information
            </h6>
            <table>
                <tr>
                    <td>Pay Period:</td>
                    <td>{{ $months[$payslip->month] }} {{ $payslip->year }}</td>
                </tr>
                <tr>
                    <td>Working Days:</td>
                    <td>{{ $payslip->working_days }}</td>
                </tr>
                <tr>
                    <td>Generated On:</td>
                    <td>{{ $payslip->created_at->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div class="attendance-section">
        <h6 style="color:#1a1a2e;">Attendance Summary</h6>
        <div class="attendance-boxes">
            <div class="att-box">
                <h4>{{ $payslip->present_days }}</h4>
                <p>Present Days</p>
            </div>
            <div class="att-box">
                <h4>{{ $payslip->absent_days }}</h4>
                <p>Absent Days</p>
            </div>
            <div class="att-box">
                <h4>{{ $payslip->leave_days }}</h4>
                <p>Leave Days</p>
            </div>
            <div class="att-box">
                <h4>{{ $payslip->working_days }}</h4>
                <p>Total Days</p>
            </div>
        </div>
    </div>

    <!-- Salary Breakdown -->
    <table class="salary-table" style="margin-top:20px;">
        <thead>
            <tr>
                <th colspan="2">Earnings</th>
                <th colspan="2">Deductions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td>Rs. {{ number_format($payslip->employee->salary->basic_salary) }}</td>
                <td>Tax Deduction</td>
                <td>Rs. {{ number_format($payslip->employee->salary->tax_deduction) }}</td>
            </tr>
            <tr>
                <td>House Allowance</td>
                <td>Rs. {{ number_format($payslip->employee->salary->house_allowance) }}</td>
                <td>Other Deduction</td>
                <td>Rs. {{ number_format($payslip->employee->salary->other_deduction) }}</td>
            </tr>
            <tr>
                <td>Transport Allowance</td>
                <td>Rs. {{ number_format($payslip->employee->salary->transport_allowance) }}</td>
                <td>Absent Deduction</td>
                <td>Rs. {{ number_format($payslip->total_deductions - $payslip->employee->salary->total_deductions) }}</td>
            </tr>
            <tr>
                <td>Medical Allowance</td>
                <td>Rs. {{ number_format($payslip->employee->salary->medical_allowance) }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td>Gross Salary</td>
                <td>Rs. {{ number_format($payslip->gross_salary) }}</td>
                <td>Total Deductions</td>
                <td>Rs. {{ number_format($payslip->total_deductions) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Net Salary -->
    <div class="net-salary">
        <h3>Net Salary: Rs. {{ number_format($payslip->net_salary) }}</h3>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This is a computer generated payslip and does not require a signature.</p>
        <p>Generated by HRM System on {{ now()->format('d M Y h:i A') }}</p>
    </div>

</body>
</html>