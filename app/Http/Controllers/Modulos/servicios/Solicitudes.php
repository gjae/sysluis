<?php

namespace App\Http\Controllers\Modulos\servicios;


/**
*   CLASE PARA LA GESTION DE SOLICITUDES 
*   DE SERVICIOS
*   CONTIENE LA LOGICA NECESARIA PARA LA GESTION
*   DE LAS SOLICITUDES DE SERVICIOS
*/
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
use App\TipoServicio;
class Solicitudes extends Controller
{
    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->modulo_id = $id;
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    }

    /**
    *   VISTA DEL INDICE DONDE ESTA EL FORMULARIO
   */ 
    public function index(Request $request, $id)
    {
        $solicitudes = Solicitud::where('edo_reg', 1)
                            ->Where('estatus_id', 2)->get();

    	return view('intranet.servicios.servicios', ['modulos' => $this->mods, 'solicitudes' =>$solicitudes]);
    }

    /**
    *   CARGA LA VENTANA DE LOS EMPLEADOS A LOS
    *   QUE SE LE PUEDE ASIGNAR UNA SOLICITUD
    */
    public function cargar_empleados(Request $request, $id)
    {
        $empleados = Empleado::where('edo_reg', 1)->get();

        $select = view()->make('intranet.servicios.formularios.asignar',[
            'empleados' => $empleados,
            'solicitud_id' => $id,
        ])->render();

        return json_encode(['fail' => false, 'formulario' => $select]);
    }
    
    public function formulario($request,$form)
    {
        if(true)
        {   
            $form = view()->make('intranet.formularios.'.$form, [
                    'categorias' => Categoria::where('edo_reg',1)->get(),
                    'tiposervicio' => TipoServicio::all()
            ])->render();
            //$form = formularios($request, $form);
        }
        else return redirect()->to('/dashboard/usuarios');

        return response(['fail' => false, 'formulario'=>$form], 200)
                ->header('Content-Type', 'application/json');
    }
    /**
    *   FUNCIÓN PARA ASIGNAR UNA SOLICITUD A UN EMPLEADO
    *   CREA UNA NUEVA ASIGNACIÓN Y HACE UN
    *   UPDATE DE ESA SOLICITUD A UN ESTATUS DE ASIGNADO
    */
    public function asignar(Request $request, $id)
    {
        $sol = Asignacion::where('solicitud_id', $request->solicitud_id)->first();
        if( !$sol )
        {
            $solicitud = new Asignacion([
                'id_emp_to' => $request->empleado_id,
                'id_emp_from' => Auth::user()->empleado->id,
                'solicitud_id' => $request->solicitud_id,
            ]);

            if($solicitud->save())
            {
                $solicitud = Solicitud::where('id', '=', $request->solicitud_id)
                            ->first();

                $solicitud->precio = $request->precio;
                $solicitud->abono = $request->abono;
                $solicitud->iva = $request->iva;
                $solicitud->total = $request->total;
                $solicitud->estatus_id = 3;
                $solicitud->save();

            }
        }
        else
        {
            if( $sol->id_emp_to != $request->empleado_id )
                $sol->id_emp_to = $request->empleado_id;
            $sol->solicitud->estatus_id = 3;
            $sol->solicitud->save();
        }
        return ['fail'=> false, 'mensaje' => 'Se ha guardado la asignación de manera exitosa'];
    }
}
