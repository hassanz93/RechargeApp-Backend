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
        Schema::create('transactions_history', function (Blueprint $table) {
            $table->id();
            $table->uuid('transactionNumber')->startingValue(10000000001);
            $table->foreignId('userId');
            $table->enum('status', ['In-Progress','Sent']);
            $table->string('card');
            $table->integer('quantity');
            $table->integer('usdPayed');
            $table->integer('lbpPayed');
            $table->timestamps();
        });

        Schema::table('transactions_history', function (Blueprint $table) {
            $table->foreign('users')->references('id')->on('transactions_history')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions_history');
    }
};
