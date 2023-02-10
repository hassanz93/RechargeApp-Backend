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
        Schema::create('phone_cards_details', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->foreignId('categoryId');
            $table->enum('type', ['Magic','Start','Smart']);
            $table->integer('dollarPrice');
            $table->integer('validity');
            $table->integer('grace');
            $table->timestamp('expiryDate');
            $table->timestamps();
        });

        Schema::table('phone_cards_details', function (Blueprint $table) {
            $table->foreign('categoryId')->references('id')->on('phone_cards_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_cards_details');
    }
};
