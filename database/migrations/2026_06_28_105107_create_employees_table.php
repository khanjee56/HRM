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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('department_id')->constrained()->onDelete('cascade');
        $table->foreignId('designation_id')->constrained()->onDelete('cascade');
        $table->string('employee_code')->unique();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->date('joining_date');
        $table->enum('employment_type', ['full-time', 'part-time', 'contract'])->default('full-time');
        $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
        $table->string('photo')->nullable();
        $table->decimal('basic_salary', 10, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
