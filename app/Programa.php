<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = "programas";

    protected $fillable = ['nombre_programa', 'url_programa', 'descripcion_programa', 'modulo_id'];

    public function modulo()
    {
    	return $this->belongsTo('App\Modulo');
    }
}
