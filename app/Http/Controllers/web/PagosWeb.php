<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Empresa;
use PDF;
use App\Persona;
use App\Cliente;
use App\TipoServicios;
use App\Servicios;
use App\Hardware;

use DB;
use App\DetalleServicio;

class PagosWeb extends Controller
{
    private function verificarDatos($request){


    }

    private function totalizarProductos($query, $articulos){
    	$total = 0.00;

    	foreach($query as $key => $producto){
    		/**
    		 * CON ESTE FOR SE RECORRE LOS ARTICULOS A PAGAR
    		 * PARA VERIFICAR LA CANTIDAD DE VECES QUE APARECE EL MISMO
    		 * ARTICULO EN EL CARRITO
    		 */
    		for($i = 0; $i < count($articulos); $i++){
    			if($articulos[$i] == $producto->codigo_hardware)
    				$total+= $producto->precio;
    		}


    	}

    	return [$query, $total, $articulos];

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

    public function pagar(Request $request){
    	$total = 0.00;
    	/**
    	 * ARTICULOS VIENE DESDE EL NAVEGADOR DEL CLIENTE
    	 * ES LA LISTA DE LOS ARTICULOS A PAGAR
    	 */

    	$articulos = explode(",", $request->articulos);
    	$hw =  Hardware::where('codigo_hardware', $articulos[0]);

    	for($k = 1; $k <count($articulos); $k++){
    	   $hw->orWhere('codigo_hardware', $articulos[$k]);
    	}
    	
    	$productos = null;

    	list($productos, $total, $articulos) = $this->totalizarProductos($hw->get(), $articulos);

    	DB::beginTransaction();
    	try{
    		$cliente  = $this->cliente($request);
    		$serv = $this->guardarServicio($productos, $total, $cliente, $articulos);
    		DB::commit();

    		return response([
    			'error' => false,
    			'mensaje' => "Operacion realizada con exito, facuta # ".$serv->id,
    			'consultar' => url('consultar/factura-online?factura_id='.$serv->id)
    		], 200)->header('Content-Type', 'application/json');

    	}catch(\Exception $e){
    		DB::rollback();
    		return response([
    			'error' => true,
    			'mensaje' => "Ha ocurrido un problema al guardar los datos, estamos trabajando para resolverlo"
    		], 200)->header('Content-Type', 'application/json');

    	}

    	return json_encode($total);
    }

    private function cliente($request){
    	$persona = Persona::where('cedula', $request->cedula)->first();

    	if( !$persona ){
    		$persona = Persona::create($request->all());
    		$persona->cliente()->save( new Cliente);
    		
    	}
    	return $persona->cliente;
    }

    public function guardarServicio($productos, $total, $cliente, $articulos){
    	$iva = 0.00;
        $iva = $total*env('IVA', '0.12');

        $servicio = Servicios::create( [
          'tipo_servicio_id'=>1, 
          'empleado_id' => 1,
          'cliente_id' => $cliente->id,
          'modalidad_pago_id' => 2,
          'iva' =>  $iva,
          'subtotal' => $total,
          'total' => $total+( $total*env('IVA', '0.12') )
        ] );
		$ds = [];

		foreach($productos as $key => $producto){

      for($i = 0; $i<count($articulos); $i++)
      {
        if($articulos[$i] == $producto->codigo_hardware)
        {
          $servicio->detalle_servicio()->save(
              new DetalleServicio([
              'hardware_id' => $producto->id,
              'precio_hardware' => $producto->precio
            ])
          );          
        }
      }

		}

		

		return $servicio;

    }

}
