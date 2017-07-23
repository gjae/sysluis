<?php

namespace App\Http\Controllers\Modulos\inventario\Modelos;

use Illuminate\Database\Eloquent\Model;

class RazonEgreso extends Model
{
    protected $table = 'razones_salidas';
    protected $fillable = [
    	'descripcion_razon', 'codigo_razon', 'explicacion_razon'
    ];



    //FUNCIONES PARA FILTRAR LOS DATOS
    public function setCodigoRazonAttribute($value)
    {
    	$this->attributes['codigo_razon'] = str_replace('.', '', strtoupper( trim($value) ) );
    }

    public function setDescripcionRazonAttribute($value)
    {
    	$this->attributes['descripcion_razon'] = str_replace('.', '',strtoupper( trim($value) ) );
    }

    public function setExplicacionRazonAttribute($value)
    {
    	$this->attributes['explicacion_razon'] = str_replace('.', '',strtoupper( trim($value) ) );
    }

    //FUNCIONES PARA RELACIONAR MODELOS

    public function egresos()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\inventario\Modelos\Egreso');
    }

}
