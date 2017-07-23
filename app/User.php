<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $usuario ="usuario";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'empleado_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    public function permisos()
    {
        return $this->hasMany('App\ModPerUser');
    }

    public function auditorias()
    {
        return $this->hasMany('App\Auditoria');
    }

    public function logProblemas(){
        return $this->hasMany('App\LogProblemas');
    }

}
