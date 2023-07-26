<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Jugueteria\model\Convenio_Model;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\Genero_model;
use Jugueteria\model\Juguete_model;
use Jugueteria\model\rel_juguete_img;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\JugueteConvenio_Model;
use Jugueteria\model\PedidoConvenio_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use File;
use Mail;

class ConvenioController extends Controller
{
    public function __construct(){        
         $this->middleware(['auth:web' || 'auth:api']); 
    }

    public function Index($Id)
    {
        session_start();

        //  $paginacion_start = 4;
        //  $paginacion_length = 2;
        // $paginacion_tamano = 2;
        // $pagina_actual = 4;
        //         select * from usuario
        // inner join TipoUsuario on TipoUsuario.ID = Usuario.IdTipoUsuario
        // inner join Empleado on Empleado.IdUsuario = Usuario.ID
        // inner join Empresa on Empresa.ID = Empleado.IdEmpresa


        // $img = rel_juguete_img::join('Juguete','Juguete.ID','=','JugueteIMG.IdJuguete')
        // ->select('JugueteIMG.IdJuguete', 'JugueteIMG.Ruta', 'JugueteIMG.Imagen', 'Juguete.Cantidad', 'Juguete.Nombre', 'Juguete.Cantidad AS CantidadNew')->where('JugueteIMG.estado','=',1)->where('Juguete.cantidad','>',0);
        // $img_count = $img->count();
        // $img_parcial = $img->count();
        // $img = $img->skip($paginacion_start)->take($paginacion_length);


        $juguetes = DB::select("call ConsultarJuguetesDisponibles ('')");

        // $img = array_slice($juguetes,0,2);
        // $paginacion = array('datos' => $img->get(),'paginacion_start'=>$paginacion_start,'paginacion_length'=>$paginacion_length,'img_count'=>$img_count,'img_parcial'=>$img_parcial,'paginacion_tamano'=>$paginacion_tamano,'pagina_actual'=>$pagina_actual);

        $img = $juguetes;

        $Genero = Genero_model::pluck('Genero.Nombre', 'Genero.ID');
        $Genero->prepend( 'Seleccione...','0');

        // $_GET['pag'] = 1;
 
        // return $img;
        // return view('Convenio.index') ->with(['img'=>$img, 'IdEmpresa'=>$Id, 'Genero'=>$Genero,'paginacion' => $paginacion]);
        return view('Convenio.index') ->with(['img'=>$img, 'IdEmpresa'=>$Id, 'Genero'=>$Genero]);
    }

    public function CargarJuguetesConvenio()
    {

        session_start();

        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'] == 'ID' ? 'Empresa.ID' :  $columna[$sortColumnIndex]['data'];

        $juguetes = DB::select("call ConsultarJuguetesDisponibles ('')");

        $img = $juguetes;

        $totalRegistros = $img->count();

        if($search['value'] != null){
                $img = $img->whereRaw(
                        "(Juguete.Nombre LIKE '%". $search['value'] . "%' OR " .
                        "Juguete.Referencia LIKE '%". $search['value'] . "%')");
            }

        $parcialRegistros = $img->count();
        $img = $img->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $empresas->toSql(),
                'recordsTotal' =>$totalRegistros,
                'tipoUSU' =>$tipoUsuario,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$img->get()];

