<?php
/**
 * CONTROLADOR DE USUARIOS:
 * ESTE ARCHIVO (MODULO), GESTIONA TODO LO RELACIONADO CON EL MODULO DE USUARIOS
 * DESDE LA CREACIÓN DE UN USUARIO HASTA LA ASIGNACIÓN DE PERMISOS Y ELIMINACIÓN 
 * DEL MISMO
 */

namespace App\Http\Controllers\Modulos\usuarios;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;
use App\User;
use App\Persona;
use App\Empleado;
use App\Modulo;
use App\Auditoria;
use App\Permiso;
use Storage;
use DB;

class Usuarios extends Controller
{
	private $mods;
    private $modulo_id;

	public function __construct($id)
	{
		$this->mods = ModPerUser::getModulos(Auth::user()->id);
        $this->modulo_id = $id;
	}

    public function index($request)
    {
    	return view('intranet.listar_usuarios', [
    		'modulos' => $this->mods,
    		'personas' => Persona::where('edo_reg', 1)->get()
    	]);
    }

    /**
     * FUNCION PARA BUSCAR UN FORMULARIO DENTRO DEL SISTEMA
     * SE HACE LA BUSQUEDA A PARTIR DE UNA SOLICITUD DE TIPO AJAX
     */

    public function formulario($request,$form)
    {
        if($request->ajax())
        {   
            if($form != 'editar')
                $form = view()->make('intranet.formularios.'.$form, [
                    'modulos' => Modulo::where('edo_reg', 1)->get(),
                    'permisos' => Permiso::where('edo_reg', 1)->get()
                ])->render();
            else{
                $form = view()->make('intranet.formularios.'.$form, [
                    'user' => User::find($request->user_id),
                ])->render();
            }
            //$form = formularios($request, $form);
        }
        else return redirect()->to('/dashboard/usuarios');

        return response(['fail' => false, 'formulario'=>$form], 200)
                ->header('Content-Type', 'application/json');
    }

    public function consultar($request, $cedula)
    {
        if($request->ajax())
        {
            $persona = Persona::where('cedula', '=', $cedula)->get()->toArray();
            $persona[0]['fail'] = empty($persona[0]);
       
            return json_encode($persona[0]);
        }
    }

    public function crear($request, $info)
    {
        /**
         * ESTA FUNCION CREA REGISTROS DE USUARIOS:
         * PRIMERO BUSCA UNA PERSONA POR SU CEDULA LA CUAL LLEGA COMO PARAMETRO
         * POR LA URL POST, CON LA FINALIDAD DE COMPROBAR QUE EXISTE
         * UNA PERSONA EN LA BASE DE DATOS CON ESA CEDULA
         * SI LA CONSULTA RETORNA UN ARRAY VACIO (PRIMER IF)
         * ENTONCES CREA UN REGISTRO EN LA TABLA DE PERSONAS
         */

        $persona = Persona::where('cedula', '=', $request->input('cedula'))
                    ->get();

        $persona_fields = $request->except([
            'usuario', 'password', 'password2', '_token', 'user_id'
        ]);
       
        if(empty($persona[0]) && $this->_auth('CREATE') )
        {
            $persona = new Persona($persona_fields);
            if($persona->save())
            {
                if($persona->empleado()->save(new Empleado()))
                {
                   $nuevo = $persona->empleado->user()->save(
                        new User([
                            'usuario' => $request->input('usuario'),
                            'password' => bcrypt($request->input('password'))
                        ])
                    );
                }
            }
        }

        /**
         * SI EXISTE UNA PERSONA EN LA TABLA CON LA CEDULA 
         * PERO NO TIENE UN REGISTRO COMO EMPLEADO ASOCIADO ENTONCES CREA
         * PRIMERO EL REGISTRO EN LA TABLA EMPELADOS 
         */
        else if($persona[0]->empleado == null && $this->_auth('CREATE'))
        {
            $persona[0]->empleado = $persona[0]->empleado()->save( new Empleado([]) );

            $persona[0]->empleado->user()->save(
                new User([
                    'usuario' => $request->input('usuario'),
                    'password' => bcrypt($request->input('password'))
                ])
            );
        }

        /**
         * SI EXISTE UNA PERSONA CON ESA CEDULA, TIENE UN REGISTRO COMO EMPLEADO
         * Y UN USUARIO INACTIVO (QUE PUDO HABE SIDO SUPRIMIDO ANTERIORMENTE)
         * SE REACTIVA EL REGISTRO Y SE ACTUALIZA CON LOS NUEVOS DATOS 
         * DE LA NUEVA CUENTA DEL USUARIO (CON LA FINALIDAD DE NO TENER REGISTROS)
         * MULTIPLES CON LA MISMA FINALIDAD
         */
        else if($persona[0]->empleado->user != null && $persona[0]->empleado->user->edo_reg == 0 && $this->_auth('CREATE'))
        {
            $persona[0]->empleado->user->edo_reg = 1;
            $persona[0]->empleado->user->usuario = $request->input('usuario');
            $persona[0]->empleado->user->password = bcrypt($request->input('password'));
            $persona[0]->empleado->user->save();
                
        }
        else
        {
            if($this->_auth('CREATE'))
                $persona[0]->empleado->user()->save(
                    new App\User([
                        'usuario' => $request->input('usuario'),
                        'password' => bcrypt($request->input('password'))
                    ])
                );
        }

        return redirect()->to('dashboard/usuarios/Usuarios');

    }

