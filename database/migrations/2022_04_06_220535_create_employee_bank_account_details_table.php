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
        Schema::create('employee_bank_account_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('branch');
            $table->string('bank_code');
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
        Schema::dropIfExists('employee_bank_account_details');
    }
};
