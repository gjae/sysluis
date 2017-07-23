<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    protected $table = 'estatus';
    protected $fillable = [
    	'nombre_estatus', 'codigo_estatus', 
    ];

    public function solicitudes()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\servicios\modelos\Estatus');
    }
}
