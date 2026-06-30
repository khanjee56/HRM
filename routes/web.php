<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\EmployeeController;

Auth::routes();

Route::get('/', function() {
    if(auth()->check()) {
        return redirect('/redirect');
    }
    return redirect('/login');
});

Route::middleware(['auth', 'employee'])->prefix('employee')->group(function() {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard']);

    // Attendance
    Route::post('/attendance/check-in', [EmployeeController::class, 'checkIn']);
    Route::post('/attendance/check-out', [EmployeeController::class, 'checkOut']);
    Route::get('/attendance', [EmployeeController::class, 'myAttendance']);
});
Route::middleware('auth')->get('/redirect', function() {
    if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'hr') {
        return redirect('/hr/dashboard');
    } elseif(auth()->user()->role == 'employee') {
        return redirect('/employee/dashboard');
    }
    return redirect('/login');
});



Route::middleware(['auth', 'hr'])->prefix('hr')->group(function() {

    Route::get('/dashboard', [HrController::class, 'dashboard']);

    // Departments
    Route::get('/departments', [HrController::class, 'departments']);
    Route::get('/departments/create', [HrController::class, 'createDepartment']);
    Route::post('/departments', [HrController::class, 'storeDepartment']);
    Route::get('/departments/{id}/edit', [HrController::class, 'editDepartment']);
    Route::put('/departments/{id}', [HrController::class, 'updateDepartment']);
    Route::delete('/departments/{id}', [HrController::class, 'destroyDepartment']);

    // Designations
    Route::get('/designations', [HrController::class, 'designations']);
    Route::get('/designations/create', [HrController::class, 'createDesignation']);
    Route::post('/designations', [HrController::class, 'storeDesignation']);
    Route::get('/designations/{id}/edit', [HrController::class, 'editDesignation']);
    Route::put('/designations/{id}', [HrController::class, 'updateDesignation']);
    Route::delete('/designations/{id}', [HrController::class, 'destroyDesignation']);

    // Employees
    Route::get('/employees', [HrController::class, 'employees']);
    Route::get('/employees/create', [HrController::class, 'createEmployee']);
    Route::post('/employees', [HrController::class, 'storeEmployee']);
    Route::get('/employees/{id}', [HrController::class, 'showEmployee']);
    Route::get('/employees/{id}/edit', [HrController::class, 'editEmployee']);
    Route::put('/employees/{id}', [HrController::class, 'updateEmployee']);
    Route::delete('/employees/{id}', [HrController::class, 'destroyEmployee']);
});

