<?php

namespace App\Http\Controllers\Modulos\reportes;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ModPerUser as modulos;
use App\Persona;
use App\Hardware;
use App\Cliente;
use App\Servicios;
use App\TipoServicio;
use App\DetalleServicio;
use App\Empresa;

use PDF;


use DB;
use Auth;
use Carbon\Carbon;

class PorTiempo extends Controller
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

  public function enTiempo(Request $request)
  {
    $servicios = Servicios::where('edo_reg', 1)
                ->where('created_at','>=', $request->fecha_desde.' 00:00:00')
                ->where('created_at','<=', $request->fecha_hasta.' 00:00:00')
                ->get();
    $data = [
      'facturas' => $servicios,
      'persona'  => Auth::user()->empleado->persona,
      'empresa' => Empresa::first(),
    ];
    $pdf = PDF::loadView('pdf.reporte_enTiempo', $data);

    return $pdf->stream();
  }
}
