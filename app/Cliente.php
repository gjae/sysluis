<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";
    protected $fillable = ['persona_id'];

    public function persona()
    {
    	return $this->belongsTo('App\Persona');
    }


    public function servicios()
    {
    	return $this->hasMany('App\Servicios');
    }

    public function solicitudes()
    {
        return $this->hasMany('App\Http\Controllers\Modulos\servicios\modelos\Solicitud');
    }
}
