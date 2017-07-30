<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';
    protected $fillable = ['accion', 'user_id', 'modulo_id'];


    //FUNCIONES PARA RELACIONES DE MODELOS

    public function modulo()
    {
    	return $this->belongsTo('App\Modulo');
    }

    public function usuario()
    {
    	return $this->belongsTo('App\User');
    }
    
    public static function auditoria($accion, $modulo_id, $user_id){
        App\Auditoria::create([
            'accion' => strtoupper( trim($accion) ),
            'modulo_id' => $modulo_id,
            'user_id' => $user_id,
        ]);
    }
}
