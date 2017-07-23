<?php

namespace App\Http\Controllers\Modulos\servicios\modelos;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitud extends Model
{
    protected $table = "detalle_solicitudes";
    protected $fillable = [ 'solicitud_id' , 'hardware_id' ];

    
}
