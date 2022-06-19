<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_user', function (Blueprint $table) {
            $table->increments('id_project_user');
            $table->unsignedInteger("id_project");
            $table->unsignedInteger("id_user");
            $table->timestamp('expired');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_project')->references('id_project')->on('project');
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
