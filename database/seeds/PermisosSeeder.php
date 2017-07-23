<?php

use Illuminate\Database\Seeder;
use App\Permiso;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permiso::create([
        	'nombre_permiso' => 'CREATE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);

        Permiso::create([
        	'nombre_permiso' => 'DELETE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);


        Permiso::create([
        	'nombre_permiso' => 'UPDATE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);


        Permiso::create([
        	'nombre_permiso' => 'SEARCH',
        	'descripcion_permiso' => 'Crear un registro'
        ]);
    }
}
