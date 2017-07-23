<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModalidadPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modalidad_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre_modalidad', 150)->default('---');
            $table->string('codigo_modalidad', 7)->unnique();


            $table->index('codigo_modalidad');
        });

        $modos = [
            'EFECTIVO' => 'EFT',
            'T. ELECTRONICA' => 'TDC',
            'CHEQUE' => 'CHQ',
            'OTROS' => 'OTR'
        ];

        foreach($modos as $nombre => $codigo)
        {
            \DB::table('modalidad_pago')
                ->insert(['nombre_modalidad' => $nombre, 'codigo_modalidad' => $codigo]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('modalidad_pago');
    }
}
