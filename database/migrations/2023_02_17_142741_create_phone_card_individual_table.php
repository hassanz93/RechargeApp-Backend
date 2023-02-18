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
        Schema::create('phone_card_individuals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->foreignId('cardDetailsId');
            $table->string('code', 50);
            $table->date('expiryDate');
            $table->enum('status', ['Available','Expired','Sold']);
            $table->timestamps();
        });

        Schema::table('phone_card_individuals', function (Blueprint $table) {
            $table->foreign('cardDetailsId')->references('id')->on('phone_cards_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_card_individual');
    }
};
