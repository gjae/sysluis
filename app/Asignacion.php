<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = ['id_emp_to', 'id_emp_from', 'solicitud_id'];


    public static function getAsignaciones($empleado_id = 0)
    {
    	$asigs = \DB::table('personas')->where([
    			['empleados.edo_reg', 1],
    			['asignaciones.edo_reg', 1],
    			['solicitudes.edo_reg', 1],
    		])
    		->join('empleados', 'empleados.persona_id', '=','personas.id')
    		->join('users', 'users.empleado_id','=', 'empleados.id')
    		->join('asignaciones', 'asignaciones.id_emp_from', '=', 'empleados.id')
    		->join('solicitudes', 'asignaciones.solicitud_id', '=', 'solicitudes.id')
    		->join('estatus', 'solicitudes.estatus_id', '=', 'estatus.id')
    		->select(\DB::raw('count(asignaciones.id) as asignaciones, estatus.nombre_estatus, estatus.codigo_estatus'))
    		->groupBy('estatus.nombre_estatus', 'estatus.codigo_estatus');

    	if($empleado_id != 0)
    		$asigs->where('empleados.id', $empleado_id);

    	return $asigs->get();
    }

    public function asignaciones()
    {
        return $this->belongsTo('App\Empleado');
    }

    public function asignar()
    {
        return $this->belongsTo('App\Empleado');
    }

    public function solicitud()
    {
        return $this->belongsTo('App\Http\Controllers\Modulos\servicios\modelos\Solicitud');
    }

}
