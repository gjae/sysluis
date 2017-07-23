<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_hardware', 160);
            $table->string('codigo_hardware', 160);
            $table->float('precio')->default('0.00');
            $table->timestamps();
            $table->tinyInteger('edo_reg')->default(1);
            $table->string('imagen', 70)->nullable();
            $table->integer('categoria_id')->unsigned();

            $table->foreign('categoria_id')->references('id')
                    ->on('categorias')->onDelete('cascade');
        });

        \DB::table('hardware')->insert([
            'nombre_hardware' => '------',
            'categoria_id' => 1,
            'edo_reg' => 0,
            'codigo_hardware' => '----',
            'precio' => 0.00,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hardware');
    }
}
