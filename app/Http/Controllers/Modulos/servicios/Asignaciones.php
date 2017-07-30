<?php

namespace App\Http\Controllers\Modulos\servicios;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;
use App\User;
use App\Categoria;
use App\Http\Controllers\Modulos\servicios\modelos\Solicitud;
use App\Empleado;
use App\Asignacion;
use App\LogProblemas;

class Asignaciones extends Controller
{

    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->modulo_id = $id;
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    }

    public function index(Request $request, $i='')
    { 
    	$empleado_id =  Auth::user()->empleado->id;
    	$asignaciones = Asignacion::where('id_emp_to', '=', $empleado_id)
    						->join('solicitudes', 'solicitudes.id', '=', 'asignaciones.solicitud_id')
    						->where('solicitudes.estatus_id', '=',3)->select('asignaciones.*')->get();
    	$datos = [
    		'modulos' => $this->mods,
    		'asignaciones' => $asignaciones,
    	];
    	return view('intranet.servicios.asignaciones', $datos);
    }

    /**
    * CARGA LOS DETALLES DE UNA DETERMINADA SOLICITUD (PASADA ATRAVEZ DE LA URL)
    */
    public function detalles(Request $request, $id)
    {
    	$asignacion = Asignacion::where('id', '=', $id)
    					->first();

    	$data = [
    		'asignacion' => $asignacion,
    		'estatus' => \App\Estatus::where('edo_reg',1)->get(),
    		'solicitud' => $asignacion->solicitud,
    		'estatus' => \App\Estatus::where('edo_reg',1)->get(),
    	];
    	$vista = \View::make('intranet.servicios.formularios.detalle_asignacion', $data)
    				->render();
    	$response = [
    		'error' => false,
    		'formulario' => $vista,
    	];
    	return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
    *	SE ENCARGA DE RUTEAR LA ACCION ENVIADA DEL FORMULARIO DE LOS DETALLES
    *	LOS FORMULARIOS POSEEN UN CAMPO OCULTO LLAMADO ACCION
    *	QUE SE USA PARA QUE ESTA FUNCION RUTEE Y SE CUMPLA
    *	EÑ OBJETIVO DEL FORMULARIO DESPLEGADO
    */
    public function guardarCambios(Request $request, $i='')
    {
    	return call_user_func_array([$this, $request->accion], [$request]);
    }

    /**
    *	FUNCION ENCARGADA DE EJECUTAR ACTUALIZACIONES SOBRE UNA
    *	DETERMINADA SOLICITUD Y SU RESPECTIVA ASIGNACION
    *	IMPLEMENTA TRANSACCIONES EN CASO DE QUE SE PRODUZCA
    *	ALGUN ERROR EN EL PROCESO
    */
    private function actualizar($request)
    {	
    	$response = [];
    	$solicitud = Solicitud::where('id', $request->solicitud_id)
	    				->first();
    	\DB::beginTransaction();
    	try {
	    	// SI NO EXISTE LAS SOLICITUD CORRESPONDIENTE AL ID PASADO
	    	//ENTONCES SE LANZA UNA EXCEPCION
	    	if(! $solicitud)
	    		throw new \Exception('No se ha encontrado solicitud');

	    	if(\App\Permiso::check_permisos('UPDATE', Auth::user()->id, $this->modulo_id))
	    	{
	    		$solicitud->estatus_id = $request->estatus_id;
	    		$solicitud->detalles = $request->detalles;
	    		$solicitud->save();

                
                if($request->titulo_log != ""){
                    LogProblemas::create([
                        'created_at' => $request->created_at,
                        'titulo' => $request->titulo_log,
                        'detalles' => $request->detalles_log,
                        'user_id' => Auth::user()->id,
                        'asignacion_id' => $solicitud->asignacion->id
                    ]);
                }
	    	}

	    	else throw new \Exception('No posee permisos para realizar esta accion');

	    	$response = [
	    		'error' => false,
	    		'mensaje' => 'El proceso se ha realizado de manera exitosa',
	    		'estatus' => 'PROCESO EXITOSO',
	    	];
	    	\DB::commit();    		
    	} catch (Exception $e) {

    		$response =[
    			'error' => true,
    			'mensaje' => 'Ha ocurrido un error: '.$e->getMessage(),
    			'estatus' => 'PROCESO FALLIDO POR '.$e->getMessage(),
    		];
    		\DB::rollback();
    	}
    	finally{
    		$accion = 'EL USUARIO HA EJECUTADO UN '.$response['estatus'].' DE ACTUALIZACION DE LA SOLICITUD '.$solicitud->codigo_solicitud;
    		\App\Auditoria::auditoria($accion, $this->modulo_id, Auth::user()->id);
    		return response($response, 200)->header('Content-Type', 'application/json');
    	}

    }
}
