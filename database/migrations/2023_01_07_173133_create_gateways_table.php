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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->nullable();
            $table->string('slug', 40)->nullable();
            $table->string('image')->nullable();
            //Currecncy table
            $table->decimal('min_amount')->default(0);
            $table->decimal('max_amount')->default(0);
            $table->decimal('fixed_charge')->default(0);
            $table->decimal('percentage_charge')->default(0);
            $table->string('currency')->nullable();
            $table->decimal('currency_value', 18,8)->nullable();

            $table->json('gateway_parameters')->nullable();
            $table->enum('type', ['deposit', 'withdrawal', 'both']);
            $table->boolean('crypto')->default(0)->comment('0: fiat currency, 1: crypto currency');
            $table->text('extra')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
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
        Schema::dropIfExists('gateways');
    }
};
