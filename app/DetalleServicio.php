<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleServicio extends Model
{
    protected $table = 'detalles_servicios';

    protected $fillable =[
    'servicio_id', 'hardware_id', 'precio_hardware'
    ];

    public function servicio()
    {
    	return $this->belongsTo('App\Servicios');
    }

    public function hardware(){
        return $this->belongsTo('App\Hardware');
    }

    public static function getDetalleServicioOn($servicio_id)
    {
    	$query = DB::table('tipo_servicios')
    				->join('servicios', 'tipo_servicios.id', '=', 'servicios.tipo_servicio_id')

    				->join('detalles_servicios', 'detalles_servicios.servicios_id', '=', 'servicios.id')
    				->join('hardware', 'detalles_servicios.hardware_id', '=', 'hardware.id')
    				->select(DB::raw('count(detalles_servicios.hardware_id) as comprados, sum(detalles_servicios.precio_hardware) as suma, hardware.nombre_hardware, hardware.precio'))
    				->where('servicios.id', $servicio_id)
    				->groupBy('hardware.nombre_hardware', 'hardware.precio')
    				->get();

    	return $query;
    }
}
