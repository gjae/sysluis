<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persona;
use App\Empleado;
use App\User;
use App\Permiso;
use App\Modulo;
use DB;

class ModPerUser extends Model
{
    protected $table = "modulos_permisos_users";

    protected $fillable = ['modulo_id', 'permiso_id', 'user_id'];

    public function permiso()
    {
    	return $this->belongsTo('App\Permiso');
    }

    public function modulo()
    {
    	return $this->belongsTo('App\Modulo');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static function getModulos($userid = 0)
    {
        $mods = DB::table('personas')->where('users.id', $userid)
                    ->where('personas.edo_reg', 1)
                    ->join('empleados', 'empleados.persona_id', '=', 'personas.id')
                    ->join('users', 'empleados.id', '=', 'users.empleado_id')
                    ->join('modulos_permisos_users', 'modulos_permisos_users.user_id', '=', 'users.id')
                    ->join('modulos', 'modulos.id', '=', 'modulos_permisos_users.modulo_id')
                    ->select('modulos.*')->distinct();

        return $mods->get();
    }
}
