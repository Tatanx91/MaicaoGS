<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\model\Convenio_Model;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\HijoEmpleado_Model;
use Jugueteria\model\UsuariosModel;
use Illuminate\Support\Facades\Auth;
use Jugueteria\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
        $this->middleware('jwt', ['except' => ['login','loginClaro','logout', 'logoutClaro']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try{

            session_start();

            $credentials = request(['Login', 'Contrasena']);
            // $credentials = request(['Correo', 'Contrasena']);
            $Contrasena = md5($credentials['Contrasena']);
            $credentials['Contrasena'] =$Contrasena;

            // $usuarios = UsuariosModel::join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                // ->where('Usuario.Correo', $credentials['Correo']);
            // $existe = $usuarios->count();
            // $usuario = $usuarios->first();

            //Session::forget('PRIVILEGIOS');
            $session = null;

            $session = UsuariosModel::select('Usuario.IdTipoUsuario','Usuario.ID', 'Administrador.NombreUsuario as Nombre', 'Administrador.NumeroDocumento', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                    ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                    ->join('Administrador', 'Administrador.IdUsuario' ,'=', 'Usuario.ID')
                    ->where('Administrador.Estado', '=', 1)
                    // ->where('Usuario.Correo', $credentials['Correo'])->first();
                    ->where('Usuario.Login', $credentials['Login'])->first();

            if(isset($session))
            {
                if($session->IdTipoUsuario == 1)
                {
                    $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                    $_SESSION['Nombre'] = $session->Nombre;
                }
                else
                {
                    $session = null;
                }
                
            }

            if(!isset($session))
            {

                $session = UsuariosModel::select('Usuario.IdTipoUsuario AS IdTipoUsuario','Usuario.ID AS IDUsuario','Empresa.ID AS IdEmpresa', 'Empresa.Nombre', 'Empresa.Logo AS LogoEmpresa', 'Empresa.NumeroDocumento', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                        ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                        ->join('Empresa', 'Empresa.IdUsuario' ,'=', 'Usuario.ID')
                        ->where('Empresa.Estado', '=', 1)
                        // ->where('Usuario.Correo', $credentials['Correo'])->first();
                        ->where('Usuario.Login', $credentials['Login'])->first();

                if(isset($session))
                {
                    if($session->IdTipoUsuario == 2)
                    {

                        $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                        $_SESSION['IdEmpresa'] = $session->IdEmpresa;
                        $_SESSION['Nombre'] = $session->Nombre;
                        $_SESSION['Logo'] = $session->Nombre;
                    }
                    else
                    {
                        $session = null;
                    }
                }
            }

            if(!isset($session))
            {

                $session = UsuariosModel::select('Usuario.IdTipoUsuario AS IdTipoUsuario','Usuario.ID AS IDUsuario','Empleado.ID AS IDempleado', 'Empleado.Nombre', 'Empleado.NumeroDocumento', 'Empleado.IdEmpresa AS IdEmpresa', 'Empresa.Logo', 'Empresa.Nombre AS NombreEmpresa', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                        ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                        ->join('Empleado', 'Empleado.IdUsuario' ,'=', 'Usuario.ID')
                        ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
                        ->where('Empleado.Estado', '=', 1)
                        //->where('Empresa.Estado', '=', 1)
                        // ->where('Usuario.Correo', $credentials['Correo'])->first();
                        ->where('Usuario.Login', $credentials['Login'])->first();

                if(isset($session))
                {
                    if($session->IdTipoUsuario == 3)
                    {
                        $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                        $_SESSION['IdEmpresa'] = $session->IdEmpresa;
                        $_SESSION['IdEmpleado'] = $session->IDempleado;
                        $_SESSION['Nombre'] = $session->Nombre;
                        $_SESSION['Logo'] = $session->Nombre;
                    }
                    else
                    {
                        $session = null;
                    }
                }
            }

            if($session != null){
                    // Session::put("PRIVILEGIOS", $session);
                    // Session::save();
                    
                    if($session->IdTipoUsuario != 1){
                        
                        if(str_contains(strtolower($session->NombreEmpresa), 'claro') == false){
                            
                            $convenioVigente = $this->validarConvenioVigente($session['IdEmpleado'], $session['IdEmpresa']);    
                            
                            if(!$convenioVigente){
                                return 'No existen convenios vigentes';
                            }    
                        }
                        else{
                            return 'Usuario no existe';   
                        }
                    }

                    // if($existe > 0 and $usuario['Confirmado'] == 0){
                    if($session['Confirmado'] == 0 && $session['IdTipoUsuario'] != 3){

                        $nombreUsuario = $session['Nombre'];
                        $numeroDocumento = $session['NumeroDocumento'];
                        $codigoConfirmacion = $session['CodigoConf'];
                        $PrimeraContraseña = md5($numeroDocumento);

                        // return $session['NumeroDocumento'];

                        // Se elimina algoritmo por solicitud del cliente
                        // $largo = strlen($numeroDocumento);

                        // $PrimeraContraseña = strtoupper(substr($nombreUsuario,0,1));
                        // $PrimeraContraseña = md5($PrimeraContraseña .substr($numeroDocumento,$largo - 4,4));

                        if($PrimeraContraseña == $Contrasena)
                        {
                            return redirect::to('/registro/verificacion/'.$codigoConfirmacion);
                        }
                        else
                        {
                            return 'La contraseña inicial asignada no es correcta';
                        }

                        
                    }
                    else if($session['Confirmado'] == 0 && $session['IdTipoUsuario'] != 3)
                    {
                        $IDUsuario = $session['IDUsuario'];
                        $DatosUsuario = UsuariosModel::find($IDUsuario);
                        $session['Confirmado'] = 1;
                        $data['Confirmado'] = $session['Confirmado'];
                        $data['ID'] = $IDUsuario;
                        $DatosUsuario->fill($data);
                        $DatosUsuario->save();
                    }

                    // if (! $token = auth()->attempt($credentials)) {
                    //     return response()->json(['error' => 'Unauthorized'], 401);
                    // }

                    if (! $token = JWTAuth::attempt($credentials)) {
                    return 'Usuario o contraseña incorrectos';
                    return response()->json(['error' => 'No Autorizado'], 401);
                    }
                        $response = compact('token');
                        $response['TipoUsuario'] = Auth::user();

                        // $retorno = Session::get("PRIVILEGIOS");
                        // echo "<pre>";
                        // var_dump($retorno);
                        // echo "</pre>";
                        // echo "<pre>";
                        // var_dump(Session::forget('PRIVILEGIOS'));
                        // echo "</pre>";

   
                       return redirect::to('/inicio/menu');
            }else{
                return redirect::to('/');
            }
        }
         catch (JWTException $e)
        {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
        catch (Exception $e)
        {
            return response()->json([$e], 400);
        }
    }
    
    public function loginClaro()
    {
        try{

            session_start();

            $credentials = request(['Login', 'Contrasena']);
            // $credentials = request(['Correo', 'Contrasena']);
            $Contrasena = md5($credentials['Contrasena']);
            $credentials['Contrasena'] =$Contrasena;

            // $usuarios = UsuariosModel::join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                // ->where('Usuario.Correo', $credentials['Correo']);
            // $existe = $usuarios->count();
            // $usuario = $usuarios->first();

            //Session::forget('PRIVILEGIOS');
            $session = null;

            $session = UsuariosModel::select('Usuario.IdTipoUsuario','Usuario.ID', 'Administrador.NombreUsuario as Nombre', 'Administrador.NumeroDocumento', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                    ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                    ->join('Administrador', 'Administrador.IdUsuario' ,'=', 'Usuario.ID')
                    ->where('Administrador.Estado', '=', 1)
                    // ->where('Usuario.Correo', $credentials['Correo'])->first();
                    ->where('Usuario.Login', $credentials['Login'])->first();

            if(isset($session))
            {

                if($session->IdTipoUsuario == 1)
                {
                    $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                    $_SESSION['Nombre'] = $session->Nombre;
                }
                else
                {
                    $session = null;
                }
                
            }

            if(!isset($session))
            {

                $session = UsuariosModel::select('Usuario.IdTipoUsuario AS IdTipoUsuario','Usuario.ID AS IDUsuario','Empresa.ID AS IdEmpresa', 'Empresa.Nombre AS NombreEmpresa', 'Empresa.Logo AS LogoEmpresa', 'Empresa.NumeroDocumento', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                        ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                        ->join('Empresa', 'Empresa.IdUsuario' ,'=', 'Usuario.ID')
                        ->where('Empresa.Estado', '=', 1)
                        // ->where('Usuario.Correo', $credentials['Correo'])->first();
                        ->where('Usuario.Login', $credentials['Login'])->first();

                if(isset($session))
                {
                    if($session->IdTipoUsuario == 2)
                    {

                        $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                        $_SESSION['IdEmpresa'] = $session->IdEmpresa;
                        $_SESSION['Nombre'] = $session->Nombre;
                        $_SESSION['Logo'] = $session->Nombre;
                    }
                    else
                    {
                        $session = null;
                    }
                }
            }

            if(!isset($session))
            {

                $session = UsuariosModel::select('Usuario.IdTipoUsuario AS IdTipoUsuario','Usuario.ID AS IDUsuario','Empleado.ID AS IDempleado', 'Empleado.Nombre', 'Empleado.NumeroDocumento', 'Empleado.IdEmpresa AS IdEmpresa', 'Empresa.Logo', 'Empresa.Nombre AS NombreEmpresa', 'Usuario.Confirmado', 'Usuario.CodigoConf')
                        ->join('TipoUsuario', 'TipoUsuario.ID' ,'=', 'Usuario.IdTipoUsuario')
                        ->join('Empleado', 'Empleado.IdUsuario' ,'=', 'Usuario.ID')
                        ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
                        ->where('Empleado.Estado', '=', 1)
                        //->where('Empresa.Estado', '=', 1)
                        // ->where('Usuario.Correo', $credentials['Correo'])->first();
                        ->where('Usuario.Login', $credentials['Login'])->first();

                if(isset($session))
                {
                    if($session->IdTipoUsuario == 3)
                    {
                        $_SESSION['IdTipoUsuario'] = $session->IdTipoUsuario;
                        $_SESSION['IdEmpresa'] = $session->IdEmpresa;
                        $_SESSION['IdEmpleado'] = $session->IDempleado;
                        $_SESSION['Nombre'] = $session->Nombre;
                        $_SESSION['Logo'] = $session->Nombre;
                    }
                    else
                    {
                        $session = null;
                    }
                }
            }

            if($session != null){
                    // Session::put("PRIVILEGIOS", $session);
                    // Session::save();
                    
                    if($session->IdTipoUsuario != 1){
                        
                        if(str_contains(strtolower($session->NombreEmpresa), 'claro') == true){
                            
                            $convenioVigente = $this->validarConvenioVigente($session['IdEmpleado'], $session['IdEmpresa']);
                            
                            if(!$convenioVigente){
                                return 'No existen convenios vigentes';
                            }    
                        }
                        else{
                            return 'Usuario no existe';   
                        }
                    }

                    // if($existe > 0 and $usuario['Confirmado'] == 0){
                    if($session['Confirmado'] == 0 && $session['IdTipoUsuario'] != 3){

                        $nombreUsuario = $session['Nombre'];
                        $numeroDocumento = $session['NumeroDocumento'];
                        $codigoConfirmacion = $session['CodigoConf'];
                        $PrimeraContraseña = md5($numeroDocumento);

                        // return $session['NumeroDocumento'];

                        // Se elimina algoritmo por solicitud del cliente
                        // $largo = strlen($numeroDocumento);

                        // $PrimeraContraseña = strtoupper(substr($nombreUsuario,0,1));
                        // $PrimeraContraseña = md5($PrimeraContraseña .substr($numeroDocumento,$largo - 4,4));

                        if($PrimeraContraseña == $Contrasena)
                        {
                            return redirect::to('/registro/verificacion/'.$codigoConfirmacion);
                        }
                        else
                        {
                            return 'La contraseña inicial asignada no es correcta';
                        }

                        
                    }
                    else if($session['Confirmado'] == 0 && $session['IdTipoUsuario'] != 3)
                    {
                        $IDUsuario = $session['IDUsuario'];
                        $DatosUsuario = UsuariosModel::find($IDUsuario);
                        $session['Confirmado'] = 1;
                        $data['Confirmado'] = $session['Confirmado'];
                        $data['ID'] = $IDUsuario;
                        $DatosUsuario->fill($data);
                        $DatosUsuario->save();
                    }

                    // if (! $token = auth()->attempt($credentials)) {
                    //     return response()->json(['error' => 'Unauthorized'], 401);
                    // }

                    if (! $token = JWTAuth::attempt($credentials)) {
                    return 'Usuario o contraseña incorrectos';
                    return response()->json(['error' => 'No Autorizado'], 401);
                    }
                        $response = compact('token');
                        $response['TipoUsuario'] = Auth::user();

                        // $retorno = Session::get("PRIVILEGIOS");
                        // echo "<pre>";
                        // var_dump($retorno);
                        // echo "</pre>";
                        // echo "<pre>";
                        // var_dump(Session::forget('PRIVILEGIOS'));
                        // echo "</pre>";

   
                       return redirect::to('/inicio/menuClaro');
            }else{
                return redirect::to('/InicioClaro');
            }
        }
         catch (JWTException $e)
        {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }
	
	
    
    private function validarConvenioVigente($IdEmpleado, $IdEmpresa)
    {
        $ConvenioVigente = 0;
        
        if($IdEmpleado != null){
            $Empresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
                ->where('Empleado.ID','=',$IdEmpleado)->select('Empresa.ID');    
                
            $IdEmpresa = $Empresa->first()->ID;
        }

        $Convenio = Convenio_Model::select('Convenio.ID')
                            ->where('Convenio.IdEmpresa','=', $IdEmpresa)
                            ->where('Convenio.FechaInicio','<=', date('y-m-d'))
                            ->where('Convenio.FechaFin','>=', date('y-m-d'))->first();

        // return $ConvenioVigente;

        if($Convenio != null && $Convenio->ID != 0)
        {
            return true;
        }
        
        return false;
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        session_start();
        session_destroy();
        return redirect::to('/');
        // \auth()->logout();

        // return response()->json(['message' => 'Successfully logged out']);
    }
    
    public function logoutClaro()
    {
        session_start();
        session_destroy();
        return redirect::to('/InicioClaro');
        // \auth()->logout();

        // return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 120,
        ]);
    }
}

