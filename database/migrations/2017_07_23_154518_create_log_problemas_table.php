<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogProblemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_problemas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('asignacion_id')->unsigned();
            $table->smallInteger('edo_registro')->default(1);


            $table->string('titulo', 40);
            $table->text('detalles');


            $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');

            $table->foreign('asignacion_id')->references('id')
                    ->on('asignaciones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_problemas');
    }
}
