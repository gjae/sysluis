<?php

namespace App\Http\Controllers\Modulos\reportes;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ModPerUser as modulos;
use App\Persona;

use DB;
use Auth;
use Carbon\Carbon;

class PorPersona extends Controller
{
	private $mods;
	private $modulo_id;
	public function __construct($id)
	{
		$this->mods = modulos::getModulos(Auth::user()->id);
		$this->modulo_id = $id;
	}

	public function index()
	{
		return view('intranet.reportes.index', ['modulos' => $this->mods]);
	}

	public function consultar(Request $request, $cedula)
	{

		$persona = Persona::where('cedula', '=', $cedula)->first();
		$facturas = $persona->cliente->servicios->toArray();

		foreach($facturas as $clave => $dato)
		{
			$facturas[$clave]['created_at'] = Carbon::parse($dato['created_at'])->format('d/m/Y');
		}
		if($persona){
			$data = [
				'persona' => $persona,
				'facturas' => $facturas,
				'error' => false,
				'mensaje' => 'Datos encontrados',
			];

			return response($data, 200)
					->header('Content-Type','application/json');

		}
		return response(['error' => true, 'mensaje' => 'No existe cliente con esta cedula de identidad, verifique que sea correcta'])
				->header('Content-Type', 'application/json');
	}
}