        return response()->json($data);

    }


    public function PaginacionConvenio($PaginaActual, $Sentido)
    {
        session_start();
        $juguetes = DB::select("call ConsultarJuguetesDisponibles ('')");
        
        // $img = $juguetes;

        $Genero = Genero_model::pluck('Genero.Nombre', 'Genero.ID');
        $Genero->prepend( 'Seleccione...','0');

        $Id = 28;
        $ImagenesAMostrar = 2;

        $Empieza = ($PaginaActual-1) * $ImagenesAMostrar;
        $Termina = $Empieza + $ImagenesAMostrar;

        $img = array_slice($juguetes,$Empieza,$Termina);

        $_GET['pag'] = $PaginaActual;
        
 
        // return $img;
        return view('Convenio.index') ->with(['img'=>$img, 'IdEmpresa'=>$Id, 'Genero'=>$Genero]);

    }

    public function FiltroJuguetes($Texto, $IdEmpresa)
    {
        session_start();
        $juguetes = DB::select("call ConsultarJuguetesDisponibles ('".$Texto."')");

        $img = $juguetes;

        $Genero = Genero_model::pluck('Genero.Nombre', 'Genero.ID');
        $Genero->prepend( 'Seleccione...','0');

        // $data = ['img' =>$img];
        // return response()->json($data);

        return view('Convenio.index') ->with(['img'=>$img, 'IdEmpresa'=>$IdEmpresa, 'Genero'=>$Genero]);


    }


    public function IndexListConvenio($Id)
    {
        session_start();
        $IdEmpresa = $Id;
        $Empresa = Empresa_Model::select('Empresa.Nombre')
                        ->where('Empresa.ID', '=', $Id);

        $NombreEmpresa = $Empresa->first()->Nombre;

        return view('Convenio.ListarConvenios')->with(['IdEmpresa'=>$IdEmpresa, 'NombreEmpresa'=>$NombreEmpresa]);
    }

    public function postStore(Request $request)
    {
        $Resultado = 0;

        try {
            
            $img = $request['_img'];
            $IdEmpresa = $request['_IdEmpresa'];

            $FechaInicio = $request['_DtpFechaIni'];
            $FechaFin = $request['_DtpFechaFin'];
            /*
            $Result = DB::select("call ValidaDuplicidadCovenio(".$IdEmpresa.",'".substr($FechaInicio,0,4).substr($FechaInicio,5,2).substr($FechaInicio,8,2)."', '".substr($FechaFin,0,4).substr($FechaFin,5,2).substr($FechaFin,8,2)."')");

            $array = json_decode(json_encode($Result), true);
            */

            //$Resultado = $array[0]['@Result'];
            $Resultado = 1;//Se omite la validacin de duplicidad de convenios
            
            //if($array[0]['@Result'] == 1)
            if($Resultado == 1)
            {  
                $Convenio = new Convenio_Model();
                $Convenio['IdEmpresa'] = $IdEmpresa;
                $Convenio['FechaInicio'] = $FechaInicio;
                $Convenio['FechaFin'] = $FechaFin;
                $Convenio->save();
                
                foreach ($img as $key) {
                    if($key['CantidadNew'] != 0)
                    {
                        DB::select("call PedidoJugueteConvenio(" . $Convenio->ID . ", " . $key['IdJuguete'] . ", " . $key['CantidadNew'] . ", " . $key['EdadInicial'] . ", " . $key['EdadFinal'] . ", " . $key['IDGenero'] .  ", 0)");
                    }

                }
            }
        } catch (Exception $e) {
            return response([
                    "mensaje" => "Error al guardar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);
        }

        // return response([
        //         "success" => true,
        //         "mensaje" => $Resultado == 1 ? "Datos guardados correctamente" : "Las fechas estipuladas para la creacion del convenio ya se encuentran asociadas." ,
        //         "Result" => $Resultado,
        //         "request" => $request->all()
        //     ]);

        $retorno = [
                "success" => true,
                "mensaje" => $Resultado == 1 ? "Datos guardados correctamente" : "Las fechas estipuladas para la creacion del convenio ya se encuentran asociadas." ,
                "request" => $request->all(),
                "Result" => $Resultado
            ];

        return response()->json($retorno);
    }

    public function eliminarConvenio(Request $request)
    {

        try{

            session_start();
            $IdEmpresa = $request->input("IdEmpresa");
            $IdConvenio = $request->input("IdConvenio");

            $ListaEmpleados = DB::table('Empleado')->where('Empleado.IdEmpresa', '=', $IdEmpresa)->get();

            if($ListaEmpleados->count() < 0)
            {
                
                foreach ($ListaEmpleados as $key) 
                {
                    $IdEmpleado = $key->ID;
                    
                    $return = DB::select("call DevolverStockEmpleado(".$IdEmpleado.")");
                    //DB::table('Empleado')->where('Empleado.ID', '=', $IdEmpleado)->delete();
                    //EmpleadoModel::destroy($IdEmpleado);

                }
            }

            $inst = new ConvenioController;
            $DevStock = $inst -> DevolverStockConvenioElim($IdConvenio);

            if($DevStock)
            {
                Convenio_Model::destroy($IdConvenio);
            }
            
            
            return response()->json($IdConvenio);
            
        }

        catch (Exception $e){

            return response([
                    "mensaje" => "Error al eliminar el convenio, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);

        }

    }

    public function DevolverStockConvenioElim($IdConvenio)
    {
        $ExisteStock = Convenio_Model::join('JugueteConvenio', 'JugueteConvenio.IdConvenio', '=', 'Convenio.ID')
        ->where('JugueteConvenio.StockActual', '>', 0)
        ->where('Convenio.ID', '=', $IdConvenio)->get();

        if($ExisteStock != null)
        {
            $juguetes = DB::select("call DevolverStock (".$IdConvenio.")");
        }

        return true;
    }

    public function datatableListConveniosXEmpresa(Request $request, $Id){

        session_start();

        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'] == 'ID' ? 'Convenio.ID' :  $columna[$sortColumnIndex]['data'];
        
        $convenio = Convenio_Model::select(
                'Convenio.ID',
                'Convenio.FechaInicio',
                'Convenio.FechaFin');

        $IdEmpresa = $Id;

        $convenio = $convenio->where('Convenio.IdEmpresa','=',$IdEmpresa);

        $convenio = $convenio->orderBy($orderBy, $sortColumnDir);  
      
        $totalRegistros = $convenio->count();
        //BUSCAR            
            if($search['value'] != null){
                $convenio = $convenio->whereRaw(
                        "(ID LIKE '%".$search["value"]."%' OR ". 
                         "FechaInicio LIKE '%". $search['value'] . "%' OR " .
                         "FechaFin LIKE '%". $search['value'] . "%')");
            }
        
        $parcialRegistros = $convenio->count();
        $convenio = $convenio->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $convenio->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$convenio->get()];

        return response()->json($data);
    }

    // public function CargarDtlleConvenio(Request $request){
    public function CargarDtlleConvenio($Id){
        session_start();
        $Id;

        $img = DB::select("call ConsultarDetalleConvenio(" . $Id . ")");

        $Empresa = Empresa_Model::join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
                    ->where('Convenio.ID','=', $Id)
                    ->select('Empresa.ID');
        $IdEmpresa = $Empresa->first()->ID;

        $Genero = Genero_model::pluck('Genero.Nombre', 'Genero.ID');
        $Genero->prepend( 'Seleccione...','0');

        $Convenio = Convenio_Model::select('Convenio.FechaInicio','Convenio.FechaFin')
                    ->where('Convenio.ID', '=', $Id);

        $FechaInicio = $Convenio->first()->FechaInicio;
        $FechaFin =  $Convenio->first()->FechaFin;

        return view('Convenio.DetalleConvenios') ->with(['img'=>$img, 'IdEmpresa'=>$IdEmpresa, 'Genero'=>$Genero, 'IdConvenio'=>$Id, 'FechaInicio'=>$FechaInicio, 'FechaFin'=>$FechaFin]);
    }

    public function EditarConvenio(Request $request)
    {
        $img = $request['_img'];
        $IdConvenio = $request['_IdConvenio'];
        $FechaIni = $request['_FechaIni'];
        $FechaFin = $request['_FechaFin'];

        $Convenio = Convenio_Model::join('Empresa', 'Empresa.ID', '=',  'Convenio.IdEmpresa')
                    ->where('Convenio.ID', '=', $IdConvenio)
                    ->select('Empresa.ID', 'Convenio.FechaFin');

        $FechaFinActual = $Convenio->first()->FechaFin;
        $IdEmpresa = $Convenio->first()->ID;

        if($img != null){

            foreach ($img as $key) {

                $IdJuguete = $key['IdJuguete'];

                $JugueteConvenio = JugueteConvenio_Model::where('IdConvenio', '=', $IdConvenio)
                            ->where('IdJuguete', '=', $IdJuguete);

                $IdJugueteConvenio = $JugueteConvenio->first()->ID;
                $CantidadAnt = $JugueteConvenio->first()->StockInicial;

                $Juguete = Juguete_model::find($IdJuguete);

                $NuevaCant = $Juguete['Cantidad'] + $CantidadAnt;

                $data = JugueteConvenio_Model::find($IdJugueteConvenio);

                $data['StockInicial'] = $key['CantidadNew'];
                $data['StockActual'] = $key['CantidadNew'];
                $data['EdadInicial'] = $key['EdadInicial'];
                $data['EdadFinal'] = $key['EdadFinal'];
                $data['IdGenero'] = $key['IDGenero'];

                $data->save();


                $Juguete['Cantidad'] = $NuevaCant - $key['CantidadNew'];
                $Juguete->save();

            }
        }

        if($FechaFinActual != $FechaFin)
        {

            $Result = DB::select("call ValidaDupliEditarConvenio(".$IdEmpresa.",".$IdConvenio.",'".substr($FechaIni,0,4).substr($FechaIni,5,2).substr($FechaIni,8,2)."', '".substr($FechaFin,0,4).substr($FechaFin,5,2).substr($FechaFin,8,2)."')");


            $array = json_decode(json_encode($Result), true);

                $Resultado = $array[0]['@Result'];
                
                if($array[0]['@Result'] == 5)
                {  

                    $retorno = [
                        "success" => false,
                        "mensaje_error" => "Las fechas estipuladas para la creacion del convenio ya se encuentran asociadas. los demas datos se guardaron correctamete."
                    ];

                   return response()->json($retorno);
                }
                else
                {
                    $dataConv = Convenio_Model::find($IdConvenio);

                    $dataConv['FechaFin'] = $FechaFin;
                    $dataConv->save();

                    $retorno = [
                        "success" => true,
                        "mensaje" => "Datos y fecha final actualizados correctamente"
                    ];

                    return response()->json($retorno);

                }
        }

        $retorno = [
            "success" => true,
            "mensaje" => "Datos actualizados correctamente"
        ];

       return response()->json($retorno);

        // return redirect::to('/convenio/CargarDtlleConvenio/'.$IdConvenio);

    }

    public function DevolverStockConvenio($IdConvenio)
    {
        $ExisteStock = Convenio_Model::join('JugueteConvenio', 'JugueteConvenio.IdConvenio', '=', 'Convenio.ID')
        ->where('JugueteConvenio.StockActual', '>', 0)
        ->where('Convenio.ID', '=', $IdConvenio)->get();

        if($ExisteStock != null)
        {
            $juguetes = DB::select("call DevolverStock (".$IdConvenio.")");
        }

        return redirect::to('/convenio/CargarDtlleConvenio/'.$IdConvenio);
    }

    public function EliminarJugueteConvenio(Request $request)
    {

        $IdJugueteConvenio = $request['_IdJugueteConvenio'];

        $IdJuguete = JugueteConvenio_Model::select('JugueteConvenio.IdJuguete')
                        ->where('JugueteConvenio.ID', '=', $IdJugueteConvenio)->get()->first()->IdJuguete;

        $Juguete = JugueteConvenio_Model::find($IdJugueteConvenio);

        $StockInicial = $Juguete->first()->StockInicial;

        $ListaEmpleados = JugueteConvenio_Model::join('PedidoConvenio', 'PedidoConvenio.IdJugueteConvenio', '=', 'JugueteConvenio.ID')
                            ->join('Juguete', 'Juguete.ID', '=', 'JugueteConvenio.IdJuguete')
                            ->join('HijoEmpleado', 'HijoEmpleado.ID', '=', 'PedidoConvenio.IdHijoEmpleado')
                            ->join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
                            ->join('Empresa', 'Empresa.ID', '=', 'Empleado.IdEmpresa')
                            ->where('JugueteConvenio.ID', '=', $IdJugueteConvenio)
                            ->select('PedidoConvenio.ID as IdPedidoConvenio',
                                'Empresa.Nombre as NombreEmpresa',
                                'Empleado.Nombre as NombreEmpleado',
                                'Empleado.NumeroDocumento',
                                'HijoEmpleado.Nombre as NombreHijo',
                                'Juguete.Nombre as NombreJuguete'
                            )->get();

        if($ListaEmpleados->count() > 0)
        {
            foreach ($ListaEmpleados as $key) {

                        PedidoConvenio_Model::destroy($key['IdPedidoConvenio']);
                    }

            $data = $request->all();

            Mail::send('Correos.JugueteElimSeleccionados',['ListaEmpleados' => $ListaEmpleados],function($mensaje) use ($data){
                $mensaje->from('ventascorporativas@maicaogiftstore.com');
                $mensaje->to('ventascorporativas@maicaogiftstore.com')->subject('Juguete eliminado');
            });
        }

        $data = Juguete_model::find($IdJuguete);
        $data['Cantidad'] = $data['Cantidad'] + $StockInicial;
        $data->save();

        JugueteConvenio_Model::destroy($IdJugueteConvenio);

        $retorno = [
            "success" => true,
            "mensaje" => "Juguete eliminado correctamente"
        ];

       return response()->json($retorno);

    }
}
