<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->unsignedInteger('id_kategori');
            $table->unsignedInteger('id_reviewer');
            $table->string('judul');
            $table->string('gambar');
            $table->string('langkah');
            $table->string('level');
            $table->string('deskripsi_singkat');
            $table->string('durasi');
            $table->string('deskripsi_kelas');
            $table->timestamps();
            
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->foreign('id_reviewer')->references('id_reviewer')->on('reviewer');
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
