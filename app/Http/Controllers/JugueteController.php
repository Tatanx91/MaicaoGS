<?php

namespace Jugueteria\Http\Controllers;

use Jugueteria\Juguete;
use Illuminate\Http\Request;
use App\Http\Requests;
use Jugueteria\model\Juguete_model;
use Jugueteria\model\Genero_model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class JugueteController extends Controller
{
    public function __construct(){
        //$this->middleware('auth', ['except' => ['Index,datatableJuguete,datatableListJuguete,postStore,postFormJuguete']]);
         $this->middleware(['auth:web' || 'auth:api']); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Index()
    {
        // if(Session::get("PRIVILEGIOS") == null){
        //     Session::forget('PRIVILEGIOS');
        //     return redirect::to('/');
        // }

       session_start();
        if(! isset($_SESSION['IdTipoUsuario'])){
            session_destroy();
            return redirect::to('/');
        }
        
        return view('Juguete.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableListJuguete(Request $request){
        // Datos de DATATABLE
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'];
        
        $juguete = Juguete_model::join('Genero','Genero.ID','=','Juguete.IdGenero')
         ->select(
                'Juguete.ID',
                'Juguete.NumeroReferencia',
                'Juguete.Nombre',
                'Juguete.Dimensiones',
                'Juguete.EdadInicial',
                'Juguete.EdadFinal',
                'Juguete.IdGenero',
                'Juguete.descripcion',
                'Juguete.cantidad',
                'Juguete.estado',
                'Genero.ID as IdGenero',
                'Genero.Nombre as NombreGenero');
                                    //->orderBy("IdJuguete", "desc");//

        $juguete  = $juguete->orderBy($orderBy, $sortColumnDir);  
      
        $totalRegistros = $juguete->count();
        //BUSCAR            
            if($search['value'] != null){
                $juguete = $juguete->whereRaw(
                        "(Juguete.ID LIKE '%".$search["value"]."%' OR ". 
                         "NumeroReferencia LIKE '%". $search['value'] . "%' OR " .
                         "Juguete.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "Dimensiones LIKE '%". $search['value'] . "%' OR " .
                         "EdadInicial LIKE '%". $search['value'] . "%' OR " .
                         "EdadFinal LIKE '%". $search['value'] . "%' OR " .
                         "descripcion LIKE '%". $search['value'] . "%' OR " .
                         "cantidad LIKE '%". $search['value'] . "%' OR " .
                         "Genero.Nombre LIKE '%". $search['value']. "%')");
            }
        
        $parcialRegistros = $juguete->count();
        $juguete = $juguete->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $juguete->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$juguete->get()];

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
            
            $IdJuguete = $request->input('IdJuguete');
            $juguete = $IdJuguete == "" ? new Juguete_model() : Juguete_model::find($IdJuguete);
            // $juguete['Imagenes'] = 'prueba';
            $juguete['Estado'] = 1;
            $data = $request->all();
            $juguete->fill($data);
            $juguete->save();
    
        } catch (Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }
        
        // return response([
        //         "success" => true,
        //         "mensaje" => "Datos guardados correctamente",
        //         //"request" => $request->all(),
        //         "juguete" => $juguete
        //     ]);

        $retorno = [
                "success" => true,
                "mensaje" => "Datos guardados correctamente",
                //"request" => $request->all(),
                "juguete" => $juguete
            ];

        // return view('Juguete.index');
        return response()->json($retorno);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Jugueteria\Juguete  $juguete
     * @return \Illuminate\Http\Response
     */
    public function postFormjuguete(Request $request)
    {
    	session_start();
        $titulo = "Juguetes";
        $jugueteID = $request->input('IdJuguete');
        $juguete = $jugueteID == "" ? new Juguete_model() : Juguete_model::find($jugueteID);

        $genero = [null=>'Seleccione...'];
        $genero = Genero_model::orderBy('ID','asc')->pluck('Nombre','ID');

        $view = view('Juguete.formJuguete')->with(['juguete' => $juguete, 'titulo' => $titulo,'genero'=>$genero]);

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
            
            $IdJuguete = $request->input('ID');
            $estado = $request->input('estado');
            $juguete = Juguete_model::find($IdJuguete);
            $juguete['Estado'] = $estado;
            $data = $request->all();
            $juguete->fill($data);
            $juguete->save();
    
        } catch (Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }
        
        // return response([
        //         "success" => true,
        //         "mensaje" => "Estado actualizado",
        //         //"request" => $request->all(),
        //         "juguete" => $juguete
        //     ]);

      $retorno = [
            "success" => true,
            "mensaje" => "Datos guardados correctamente",
            //"request" => $request->all(),
            "juguete" => $juguete
        ];

        return response()->json($retorno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Jugueteria\Juguete  $juguete
     * @return \Illuminate\Http\Response
     */

    public function galeria(Request $request)
    {
        session_start();
        $titulo = "Juguetes";
        $jugueteID = $request->input('idJuguete');

        $data = Juguete_model::select( '*')
        ->join('JugueteImg','JugueteImg.IdJuguete','=','Juguete.ID')->
        where('Juguete.ID','=',$jugueteID)
->where('JugueteImg.Estado','=',1)->get();

        $view = view('Juguete.partials.slider')->with(['data' => $data]);
        
        return $view->renderSections()['content_modal'];

        if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }       
    }
}
