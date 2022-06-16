<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LearningPathClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_path_class', function (Blueprint $table) {
            $table->increments('id_learning_path_class');
            $table->unsignedInteger('id_learning_path');
            $table->unsignedInteger('id_learning_kelas');
            $table->timestamps();
            
            $table->foreign('id_learning_path')->references('id_learning_path')->on('learning_path');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
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
