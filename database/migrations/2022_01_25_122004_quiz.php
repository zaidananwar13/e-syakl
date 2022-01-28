<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Quiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->unsignedInteger('id_sub_kategori_silabus');
            $table->text('soal');
            $table->string('tipe_soal');
            $table->string('kunci');
            $table->string('jawaban');
            $table->timestamps();
            
            $table->foreign('id_sub_kategori_silabus')->references('id_sub_kategori_silabus')->on('sub_kategori_silabus');
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
