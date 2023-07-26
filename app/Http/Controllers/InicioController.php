<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    public function Index()
    {
    	// if(Session::get("PRIVILEGIOS") != null)
     //    	Session::forget('PRIVILEGIOS');

        // session_start();
        // if($_SESSION['IdTipoUsuario'] == null || $_SESSION['IdTipoUsuario'] == 0){
        //     session_destroy();
        //     return redirect::to('/');
        // }

        return view('Templates.master');
    }
    
    public function IndexClaro()
    {
    	// if(Session::get("PRIVILEGIOS") != null)
     //    	Session::forget('PRIVILEGIOS');

        // session_start();
        // if($_SESSION['IdTipoUsuario'] == null || $_SESSION['IdTipoUsuario'] == 0){
        //     session_destroy();
        //     return redirect::to('/');
        // }

        return view('Templates.master-claro');
    }

 	public function indexMenu()
    {
        session_start();
        if(! isset($_SESSION['IdTipoUsuario']))
        {
            session_destroy();
            return redirect::to('/');
        }

        $IdTipoUsuario = $_SESSION['IdTipoUsuario'];
        $Nombre = $_SESSION['Nombre'];

        // if(Session::get("PRIVILEGIOS") == null){
        //     Session::forget('PRIVILEGIOS');
        //     return redirect::to('/');
        // }
        if($IdTipoUsuario == 1)
        {
            return view('Templates.Menu');
        }
        else if($IdTipoUsuario == 2)
        {
            $IdEmpresa = $_SESSION['IdEmpresa'];
            return redirect::to('/empresa/IndexEmpresa/'.$IdEmpresa);
        }
        else if($IdTipoUsuario == 3)
        {
            $IdEmpleado = $_SESSION['IdEmpleado'];
            return redirect::to('/Empleado/IndexEmpleado/'.$IdEmpleado);
        }
        
    }
    
    public function indexMenuClaro()
    {
        session_start();
        if(! isset($_SESSION['IdTipoUsuario']))
        {
            session_destroy();
            return redirect::to('/InicioClaro');
        }

        $IdTipoUsuario = $_SESSION['IdTipoUsuario'];
        $Nombre = $_SESSION['Nombre'];

        // if(Session::get("PRIVILEGIOS") == null){
        //     Session::forget('PRIVILEGIOS');
        //     return redirect::to('/');
        // }
        if($IdTipoUsuario == 1)
        {
            return view('Templates.Menu-Claro');
        }
        else if($IdTipoUsuario == 2)
        {
            $IdEmpresa = $_SESSION['IdEmpresa'];
            return redirect::to('/empresa/IndexEmpresa/'.$IdEmpresa);
        }
        else if($IdTipoUsuario == 3)
        {
            $IdEmpleado = $_SESSION['IdEmpleado'];
            return redirect::to('/Empleado/IndexEmpleadoClaro/'.$IdEmpleado);
        }
        
    }
}
