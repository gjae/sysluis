<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->string('codigo');
            $table->text('observacion');
            
            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();

            $table->foreign('status_id')
                    ->references('id')
                    ->on('estatus')
                    ->onDelete('cascade');

            $table->foreign('empleado_id')
                    ->references('id')
                    ->on('empleados')
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
        Schema::drop('trabajos');
    }
}
