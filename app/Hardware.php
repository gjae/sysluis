<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table = "hardware";
    protected $fillable = [
    	'nombre_hardware', 'codigo_hardware', 'precio', 'categoria_id', 'imagen'
    ];

    public function stock()
    {
    	return $this->hasOne('App\Stock');
    }

    public function categoria()
    {
    	return $this->belongsTo('App\Categoria');
    }

    public function setCodigoHardwareAttribute($value)
    {
        $this->attributes['codigo_hardware'] = strtoupper(trim($value));
    }

    public function setNombreHardwareAttribute($value)
    {
        $this->attributes['nombre_hardware'] = trim($value);
    }

    public function getImagenAttribute($value){
        return asset('img/uploaders/'.$value);
    }

    public function detalle_servicio(){
        return $this->hasMany('App\DetalleServicio');
    }
    
    public static function hardwaresVendidosPorId($hardware_id){
        $cuenta = \DB::table('detalles_servicios')->where([
            ['hardware_id', $hardware_id],
            ['activo', 1],
        ])->select(\DB::raw('count(hardware_id) as vendidos'))->get();

        return $cuenta[0]->vendidos;
    }
}
