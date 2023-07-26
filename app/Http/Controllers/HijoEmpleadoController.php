<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\HijoEmpleado_Model;
use Jugueteria\model\TipoDocumento_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\model\Usuario_Model;
use Jugueteria\model\Genero_model;
use Illuminate\Support\Facades\Session;
use File;


class HijoEmpleadoController extends Controller
{
	public function __construct(){
        //$this->middleware('auth', ['except' => ['Index,datatableJuguete,datatableListJuguete,postStore,postFormJuguete']]);
         $this->middleware(['auth:web' || 'auth:api']); 
    }

    public function Index(Request $request)
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

        $IdEmpleado = $request->input('IdEmpleado');

        $view = view('HijoEmpleado.index')->with(['titulo' =>'Hijos del empleado','IdEmpleado'=>$IdEmpleado]);
        
        return $view->renderSections()['content_modal'];
        
        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
    }

    public function datatableListEmpleadoHijo(Request $request){
        session_start();
        // Datos de DATATABLE
        $IdEmpleadoP = $request->get("IdEmpleadoP");
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'];
        
        $result = HijoEmpleado_Model::join('TipoDocumento','TipoDocumento.Id','=','HijoEmpleado.IdGenero')
        ->join('Genero', 'HijoEmpleado.IdGenero', '=', 'Genero.ID')
        ->join('Empleado','Empleado.Id','=','HijoEmpleado.IdEmpleado')
         ->select(
            'HijoEmpleado.ID',
            'HijoEmpleado.IdEmpleado',
            'HijoEmpleado.Nombre',
            'HijoEmpleado.Apellido',
            'HijoEmpleado.IdTipoDocumento',
            'HijoEmpleado.NumeroDocumento',
            'HijoEmpleado.FechaNacimiento',
            'HijoEmpleado.Estado',
            'HijoEmpleado.Obsequio',
            'TipoDocumento.Nombre as NombreTipoDocumento',
            'Genero.Nombre as NombreGenero')->where('Empleado.ID',$IdEmpleadoP);
                                    //->orderBy("Idresult", "desc");//

        $result  = $result->orderBy($orderBy, $sortColumnDir);  
      
        $totalRegistros = $result->count();
        //BUSCAR            
            if($search['value'] != null){
                $result = $result->whereRaw(
                        "(HijoEmpleado.ID LIKE '%".$search["value"]."%' OR ". 
                         "HijoEmpleado.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "HijoEmpleado.Apellido LIKE '%". $search['value'] . "%' OR " .
                         "HijoEmpleado.NumeroDocumento LIKE '%". $search['value'] . "%' OR " .
                         "HijoEmpleado.FechaNacimiento LIKE '%". $search['value'] . "%' OR " .
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

    public function postForm(Request $request)
    {
        session_start();
        $IdEmpleado = $request->input('IdEmpleado');
        $ID = $request->input('ID');
        $datos = $ID == "" ? new HijoEmpleado_Model() : HijoEmpleado_Model::find($ID);
        $tipodoc = [null=>'Seleccione...'];
        $tipodoc = TipoDocumento_Model::orderBy('ID','asc')->pluck('Nombre','Id');
        $genero = Genero_model::orderBy('Id','asc')->pluck('Nombre','Id');
        $view = view('HijoEmpleado.formHijoEmpleado')->with(['datos' => $datos, 'tipodoc'=>$tipodoc,'IdEmpleado'=>$IdEmpleado,'genero'=>$genero]);
        
        return $view->renderSections()['content_modal'];

        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }       
    }

    public function postStore(Request $request)
    {
        try {
            session_start();
            $IdEmpleado = $request->input('IdEmpleado');
            $Id = $request->input('Id');
            $data = $request->all();
            //echo $Id;
            $datos = $Id == "" ? new HijoEmpleado_Model() : HijoEmpleado_Model::find($Id);

            $datos->fill($data);
            $datos['Estado'] = 1;
            $datos['IdTipoDocumento'] = 0;
            $datos['NumeroDocumento'] = "";
            $datos->save();
    
        } catch (Exception $e) {
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


    public function cambiaEstado(Request $request)
    {
        try {
            
            $Id = $request->input('Id');
            $estado = $request->input('estado');
            $datos = HijoEmpleado_Model::find($Id);
            $datos['estado'] = $estado;
            $data = $request->all();
            $datos->fill($data);
            $datos->save();
            if($estado == 1)
                EmpleadoModel::where('Id', $datos['IdEmpleado'])->update(['Estado' => $estado]);
    
        } catch (Exception $e) {
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
    
    public function eliminarHijo(Request $request)
    {
        try{
            session_start();
            var_dump($request);
            $IdHijo = $request->input('IdHijo');
            $IdEmpleado = $request->input('IdEmpleado');
            $IdEmpresa = $request->input('IdEmpresa');
            //TODO
            //De devuelve el stock si el empleado ya ha seleccionado algun juguete para sus hijos en el convenio vigente
            //$return = DB::select("call DevolverStockEmpleado (".$IdEmpleado.")");
            DB::table('HijoEmpleado')->where('HijoEmpleado.ID', '=', $IdHijo)->delete();
            
            
            return response([
                "success" => true,
                "mensaje" => "Datos eliminados correctamente",
                "request" => $request->all()
            ]);
            
            /*
            return view('Empleado.index')->with(['IdEmpresa'=>$IdEmpresa]);
            */
            
        }

        catch (Exception $e){

            return response([
                    "mensaje" => "Error al eliminar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);

        }
    }



}
