<?php

namespace App\Http\Controllers\Modulos\inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ModPerUser as modulos;
use App\Hardware as equipos;
use App\Categoria;
use App\Stock;

use App\Http\Controllers\Modulos\inventario\Modelos\RazonEgreso;

use Auth;

class MetodosEgreso extends Controller
{
	private $mods;
	private $modulo_id;
	public function __construct($id)
	{
		$this->mods = modulos::getModulos(Auth::user()->id);
		$this->modulo_id = $id;
	}
	
	public function index(Request $request, $id='')
	{
		$metodos = RazonEgreso::where('edo_reg', '=', 1)->get();

		return view('intranet.inventario.metodos_egreso', [
					'modulos' => $this->mods,
					'metodos' => $metodos,
				]);
	} 

	public function formulario(Request $request, $form)
	{
		$form = \View::make('intranet.inventario.formularios.'.$form)->render();
		$response = [
			'formulario' => $form,
			'error' => false,
			'mensaje' => '',
		];
		return response($response, 200)
				->header('Content-Type', 'application/json');
	}

	public function salvarInformacion(Request $request, $i='')
	{
		return call_user_func_array([$this, $request->accion ], [$request]);
	}  	

	private function nuevo($request)
	{
		$datos = $request->except(['_token', 'accion']);
		$response = [];

		foreach ($datos as $dato) {
			if( !isset($dato) || empty($dato) )
				$response = [
					'error' => true,
					'mensaje' => 'Alguno de los datos esta vacio, verifique',
					'estatus' => 'FALLIDA'
				];
		}

		if( !isset($response['estatus']) ){
			RazonEgreso::create($datos);
			$response = [
				'error' => false,
				'mensaje' => 'Informacion guardada de manera exitosa',
				'estatus' => 'COMPLETADO'
			];
		}

		return response($response, 200)
				->header('Content-Type', 'application/json');
	}


	private function suprimir($request)
	{
		$response = [];

		try{
			if(! check_permisos('DELETE' ,   Auth::user()->id,$this->modulo_id) )
				throw new \Exception('No posee los permisos para realizar esta accion.');

			RazonEgreso::where('id', '=', $request->id)
						->update(['edo_reg' => 0]);

			$response = [
				'error' => false,
				'mensaje' => 'El registro se ha suprimido satisfactoriamente',
				'estatus' => 'Exitosamente',
			];
		}
		catch(\Exception $e)
		{
			$response = [
				'error' => true,
				'mensaje' => 'Ha ocurrido un error interno al procesar la solicitud '.$e->getMessage(),
				'estatus' => 'Fallido por: '.$e->getMessage(),
			];
		}

		$accion = 'EL USUARIO HA INTENTADO SUPRIMIR DE MANERA '.$response['estatus'].' EL METODO DE EGRESO CON EL ID '.$request->id.' EN EL MODULO DE EGRESOS';

		auditoria($accion, $this->modulo_id, Auth::user()->id);
		return response($response, 200)
				->header('Content-Type', 'application/json');
	}
}
