<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcasModelosPiesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas_modelos_piesas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marca_id')->unsigned();
            $table->integer('modelo_id')->unsigned();
            $table->integer('piesa_id')->unsigned();
            $table->integer('hardware_id')->unsigned();
            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();

            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
            $table->foreign('modelo_id')->references('id')->on('modelos')->onDelete('cascade');
            $table->foreign('piesa_id')->references('id')->on('piesas')->onDelete('cascade');
            $table->foreign('hardware_id')->references('id')->on('hardware')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('marcas_modelos_piesas');
    }
}
