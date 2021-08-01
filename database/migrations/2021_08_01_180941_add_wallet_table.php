<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletTable extends Migration
{
   
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->float('money');

            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->unique()->references("id")->on("users")->onDelete('cascade');
                
        });
    }

    public function down()
    {
        Schema::dropIfExists("wallets");
    }
}
