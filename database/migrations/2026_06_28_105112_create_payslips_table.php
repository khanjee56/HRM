<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('payslips', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->foreignId('salary_id')->constrained()->onDelete('cascade');
        $table->integer('month');
        $table->integer('year');
        $table->decimal('gross_salary', 10, 2);
        $table->decimal('total_deductions', 10, 2);
        $table->decimal('net_salary', 10, 2);
        $table->integer('working_days');
        $table->integer('present_days');
        $table->integer('absent_days');
        $table->integer('leave_days');
        $table->enum('status', ['generated', 'paid'])->default('generated');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