    public function DELETE($request, $id)
    {
        /**
         * FUNCION DELETE, TIENE LA TAREA DE SUPRIMIR UN REGISTRO
         * DE LA TABLA DE USUAROS (COLOCA SU EDO REG EN 0)
         */

        $user = User::find($request->input('id'));
        if($user!= null && $this->_auth('DELETE')) 
        {
            $user->edo_reg = 0;
            if($user->save()) return json_encode(['fail' => false]);
        }
        return json_encode(['fail' => true]);
    }

    /**
     * [asignar_permisos darle permisos a usuarios]
     * @param  [object] $request [request]
     * @param  [string] $accion  [<id o cedula del usuario>]
     * @return [redirect]          [redirecciona al modulo usuarios de dashboard]
     */
    public function asignar_permisos($request, $accion)
    {
        $user = User::find($request->input('user_id'));

        $permisos= $request->input('permiso');
        if($this->_auth('UPDATE'))
        {
            //SI SE TILDA LA OPCION "ASIGNAR PERMISOS"
           if($request->input('opcion') == "asignar")
           {
                $obj_array_permisos = [];
                for($i=0; $i<count($permisos); $i++)
                {
                    $obj_array_permisos[$i] = new ModPerUser([
                        'modulo_id' => $request->input('modulo_id'),
                        'permiso_id' => $permisos[$i],
                        'user_id' => $request->input('user_id')
                    ]);
                }

                $user->permisos()->saveMany($obj_array_permisos);
            }

            //SI SE TILDA LA OPCION "REVOCAR PERMISOS"
            else
            {
                $permisos_usuario = ModPerUser::where('user_id', $request->input('user_id'))
                                        ->where('modulo_id', $request->input('modulo_id'))->get();


                for($i = 0; $i< count($permisos_usuario); $i++)
                {
                    foreach ($permisos as $indice => $permiso_id) {

                        if($permisos_usuario[$i]->permiso_id == $permiso_id)
                        {
                            $permisos_usuario[$i]->delete();
                        }
                    } #FIN DEL FOREACH
                    
                } #FIN DEL FOR
            }
        }
        return redirect()->to('/dashboard/usuarios/Usuarios');
    }

    public function consultar_modulo($request, $modulo_id)
    {
        $permisos = ModPerUser::where('modulo_id', $modulo_id)
                                ->where('user_id', $request->input('user_id'))->get();

        $permisologia = [];

        for($i = 0; $i< count($permisos) ; $i++)
        {
            $permisologia['permiso'][$i] = $permisos[$i]->permiso->nombre_permiso;
        }

        return $permisologia;
    } 

    /**
     * METODO PARA ACTUALIZAR A LOS USUARIOS
     * |    ESTE METODO PRIMERAMENTE CONSULTA SI EL USUARIO POSEE PERMISOS
     * |    PARA ACTUALIZAR, DE SER ASI PERMITE LA ACTUALIZACION
     * |    EN EL CASO CONTRARIO SE LANZA UNA EXCEPCION INDICANDO
     * |    QUE EL USUARIO NO POSEE PERMISOS DE ACTUALIZACION DE REGISTROS
     */

    public function editar($req, $id){
        $user = User::find($req->user_id);

        $data = $req->except('password');
        if( $req->password != Auth::user()->password )
            $data['password'] = bcrypt( $req->password );

        DB::beginTransaction();
        try{
            if( $this->_auth('UPDATE') ){

                if($user->empleado->persona->update($req->all())){
                    
                    if( $req->password != Auth::user()->password )
                        $data['password'] = bcrypt($req->password);
                    if($user->update( $data )){
                        Auditoria::create([
                            'accion' => 'EL USUARIO '.Auth::user()->empleado->persona->nombres.' HA REALIZADO UNA ACTUALIZACION DEL AL REGISTRO DEL USUARIO '.$user->usuario,
                            'user_id' => Auth::user()->id,
                            'modulo_id' => $this->modulo_id
                        ]);
                        DB::commit();
                        return redirect()
                            ->to('dashboard/usuarios/Usuarios')
                            ->with('exito', 'SE HAN ACTUALIZADO LOS DATOS DE MANERA CORRECTA');
                    }
                }

            }else{
                throw new Exception("El usuario no tiene permisos para actualizar en este modulo, consulte a su supervisor", 1);
                
            }
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->to('dashboard/usuarios/Usuarios')
                ->with('error', 'Ha ocurrido un error: '.$e->getMessage() );
        }

    }


    private function _auth($accion)
    {
       return \App\Permiso::check_permisos($accion, Auth::user()->id, $this->modulo_id);
    }

}