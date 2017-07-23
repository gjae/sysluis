<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('servicios_id')->unsigned();
            $table->integer('hardware_id')->unsigned()->default(1);
            $table->float('precio_hardware')->default('0.00');
            $table->tinyInteger('activo')->default(1);

            /**
             * INDICES FOREIGN
             */
            
            $table->foreign('servicios_id')
                    ->references('id')
                    ->on('servicios')->onDelete('cascade');

            $table->foreign('hardware_id')
                    ->references('id')
                    ->on('hardware')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detalles_servicios');
    }
}
