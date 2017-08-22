<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depositos extends Model
{
    protected $table = 'depositos';
    protected $fillable = ['imagen_deposito', 'servicio_id', 'numero_transaccion'];


    public function servicio(){
    	return $this->belongsTo('App\Servicios');
    }
}
