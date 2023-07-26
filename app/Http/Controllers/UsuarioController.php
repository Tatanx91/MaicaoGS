<?php

namespace Jugueteria\Http\Controllers;

use Jugueteria\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests;
use Jugueteria\model\UsuariosModel;
use Jugueteria\model\AdministradorModel;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\http\Request\UsuarioFormReqest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web' || 'auth:api']);
    }


    public function index(Request $request)
    {
        // if(Session::get("PRIVILEGIOS") == null){
        //     Session::forget('PRIVILEGIOS');
        //     return redirect::to('/');
        // }

        session_start();
        if(!isset($_SESSION['IdTipoUsuario'])){
            session_destroy();
            return redirect::to('/');
        }

    	$nombre ='';
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$Usuarios=DB::table('Usuarios')-> where('NombreUsuario','LIKE','%'.$query.'%')
    		->where('ApellidoUsuario','like','%'.$query.'%')
    		->orderBy('NombreUsuario')
    		->paginate(7);

    		return view('Usuario.index');
    	}

    }
    public function getIndex()
    {
        session_start();
        $Usuario = UsuariosModel::join('Administrador', 'Administrador.IdUsuario', '=', 'Usuario.ID')
            ->orderBy('Administrador.NombreUsuario', 'desc')->get();
        return view('Usuario.ConsultarUsuarios',compact('Usuario'));
    }
    
