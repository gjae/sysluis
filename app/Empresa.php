<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable = [
    	'nombre', 'rif', 'direccion', 'actividad', 'logo', 'personalidad'
    ];
}
