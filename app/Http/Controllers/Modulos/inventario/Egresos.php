<?php

namespace App\Http\Controllers\Modulos\inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ModPerUser as modulos;
use App\Hardware as equipos;
use App\Categoria;
use App\Stock;

use App\Http\Controllers\Modulos\inventario\Modelos\Egreso;
use App\Http\Controllers\Modulos\inventario\Modelos\Adquisicion;
use App\Http\Controllers\Modulos\inventario\Modelos\RazonEgreso;

use Storage;

use Auth;


class Egresos extends Controller
{
 
	private $mods;
	private $modulo_id;
	public function __construct($id)
	{
		$this->mods = modulos::getModulos(Auth::user()->id);
		$this->modulo_id = $id;
	}
	
	public function index(Request $index, $id = '')
	{
		$re = RazonEgreso::where('edo_reg', '=',1)->get();
		return view('intranet.inventario.egresos',[
					'modulos' => $this->mods,
					'razones' => $re,
				]);
	}


	public function buscar(Request $request, $codigo)
	{
		$equipo = equipos::where('codigo_hardware', '=', strtoupper($request->_codigo) )
						->first();

		if( $equipo)
			$data = [
				'error' => false,
				'producto' => $equipo,
				'stock' => $equipo->stock,
				'mensaje' => 'Producto encontrado'
			];
		else
			$data = [
				'error' => true,
				'mensaje' => 'No se ha encontrado producto con el codigo ingresado'
			];

		return response($data, 200)
				->header('Content-Type', 'application/json');
	}

	public function procesar(Request $request, $id='')
	{
		$response = [];
		\DB::beginTransaction();
			try{

				if( !App\Permiso::check_permisos('UPDATE', Auth::user()->id, $this->modulo_id) )
					throw new \Exception("No posee permisos para realizar esta accion", 1);
					
				$stock = Stock::where('id','=',$request->stock_id)->first();

				if($this->_insertarRegistros($stock, $request->cantidad, $request->razon_salida_id))
				{
					$response = [
						'error' => false,
						'mensaje' => 'El egreso se ha realizado exitosamente',
						'estado_accion' => 'Exitosa',

					];
				}
				else throw new \Exception('Se ha producido un error en el proceso');

				\DB::commit();
			}
			catch(\Exception $e){
				$response = [
					'error' => true,
					'mensaje' => $e->getMessage(),
					'estado_accion' => 'Faillida por: '.$e->getMessage(),
				];
				\DB::rollback();

			}
			//FINALMENTE AL TERMINAR LA TRANSACCION (GENERE UN ROLLBACK O UN COMMIT)
			//SE RETORNA UNA RESPUESTA EN FORMATO JSON
			finally{
				$accion = 'El usuario intento realizar un egreso el cual resulto '.$response['estado_accion'].' en el programa "EGRESOS"';
				auditoria($accion, $this->modulo_id, Auth::user()->id);
				return response($response, 200)
						->header('Content-Type','application/json');
			}
	}

	//INSERTA EL REGISTRO CORRESPONDIENTE EN LA TABLA DE EGRESO
	//MEDIANTE LA RELACION DEL MODELO STOCK
	private function _insertarRegistros($stock, $cantidad_egresar, $razon)
	{
		if( ( $stock->stock - $cantidad_egresar ) < 0 )
			throw new \Exception('El stock disponible para este producto es inferior a la cantidad de productos a egresar, verifique y vuelva a intentarlo.');

		$data['monto_egreso'] = $cantidad_egresar * $stock->hardware->precio;
		$data['antes_egreso'] = $stock->stock;
		$data['despues_egreso'] = $this->_calcularStock($stock, $cantidad_egresar);
		$data['razon_salida_id'] = $razon;
		$data['cantidad_egresada'] = $cantidad_egresar;
		
		return $stock->egresos()->save(
			new Egreso($data)
		);
	}

	/**
	*	RECALCULA LA CANTIDAD DE PRODUCTOS NUEVA
	*	Y ACTUALIZA EN LA TABLA STOCK
	*/
	private function _calcularStock($stock, $cantidad_egresar)
	{
		$stock->stock = ( $stock->stock - $cantidad_egresar );
		$stock->save();
		return $stock->stock;
	}
}
