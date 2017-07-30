<?php

namespace App\Http\Controllers\Modulos\inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ModPerUser as modulos;
use App\Hardware as equipos;
use App\Categoria;
use App\Stock;

use App\Http\Controllers\Modulos\inventario\Modelos\Adquisicion as ad;

use Storage;

use Auth;

class Ingresos extends Controller
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
		return view('intranet.inventario.ingresos', ['modulos' => $this->mods,]);
	}

	public function buscar(Request $request, $id='')
	{
		$producto = equipos::where('codigo_hardware', '=', strtoupper($request->_codigo))->first();

		if( $producto )
			$datos = [
				'error' => false,
				'producto' => $producto,
				'mensaje' => 'Se ha encontrado un producto'
			];

		else
			$datos = [
				'error' => true,
				'mensaje' => 'No existe producto con este codigo',
			];

		return response($datos, 200)
				->header('Content-Type', 'application/json');
	}

	public function guardar(Request $request, $id='')
	{
		$producto = Stock::where('hardware_id', '=', $request->hardware_id)->first();
		$response = [];
		//return $producto->toArray();
		\DB::beginTransaction();
		try{

			$insercion = $producto->adquisiciones()->save(
				new ad( $request->except(['_token', 'hardware_id', 'nombre_hardware', 'codigo_hardware']) )
			);
			if( $insercion ){
				$producto->stock = $producto->adquisiciones->sum('cantidad');
				$producto->save();
				\DB::commit();
				$response = [
					'error' => false, 
					'mensaje' => 'Se ha realizado exitosamente',
					'estado_accion' => 'Exitosa',
				];
			}

		}
		catch(\Exception $e){
			\DB::rollback();
			$response = [
				'error' => true, 
				'mensaje' => 'Ha ocurrido un error al guardar la informacion', 
				'excepcion' => $e->getMessage(),
				'estado_accion' => 'Fallida por: '.$e->getMessage(),
			];

		}
		finally{
			$accion = 'EL USUARIO INTETO REALIZAR UN INGRESO QUE RESULTO '.$response['estado_accion'].' EN EL PROGRAMA DE INGRESOS';

			\App\Auditoria::auditoria($accion, $this->modulo_id, Auth::user()->id);
			return response($response, 200)
					->header('Content-Type', 'application/json');
		}
	}
}
