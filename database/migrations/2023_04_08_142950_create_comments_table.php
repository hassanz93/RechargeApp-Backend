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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('senderId');
            $table->foreignId('receiverId');
            $table->string('message', 200);
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('receiverId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('senderId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
