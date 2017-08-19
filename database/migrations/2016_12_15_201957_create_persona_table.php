<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nombres', 250);
            $table->string('apellidos', 250);
            $table->string('email');
            $table->text('direccion');
            $table->string('cedula', 20);
            $table->enum('tipo_persona', ['N', 'J'])->default('N');
            $table->string('telefono_personal');
            $table->string('telefono_habitacion');
            $table->tinyInteger('edo_reg')->default(1);
        });

        \DB::table('personas')->insert([
            'edo_reg' => 0,
            'nombres' => 'REGISTRO POR DEFECTO',
            'apellidos' => '---------',
            'email' => '-----------------',
            'direccion' => '------------------------',
            'cedula' => '000000000',
            'telefono_personal' => '-------',
            'telefono_habitacion' => '---------',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('personas');
    }
}
