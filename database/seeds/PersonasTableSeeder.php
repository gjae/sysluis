<?php

use Illuminate\Database\Seeder;


class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $generos = ['Male', 'FeMale'];

        for($i = 0; $i< 130; $i++)
        {
        	App\Persona::create([
        		'nombres' => call_user_func_array([$faker, 'firstName'.$generos[array_rand($generos)]], []),
        		'apellidos' => $faker->lastName,
        		'email' => $faker->unique()->email,
        		'direccion' => $faker->address,
        		'cedula' => $faker->unique()->ean8,
        		'telefono_personal' => 'No aplica',
        		'telefono_habitacion' => 'No aplica',
        	])->cliente()->save( new App\Cliente([]));
        }
    }
}
