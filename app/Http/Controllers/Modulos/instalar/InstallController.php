<?php

namespace App\Http\Controllers\Modulos\instalar;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Artisan;
use App\User;
use App\Empresa;

class InstallController extends Controller
{

    public function installDB(){
    	print("Cargando la base de datos...<br>");
    	//$a = 'php '.base_path().'/artisan migrate';
    	sleep(0);
    	echo Artisan::call('migrate');

    	return true;
    }

    public function index()
    {
    	return view('vendor.install');
    }

    public function procesar(Request $request)
    {
    	return call_user_func_array([$this, $request->accion], [$request]);	
    }

    public function env($request)
    {
    	if($this->generarEnv($request))
    	{
    		return view('vendor.fin_install', $request->all());
    	}
    	return "error";

    }

    /**
    *	METODO PARA GENERAR EL ARCHIVO .ENV NECESARIO
    *	PARA CONFIGURAR EL SISTEMA
    */
    private function generarEnv($datos)
    {

    	$env = \View::make('vendor.generate_env', $datos->all());
    	\Storage::disk('install_env')->put('.env', $env);
    	return true;
    }

    /**
    *	METODO PARA EJECUTAR LAS MIGRACIONES Y CREAR LAS TABLAS 
    *	DE LA BD
    */
    private function putDatabase()
    {
    	\DB::beginTransaction();
    	try {
    		Artisan::call('migrate');
    		Artisan::call('db:seed');
    		\DB::commit();
    		return view('vendor.empresa');
    		
    	} catch (\Exception $e) {
    		\DB::rollback();
    		return "excepcion capturada: ".$e->getMessage();
    	}
    }

    private function empresa($request)
    {

    	\DB::beginTransaction();
    	try {
    		$empresa = new Empresa($request->except('logo'));
    		$empresa->logo = ( $request->hasFile('logo') ) ? 
    							$this->guardarImg($request->file('logo')) : '';
    		if($empresa->save())
    		{
    			\DB::commit();
    			return view('vendor.usuario');
    		}
    		else
    		{
    			throw new \Exception('Se ha producido un error guardando la empresa');
    		}


    	} catch (\Exception $e) {
    		\DB::rollback();
    		return $e->getMessage();
    	}
    }

    private function guardarImg($img)
    {
    	$img->move(
    		public_path().'/img',
    		$img->getClientOriginalName()
    	);
    	return $img->getClientOriginalName();
    }

    private function usuario($request)
    {
    	$u = User::where('id', 1)->first();
    	$u->password = bcrypt($request->password);
    	$u->usuario = $request->usuario;
    	if($u->save())
    	{
    		return redirect()->to('/login');
    	}
    }

}
