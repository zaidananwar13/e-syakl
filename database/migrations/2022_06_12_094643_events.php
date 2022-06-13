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
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id_event');
            $table->unsignedInteger('hoster');
            $table->unsignedInteger('title');
            $table->string('image');
            $table->string('desc');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('location');
            $table->int('tickets');
            $table->int('available_tickets');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_blog')->references('id_blog')->on('blog');
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
