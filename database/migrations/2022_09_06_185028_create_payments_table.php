<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id')->unsigned();
            $table->string('total')->nullable(); // 1000
            $table->string('discount')->nullable(); // 200
            $table->string('paid')->nullable();
            $table->string('remain')->nullable();
            $table->string('status')->nullable(); // paid , unpaid , remain
            $table->string('p_date')->nullable();
            $table->string('receivableRemain')->nullable(); //add new
            $table->string('testCaseArray')->nullable(); // filling, whitening
            $table->string('deleted_date')->default('0');  // add new// when case is deleted ?
            $table->string('note')->nullable();  // add new// when case is deleted ?
            $table->string('user_id')->nullable(); //add new
            $table->string('print_out_date')->nullable(); //add new
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
        Schema::dropIfExists('payments');
    }
}
