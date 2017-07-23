<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('cliente_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('tipo_servicio_id')->unsigned();
            $table->integer('modalidad_pago_id')->unsigned();
            $table->text('concepto')->nullable();
            $table->string('codigo_pago', 150)->nullable();
            
            $table->float('iva')->default(0.00);
            $table->float('subtotal')->default(0.00);
            $table->float('total')->default(0.00);
            $table->float('dinero_recibido')->default(0.00);
            $table->float('cambio')->default(0.00);
           
            $table->integer('solicitud_id')->unsigned()->default(1);
            $table->tinyInteger('edo_reg')->default(1);

            /*
            * INDEX FOREIGN
             */
            
            $table->foreign('cliente_id')
                    ->references('id')
                    ->on('clientes')->onDelete('cascade');

            $table->foreign('empleado_id')
                    ->references('id')
                    ->on('empleados')->onDelete('cascade');

            $table->foreign('tipo_servicio_id')
                    ->references('id')
                    ->on('tipo_servicios');

            $table->foreign('solicitud_id')->references('id')
                    ->on('solicitudes')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->foreign('modalidad_pago_id')->references('id')
                    ->on('modalidad_pago')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('servicios');
    }
}
