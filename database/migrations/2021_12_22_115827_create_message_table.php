<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id', true);
            $table->integer('transmitter_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->foreign('transmitter_id')->references('id')->on('profile')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('message');
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
        Schema::dropIfExists('message');
    }
}
