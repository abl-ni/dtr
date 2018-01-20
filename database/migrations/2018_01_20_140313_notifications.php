<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('dtr_id')->unsigned();
            $table->string('overtime');
            $table->integer('status')->unsigned();
            $table->integer('requested_by')->unsigned();
            $table->integer('approved_by')->unsigned();
            $table->timestamps();
            $table->foreign('requested_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('dtr_id')
                ->references('id')
                ->on('dtrs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
