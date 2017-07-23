<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogProblemas extends Model
{
    protected $table = 'log_problemas';
    protected $fillable = [
    	'created_at', 'titulo', 'detalles', 'asignacion_id', 'user_id'
    ];


    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function asignacion(){
    	return $this->belongsTo('App\Asignacion');
    }
}
