<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cid')->unsigned();
            $table->integer('paymentid')->unsigned();
            $table->string('totalAmount')->nullable(); //
            $table->string('remainPayment')->nullable(); //
            $table->string('paid')->nullable(); //
            $table->string('discount')->nullable(); //
            $table->string('remain')->nullable(); //
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
        Schema::dropIfExists('receivables');
    }
}
