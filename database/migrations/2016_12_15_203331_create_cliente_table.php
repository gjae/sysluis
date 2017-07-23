<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('persona_id')->unsigned();
            $table->tinyInteger('edo_reg')->default(1);
            $table->timestamps();

            /**
             * constrainst
             */
            
            $table->foreign('persona_id')
                    ->references('id')
                    ->on('personas')
                    ->onDelete('cascade');
        });

        \DB::table('clientes')->insert([
            'persona_id' => 1,
            'edo_reg' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientes');
    }
}
