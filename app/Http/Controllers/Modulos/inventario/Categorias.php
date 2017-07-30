<?php

namespace App\Http\Controllers\Modulos\inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;
use App\User;
use App\Categoria;

use Storage;

class Categorias extends Controller
{
    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->modulo_id = $id;
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    }


    public function index()
    {
    	return view('intranet.inventario.categorias', ['modulos' => $this->mods, 'categorias' => Categoria::all()]);
    }

    public function guardar(Request $request, $id)
    {
    	if(\App\Permiso::check_permisos('CREATE', Auth::user()->id, $this->modulo_id))
    	{
	    	if(Categoria::create($request->except(['_token'])) )
	    	{
	    		return ['fail'=> false, 'mensaje' => 'La categoria se ha guardado' ];
	    	}
	    }

	    return ['fail'=> true, 'mensaje' => 'No posee permio para realizar esta acción' ];
    }

    public function DELETE(Request $request, $id)
    {
    	$categoria = Categoria::find($request->id);
    	#SI EL USUARIO CONECTADO NO POSEE PERMISOS PARA REALIZAR LA ACCION
    	if(! \App\Permiso::check_permisos('DELETE', Auth::user()->id, $this->modulo_id))
    	{
    		return [
    			'fail' => true,
    			'mensaje' => 'Usted no posee permisos para realizar esta acción'
    		];
    	}

    	if( $categoria->hardwares->where('edo_reg', 1)->count()  > 0)
    	{
    		return [
    			'fail' => true,
    			'mensaje' => 'No se puede eliminar esta categoría porque tiene mas registros asociados'
    		];
    		exit;
    	}

    	$categoria->edo_reg = 0;
    	return [
    		'fail' => $categoria->save(),
    		'mensaje' => 'El registro se ha suprimido satisfactoriamente'
    	];
    }


    public function consultar(Request $request, $id){

    	$cat = Categoria::find($id);

    	if($cat)
    		return $cat->toArray();
    }

}
