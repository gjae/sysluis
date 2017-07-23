<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_emp_to')->unsigned();
            $table->integer('id_emp_from')->unsigned();
            $table->integer('solicitud_id')->unsigned();
            
            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();

            $table->foreign('id_emp_to')
                    ->references('id')
                    ->on('empleados')
                    ->onDelete('cascade');

            $table->foreign('solicitud_id')->references('id')
                    ->on('solicitudes')
                    ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asignaciones');
    }
}
