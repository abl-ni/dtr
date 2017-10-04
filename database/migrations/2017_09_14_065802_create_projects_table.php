<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('added_by')->unsigned();
            $table->integer('pm_id')->unsigned();
            $table->integer('tl_id')->unsigned();
            $table->foreign('added_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('pm_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('tl_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->string('date_created')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
