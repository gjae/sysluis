<?php

namespace App\Http\Controllers\Modulos\inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

#--
use App\ModPerUser as modulos;
use App\Hardware as equipos;
use App\Categoria;
use App\Stock;
use Carbon\Carbon;
use Storage;

use Auth;

class Hardware extends Controller
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
   		$hw = equipos::where('edo_reg', 1)->get();
   		//return dd($hw);
   		return view('intranet.inventario.listar_hardware', ['modulos' => $this->mods, 'hardwares' => $hw]);
   	} 


   	/**
   	 * funcion GUARDAR
   	 * CREA UN NUEVO ITEM EN EL INVENTARIO 
   	 */

   	public function  guardar(Request $request, $id)
   	{
   		if(App\Permiso::check_permisos('CREATE', Auth::user()->id, $this->modulo_id))
   		{
   			if(true)
   			{
   				/*
   				*	BUSCA AL PROVEEDOR POR SU ID (APARECE EN EL SELECT EN LA VENTANA EMERGENTE)
   				 */
          
          $name = md5(Carbon::now()).'.jpg';
          $request->file('imagen')->move(public_path('img/uploaders'), $name);

          $datos = $request->except(['stock', '_token']);
          $datos['imagen'] = $name;

   				$hw = equipos::create($datos);

   				$hw->stock()->save(
   					new Stock()
   				);

          return redirect()->to('http://localhost:8000/dashboard/inventario/Hardware');
   			}
   		}

   		return ['fail' => true, 'mensaje' => 'Usted no posee permisos para realisar esta acción1.'];
   	}

   	public function formularios(Request $request, $formulario)
   	{ 	
        $categorias = Categoria::where('edo_reg', '=', 1)->get();
        $formulario = \View::make('intranet.inventario.formularios.'.$formulario, [
                          'categorias' => $categorias,
                        ])
                        ->render();

        return json_encode([
            'fail' => false,
            'formulario' => $formulario
        ]);
   	}



    public function DELETE(Request $request, $id)
    {
        if(App\Permiso::check_permisos('DELETE', Auth::user()->id, $this->modulo_id))
        {
            $hw = equipos::find($request->id);
            $hw->edo_reg = 0;
            if( $hw->save())
            {
              return [
                'fail'=> false,
                'mensaje' => 'El registro se ha suprimido satisfactoriamente'
              ];
            }
        }

        return [
          'fail' => true,
          'mensaje' => 'Usted no posee permisos para realisar esta acción',
        ];
    }
}
