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
    Schema::create('salaries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->decimal('basic_salary', 10, 2);
        $table->decimal('house_allowance', 10, 2)->default(0);
        $table->decimal('transport_allowance', 10, 2)->default(0);
        $table->decimal('medical_allowance', 10, 2)->default(0);
        $table->decimal('tax_deduction', 10, 2)->default(0);
        $table->decimal('other_deduction', 10, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
