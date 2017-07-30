<?php

namespace App\Http\Controllers\Modulos\facturacion;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
#------------- MODELOS ---------------
use App\Persona;
use App\Empleado;
use App\User;
use App\ModPerUser as modulos;
use App\Hardware;
use App\Cliente;
use App\Servicios;
use App\TipoServicio;
use App\DetalleServicio;
use App\ModalidadPago;
use App\Empresa;

use PDF;
use DNS1D;

use Carbon\Carbon;


class Facturacion extends Controller
{
	private $mods;
  private $modulo_id;
	
	public function __construct($id)
	{
		$this->mods = modulos::getModulos(Auth::user()->id);
    $this->modulo_id = $id;
	}
   
   public function index(Request $request, $id)
   {
    	return view('intranet.facturacion.facturacion', [
        'modulos' => $this->mods,
        'formas_pagos' =>  ModalidadPago::all(),
        ]);
   }

   public function crearCliente(Request $request, $id='')
   {
      $datos = $request->except(['_token']);
      $persona = new Persona($datos);
      if($persona->save())
      {
         if($persona->cliente()->save( new Cliente([])))
         {
            return json_encode(array('fail' => false)); 
         }
      }
      return json_encode(array('fail' => true, 'mensaje_error' => 'Ha ocurrido un error registrando al cliente, verifique que los datos esten correctamente llenados'));
   }

   /**
    * verificarCliente
    * COMO EL NOMBRE LO DICE: VERIFICA LOS DATOS DE UN CLIENTE
    * MEDIANTE LA CEDULA (ULTIMO DE LOS ARGUMENTOS/PARAMETROS )
    */

   public function verificarCliente(Request $request, $cedula=""){

      $persona = Persona::where('cedula', $cedula)->get();
      
      if(empty($persona[0])) return json_encode(['fail' =>true, 'persona' => 'No existe']);
      if($persona[0]->cliente == null ) $persona->cliente()->save( new Cliente);

      $datos['nombres'] = $persona[0]->nombres;
      $datos['cliente_id'] = $persona[0]->cliente->id;
      $datos['persona_id'] = $persona[0]->id;
      $datos['fail'] = false;
      return json_encode($datos);
   }

   /**
    * verificarCodigo
    * IDENTICA A LA FUNCION verificarCliente A DIFERENCIA DE QUE 
    * ESTA FUNCION BUSCA UN HARDWARE POR SU CODIGO
    */

   public function verificarCodigo(Request $request, $codigo)
   {
      $hardware = Hardware::where('codigo_hardware', strtoupper( trim($codigo) ))->get()->toJson();

      return $hardware;
   }

   public function factura(Request $request, $id)
   {
      if(\App\Permiso::check_permisos('CREATE', Auth::user()->id, $this->modulo_id))
      {
     		$data = $request->all();

        //DENTRO DE LA VISTA DEL MODULO DE FACTURACION HAY UN CAMPO
        //OCULTO LLAMADO persona_id EL CUAL SE LLENA DINAMICAMENTE
        //CUANDO SE BUSCA LA CEDULA DEL CLIENTE
        $persona = Persona::find($data['persona_id']);

        /**
         * TODOS LOS CONTROLES DEL SISTEMA SE LLEVAN MEDIANTE UN SERVICIO
         * PRIMERO SE CREA UN REGISTRO EN LA TABLA SERVICIO QUE SERA EL QUE 
         * TENGA LA INFORMACION PRINCIPAL DE LA FACUTRA
         * (TOTAL, SUBTOTAL, IVA, ETC)
         */

     		$data['total'] = 0;
        $servicio = Servicios::create( [
          'tipo_servicio_id'=>1, 
          'empleado_id' => Auth::user()->empleado->id,
          'cliente_id' => $data['cliente_id'],
          'modalidad_pago_id' => $request->modalidad_pago_id
        ] );
        $ds = [];
        $iva = 0;
     		for($i = 0; $i<count($data['cantidad']); $i++)
        {
     			$data['total'] += $data['cantidad'][$i] * $data['precio'][$i];
          $iva += $data['cantidad'][$i] * ($data['precio'][$i]* env('IVA', 0.12) );
          $ds[$i] = new DetalleServicio([
            'hardware_id' => $data['hardware_id'][$i],
            'precio_hardware' => $data['precio'][$i]
          ]);
        }

     		$servicio->iva = $iva;
     		$servicio->subtotal =  $data['total'];
     		$servicio->total = $servicio->subtotal + $servicio->iva;

        if($servicio->save()) $servicio->detalle_servicio()->saveMany($ds);


        //$detser = DetalleServicio::getDetalleServicioOn($servicio->id);
    
        /**
         * SI TODO EL PROCEDIMIENTO SALE BIEN, SE RETORNA QUE FAIL (FALLO)
         * ES FALSO (PUES SALIO BIEN...) Y EL ID DEL SERVICIO
         * QUE GENERARA UNA FACTURA
         */

     		return array('fail'=> false, 'factura_id' => $servicio->id);
      }
      return array('fail' => true, 'mensaje_error' =>'Usted no posee permisos para generar facturas, contacte a su gerente');
   }


   public function consultarFactura(Request $request, $factura_id)
   {
      /**
       * getDetalleServicioOn HACE UNA CONSULTA SQL (CON FLUENT, EL CONSTRUCTOR
       * DE CONSULTAS DE LARAVEL)
       * SOBRE LOS DETALLES DE UN SERVICIO (GENERA LOS DATOS DE LA FACTURA)
       * MEDIANTE EL ID DE UN SERVICIO
       * $detser => ACRONIMO DE LA PALABRA DETallesSERvicio (almacena los datos)
      */

      //EL ARGUMENTO $factura_id ES EL ID DEL SERVICIO QUE SE RETORNO EN LA
      //FUNCION FACTURA
      
      if(\App\Permiso::check_permisos('SEARCH', Auth::user()->id, $this->modulo_id))
      {
        $servicio = Servicios::find($factura_id);
        $detser = DetalleServicio::getDetalleServicioOn($servicio->id);
    
        $data =  [
          'persona' => $servicio->cliente->persona, 
          'servicio' => $servicio, 
          'detalles' => $detser,
          'empresa' => Empresa::first(),
        ];
        $pdf = PDF::loadView('pdf.factura', $data);
        return $pdf->stream();
      }
      return abort(404);
   }

   public function facturaOnline(Request $request)
   {
      /**
       * getDetalleServicioOn HACE UNA CONSULTA SQL (CON FLUENT, EL CONSTRUCTOR
       * DE CONSULTAS DE LARAVEL)
       * SOBRE LOS DETALLES DE UN SERVICIO (GENERA LOS DATOS DE LA FACTURA)
       * MEDIANTE EL ID DE UN SERVICIO
       * $detser => ACRONIMO DE LA PALABRA DETallesSERvicio (almacena los datos)
      */

      //EL ARGUMENTO $factura_id ES EL ID DEL SERVICIO QUE SE RETORNO EN LA
      //FUNCION FACTURA
      
        $servicio = Servicios::find($request->factura_id);
        $detser = DetalleServicio::getDetalleServicioOn($servicio->id);
    
        $data =  [
          'persona' => $servicio->cliente->persona, 
          'servicio' => $servicio, 
          'detalles' => $detser,
          'empresa' => Empresa::first(),
        ];
        $pdf = PDF::loadView('pdf.factura', $data);
        return $pdf->stream();
   }
}
