<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateEstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_estatus', 150);
            $table->string('codigo_estatus', 4)->unique();

            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();
        });
        
        $status = [
            '-----' => '---', 
            'PENDIENTE' => 'P', 
            'ASIGNADO' => 'AS', 
            'LISTO' => 'LS',
            'FACTURADO' => 'FTR',
            'REVERSADO' => 'RVR',
            'ANULADO' => 'NULL'
        ];
        foreach($status as $clave => $valor)
        {
            \DB::table('estatus')->insert([
                'nombre_estatus' => $clave,
                'codigo_estatus' => $valor,
                'edo_reg' => ($clave == 'NULL') ? 0 : 1,
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
        Schema::drop('estatus');
    }
}
