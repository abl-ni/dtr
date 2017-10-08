<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('proj_devs_id')->unsigned();
            $table->string('task_title');
            $table->string('ticket_no');
            $table->string('roadblock')->nullable();
            $table->string('hours_rendered');
            $table->foreign('proj_devs_id')
                ->references('id')
                ->on('devs')
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
        Schema::dropIfExists('dtrs');
    }
}
