<?php

namespace App\Http\Controllers\Modulos\facturacion;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Servicios;
use App\ModPerUser as modulos;
use App\DetalleServicio;

class BuscarFacturas extends Controller
{
	private $mods;
  	private $modulo_id;
	
	public function __construct($id)
	{
		$this->mods = modulos::getModulos(Auth::user()->id);
    	$this->modulo_id = $id;
	}

    public function index(Request $request){
    	return view('intranet.facturacion.buscar_facturas',[
        'modulos' => $this->mods,
        ]);
    }

    public function consultar(Request $request){
    	$factura = Servicios::where('id', $request->factura_id)->first();

        
 
    	$data = [];

    	if($factura){
    		$detser = DetalleServicio::getDetalleServicioOn($factura->id);
    		$data = [
    			'error' => false,
    			'cliente' => $factura->cliente->persona,
    			'datos_factura' => [
    				'total' => number_format($factura->total, 2),
    				'iva' => number_format($factura->iva, 2),
    				'subtotal' => number_format($factura->subtotal, 2),
    				"fecha" => $factura->created_at->format('d-m-Y'),
    				"hora" => $factura->created_at->format('h:i:s A')
    			],
    			'pago' => $factura->modalidad_pago,
    			'detalles' => $detser,
                'deposito' => ($factura->soporteTransaccion != null) ? $factura->soporteTransaccion : false
    		];
    	}
    	else{
    		$data = [
    			'error' => true,
    			'mensaje' => 'La factura no se encuentra dentro de la base de datos, asegurese de haberla escrito correctamente',
    		];
    	}

    	return response($data, 200)->header('Content-Type', 'Application/json');
    }

    public function detalles($detalles){
    	$datos = [];
    	return count($detalles);
    }
}
