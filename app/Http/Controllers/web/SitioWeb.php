<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TipoServicio;
use App\Persona;
use App\Cliente;
use App\Categoria;
use App\Http\Controllers\Modulos\servicios\modelos\Solicitud;
use Carbon\Carbon;
use App\Empresa;

use PDF;

class SitioWeb extends Controller
{
    
    public function index()
    {
    	$html = view()->make('web.index')->render();

    	return $html;
    }

    public function solicitudes(){
        $datos =[
            'tipos' => TipoServicio::where('edo_reg', 1)->get(),
            'categorias' => Categoria::where('edo_reg', 1)->get(),
        ];       

        return view('web.web_index',$datos);

    }

    public function consultar(Request $request){
        return view('web.consultar');
    }

    private function colores($isStatus = false, $codigo){
        if($isStatus){
            switch ($codigo) {
                case 'P':
                    return "alert-warning";
                    break;
                
                case 'AS':
                    return 'alert-primary';
                    break;
                case 'LS':
                case 'FTR':
                    return 'alert-success';
                    break;

                case 'RVR':
                case 'NULL':
                    return 'alert-danger';
                    break;

            }
        }

        return "#000";
    }

    public function consultarCodigo($codigo){

        $solicitud = Solicitud::where('codigo_solicitud', '=', $codigo)->first();

        $respuesta = [];
        if($solicitud){
            $respuesta = [
                'codigo' => $solicitud->codigo_solicitud,
                'estatus' => [
                    'estatus_id' => $solicitud->estatus_id,
                    'codigo_estatus' => $solicitud->estatus->codigo_estatus,
                    'nombre_estatus' => $solicitud->estatus->nombre_estatus,
                    'color_estatus' => $this->colores(true, $solicitud->estatus->codigo_estatus),
                ],
                'cliente' => $solicitud->cliente->persona,
                'solicitud' => [
                    'datos' => $solicitud,
                    'fecha_solicitud' => $solicitud->created_at->format('d-m-Y')
                ],
                'error' => false
            ];
        }
        else{
            $respuesta = [
                'error' => true,
                'mensaje' => "El codigo {$codigo} no se encuentra en nuestra base de datos, por favor, asegurese de que esta ingresando un codigo correcto. Si piensa que esto es un error, pongase en contacto con el personal"
            ];
        }
        return response($respuesta, 200)
                        ->header('Content-Type', 'application/json');

    }

    /**
     * solicitarServicio FUNCION PARA REGISTRAR LA SOLICITUD DE SERVICIO
     * @param  Request $request DATOS DE LA SOLICITUD HTTP
     * @return redirect           redirecciona
     */
    public function solicitarServicio(Request $request)
    {
    	$persona = $this->verificarPersona($request);

    	if( ( $persona instanceOf Persona ) && ($persona != null) )
    	{
    		$carbon = Carbon::now();
    		$solicitud = Solicitud::create([
    			'tipo_id' => $request->tipo_id,
    			'cliente_id' => $persona->cliente->id,
    			'detalles'	=> $request->detalles,
    			'codigo_solicitud' => $carbon->year.'-0'.$carbon->month.'-00'.Solicitud::where('edo_reg', 1)->count() +1,
                'categoria_id' => $request->categoria_id,
    		]);

    		if( $solicitud)
    		{
                $html = \View::make('pdf.comprobante_solicitud',[
                        'datos' => $solicitud,
                        'empresa' => Empresa::first(),
                        'persona' => null
                    ])->render();

                $pdf = PDF::loadHtml($html);
                return $pdf->stream('comprobante', ['attachment' => 0]);
    			return redirect()->to('/')->with('exito', 'Se ha realizado la solicitud exitosamente!');
    		}
    	}

    	return "Fallo el intento :(";
    }


    private function verificarPersona($request)
    {    	
    	$persona = Persona::where('cedula', $request->cedula)->get();

    	if(! empty($persona[0]))
    	{
    		if( $persona[0]->edo_reg == 0 )
    		{
    			$persona[0]->edo_reg = 1; 
    			$persona[0]->save();
    		}
    		if( $persona[0]->cliente == null) $persona[0]->cliente()->save(new Cliente([]));
    		return $persona[0];
    	}

    	else
    	{
    		$persona = Persona::create( $request->except(['_token', 'tipo_id']) );
    		if( $persona->cliente()->save(new Cliente([]) ) ) return $persona;
    	}
    	return false;
    }
}
