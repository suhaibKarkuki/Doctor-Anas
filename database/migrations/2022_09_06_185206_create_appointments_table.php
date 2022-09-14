<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pid')->unsigned()->nullable(); // 1
            $table->integer('cid')->unsigned()->nullable(); // filling
            $table->string('toDr')->nullable(); // aram.
            $table->string('appointmentDate')->nullable();
            $table->string('status')->nullable()->default('pending'); // pending, reject, confirm
            $table->string('note')->nullable(); //
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
        Schema::dropIfExists('appointments');
    }
}
