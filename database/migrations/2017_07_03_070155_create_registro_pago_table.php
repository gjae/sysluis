<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nro_transaccion', 25)->nullable();

            $table->text('observacion')->nullable();

            $table->integer('solicitud_id')->unsigned();
            
            $table->float('monto')->default(0.0);
            $table->string('numero_tarjeta')->nullable();
            $table->date('fecha_exp_tarjeta')->nullable();
            $table->integer('persona_id')->unsigned();

            $table->foreign('persona_id')->references('id')
                    ->on('personas')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->foreign('solicitud_id')->references('id')
                    ->on('solicitudes')->onDelete('CASCADE')->onUpdate('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registro_pago');
    }
}
