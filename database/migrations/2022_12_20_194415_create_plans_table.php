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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('description')->nullable();
            $table->decimal('price', 28, 8)->default(0);
            $table->decimal('min_price', 28, 8)->default(0);
            $table->decimal('max_price', 28, 8)->default(0);
            $table->decimal('amount_return')->default(0);
            $table->float('min_profit_percent')->default(0);
            $table->float('max_profit_percent')->default(0);
            $table->float('profit_bonus_percent')->default(0);
            $table->string('validity')->default('0');
            $table->string('status')->default('inactive');
            $table->string('type')->default('default');
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
        Schema::dropIfExists('plans');
    }
};
