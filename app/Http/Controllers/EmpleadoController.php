<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\HijoEmpleado_Model;
use Jugueteria\model\TipoDocumento_Model;
use Jugueteria\model\PedidoConvenio_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\model\UsuariosModel;
use Jugueteria\model\Novedad_Model;
use Jugueteria\model\Convenio_Model;
use Illuminate\Support\Facades\Session;
use File;
use Mail;
use DateTime;
use Jugueteria\model\Genero_model;

class EmpleadoController extends Controller
{  
    private $IdEmpresa;

	public function __construct(){
        //$this->middleware('auth', ['except' => ['Index,datatableJuguete,datatableListJuguete,postStore,postFormJuguete']]);
         $this->middleware(['auth:web' || 'auth:api']); 
    }
    public function Index($IdEmpresa)
    {
        // if(Session::get("PRIVILEGIOS") == null){
        //     Session::forget('PRIVILEGIOS');
        //     return redirect::to('/');
        // }

        session_start();
        if($_SESSION['IdTipoUsuario'] == null || $_SESSION['IdTipoUsuario'] == 0){
            session_destroy();
            return redirect::to('/');
        }

        $this->IdEmpresa = $IdEmpresa;
        return view('Empleado.index')->with(['IdEmpresa'=>$IdEmpresa]);
    }

    public function IndexEmpleado($Id)
    {
        session_start();
        $Empleado = EmpleadoModel::join('TipoDocumento', 'TipoDocumento.ID', '=', 'Empleado.IdTipoDocumento')
                                ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
                                ->select('Empresa.Nombre AS NombreEmpresa', 
                                        'Empleado.Nombre',
                                        'Empleado.Apellido',
                                        'TipoDocumento.Nombre AS NombreTipoDoc',
                                        'Empleado.NumeroDocumento',
                                        'Empleado.FechaNacimiento',
                                        'Empleado.Direccion',
                                        'Empleado.Telefono',
                                        'Empresa.Logo',
                                        'Empresa.ID as IdEmpresa')  
                                ->where('Empleado.ID','=',$Id)
                                ->get();


        $Hijo = HijoEmpleado_Model::join('Genero', 'Genero.ID', '=', 'HijoEmpleado.IdGenero') 
                                // ->join('TipoDocumento', 'TipoDocumento.ID', '=', 'HijoEmpleado.IdTipoDocumento')
                                ->select('Genero.Nombre AS NombreGenero',
                                        'HijoEmpleado.Id',
                                        'HijoEmpleado.Nombre',
                                        'HijoEmpleado.Apellido',
                                        'HijoEmpleado.Obsequio',
                                        // 'TipoDocumento.Nombre AS NombreTipoDoc',
                                        'HijoEmpleado.NumeroDocumento',
                                        'HijoEmpleado.FechaNacimiento')  
                                ->where('HijoEmpleado.IdEmpleado','=',$Id)
                                ->get();

        $LogoEmpresa = $Empleado->first()->Logo;
        $IdEmpresa = $Empleado->first()->IdEmpresa;

        return view('Empleado.indexEmpleado')->with(['Empleado'=>$Empleado, 'Hijo'=>$Hijo, 'IDEmpleado'=>$Id, 'LogoEmpresa'=>$LogoEmpresa, 'IdEmpresa'=>$IdEmpresa]);

    }
    
    public function IndexEmpleadoClaro($Id)
    {
        session_start();
        $Empleado = EmpleadoModel::join('TipoDocumento', 'TipoDocumento.ID', '=', 'Empleado.IdTipoDocumento')
                                ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
                                ->select('Empresa.Nombre AS NombreEmpresa', 
                                        'Empleado.Nombre',
                                        'Empleado.Apellido',
                                        'TipoDocumento.Nombre AS NombreTipoDoc',
                                        'Empleado.NumeroDocumento',
                                        'Empleado.FechaNacimiento',
                                        'Empleado.Direccion',
                                        'Empresa.Logo',
                                        'Empresa.ID as IdEmpresa')  
                                ->where('Empleado.ID','=',$Id)
                                ->get();


        $Hijo = HijoEmpleado_Model::join('Genero', 'Genero.ID', '=', 'HijoEmpleado.IdGenero') 
                                // ->join('TipoDocumento', 'TipoDocumento.ID', '=', 'HijoEmpleado.IdTipoDocumento')
                                ->select('Genero.Nombre AS NombreGenero',
                                         'HijoEmpleado.Id',
                                        'HijoEmpleado.Nombre',
                                        'HijoEmpleado.Apellido',
                                        // 'TipoDocumento.Nombre AS NombreTipoDoc',
                                        'HijoEmpleado.NumeroDocumento',
                                        'HijoEmpleado.FechaNacimiento')  
                                ->where('HijoEmpleado.IdEmpleado','=',$Id)
                                ->get();

        $LogoEmpresa = $Empleado->first()->Logo;
        $IdEmpresa = $Empleado->first()->IdEmpresa;

        return view('Empleado.indexEmpleado-Claro')->with(['Empleado'=>$Empleado, 'Hijo'=>$Hijo, 'IDEmpleado'=>$Id, 'LogoEmpresa'=>$LogoEmpresa, 'IdEmpresa'=>$IdEmpresa]);

    }

