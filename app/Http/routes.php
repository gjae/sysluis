<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/consultar/factura-online','web\PagosWeb@facturaOnline');
Route::group(['prefix' => 'api'], function(){
	Route::get('/productos', 'api\ApiController@productos');
});

Route::group(['prefix' => 'instalar'], function(){

	Route::get('/','Modulos\instalar\InstallController@index');
	Route::post('/procesar', 'Modulos\instalar\InstallController@procesar');
});

Route::group(['middleware' => 'instalado'], function(){
	Route::get('/', 'web\SitioWeb@index');

	Route::group(['prefix' => 'solicitudes'], function(){

		Route::post('/servicios', 'web\SitioWeb@solicitarServicio');
		Route::get('/', 'web\SitioWeb@solicitudes');
		Route::get('/consultar-estatus', 'web\SitioWeb@consultar' );
		Route::get('/consultar-estatus/{codigo}', 'web\SitioWeb@consultarCodigo' );

		Route::post('/pagar', 'web\PagosWeb@pagar');

		Route::get('/categoria-tipo-servicio', function(){
			$tipos = App\TipoServicio::all();
			$categorias = App\Categoria::all();

			$data = [
				'tipos' => $tipos,
				'categorias' => $categorias
			];

			return response($data, 200)
						->header('Content-Type', 'application/json');
		});

		Route::get('/pagos', function(){
			$datos = App\ModalidadPago::all();
			return view('web.pago', ['modos' => $datos]);
		});
	});

	Route::group(['prefix' => 'get'], function(){
		Route::get('/persona', function(){
			return response(['persona' => '123123'], 200)
					->header('Content-Type', 'application/json');
		});
	});
	Route::auth();


	/*
	/------------------------------------------------
	/	RUTAS A LA INTRANET
	/------------------------------------------------
	/
	/	Estas rutas lanzan a la intranet, antes pasando por el
	/ middleware auth para verificar que esta autenticado
	*/

	Route::group(['middleware' => 'auth'], function(){

		Route::group(['prefix' => 'dashboard'], function(){
			Route::get('/','intranet\Dashboard@index');
			Route::get('/{modulo}/{programa?}/{accion?}/{id?}', 'intranet\Dashboard@modulo');
			Route::post('/{modulo}/{programa?}/{accion?}/{id?}', 'intranet\Dashboard@modulo');
		});
		
	});

});
