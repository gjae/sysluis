<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{

	protected $table = 'registro_pago';
	protected $fillable = [
		'nro_transaccion', 
		'observacion', 
		'solicitud_id', 
		'monto',
		'fecha_exp_tarjeta',
		'persona_id',
		'numero_tarjeta' 
	]; 


	public function persona(){
		return $this->belongsTo('App\Persona');
	}

	public function solicitud(){

		return $this->belongsTo('App\Solicitud');

	}
}
