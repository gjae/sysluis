<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->tinyInteger('edo_reg')->default(1);
            $table->string('nombre_programa', 50);
            $table->string('url_programa', 100);
            $table->text('descripcion_programa')->nullable();
            $table->integer('modulo_id')->unsigned();

            $table->foreign('modulo_id')->references('id')
                    ->on('modulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programas');
    }
}
