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
use App\Servicios;
use App\Asignacion;
use App\ModalidadPago;
use App\Empresa;

use PDF;

class Facturar extends Controller
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
   		$solicitudes = Solicitud::where('estatus_id', 4)
   						->where('edo_reg', 1)
   						->get();

   		return view('intranet.servicios.facturar', ['modulos' => $this->mods, 'solicitudes' => $solicitudes]);
   	}

   	public function accion(Request $request, $accion='')
   	{	$pass = [
   			$this,
   			($accion!='')? $accion : $request->accion,
   		];
   		return call_user_func_array($pass, [$request, ]);
   	}

   	public function detalles($request)
   	{
   		$solicitud = Solicitud::where('id', $request->_id)->first();

        // return dd($solicitud->total);
   		$formulario = \View::make('intranet.servicios.formularios.detalles_factura', [
            'solicitud' => $solicitud,
            'modalidades' => ModalidadPago::all(),
         ])->render();

   		$response = [
   			'error' => false,
   			'mensaje' => '',
   			'formulario' => $formulario,
   		];
   		return response($response, 200)
   				->header('Content-Type', 'application/json');
   	}

   	public function facturar(Request $request, $i='')
   	{
   		$response = [];
   		\DB::beginTransaction();
   		try{

   			$factura = new Servicios( $request->all() );
   			$solicitud = Solicitud::where('id', $request->solicitud_id)
   									->first();
   			if( $solicitud )
   			{
   				$solicitud->estatus_id = 5;
               $factura->solicitud_id = $request->solicitud_id;
   				if( $factura->save() && $solicitud->save() )
   					$response = [
   						'error' => false,
   						'mensaje' => 'Se ha guardado esta factura correctamente #'.$factura->id,
   						'estatus' => 'OPERACION EXITOSA',
                     'id' => $factura->id,
   					];
   				else
   					throw new \Exception('Ha ocurrido un error inesperado al guardar la factura o actualizar el estatus de la solicitud');
   			}
   			else
   				throw new \Exception('Problemas ubicando la solicitud '.$solicitud->codigo_solicitud);
   			
   			\DB::commit();
   		}
   		catch(\Exception $e){
   			\DB::rollback();
   			$response = [
   				'error' => true,
   				'mensaje' => 'HA OCURRIDO UN ERROR: '.$e->getMessage(),
   				'estatus' => 'OPERACION FALLIDA'
   			];
   		}
   		finally{
   			return response($response, 200)
   					->header('Content-Type', 'application/json');
   		}
   	}

      public function factura(Request $request, $id)
      {

         $data = [
            'empresa' => Empresa::first(),
            'factura' => Servicios::find($id),
            'modo_pago' => ModalidadPago::all(),
         ];

         $vista = \View::make('intranet.servicios.reportes.facturacion', $data)->render();

         $pdf = PDF::loadHtml($vista);
         //return $vista;
         return $pdf->stream('invoice', ['attachment' => 1]);
      }
}
