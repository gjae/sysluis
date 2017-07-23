<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = "tipo_servicios";

    protected $fillable =[ 'denominacion' ];


    public function servicio()
    {
    	return $this->hasMany('App\Servicios');
    }

    public function solicitudes()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\servicios\modelos\Solicitud', 'tipo_id');
    }
}
