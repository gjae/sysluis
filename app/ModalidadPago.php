<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModalidadPago extends Model
{
    protected $table = "modalidad_pago";
    protected $fillable = [
    	'nombre_modalidad', 'codigo_modalidad'
    ];


    public function servicios()
    {
    	return $this->hasMany('App\Servicios');
    }
}
