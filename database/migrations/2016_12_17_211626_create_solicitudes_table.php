<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('estatus_id')->unsigned()->default(2);

            $table->string('codigo_solicitud', '130')->unique();

            $table->float('precio')->default(0.00);
            $table->float('abono')->default(0.00);
            $table->float('iva')->default(0.00);
            $table->float('total')->default(0.00);
            
            $table->integer('categoria_id')->unsigned();
            $table->text('detalles');
            
            $table->tinyInteger('edo_reg')->default(1);
            $table->integer('cliente_id')->unsigned(); 

            $table->integer('tipo_id')->unsigned();

            $table->foreign('cliente_id')->references('id')
                    ->on('clientes')->onDelete('CASCADE')->onUpdate('CASCADE');

             $table->foreign('tipo_id')->references('id')
                    ->on('tipo_servicios')->onDelete('CASCADE')->onUpdate('CASCADE');
                    
            $table->foreign('estatus_id')->references('id')
                    ->on('estatus')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->foreign('categoria_id')->references('id')
                    ->on('categorias')->onDelete('cascade')->onUpdate('cascade');
        });

        \DB::table('solicitudes')->insert([
            'estatus_id' => 1,
            'codigo_solicitud' => '00000-00',
            'detalles' => 'SOLICITUD POR DEFECTO',
            'edo_reg' => 0,
            'cliente_id' => 1,
            'tipo_id' =>1,
            'categoria_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitudes');
    }
}
