<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hardware;

class ApiController extends Controller
{
    public function productos(){
    	$data = [
    		'error' => false,
    		'productos' => $this->getProductsData(),
    	];


    	return response()->json($data, 200);
    }

    private function getProductsData(){
    	$producst = [];
    	$i = 0;
    	foreach (Hardware::where('edo_reg', 1)->get() as $key => $producto) {
    		if($producto->stock)
    		{
    			$products[$i]['producto'] = $producto;
    			$products[$i]['categoria'] = $producto->categoria;
    			$i++;
    		}
    	}
    	return $products;
    }
}
