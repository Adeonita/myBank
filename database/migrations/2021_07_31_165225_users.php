<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('firstName');
            $table->string('lastName');
            $table->string('document')->unique();
            $table->primary('document');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phoneNumber')->unique();
            $table->enum('type', ['COMMON','SHOPKEEPER']);
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
}
