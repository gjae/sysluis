<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre_categoria'];

    public function hardwares()
    {
    	return $this->hasMany('App\Hardware');
    }

    public function solicitudes(){
    	return $this->hasMany('App\Http\Controllers\Modulos\servicios\modelos\Solicitud');
    }
}
