<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = "servicios";

    protected $fillable =[
    	'empleado_id', 'tipo_servicio_id', 'servicio_id' ,'iva', 'subtotal', 'total', 'dinero_recibido',
    	'cambio', 'cliente_id', 'concepto', 'modalidad_pago_id', 'codigo_pago',
    ];


    public function detalle_servicio()
    {
    	return $this->hasMany('App\DetalleServicio');
    }

 	public function empleado()
 	{
 		return $this->belongsTo('App\Empleado');
 	}

 	public function tipo_servicio()
 	{
 		return $this->belongsTo('App\TipoServicio');
 	}

 	public function cliente()
 	{
 		return $this->belongsTo('App\Cliente');
 	}

 	public function solicitud()
 	{
 		return $this->belongsTo('App\Http\Controllers\Modulos\servicios\modelos\Solicitud');
 	}


 	public function modalidad_pago()
 	{
 		return $this->belongsTo('App\ModalidadPago');
 	}

 	/**
 	 * FUNCIONES DE TIPO GETTERS Y SETTERS
 	 */
 	
 	public function getIdAttribute($value)
 	{
 		if($value < 10)
 			return '0000000'.$value;
 		else if($value < 100)
 			return '000000'.$value;
 		else if($value < 1000)
 			return '00000'.$value;
 		else if($value < 10000)
 			return '0000'.$value;
 		else if($value < 100000)
 			return '0000'.$value;
 	}	

}
