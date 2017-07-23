<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
   protected $table = "personas";

   protected $fillable = [
   		'nombres', 'apellidos', 'email', 'direccion', 
   		'cedula', 'telefono_personal', 'telefono_habitacion'
   ];

   public function empleado()
   {
   		return $this->hasOne('App\Empleado');
   }

   public function cliente()
   {
   		return $this->hasOne('App\Cliente');
   }

   public function proveedor()
   {
      return $this->hasOne('App\Proveedor');
   }

   public function pagos(){

      return $this->hasMany('App\RegistroPago');
   }

}
