<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRazonSalidaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('razones_salidas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('descripcion_razon', 39);
            $table->string('codigo_razon', 6)->unique();
            $table->text('explicacion_razon')->nullable();
            $table->tinyInteger('edo_reg')->default(1);

            $table->index('codigo_razon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('razones_salidas');
    }
}
