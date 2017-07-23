<?php

namespace  App\Http\Controllers\Modulos\inventario\Modelos;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';

    protected $fillable = [
    	'razon_salida_id', 'stock_id', 'antes_egreso', 'despues_egreso', 'monto_egreso', 'cantidad_egresada'
    ];

    //FUNCIONES PARA FILTRADO DE DATOS


    //FUNCIONES PARA RELACIONES CON OTROS MODELOS

    public function razon_egreso()
    {
    	return $this->belongsTo('App\Http\Modulos\inventario\Modelos\RazonEgreso');
    }

    public function stock()
    {
    	return $this->belongsTo('App\Stock');
    }
}
