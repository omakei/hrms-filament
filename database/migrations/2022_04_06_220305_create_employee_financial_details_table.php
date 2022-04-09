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
        Schema::create('employee_financial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('salary_type_id')->constrained();
            $table->foreignId('pay_scale_id')->constrained();
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
        Schema::dropIfExists('employee_financial_details');
    }
};
