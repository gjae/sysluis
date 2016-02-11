<?php

namespace App\Http\Controllers\Modulos\servicios\modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = ['tipo_id', 'cliente_id', 'codigo_solicitud', 'detalles', 'precio', 'abono', 'iva', 'total', 'categoria_id'];


    public function tipo()
    {
    	return $this->belongsTo('App\TipoServicio', 'tipo_id');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function servicio()
    {
        return $this->hasOne('App\Servicio');
    }

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

    public function setCreatedAtAttribute($value){
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function pagos(){
        return $this->hasMany('App\RegistroPago');
    }

    /**
    *   RUTINA PARA ASIGNACIÓN DE UN CODIGO DE SOLICITUD UNICO
    *   EL CODIGO ES UNA SECUENCIA QUE SIGUE EL ULTIMO NUMERO DE
    *   SOLICITUDES EN EL MES, ES DECIR, HACE UNA CUENTA DE CUANTAS
    *   SOLICITUDES HAY EN EL MES DE ESE AÑO Y LE SUMA 1, LUEGO
    *   EL CODIGO SE COMPONE DE AÑOMES-CONSECUTIVO
    */

    public function setCodigoSolicitudAttribute($value)
    {
        $terminal = \DB::table('solicitudes')
            ->select(\DB::raw("count(codigo_solicitud) as code  ") )
            ->where('codigo_solicitud', 'LIKE', Carbon::now()->format('Y-m').'%' );

        $terminal = $terminal +1;
        $now = Carbon::now();

    	$this->attributes['codigo_solicitud'] = $now->year.'0'.$now->month.'-0'.$ultimos_digitos;
    }

    public function getIdAttribute($value)
    {
        if($value < 10) $value = '00000'.$value;
        elseif($value < 100) $value = '0000'.$value;
        elseif($value < 1000) $value = '000'.$value;
        elseif($value < 10000) $value = '00'.$value;
        elseif($value < 100000) $value = '0'.$value;

        return $value; 
    }

    private static function getCodigo()
    {
    	return self::where('edo_reg', 1)->count() + 1; 
    }

    public function asignacion()
    {
        return $this->hasOne('App\Asignacion');
    }

    public function estatus()
    {
        return $this->belongsTo('App\Estatus');
    }
}
