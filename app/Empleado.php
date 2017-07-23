<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persona;

class Empleado extends Model
{
    protected $table = "empleados";

    protected $fillable = ['fecha_inactividad'];

    private $persona;

    /**
     * RELACIONES - TIENE
     */
    
    public function user()
    {
    	return $this->hasOne('App\User');
    }

    /**
     * RELACIONES - PERTENECE
     */

    public function persona()
    {
    	return $this->belongsTo('App\Persona');
    }

    public function servicios()
    {
        return $this->hasMany('App\Servicios');
    }

    /**
     * asignar trabajos a un empleado
     * @return Model
     */
    public function asignar()
    {
        return $this->hasMany('App\Asignacion', 'id_emp_from');
    }

    /**
     * ver asignaciones
     * @return Model
     */
    public function asignaciones()
    {
        return $this->hasMany('App\Asignacion', 'id_emp_to');
    }
   
}
