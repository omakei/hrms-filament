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
        Schema::create('pay_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->year('year');
            $table->string('month');
            $table->foreignId('pay_scale_id')->constrained();
            $table->string('status');
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
        Schema::dropIfExists('pay_rolls');
    }
};
