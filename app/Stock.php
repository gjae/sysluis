<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $fillable = [
    	'hardware_id', 'stock', 
    ];

    public function hardware()
    {
    	return $this->belongsTo('App\Hardware');
    }

    public function adquisiciones()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\inventario\Modelos\Adquisicion');
    }

    public function egresos()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\inventario\Modelos\Egreso');
    }
}
