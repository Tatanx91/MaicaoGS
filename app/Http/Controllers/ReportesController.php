<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\model\Empresa_Model;
use Illuminate\Support\Facades\DB;
use File;
use Excel;
use Jugueteria\model\Convenio_Model;
class ReportesController extends Controller
{
     public function __construct()
    {
         $this->middleware(['auth:web' || 'auth:api']); 
    }

    public function Index()
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

        $empresas = Empresa_model::orderBy('ID','asc')->pluck('Nombre','ID');
        $empresas->prepend( 'Seleccione...','0');
        return view('Reportes.index')->with(['empresas' => $empresas]);
    }

    public function datatableList(Request $request){

        session_start();
        $tipoReporte = $request->get('tipoReporte');
        $empresa = $request->get('empresa');
        $FechaIni = $request->get('FechaIni');
        $FechaFin = $request->get('FechaFin');

        error_log($FechaIni);

        // Datos de DATATABLE
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $sortColumnDir = $order[0]['dir'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'];

        if($tipoReporte == 1)
        {
            $table = Convenio_Model::join('JugueteConvenio','JugueteConvenio.IDConvenio','=','Convenio.ID')
                                 ->join('Juguete','Juguete.ID','=','JugueteConvenio.IdJuguete')
                                 ->join('Empresa','Empresa.ID','=','Convenio.IdEmpresa')
                                 ->join('Empleado','Empleado.IdEmpresa','=','Empresa.ID')
                                 ->join('HijoEmpleado', 'Empleado.ID','=','HijoEmpleado.IdEmpleado')
                                 ->join('PedidoConvenio',function($join){

                                    $join->on('JugueteConvenio.ID','=', 'PedidoConvenio.IdJugueteConvenio')
                                    ->On('HijoEmpleado.ID','=','PedidoConvenio.IdHijoEmpleado');
                                 })
             ->select(
                    // 'Convenio.ID as IdConvenio',
                    'Empresa.Nombre as NombreEmpresa',
                    'Juguete.Nombre as NombreJuguete', 
                    //'JugueteConvenio.StockInicial',
                    'Empleado.Nombre as NombreEmpleado',
                    'Empleado.Apellido as ApellidoEmpleado',
                    'HijoEmpleado.Nombre as NombreHijo',
                    'HijoEmpleado.Apellido as ApellidoHijo',
                    'HijoEmpleado.FechaNacimiento as FechaNacimiento',
                    'Empleado.Direccion',
                    'Empleado.Telefono',
                    'Empleado.Ciudad',
                    'Empleado.NumeroDocumento',
                    'Convenio.FechaInicio',
                    'Convenio.FechaFin',
                    'PedidoConvenio.Created_At as FechaSeleccion')
             ->where('Convenio.IdEmpresa','=',$empresa)
             ->distinct();
        }
        else if($tipoReporte == 2)
        {
            $table = Convenio_Model::join('JugueteConvenio','JugueteConvenio.IDConvenio','=','Convenio.ID')
                                 ->join('Juguete','Juguete.ID','=','JugueteConvenio.IdJuguete')
                                 ->join('Empresa','Empresa.ID','=','Convenio.IdEmpresa')
                                 ->join('Empleado','Empleado.IdEmpresa','=','Empresa.ID')
                                 ->join('HijoEmpleado', 'Empleado.ID','=','HijoEmpleado.IdEmpleado')
                                 ->leftjoin('PedidoConvenio',function($join){

                                    $join->On('HijoEmpleado.ID','=','PedidoConvenio.IdHijoEmpleado');
                                    //$join->on('JugueteConvenio.ID','=', 'PedidoConvenio.IdJugueteConvenio')
                                 })
             ->select(
                    // 'Convenio.ID as IdConvenio',
                    'Empresa.Nombre as NombreEmpresa',
                    'Empleado.Nombre as NombreJuguete', 
                    // 'JugueteConvenio.StockInicial',
                    'Empleado.Nombre as NombreEmpleado',
                    'Empleado.Apellido as ApellidoEmpleado',
                    'HijoEmpleado.Nombre as NombreHijo',
                    'HijoEmpleado.Apellido as ApellidoHijo',
                    'HijoEmpleado.FechaNacimiento as FechaNacimiento',
                    'Empleado.Direccion',
                    'Empleado.Ciudad',
                    'Empleado.NumeroDocumento',
                    'Empleado.Telefono'
                    // 'Convenio.FechaInicio',
                    // 'Convenio.FechaFin',
                    // 'PedidoConvenio.Created_At as FechaSeleccion'
                )
             ->where('Convenio.IdEmpresa','=',295)
             ->whereNull('PedidoConvenio.ID')
             ->distinct();

        }
        
        
         if($FechaIni != null && $FechaIni != '')
                $table  = $table->where('Convenio.FechaInicio',$FechaIni);
            
         if($FechaFin != null && $FechaFin != '')
                $table  = $table->where('Convenio.FechaFin','>=',$FechaFin);
                 //->orderBy("IdJuguete", "desc");//

        $table  = $table->orderBy($orderBy, $sortColumnDir);  
      
        $totalRegistros = $table->count();
        //BUSCAR            
            if($search['value'] != null){
                $table = $table->whereRaw(
                        // "(Convenio.ID LIKE '%".$search["value"]."%' OR ". 
                         "(Empresa.Nombre LIKE '%". $search['value'] . "%' OR " .
                         // "Juguete.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "JugueteConvenio.StockInicial LIKE '%". $search['value'] . "%' OR " .
                         "Empleado.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "Empleado.Apellido LIKE '%". $search['value'] . "%' OR " .
                         "HijoEmpleado.Nombre LIKE '%". $search['value'] . "%' OR " .
                         "Empleado.direccion LIKE '%". $search['value'] . "%' OR " .
                         "Empleado.NumeroDocumento LIKE '%". $search['value'] . "%' OR " .
                         // "Convenio.FechaInicio LIKE '%". $search['value'] . "%' OR " .
                         // "Convenio.FechaFin LIKE '%". $search['value'].
                          "%')");
            }
        
        $parcialRegistros = $table->count();
        $table = $table->skip($start)->take($length);

        $data = ['length'=> $length,
                'start' => $start,
                'buscar' => $search['value'],
                'draw' => $request->get('draw'),
                'last_query' => $table->toSql(),
                'recordsTotal' =>$totalRegistros,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$table->get()];

        return response()->json($data);
    }



    public function cargaConvenios(Request $request){
        $data = $request->all();

        $result = Empresa_Model::join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->select('Convenio.ID as id','Nombre as name')
        ->where('Empresa.ID','=',$data["element"])
        ->where('Estado','=','1')
        ->orderBy('ID')
        ->get();

        return response()->json($result);      
    }

    public function generaDescarga(Request $request)
    {ini_set("memory_limit",-1);
        set_time_limit(0);

        $tipoReporte = $request->get('tipoReporte');
        
        $myArray=[];     
        $empresa = $request->get('empresa_id');
        $tipo_archivo = $request->get('tipo_archivo');
        $FechaFin = $request->get('FechaFin');
        $FechaIni = $request->get('FechaIni');
        $filtro_tabla = $request->get('filtro_tabla');

        $nombre = "Reporte maicao";


        //$empresas = Empresa_model::orderBy('ID','asc')->get();

        if($tipoReporte == 1)
        {

            $Reporte = Convenio_Model::join('JugueteConvenio','JugueteConvenio.IDConvenio','=','Convenio.ID')
                                     ->join('Juguete','Juguete.ID','=','JugueteConvenio.IdJuguete')
                                     ->join('Empresa','Empresa.ID','=','Convenio.IdEmpresa')
                                     ->join('Empleado','Empleado.IdEmpresa','=','Empresa.ID')
                                     ->join('HijoEmpleado', 'Empleado.ID','=','HijoEmpleado.IdEmpleado')
                                     ->join('PedidoConvenio',function($join){

                                        $join->on('JugueteConvenio.ID','=', 'PedidoConvenio.IdJugueteConvenio')
                                        ->On('HijoEmpleado.ID','=','PedidoConvenio.IdHijoEmpleado');
                                     })
             ->select(
                    //'Convenio.ID as IdConvenio',
                    'Empresa.Nombre as NombreEmpresa',
                    'Juguete.Nombre as NombreJuguete', 
                    'JugueteConvenio.StockInicial',
                    'Empleado.Nombre as NombreEmpleado',
                    'Empleado.Apellido as ApellidoEmpleado',
                    'Empleado.Ciudad',
                    'HijoEmpleado.Nombre as NombreHijo',
                    'HijoEmpleado.Apellido as ApellidoHijo',
                    'HijoEmpleado.FechaNacimiento as FechaNacimiento',
                    'Empleado.Direccion',
                    'Empleado.Telefono',
                    'Empleado.NumeroDocumento',
                    'Convenio.FechaInicio',
                    'Convenio.FechaFin',
                    'PedidoConvenio.Created_At as FechaSeleccion')
             ->where('Convenio.IdEmpresa','=',$empresa);
             if($FechaIni != null && $FechaIni != '')
                    $Reporte  = $Reporte->where('Convenio.FechaInicio','<=',$FechaIni);
                
             if($FechaFin != null && $FechaFin != '')
                    $Reporte  = $Reporte->where('Convenio.FechaFin','>=',$FechaFin);      
                     //->orderBy("IdJuguete", "desc");//

                $Reporte=$Reporte->get();
         //DB::select("call ReporteConvenios(" . $empresa . ", " . $FechaInicio . ")");        

            if($tipo_archivo == 'excel'){
                return Excel::create($nombre, function($excel) use ($Reporte, $tipoReporte) {
                    $excel->sheet('Lista', function($sheet) use ($Reporte,$tipoReporte) {
                        $sheet->loadView('Reportes.partials.Descarga',["lista"=>$Reporte, "tipoReporte"=>$tipoReporte]); 
                        // $sheet->cells('A1:H1', function($cells) {
                        //     //$cells->setBackground('#2E6B7F');
                        //     //$cells->setAlignment('center');

                        // });
                        //$sheet->setAutoSize(true);
                    });

                })->export("xls");
            }else{
                return '0';
            }
        }
        else if($tipoReporte == 2)
        {
            $Reporte = Convenio_Model::join('Empresa','Empresa.ID','=','Convenio.IdEmpresa')
                                     // ->join('Juguete','Juguete.ID','=','JugueteConvenio.IdJuguete')
                                     // ->join('JugueteConvenio','JugueteConvenio.IDConvenio','=','Convenio.ID')
                                     ->join('Empleado','Empleado.IdEmpresa','=','Empresa.ID')
                                     ->join('HijoEmpleado', 'Empleado.ID','=','HijoEmpleado.IdEmpleado')
                                     ->leftjoin('PedidoConvenio',function($join){

                                        $join->On('HijoEmpleado.ID','=','PedidoConvenio.IdHijoEmpleado');
                                        //$join->on('JugueteConvenio.ID','=', 'PedidoConvenio.IdJugueteConvenio')
                                        
                                    })
             ->select(
                    //'Convenio.ID as IdConvenio',
                    'Empresa.Nombre as NombreEmpresa',
                    // 'Juguete.Nombre as NombreJuguete', 
                    // 'JugueteConvenio.StockInicial',
                    'Empleado.Nombre as NombreEmpleado',
                    'Empleado.Apellido as ApellidoEmpleado',
                    'Empleado.Ciudad',
                    'HijoEmpleado.Nombre as NombreHijo',
                    'HijoEmpleado.Apellido as ApellidoHijo',
                    'HijoEmpleado.FechaNacimiento as FechaNacimiento',
                    'Empleado.Direccion',
                    'Empleado.Telefono',
                    'Empleado.NumeroDocumento')
                    // 'Convenio.FechaInicio',
                    // 'Convenio.FechaFin',
                    // 'PedidoConvenio.Created_At as FechaSeleccion')
             ->where('Convenio.IdEmpresa','=',$empresa)
             ->whereNull('PedidoConvenio.ID')
             ->distinct();
             if($FechaIni != null && $FechaIni != '')
                    $Reporte  = $Reporte->where('Convenio.FechaInicio','<=',$FechaIni);
                
             if($FechaFin != null && $FechaFin != '')
                    $Reporte  = $Reporte->where('Convenio.FechaFin','>=',$FechaFin);      
                     //->orderBy("IdJuguete", "desc");//

                $Reporte=$Reporte->get();
         //DB::select("call ReporteConvenios(" . $empresa . ", " . $FechaInicio . ")");        

            if($tipo_archivo == 'excel'){
                return Excel::create($nombre, function($excel) use ($Reporte, $tipoReporte) {
                    $excel->sheet('Lista', function($sheet) use ($Reporte,$tipoReporte) {
                        $sheet->loadView('Reportes.partials.DescargaN',["lista"=>$Reporte, "tipoReporte"=>$tipoReporte]); 
                        // $sheet->cells('A1:H1', function($cells) {
                        //     //$cells->setBackground('#2E6B7F');
                        //     //$cells->setAlignment('center');

                        // });
                        //$sheet->setAutoSize(true);
                    });

                })->export("xls");
            }else{
                return '0';
            }

        }

        
    }
}