/*
    public function create()
    {
    	return view("Usuario.Usuarios.create");
    }
*/
    public function store(request $request)
    {

        
        $this->validate($request,[
            'NombreUsuario'=>'Required',
            'NumeroDocumento'=>'Required',
            'Contrasena'=>'Required'
        ]);
        

        $NombreUsuario = $request ['NombreUsuario'];
        $NumeroDocumento = $request ['NumeroDocumento'];
        //$contrasena = bcrypt($request ['Contrasena']);
        $contrasena = md5($request ['Contrasena']);
        $Correo = $request ['Correo'];

        $usuario = new usuario();
        $usuario->NombreUsuario = $NombreUsuario;
        $usuario->NumeroDocumento = $NumeroDocumento;
        $usuario->Contrasena = $contrasena;
        $usuario->Correo = $Correo;

        $usuario->save();
        //redirect('create');
        //return request()->back();
        //return "Ke esta hacieeendooooo!!!!";
        return view('Usuario.create');

    }

    public function postStore(request $request)
    {

        try{


           // $this->validate($request,[
           //          'NombreUsuario'=>'Required',
           //          'NumeroDocumento'=>'Required'
           //      ]);

            $token = $request['_token'];

            $data = $request->all();
            
            $data['CodigoConf'] = str_random(25);
            $data['IdTipoUsuario'] = 1;

            $IdUsuario = $request->input('ID');
            $usuario = $IdUsuario == "" ? new UsuariosModel() : UsuariosModel::find($IdUsuario);
            $adinistradores = $IdUsuario == "" ? new AdministradorModel() : AdministradorModel::where('IdUsuario', $IdUsuario);

            if($IdUsuario == null){

                $nombreUsuario = $data['NombreUsuario'];
                $numeroDocumento = $data['NumeroDocumento'];
                $codigoConfirmacion = $data['CodigoConf'];
                $data['Login'] = $numeroDocumento;

                //Se elimina algoritmo por solicitud del cliente
                // $largo = strlen($numeroDocumento);

                // $PrimeraContraseña = strtoupper(substr($nombreUsuario,0,1));
                // $PrimeraContraseña = $PrimeraContraseña .substr($numeroDocumento,$largo - 4,4);

                // $data['Contrasena'] = md5($PrimeraContraseña);

                $data['Contrasena'] = md5($data['NumeroDocumento']);

                if($data['Correo'] != null || $data['Correo'] != '')
                {
                    
                    //envio correo de confirmacion
                    Mail::send('Correos.CorreoConfirmacion',['data' => $data],function($mensaje) use ($data){
                        $mensaje->from('ventascorporativas@maicaogiftstore.com');
                        $mensaje->to($data['Correo'], $data['NombreUsuario'])->subject('Confirmacion registro plataforma Maicao Gift Strore');
                    });
                }

                // return redirect::to('/registro/verificacion/'.$codigoConfirmacion);
            

            $usuario->fill($data);
            $usuario->save();

            $usuarios = UsuariosModel::where('CodigoConf', $data['CodigoConf']);
            $usuario = $usuarios->first();
            $IdUsuario = $usuario->ID;
            $data['IdUsuario'] = $IdUsuario;


                $administradores = new AdministradorModel();
                $administradores->fill($data);
                $administradores->save();
            }
            else
            {

                $data['Login'] = $data['NumeroDocumento'];

                $usuario->fill($data);
                $usuario->save();

                // $usuarios = UsuariosModel::where('CodigoConf', $data['CodigoConf']);
                // $usuario = $usuarios->first();
                $IdUsuario = $usuario->ID;
                $data['IdUsuario'] = $IdUsuario;

                $adinistradores = AdministradorModel::where('IdUsuario', $IdUsuario);
                $adinistrador = $adinistradores->first();
                $adinistrador->fill($data);
                $adinistrador->save();

            }
            

        } catch (Exception $e) {

            $retorno = [
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ];

            return response()->json($retorno);
        }
        
            $retorno = [
                "success" => true,
                "mensaje" => "Datos guardados correctamente",
                //"request" => $request->all(),
                "usuario" => $usuario
            ];

        // return view('Usuario.ConsultarUsuarios');
        return response()->json($retorno);

    }

    public function VerificarUsuario($CodigoConf)
    {
        session_start();
        $usuarios = UsuariosModel::where('CodigoConf', $CodigoConf);
        $existe = $usuarios->count();
        $usuario = $usuarios->first();

        if($existe == 1 > 0 and $usuario->Confirmado == 0)
        {
            $IdUsuario = $usuario->ID;
            
            return view('Usuario.CambioContrasena')->with(['IdUsuario' => $IdUsuario]);
        }
        else{
            // return redirect::to('datatableListUsuario');
            return 'El usuario ya ha sido verificado, por favor ingresar por el login';
        }
    }

    public function CambiarContrasena(Request $request)
    {
        session_start();
        $data = $request->all();
        $IdUsuario = $request['IdUsuario'];
        $ContrasenaAnt = md5($request['ContrasenaActual']);
        $ContrasenaNueva = md5($request['NuevaContrasena']);

        $Usuario = UsuariosModel::find($IdUsuario);
        $ContrasenaActual = $Usuario['Contrasena'];

        if($ContrasenaActual <> $ContrasenaAnt){
            return 'La contraseña anterior no es valida';
        }
        else if($ContrasenaNueva == $ContrasenaActual){
            return 'La nueva contraseña debe ser distinta a la contraseña anterior';   
        }
        
        $data['Contrasena'] = $ContrasenaNueva;
        $data['Confirmado'] = 1;

        // DB::update('update Usuarios set Confirmado = 1, Contrasena = "'.$ContrasenaNueva.'" where IdUsuario = '.$IdUsuario);
        $Usuario->fill($data);
        $Usuario->save();

        return redirect::to('/');

    }

    public function EnviarRecuperarContrasena(Request $request)
    {
        session_start();
        $data = $request->all();
        $correo = $request->input('Correo');
        $Login = $request->input('NumeroDocumento');
        $usuarios = UsuariosModel::where('Login', $Login);
        $usuario = $usuarios->first();

        $IdUsuario = $usuario["ID"];
        $codigoConf = str_random(25);
        
        if($IdUsuario != null)
        {
            if($usuario["IdTipoUsuario"] == 1)
            {
                $Existe = UsuariosModel::where('Correo', $usuario["Correo"]);

                if($Existe != null)
                {
                    DB::update('update Usuario set Confirmado = 0, CodigoConf = "'.$codigoConf.'" where ID = '.$IdUsuario); 
            
                    //envio correo de confirmacion
                    Mail::send('Correos.RecuperarContrasena',['codigoConf' => $codigoConf],function($mensaje) use ($data){
                        $mensaje->from('ventascorporativas@maicaogiftstore.com');
                        $mensaje->to($data['Correo'])->subject('Recuperacion de contraseña');
                    });

                    return redirect::to('/InicioClaro');
                }
            }

            DB::update('update Usuario set Confirmado = 0, CodigoConf = "'.$codigoConf.'" where ID = '.$IdUsuario); 
            
            //envio correo de confirmacion
            Mail::send('Correos.RecuperarContrasena',['codigoConf' => $codigoConf],function($mensaje) use ($data){
                $mensaje->from('ventascorporativas@maicaogiftstore.com');
                $mensaje->to($data['Correo'])->subject('Recuperacion de contraseña');
            });
        }
        else
        {
            return "El usuario no se encuentra registrado en la base de datos";
        }        

        return redirect::to('/InicioClaro');

    }

    public function RecuperarContrasena($codigoConf)
    {

        session_start();
        $usuarios = UsuariosModel::where('CodigoConf', $codigoConf);
        $existe = $usuarios->count();
        $usuario = $usuarios->first();

        if($existe == 1 > 0 and $usuario->Confirmado == 0)
        {
            $IdUsuario = $usuario->ID;
            
            return view('Usuario.RecuperarContrasena')->with(['IdUsuario' => $IdUsuario]);
        }
        else{
            // return redirect::to('datatableListUsuario');
            return 'El usuario ya ha sido verificado, por favor ingresar por el login';
        }
    }

    public function RecuperarCambiarContrasena(Request $request)
    {
        session_start();
        $data = $request->all();
        $IdUsuario = $request['IdUsuario'];
        $ContrasenaNueva = md5($request['NuevaContrasena']);
        $ContrasenaValida = md5($request['ReperirContrasena']);

        $Usuario = UsuariosModel::find($IdUsuario);

        if($ContrasenaNueva <> $ContrasenaValida){

            return 'La contraseña debe ser igual';

        }
        else{
            $Usuario['Confirmado'] = 1;
            $Usuario['Contrasena'] = $ContrasenaNueva;
        }

        // DB::update('update Usuarios set Confirmado = 1, Contrasena = "'.$ContrasenaNueva.'" where IdUsuario = '.$IdUsuario);

        $Usuario->fill($data);
        $Usuario->save();

        // return 'Contraseña actualizada, Por favor ingresar por el login';        

        return redirect::to('/');

    }

    public function FormRecuperar()
    {
        session_start();
        $_SESSION['IdTipoUsuario'] = 3;
        $CodigoConf = str_random(25);
        return view('Usuario.EmailRecuperarContrasena')->with(['CodigoConf' => $CodigoConf]);
    }

    public function datatableListUsuario(Request $request){
        //Datos de datadable
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'];

        $usuario = UsuariosModel::join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
            ->join('Administrador', 'Administrador.IdUsuario' ,'=', 'Usuario.ID')
            ->select(
                'Usuario.ID',
                'Administrador.NumeroDocumento',
                'Administrador.NombreUsuario',
                'Usuario.Correo',
                'TipoUsuario.Nombre as TipoUsuario',
                'Administrador.Estado');

        $usuario  = $usuario->orderBy($orderBy, $sortColumnDir);  

        $totalRegistros = $usuario->count();

         if($search['value'] != null){
                $usuario = $usuario->whereRaw(
                        "(Usuario.ID LIKE '%".$search["value"]."%' OR ". 
                         "NumeroDocumento LIKE '%". $search['value'] . "%' OR " .
                         "NombreUsuario LIKE '%". $search['value'] . "%' OR " .
                         "Correo LIKE '%". $search['value'] . "%' OR " .
                         "ApellidoUsuario LIKE '%". $search['value'] . "%' OR " .
                         "IdTipoUsuario LIKE '%". $search['value']. "%')");
            }
        
        $parcialRegistros = $usuario->count();
        $usuario = $usuario->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $usuario->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$usuario->get()];

        return response()->json($data);
    }

    public function show()
    {

    }

    public function edit($idUsuario)
    {
        $usuario = Usuario::edit($idUsuario);   
        return view('Usuario.Editar',compact('Usuario'));
    }

    public function update(request $request, $idUsuario)
    {
        $this->validate($request,[
            'NombreUsuario'=>'Required',
            'NumeroDocumento'=>'Required',
            'Contrasena'=>'Required'
        ]);

        $usuario = UsuariosModel::find($idUsuario);
        $usuarioUpdate = $request->all();
        $usuario->update($usuarioUpdate);

        return view('Usuario.create');
    }

    public function postFormusuario(request $request)
    {
        session_start();
        $titulo = "Usuario";
        $IdUsuario = $request->input('IdUsuario');
        $usuario = $IdUsuario == "" ? new UsuariosModel() : UsuariosModel::find($IdUsuario);

        $data = $request->all();

        if($usuario != null && $usuario->ID > 0){
            $adinistradores = AdministradorModel::where('IdUsuario', $IdUsuario);
            $administrador = $adinistradores->first();    
        }
        else {

            $administrador = new AdministradorModel();
        }

        $view = view('Usuario.FormUsuario')->with(['usuario' => $usuario, 'administrador' => $administrador, 'titulo' => $titulo]);

        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }       
    }

    public function cambiaEstadoUsuario(Request $request)
    {
        try {

            $IdUsuario = $request->input('IdUsuario');
            $estado = $request->input('Estado');

            // DB::update('update Usuarios set Estado = '.$estado.' where IdUsuario = '.$IdUsuario);

            $usuario = UsuariosModel::find($IdUsuario);
            $Administradores = AdministradorModel::where('IdUsuario', $IdUsuario);
            $Administrador = $Administradores->first();

            $Administrador['Estado'] = $estado;
            $data = $request->all();
            $Administrador->fill($data);
            $Administrador->save();
    
        } catch (Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }

        $retorno = [
        "success" => true,
        "mensaje" => "Estado actualizado",
        //"request" => $request->all(),
        "usuario" => $usuario
        ];

        return response()->json($retorno);
        // return view('Usuario.ConsultarUsuarios');


    }

    public function destroy()
    {
    	
    }


}

