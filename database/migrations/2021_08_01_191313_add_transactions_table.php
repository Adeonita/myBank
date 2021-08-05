<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionsTable extends Migration
{
    
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->enum('type', ['DEBIT','CREDIT']);

            $table->unsignedBigInteger("payer");
            $table->foreign("payer")->unique()->references("id")->on("users")->onDelete('cascade');
                
            $table->unsignedBigInteger("payee");
            $table->foreign("payee")->unique()->references("id")->on("users")->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
