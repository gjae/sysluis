<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion', 140);
            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();
        });
         \DB::table('tipo_servicios')->insert([
            'denominacion' => '-------',
            'edo_reg' => 0,
        ]); 
        foreach (['Compra', 'Ventra', 'Servicios'] as $key => $value) {
            \DB::table('tipo_servicios')->insert([
                'denominacion' => $value,
                'edo_reg' => 1,
            ]); 
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_servicios');
    }
}
