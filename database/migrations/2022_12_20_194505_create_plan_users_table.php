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
        Schema::create('plan_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('daily_limit', 18,8)->default(0);
            $table->decimal('balance', 28, 8)->default(0)->comment('Deposit');
            $table->decimal('referral_income', 28, 8)->default(0)->comment('profit_Bonus');
            $table->decimal('profit_bonus', 28, 8)->default(0)->comment('user_profit_bonus');
            $table->decimal('referral_deposit', 28, 8)->default(0)->comment('deposit_commission');
            $table->decimal('current_profit', 28, 8)->default(0);
            $table->dateTime('last_withdraw')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->on('plans')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_users');
    }
};
