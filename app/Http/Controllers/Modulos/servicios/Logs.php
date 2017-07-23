<?php

namespace App\Http\Controllers\Modulos\servicios;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ModPerUser;
use App\User;
use App\Categoria;
use App\LogProblemas;
use Auth;

class Logs extends Controller
{
    private $mods;
    private $modulo_id;

    public function __construct($id)
    {
    	$this->modulo_id = $id;
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
    }

    public function index(Request $request, $id)
    {
        $logs = LogProblemas::all();
        return view('intranet.servicios.logs', ['modulos' => $this->mods, 'logs' => $logs]);
    }
}