    public function validarConvenioVigente($IdEmpleado, $IdHijo)
    {
        session_start();
        $ConvenioVigente = 0;
        $Empresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('Empleado.ID','=',$IdEmpleado)->select('Empresa.ID');

        $IdEmpresa = $Empresa->first()->ID;

        $Convenio = Convenio_Model::select('Convenio.ID')
                            ->where('Convenio.IdEmpresa','=', $IdEmpresa)
                            ->where('Convenio.FechaInicio','<=', date('y-m-d'))
                            ->where('Convenio.FechaFin','>=', date('y-m-d'))->first();

        // return $ConvenioVigente;

        if($Convenio != null)
        {
            $ConvenioVigente = $Convenio->ID;
        }

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');
        
        if($IdHijo != null){
            $seleccionHijo = PedidoConvenio_Model::join('JugueteConvenio', 'JugueteConvenio.ID', '=', 'PedidoConvenio.IdJugueteConvenio')
            ->join('Convenio', 'Convenio.ID', '=', 'JugueteConvenio.IdConvenio')
            ->join('Empresa', 'Empresa.ID', '=', 'Convenio.IdEmpresa')
            ->join('Empleado', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
            ->where('Empleado.ID','=',$IdEmpleado)
            ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
            ->where('Convenio.FechaFin','>=',date("Y-m-d"))
            ->where('PedidoConvenio.IdHijoEmpleado','=',$IdHijo)
            // ->orderBy('ID','asc')
            ->pluck('PedidoConvenio.IdHijoEmpleado');

            if(count($seleccionHijo) > 0){
                $retorno = [
                    "success" => false,
                    "mensaje" => "Ya ha seleccionado los juguetes"
                ];   

                return response()->json($retorno);
            }
            
        }

        if($ConvenioVigente == null || $ConvenioVigente == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "No existen convenios vigentes"
            ];

            return response()->json($retorno);
        }

        if(count($hijoEmpleado) == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "Ya ha seleccionado los juguetes para todos sus hijos"
            ];
            
            return response()->json($retorno);
        }

        $retorno = [ "success" => true, "mensaje" => '/pedidoEmpleado/Index/'.$IdEmpleado ];
        
        return response()->json($retorno);
        
