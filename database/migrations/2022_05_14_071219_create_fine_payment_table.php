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
        Schema::create('fine_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('loan_id')->nullable();
            $table->date('payment_date');
            $table->integer('payment_amount');
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
        Schema::dropIfExists('fine_payments');
    }
};
