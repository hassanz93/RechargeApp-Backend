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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('email', 500)->unique();
            $table->integer('phoneNumber')->unique();
            $table->string('password', 500);
            $table->enum('role', ['resellerB','manager','resellerA','SuperAdmin']);
            $table->boolean('verified')->default(0);
            $table->integer('lbpBalance')->default(0);
            $table->integer('usdBalance')->default(0);
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
        Schema::dropIfExists('users');
    }
};
