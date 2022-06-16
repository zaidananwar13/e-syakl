<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id_event');
            $table->unsignedInteger('hoster');
            $table->string('title');
            $table->string('image');
            $table->string('desc');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('location');
            $table->unsignedInteger('tickets');
            $table->unsignedInteger('available_tickets');
            $table->timestamps();
            
            $table->foreign('hoster')->references('id_user')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
