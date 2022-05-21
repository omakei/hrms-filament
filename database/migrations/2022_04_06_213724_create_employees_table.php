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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('gender');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('nationality');
            $table->string('reference_name_1');
            $table->string('reference_phone_1');
            $table->string('reference_name_2');
            $table->string('reference_phone_2')->nullable();
            $table->string('marital_status');
            $table->text('comment');
            $table->foreignId('user_id')->nullable()->constrained();
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
        Schema::dropIfExists('employees');
    }
};
