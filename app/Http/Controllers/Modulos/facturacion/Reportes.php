<?php

namespace App\Http\Controllers\Modulos\facturacion;

use Illuminate\Http\Request;


use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Persona;
use App\Empleado;
use App\User;
use App\ModPerUser as modulos;
use App\Hardware;
use App\Cliente;
use App\Servicios;
use App\TipoServicio;
use App\DetalleServicio;
use App\Empresa;


use PDF;
use DNS1D;

use Carbon\Carbon;

class Reportes extends Controller
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
		return view('intranet.facturacion.reportes', ['modulos' => $this->mods]);
	}

	public function formularios(Request $request, $form)
	{
		$json = [
			'error' => false,
			'formulario' => view()->make('intranet.facturacion.formularios.'.$form)->render(),
		];
		return response($json, 200)->header('Content-Type', 'application/json');
	}

	/**
	*/
	public function enTiempo(Request $request)
	{
		$servicios = Servicios::where('edo_reg', 1)
					->where('created_at','>=', $request->fecha_desde.' 00:00:00')
					->where('created_at','<=', $request->fecha_hasta.' 00:00:00')
					->get();

		if($servicios)
		{
			$data = [
				'facturas' => $servicios,
				'persona'  => Auth::user()->empleado->persona,
				'empresa' =>  Empresa::first()
			];
			$pdf = PDF::loadView('pdf.reporte_enTiempo', $data);

			return $pdf->stream();
		}
		else
			return redirect()->to( url('dashboard/Facturacion/Reportes') );
	}
}
