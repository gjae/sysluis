<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('razon_salida_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->integer('antes_egreso')->default(0);
            $table->integer('despues_egreso')->default(0);
            $table->float('monto_egreso')->default(0.00);
            $table->tinyInteger('edo_reg')->default(1);
            $table->integer('cantidad_egresada')->default(0);

            $table->foreign('stock_id')
                    ->references('id')
                    ->on('stock')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('egresos');
    }
}
