<?php

namespace App\Http\Controllers\Modulos\inventario\Modelos;

use Illuminate\Database\Eloquent\Model;

class Adquisicion extends Model
{
    protected $table = 'adquisiciones';
    protected $fillable = [
    	'numero_factura', 'cantidad', 'precio_unitario', 'stock_id', 'iva', 'total', 
    ];


    public function stock(){
    	return $this->belongsTo('App\Stock');
    }

    /**
    *	FUNCION PARA CALCULAR EL TOTAL DE LA COMPRA O ADQUISICION
    *	CALCULA EL TOTAL CON EL IVA A PARTIR DE LA CANTIDAD DE UNIDADES ADQUIRIDAS
    *	Y EL PORCENTAJE DE IVA INGRESADOS
    */

}