        //return redirect::to('/pedidoEmpleado/Index/'.$IdEmpleado);

        
    }
    
    public function validarConvenioVigenteClaro($IdEmpleado, $IdHijo)
    {
        session_start();
        $ConvenioVigente = 0;
        $Empresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('Empleado.ID','=',$IdEmpleado)->select('Empresa.ID');

        $IdEmpresa = $Empresa->first()->ID;

        $Convenio = Convenio_Model::select('Convenio.ID')
                            ->where('Convenio.IdEmpresa','=', $IdEmpresa)
                            ->where('Convenio.FechaInicio','<=', date('y-m-d'))
                            ->where('Convenio.FechaFin','>=', date('y-m-d'))->first();

        // return $ConvenioVigente;

        if($Convenio != null)
        {
            $ConvenioVigente = $Convenio->ID;
        }

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');
        
        if($IdHijo != null){
            $seleccionHijo = PedidoConvenio_Model::join('JugueteConvenio', 'JugueteConvenio.ID', '=', 'PedidoConvenio.IdJugueteConvenio')
            ->join('Convenio', 'Convenio.ID', '=', 'JugueteConvenio.IdConvenio')
            ->join('Empresa', 'Empresa.ID', '=', 'Convenio.IdEmpresa')
            ->join('Empleado', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
            ->where('Empleado.ID','=',$IdEmpleado)
            ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
            ->where('Convenio.FechaFin','>=',date("Y-m-d"))
            ->where('PedidoConvenio.IdHijoEmpleado','=',$IdHijo)
            // ->orderBy('ID','asc')
            ->pluck('PedidoConvenio.IdHijoEmpleado');

            if(count($seleccionHijo) > 0){
                $retorno = [
                    "success" => false,
                    "mensaje" => "Ya ha seleccionado los juguetes"
                ];   

                return response()->json($retorno);
            }
            
        }

        if($ConvenioVigente == null || $ConvenioVigente == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "No existen convenios vigentes"
            ];

            return response()->json($retorno);
        }

        if(count($hijoEmpleado) == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "Ya ha seleccionado los juguetes para todos sus hijos"
            ];
            
            return response()->json($retorno);
        }

        $retorno = [ "success" => true, "mensaje" => '/pedidoEmpleado/IndexClaro/'.$IdEmpleado ];
        
        return response()->json($retorno);
        
        //return redirect::to('/pedidoEmpleado/Index/'.$IdEmpleado);

        
    }
    
    /*
    public function validarConvenioVigenteClaro($IdEmpleado)
    {
        session_start();
        
        $ConvenioVigente = 0;
        $Empresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('Empleado.ID','=',$IdEmpleado)->select('Empresa.ID');

        $IdEmpresa = $Empresa->first()->ID;

        $Convenio = Convenio_Model::select('Convenio.ID')
                            ->where('Convenio.IdEmpresa','=', $IdEmpresa)
                            ->where('Convenio.FechaInicio','<=', date('y-m-d'))
                            ->where('Convenio.FechaFin','>=', date('y-m-d'))->first();

        // return $ConvenioVigente;

        if($Convenio != null)
        {
            $ConvenioVigente = $Convenio->ID;
        }

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('HijoEmpleado.Estado','=',"1")
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');

        if($ConvenioVigente == null || $ConvenioVigente == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "No existen convenios vigentes"
            ];

            return response()->json($retorno);
        }

        if(count($hijoEmpleado) == 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "Ya ha seleccionado los juguetes para todos sus hijos"
            ];
            
            return response()->json($retorno);
        }

        $retorno = [ "success" => true, "mensaje" => '/pedidoEmpleado/IndexClaro/'.$IdEmpleado ];
        
        return response()->json($retorno);
        
        //return redirect::to('/pedidoEmpleado/Index/'.$IdEmpleado);

        
    }
    */

    public function validarSelecHijoIndividual($IdHijo)
    {
        session_start();

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->join('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.Id','=',$IdHijo)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');

        if(count($hijoEmpleado) > 0)
        {
            $retorno = [
                "success" => false,
                "mensaje" => "Ya ha seleccionado el juguete para ".$hijoEmpleado->Nombre
            ];
            
            return response()->json($retorno);
        }

        $retorno = [ "success" => true, "mensaje" => '/pedidoEmpleado/Index/'.$IdEmpleado ];
        
        return response()->json($retorno);
        
        //return redirect::to('/pedidoEmpleado/Index/'.$IdEmpleado);
        
    }

    public function Masivoempleado(Request $request){
        session_start();
        $titulo = "masivo Empleado";
        $datos =  new EmpleadoModel();
        $datos['IdEmpresa'] = $request->get("empresa");
        $view = view('Empleado.MasivoEmpleado')->with(['titulo' => $titulo,'datos'=>$datos]);

        return $view->renderSections()['content_modal'];
        
    	if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
        //return view('Empleado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableListEmpleado(Request $request){

        session_start();
        // Datos de DATATABLE
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'];
        
        $tipoUsuario = null;
        $EmpleadoID = null;
        // if(Session::get("PRIVILEGIOS") != null){
        //     $tipoUsuario = Session::get("PRIVILEGIOS")->IdTipoUsuario;
        //     $EmpleadoID = Session::get("PRIVILEGIOS")->IDempleado;
        // }

        $tipoUsuario = $_SESSION['IdTipoUsuario'];
        $result = EmpleadoModel::join('Usuario','Usuario.ID','=','Empleado.IdUsuario')
         ->join('TipoDocumento','TipoDocumento.Id','=','Empleado.IdTipoDocumento')
         ->select(
         	'Empleado.ID',
         	'Empleado.IdUsuario',
			'Empleado.IdEmpresa',
			'Empleado.Nombre',
			'Empleado.Apellido',
			'Empleado.IdTipoDocumento',
			'Empleado.NumeroDocumento',
            'Usuario.Correo',
			'Empleado.Direccion',
            'Empleado.Telefono',
            'Empleado.Ciudad',
			'Empleado.Estado',
			'TipoDocumento.Nombre as NombreTipoDoc')
			->where('Empleado.IdEmpresa',$request->get("empresa"));

                                    //->orderBy("Idresult", "desc");//
            switch ($tipoUsuario ) {
            case '3':
                if(isset($_SESSION['IDempleado']))
                {
                    $EmpleadoID = $_SESSION['IDempleado'];
                    $result = $result->where('Empleado.ID','=',$EmpleadoID);
                }
                
                break;
            default:
                break;
        } 


        $result  = $result->orderBy($orderBy, $sortColumnDir);  

        
        $totalRegistros = $result->count();
        //BUSCAR            
            if($search['value'] != null){
                $result = $result->whereRaw(
                        "(Empleado.ID LIKE '%".$search["value"]."%' OR ". 
                         "Empleado.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "Empleado.Apellido LIKE '%". $search['value'] . "%' OR " .
                         "NumeroDocumento LIKE '%". $search['value'] . "%' OR " .
                         "Direccion LIKE '%". $search['value'] . "%' OR " .
                         "Ciudad LIKE '%". $search['value'] . "%' OR " .
                         "TipoDocumento.Nombre LIKE '%". $search['value']. "%')");
            }
        
        $parcialRegistros = $result->count();
        $result = $result->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $result->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$result->get()];

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        try {

            session_start();

            $Id = $request->input('ID');
            $data = $request->all();
            $empleadoExiste = null;
            $empleadoExiste = EmpleadoModel::where('NumeroDocumento', $request->input('NumeroDocumento'))->first();
            $actualizacion = $request->input('Actualizacion');

            if($empleadoExiste != null && $actualizacion == ""){

                return response()->json([
                        'mensaje'=>"Error al crear, el empleado con el documento ".$request->input('NumeroDocumento').", ya existe",
                        'error' => 'error'
                    ]);
            }

            $datos = $Id == "" ? new EmpleadoModel() : EmpleadoModel::find($Id);

            if($Id != ""){
	        	$datosusu = UsuariosModel::find($datos['IdUsuario']);
	        	// $datosusu['Correo'] = $request->input('Login');
                if($request->input('Correo') != ""){
                    $datosusu['Correo'] = $request->input('Correo');
                }
                if($request->input('NumeroDocumento') != ""){
                    $datosusu['Login'] = $request->input('NumeroDocumento');
                }
                $datosusu->save();
	        }else{


                $datosusu = new UsuariosModel();
                $numeroDocumento = $request->input('NumeroDocumento');
                $Nombre = $request->input('Nombre');

                //Se elimina algoritmo por solicitud del cliente
                // $largo = strlen($numeroDocumento);
                // $PrimeraContraseña = strtoupper(substr($Nombre,0,1));
                // $PrimeraContraseña = $PrimeraContraseña .substr($numeroDocumento,$largo - 4,4);

				$datosusu['Contrasena'] = md5($request->input('NumeroDocumento'));
                // $datosusu['Contrasena'] = md5($PrimeraContraseña);
                $datosusu['Correo'] = $request->input('Correo');
                $datosusu['IdTipoUsuario'] = 3;
                $datosusu['Confirmado'] = 0;
                $datosusu['CodigoConf'] = str_random(25);
                $datosusu['Login'] = $numeroDocumento;
                // $datosusu['CodigoConf'] = "";
                // $datosusu['Correo'] = $request->input('Login');


                $datosusu->save();
		 	}

            $datos->fill($data);

            if($Id == ""){ $datos['IdUsuario'] = $datosusu->ID;}
            $datos['Direccion'] = $request->input('Direccion');
            $datos['Ciudad'] = $request->input('Ciudad');
            $datos['Telefono'] = $request->input('Telefono');
         	$datos['estado'] = 1;

            if($actualizacion == 1)
            {
                $datos['Datos_Confirmados'] = 1;
            }
            $datos->save();
    
        } catch (\Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }

        $retorno = [
                "success" => true,
                "mensaje" => "Datos guardados correctamente",
                //"request" => $request->all(),
                "result" => $datos
            ];
		return response()->json($retorno);
        //return view('Empleado.index');
    }

    public function postFormempleado(Request $request)
    {
        session_start();
        $titulo = "Empleado";
        $ID = $request->input('IdJuguete');
        $datos = $ID == "" ? new EmpleadoModel() : EmpleadoModel::find($ID);

        if($ID != ""){
        	$datosusu = UsuariosModel::find($datos['IdUsuario']);
			$datos['Correo'] = $datosusu['Correo'];	
        }
        else{
            $datosusu = new UsuariosModel();
            $datosusu['Correo'] = '';
        }

        $tipodoc = [null=>'Seleccione...'];
        $tipodoc = TipoDocumento_Model::orderBy('ID','asc')->pluck('Nombre','Id');
        $view = view('Empleado.formEmpleado')->with(['datos' => $datos, 'titulo' => $titulo, 'tipodoc'=>$tipodoc, 'datosUsu' => $datosusu]);

        return $view->renderSections()['content_modal'];
        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }       
    }


    public function cambiaEstado(Request $request)
    {
        try {

            session_start();
            
            $Id = $request->input('Id');
            $estado = $request->input('estado');
            $datos = EmpleadoModel::find($Id);
            $datos['estado'] = $estado;
            $data = $request->all();
            $datos->fill($data);
            $datos->save();
    
        } catch (\Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }
        
        return response([
                "success" => true,
                "mensaje" => "Datos guardados correctamente",
                //"request" => $request->all(),
                "datos" => $datos
            ]);
    }

    public function eliminarEmpleado(Request $request)
    {
        try{

            session_start();
            $IdEmpleado = $request->input('IdEmpleado');
            $IdEmpresa = $request->input('IdEmpresa');
            
            //De devuelve el stoc si el empleado ya ha seleccionado algun juguete para sus hijos en el convenio vigente
            $return = DB::select("call DevolverStockEmpleado (".$IdEmpleado.")");

            $Empleado = EmpleadoModel::select('IdUsuario')
                                ->where('Empleado.ID', '=', $IdEmpleado)
                                ->first();

            $IdUsuario = $Empleado->IdUsuario;

            $Empleado->delete();

            DB::table('Usuario')->where('Usuario.ID', '=', $IdUsuario)->Delete();

            return view('Empleado.index')->with(['IdEmpresa'=>$IdEmpresa]);
            
        }

        catch (\Exception $e){

            return response([
                    "mensaje" => "Error al eliminar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);

        }
    }


    public function GuardarTxt(Request $request){
        try{

                $root = $_SERVER["DOCUMENT_ROOT"];
                $data = $request->all();
                $Id = $request->input('Id');

                //$file = $request->file('file');
                $file = $_FILES['file'];
                $tmpfile = $_FILES["file"]["tmp_name"];
                $allowedFiles = array('txt');
                //$path = public_path().'/uploads/Masivo/empleado/'.$Id.'/'; 
                $path = $root.'/uploads/Masivo/empleado/'.$Id.'/';

                if($file != null ){
                    //$archivo =  str_replace(" ", "_", $file->getClientOriginalName());
                    $archivo =  str_replace(" ", "_", $file['name']);
                    $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                    if(in_array($extension,$allowedFiles)){                    
                        if(!file_exists($path)){
                          mkdir($path,0777,true);
                          chmod($path, 0777); 
                        }                       
                    }

                    //$fileName = str_replace(" ", "_", $file->getClientOriginalName());
                    //$file->move($path, 'dato_'.$Id.'.'.$extension);   
                    //$leerarchivoTxt = explode("\n",File::get($path. '/dato_'.$Id.'.'.$extension));
                    
                    $fileName = str_replace(" ", "_", $archivo);
                    $move = rename($tmpfile, $path.'dato_'.$Id.'.'.$extension);
                    $leerarchivoTxt = explode("\n",File::get($path. '/dato_'.$Id.'.'.$extension));
                    $leerarchivo = $this->letrasReplace($leerarchivoTxt);

                    $result_texto = '';

                   // var_dump($leerarchivo);
                    foreach ($leerarchivo as $key=>$line){
                        $datosLinea = explode(',', $line);
                        //echo count($datosLinea);
                         $datos =  new EmpleadoModel();
                         $datosusu = new UsuariosModel();

                        
                        if(count($datosLinea) > 0  && (count($datosLinea) == 8 || count($datosLinea) == 13)){
                            $empleadoExiste = null;
                            if(is_string($datosLinea[3])){
                                $empleadoExiste = EmpleadoModel::where('NumeroDocumento',trim($datosLinea[3]))/*->where('IdEmpresa',$request->input('IdEmpresa'))*/->first();
                            }

                            if($empleadoExiste == null){
                                if(is_string($datosLinea[0])){
                                    $datos['Nombre'] = utf8_encode($datosLinea[0]);
                                    if(is_string($datosLinea[1])){
                                        $datos['Apellido'] = utf8_encode($datosLinea[1]);
                                        if(is_string($datosLinea[2])){  
                                            $id_codigo = TipoDocumento_Model::where('Codigo',$datosLinea[2])->select('ID')->first();
                                            $datos['IdTipoDocumento'] = ($id_codigo['ID'] != null)?$id_codigo['ID']:1;
                                            if(is_string($datosLinea[3])){
                                                $datos['NumeroDocumento'] = utf8_encode(trim($datosLinea[3]));
                                                if(is_string($datosLinea[4])){
                                                    $datos['Direccion'] = utf8_encode(trim($datosLinea[4]));
                                                    if(is_string($datosLinea[5])){
                                                        $datos['Telefono'] = utf8_encode($datosLinea[5]);
                                                            if(is_string($datosLinea[6])){
                                                                $datos['Ciudad'] = utf8_encode($datosLinea[6]);
                                                                if(is_string($datosLinea[7])){
                                                                    $datosusu['Correo'] = utf8_encode(trim($datosLinea[7]));
                                                                }else{
                                                                    $result_texto .= '| Email no valido, linea:'.$key.' |';
                                                                }
                                                                }else{
                                                                    $result_texto .= '| Ciudad no valida, linea:'.$key.' |';
                                                                }
                                                            }
                                                        else
                                                        {
                                                            $result_texto .= '| Telefono no valido, linea:'.$key.' |';
                                                        }
                                                }else{
                                                    $result_texto .= '| Direccion no valida, linea:'.$key.' |';
                                                }
                                            }else{
                                                $result_texto .= '| NumeroDocumento no valido, linea:'.$key.' |';
                                            }
                                        }else{
                                            $result_texto .= '| IdTipoDocumento no valido, linea:'.$key.' |';
                                        }
                                    }else{
                                        $result_texto .= '| Apellido no valido, linea:'.$key.' |';
                                    }
                                }else{
                                    $result_texto .= '| Nombre no valido, linea:'.$key.' |';
                                }
                            }

                            if($result_texto == '' ){

                                if(count($datosLinea) == 13){
                                    $datosHijos = new HijoEmpleado_Model();
                                    $hijoexiste = null;

                                    if(is_string($datosLinea[8])){
                                        $datosHijos['Nombre']=utf8_encode($datosLinea[8]);
                                        if(is_string($datosLinea[9])){
                                            $datosHijos['Apellido']=utf8_encode($datosLinea[9]);
                                            $hijoexiste = HijoEmpleado_Model::where('Nombre', 'like', '%'.trim($datosLinea[8]).'%')
                                            ->where('Apellido', 'like', '%'.trim($datosLinea[9]).'%')->first();
                                            if(is_string($datosLinea[10])){  
                                                $id_codigoH = Genero_model::where('Codigo',$datosLinea[10])->select('ID')->first();
                                                $datosHijos['IdGenero'] = ($id_codigoH['ID'] != null)?$id_codigoH['ID']:1;
                                                if($this->validateDate($datosLinea[11])){
                                                    $datosHijos['FechaNacimiento'] = utf8_encode(trim($datosLinea[11]));
                                                }else{
                                                    $result_texto .= '| Fecha de macimiento no valida, linea:'.$key.' |';
                                                }
                                            }else{
                                                $result_texto .= '| Genero del hijo no valido, linea:'.$key.' |';
                                            }
                                        }else{
                                            $result_texto .= '| Apellido del hijo no valido, linea:'.$key.' |';
                                        }
                                    }else{
                                        $result_texto .= '| Nombre del hijo no valido, linea:'.$key.' |';
                                    }

                                    $datosHijos['Estado'] = 1;
                                    $datosHijos['Obsequio'] = $datosLinea[12];
                                }

                                if($empleadoExiste == null ){// && (count($datosLinea) ==){
                                    $datosusu['Login'] = $datos['NumeroDocumento'];
                                    //Se elimina algoritmo por solicitud del cliente
                                    // $largo = strlen($datos['NumeroDocumento']);

                                    // $PrimeraContraseña = strtoupper(substr($datos['Nombre'],0,1));
                                    // $PrimeraContraseña = $PrimeraContraseña .substr($datos['NumeroDocumento'],$largo - 4,4);

                                    // $datosusu['Contrasena'] = md5($PrimeraContraseña);

                                    $datosusu['Contrasena'] = md5($datos['NumeroDocumento']);
                                    $datosusu['Confirmado'] = 0;
                                    $datosusu['CodigoConf'] = str_random(25);
                                    $datosusu['IdTipoUsuario'] = 3;
                                    $datosusu->save();
                                    $datos['IdUsuario'] = $datosusu->ID;

                                    $datos['IdEmpresa'] = $request->input('IdEmpresa');
                                    //$datos['IdUsuario'] = 1;
                                    $datos->save();

                                    if(count($datosLinea) == 13 && $hijoexiste == null){
                                        $datosHijos['IdEmpleado'] = $datos->ID;
                                        $datosHijos->save();
                                    }
                                }else{
                                    if(count($datosLinea) == 13 && $hijoexiste == null){
                                        $datosHijos['IdEmpleado'] = $empleadoExiste['ID'];
                                        $datosHijos->save();
                                    }
                                }
                            }
                            
                        }else{
                            $result_texto = 'Error  al guardar. Cadena de texto no coniside, linea: '.$key.' LINEA: '. $line;
                        }
                    }

                    if($result_texto != ''){
                        return response()->json([
                                'mensaje'=>$result_texto,    
                                'error' => 'error',
                                'count' => count($datosLinea),
                            ]);
                    }
                }else{
                    return response()->json([
                    'mensaje'=>"Error al guardar. Extensión no válida."        
                    
                    ]);
                }
                return response()->json([
                   'mensaje'=> "Datos guardados Correctamente", 
                   'ID' => $Id,
                   'success' => 'success'
                 ]);

            }catch (\Exception $e) {
                return response()->json([
                    'mensaje'=>"Error  al guardar. Por favor intenta de nuevo.",         
                    'error' => $e->getMessage()
                ]);
            }
    }

    public function letrasReplace($arrTxt){
    
        $cadena = "";
        
        for ($i = 0; $i < count($arrTxt); $i++)
        {
            $cadena = utf8_encode($arrTxt[$i]);
            //Reemplazamos la A y a
            $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
            );
     
            //Reemplazamos la E y e
            $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena );
     
            //Reemplazamos la I y i
            $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena );
     
            //Reemplazamos la O y o
            $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena );
     
            //Reemplazamos la U y u
            $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena );
     
            //Reemplazamos la N, n, C y c
            $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
            );
            
            $cadena = str_replace(
            array('#', '"'),
            array('No', ''),
            $cadena
            );
            
            $arrTxt[$i] = $cadena;
            
            
        }
        
        return $arrTxt;
    
    }

    function email($str){
	  return (false !== strpos($str, "@") && false !== strpos($str, "."));
	}

	function validateDate($date, $format = 'YYYY-MM-DD')
	{
		try{
			\DateTime::createFromFormat("Y-m-d", $date);
			return true;
		}catch(\Exception $e) {
			return false;
		}
	    // $d = \DateTime::createFromFormat($format, $date);
	    // return $d && $d->format($format) == $date;
	}

    public function GuardarNovedad(Request $request)
    {
        try {
            $Novedad = new Novedad_Model();

            $Novedad['IDEmpleado'] = $request['_IDEmpleado'];
            $Novedad['Novedad'] = $request['_Novedad'];
            $Novedad->save();

            $IdEmpleado = $request['_IDEmpleado'];

            $Empresa = Empresa_Model::join('Empleado', 'Empleado.IdEmpresa', '=', 'Empresa.ID')
                        ->where('Empleado.ID','=', $IdEmpleado)
                        ->select('Empresa.Nombre', 'Empresa.CorreoComercial');

            $Empleado = EmpleadoModel::join('Usuario', 'Usuario.ID', '=', 'Empleado.IdUsuario')
                               ->where('Empleado.ID', '=', $IdEmpleado)
                               ->select('Empleado.Nombre', 'Empleado.Apellido');

            $NombreEmpresa = $Empresa->first()->Nombre;
            $CorreoComercial = $Empresa->first()->CorreoComercial;
            $NombreEmpleado = $Empleado->first()->Nombre;
            $ApellidoEmpleado = $Empleado->first()->Apellido;

            $data['NombreUsuario'] = $NombreEmpleado.' '.$ApellidoEmpleado;
            $data['Novedad'] = $request['_Novedad'];
            $data['CorreoComercial'] = $CorreoComercial;
            $data['NombreEmpresa'] = $NombreEmpresa;

            //envio correo de novedad
            Mail::send('Correos.Novedad',['data' => $data],function($mensaje) use ($data){
                $mensaje->from('ventascorporativas@maicaogiftstore.com');
                $mensaje->to($data['CorreoComercial'], $data['NombreUsuario'])->subject('Novedad Empleado '.$data['NombreUsuario'] );
            });
    
        } catch (\Exception $e) {
            return response([
                    "error" => $e->getMessage()
                ]);
        }
        
        return response([
                "success" => true
            ]);
    }

    public function ConfirmarDatosEmpleado(Request $request)
    {
        try {

            session_start();

            $Hoy = new DateTime(date("yy-m-d"));
            $IdEmpleado = $request['_IDEmpleado'];
            $dataEmpleado = EmpleadoModel::find($IdEmpleado);

            $Empleado = EmpleadoModel::select(
                                    'Empleado.IdUsuario',
                                    'Empleado.Nombre',
                                    'Empleado.Apellido',
                                    'Empleado.Direccion',
                                    'Empleado.Telefono',
                                    'Empleado.Ciudad',
                                    'Empleado.IdEmpresa',
                                    'Empleado.Updated_At',
                                    'Empleado.Datos_Confirmados'
                                )
                               ->where('Empleado.ID', '=', $IdEmpleado)
                               ->first();;


            $NombreEmpleado = $Empleado->Nombre;
            $ApellidoEmpleado = $Empleado->Apellido;
            $IdEmpresa = $Empleado->IdEmpresa;            
            $TelefonoEmpleado = $Empleado->Telefono;
            $DireccionEmpleado = $Empleado->Direccion;
            $CiudadEmpleado = $Empleado->Ciudad;
            $ConfirmDatos = $Empleado->Datos_Confirmados;
            $FechaActualizacion = new DateTime($Empleado->Updated_At);

            //Diferencia entre dos fechas
            $diff = $FechaActualizacion->diff($Hoy)->days;

            $data['IdEmpleado'] = $IdEmpleado;
            $data['IdEmpresa'] = $IdEmpresa;
            $data['NombreUsuario'] = $NombreEmpleado.' '.$ApellidoEmpleado;
            $data['TelefonoEmpleado'] = $TelefonoEmpleado;            
            $data['DireccionEmpleado'] = $DireccionEmpleado;
            $data['CiudadEmpleado'] = $CiudadEmpleado;
            $data['ConfirmDatos'] = "0";

            $CorreoEmpleado = UsuariosModel::find($Empleado->IdUsuario)->Correo;
            $data['CorreoEmpleado'] = $CorreoEmpleado;

            if($diff < 30 && $ConfirmDatos == "1")
            {
                $data['ConfirmDatos'] = "1";

                return response([
                "success" => false,
                "data" => $data
                ]);
            }
            else if($diff > 30 && $ConfirmDatos == "1")
            {
                $data['ConfirmDatos'] = "0";
                $dataEmpleado['Datos_Confirmados'] = "0";
                $dataEmpleado->save();
            }
            
    
        } catch (\Exception $e) {
            return response([
                    "error" => $e->getMessage()
                ]);
        }
        
        return response([
                "success" => true,
                "data" => $data
            ]);
    }

    public function postFormempleadoAct(Request $request)
    {
        session_start();
        $titulo = "Tratamiento de datos y Actualización";
        $datos = $request->datos;
        $view = view('Empleado.formActualizarDatosEmpleado')->with(['datos' => $datos, 'ID' => $datos["IdEmpleado"], 'titulo' => $titulo]);

        return $view->renderSections()['content_modal'];
        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
    }

}
