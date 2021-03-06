<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Jugueteria\Empresa;
use App\Http\Requests;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\TipoDocumento_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class EmpresaController extends Controller
{
    public function __construct(){
        //$this->middleware('auth', ['except' => ['Index,datatableJuguete,datatableListJuguete,postStore,postFormJuguete']]);
         $this->middleware(['auth:web' || 'auth:api']); 
    }

    public function Masivoempresa(Request $request){
        $titulo = "masivo Empresa";
        $datos =  new Empresa_Model();
        $datos['IdEmpresa'] = 1;
        $view = view('Empresa.MasivoEmpresa')->with(['titulo' => $titulo,'datos'=>$datos]);

          if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
        //return view('Empresa.index');
    }

    public function Index()
    {
        if(Session::get("PRIVILEGIOS") == null){
            Session::forget('PRIVILEGIOS');
            return redirect::to('/');
        }
        return view('Empresa.index');
    }

    public function datatableListEmpresa(Request $request){
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'] == 'ID' ? 'Empresa.ID' :  $columna[$sortColumnIndex]['data'];
        
        $empresas = Empresa_Model::join('TipoDocumento','TipoDocumento.Id','=','Empresa.IdTipoDocumento')
        //join('TipoDocumento','TipoDocumento.ID','=','Empresa.IdTipoDocumento')
                 ->select(
                        'Empresa.ID',
                        'Empresa.IdUsuario',
                        'Empresa.Nombre',
                        'Empresa.IdTipoDocumento',
                        'TipoDocumento.Nombre AS NombreTipoDocumento',
                        'Empresa.NumeroDocumento',
                        'Empresa.Logo',
                        'Empresa.Estado');
                        //->orderBy("IdEmpresa", "desc");)

        $empresas = $empresas->orderBy($orderBy, $sortColumnDir);  
      
        $totalRegistros = $empresas->count();
        //BUSCAR            
            if($search['value'] != null){
                $empresas = $empresas->whereRaw(
                        "(Id LIKE '%".$search["value"]."%' OR ". 
                         "Nombre LIKE '%". $search['value'] . "%' OR " .
                         //"NombreTipoDocumento LIKE '%". $search['value'] . "%' OR " .
                         "NumeroDocumento LIKE '%". $search['value'] . "%')");
            }
        
        $parcialRegistros = $empresas->count();
        $empresas = $empresas->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $empresas->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$empresas->get()];

        return response()->json($data);
    }

    public function postStore(Request $request)
    {
        try {
            $IdEmpresa = $request->input('ID');
            $empresas = $IdEmpresa == "" ? new Empresa_Model() : Empresa_Model::find($IdEmpresa);
            $empresas['Estado'] = 1;
            $empresas['IdUsuario'] = 1;
            $data = $request->all();
            $empresas->fill($data);
            $empresas->save();
    
        } catch (Exception $e) {
            // return response([
            //         "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
            //         "error" => $e->getMessage()
            //     ]);

            $retorno = [
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ];

            return response()->json($retorno);
        }
        
        // return response([
        //         "success" => true,
        //         "mensaje" => "Datos guardados correctamente",
        //         //"request" => $request->all(),
        //         "empresas" => $empresas
        //     ]);

         $retorno = [
                "success" => true,
                "mensaje" => "Datos guardados correctamente",
                //"request" => $request->all(),
                "usuario" => $empresas
            ];

        return response()->json($retorno);
    }

    public function postFormempresa(Request $request)
    {
        $titulo = "Empresas";
        $empresaID = $request->input('IdItem');
        $empresas = $empresaID == "" ? new Empresa_Model() : Empresa_Model::find($empresaID);

        $tipodocumento = [null=>'Seleccione...'];
        $tipodocumento = TipoDocumento_Model::orderBy('ID','asc')->pluck('Nombre','ID');

        $view = view('Empresa.formEmpresa')->with(['empresa' => $empresas, 'titulo' => $titulo,'tipodocumento'=>$tipodocumento]);

        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }       
    }

    public function cambiaEstado(Request $request)
    {
        try {
            
            $IdEmpresa = $request->input('ID');
            $Estado = $request->input('Estado');
            $empresas = Empresa_Model::find($IdEmpresa);
            $empresas['Estado'] = $Estado;
            $data = $request->all();
            $empresas->fill($data);
            $empresas->save();
    
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
                "empresas" => $empresas
            ]);
    }

    public function destroy(Empresas $empresas)
    {
        //
    }

}
