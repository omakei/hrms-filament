<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_company_details', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->date('joined_at');
            $table->date('left_at')->nullable();
            $table->string('status');
            $table->foreignId('department_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('manager_id')->nullable()->constrained('employees');
            $table->foreignId('shift_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_company_details');
    }
};
