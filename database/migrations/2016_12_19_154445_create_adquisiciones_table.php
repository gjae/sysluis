<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdquisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adquisiciones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('numero_factura', 155)->default('00000');
            $table->integer('cantidad')->default(0);
            $table->integer('stock_id')->unsigned();
            $table->tinyInteger('edo_reg')->default(1);
            $table->float('precio_unitario')->default(0);
            $table->float('iva')->default(0.00);
            $table->float('total')->default(0.00);

            $table->index('numero_factura');
            $table->foreign('stock_id')
                    ->references('id')->on('stock')
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
        Schema::drop('adquisiciones');
    }
}
