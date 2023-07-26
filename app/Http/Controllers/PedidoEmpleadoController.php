<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Jugueteria\model\HijoEmpleado_Model;
use Jugueteria\model\Convenio_Model;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\JugueteConvenio_Model;
use Jugueteria\model\Juguete_model;
use Jugueteria\model\JugueteIMG_Model;
use Jugueteria\model\UsuariosModel;
use Jugueteria\model\PedidoConvenio_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Mail;

class PedidoEmpleadoController extends Controller
{
	public function Index($id)
	{
        session_start();
		$IdEmpleado = $id;
        $NombreHijo = '';
        $IdHijo = 0;

        $IdEmpresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('Empleado.ID','=',$IdEmpleado)->pluck('Empresa.ID');

        // $hijoEmpleado = [null=>'Seleccione...'];
        // $hijoEmpleado = HijoEmpleado_Model::where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)->orderBy('ID','asc')->pluck('Nombre','Id');
        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->where('HijoEmpleado.Estado', '=', '1')
        ->whereNull('PedidoConvenio.ID')
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');
        

        $hijoEmpleado->prepend( 'Selecciona...','0');

        $convenio = new Convenio_Model();

        return view('PedidoEmpleado.index') ->with(['convenio'=>$convenio, 'hijoEmpleado' => $hijoEmpleado, 'IdEmpleado' => $IdEmpleado, 'NombreHijo' =>$NombreHijo, 'IdHijo' =>$IdHijo]);
    }
    
    public function IndexClaro($id)
	{
        session_start();
		$IdEmpleado = $id;
        $NombreHijo = '';
        $IdHijo = 0;

        $IdEmpresa = EmpleadoModel::join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('Empleado.ID','=',$IdEmpleado)->pluck('Empresa.ID');

        // $hijoEmpleado = [null=>'Seleccione...'];
        // $hijoEmpleado = HijoEmpleado_Model::where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)->orderBy('ID','asc')->pluck('Nombre','Id');
        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        // ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');
        

        $hijoEmpleado->prepend( 'Selecciona...','0');

        $convenio = new Convenio_Model();

        return view('PedidoEmpleado.index-claro') ->with(['convenio'=>$convenio, 'hijoEmpleado' => $hijoEmpleado, 'IdEmpleado' => $IdEmpleado, 'NombreHijo' =>$NombreHijo, 'IdHijo' =>$IdHijo]);
    }

    public function postStore(Request $request)
    {

    	$IdHijo = $request['_IdHijoEmpleado'];
        $IdJugueteConvenio = $request['_IdJugueteConvenio'];
        // $img = $request['_pedidoEmpleado'];
        
        //return $IdJugueteConvenio;

		$Result = DB::select("call RealizaPedidoEmpleado('".$IdJugueteConvenio."', '".$IdHijo."')");

        $Hijo = HijoEmpleado_Model::where('Id','=', $IdHijo)
        ->select('HijoEmpleado.Nombre',
                'HijoEmpleado.Apellido',
				'HijoEmpleado.IdEmpleado');

        $Juguete = JugueteConvenio_Model::join('Juguete', 'Juguete.ID', '=', 'JugueteConvenio.IdJuguete')
        ->where('JugueteConvenio.ID', '=', $IdJugueteConvenio)
        ->select('Juguete.Nombre',
                'JugueteConvenio.IdJuguete');

        $JugueteIMG = JugueteIMG_Model::where('Estado','=',1)
        ->where('IdJuguete','=', $Juguete->first()->IdJuguete)
        ->select('Ruta',
                'Imagen');

        $ImagenSeleccionado = $JugueteIMG->first()->Ruta . $JugueteIMG->first()->Imagen;
		
		$IdEmpleado = $Hijo->first()->IdEmpleado;
		
		$Empleado = EmpleadoModel::where('ID', '=', $IdEmpleado)
		->select('Empleado.IdUsuario');
		
		$IdUsuario = $Empleado->first()->IdUsuario;
		
		$Usuario = UsuariosModel::where('ID', '=', $IdUsuario)
		->select('Usuario.Correo');

        $NombreH = $Hijo->first()->Nombre;
        $ApellidoH = $Hijo->first()->Apellido;
        $NombreJ = $Juguete->first()->Nombre;
		$CorreoEmpleado = $Usuario->first()->Correo;

        $data['NombreUsuario'] = 'Usuario MaicaoGS';
        $data['CorreoComercial'] = $CorreoEmpleado;
        $data['NombreHijo'] = $NombreH;
        $data['ApellidoHijo'] = $ApellidoH;
        $data['NombreJuguete'] = $NombreJ;
        $data['ImgJuguete'] = $ImagenSeleccionado;
		
		if($CorreoEmpleado != null)
        {
            Mail::send('Correos.CorreoSeleccion',['data' => $data],function($mensaje) use ($data){
                $mensaje->from('community.maicao@gmail.com');
                $mensaje->to($data['CorreoComercial'], $data['NombreUsuario'])->subject('Seleccion de juguete para '.$data['NombreHijo'] );
            });

            if( count(Mail::failures()) <= 0 ) {

                  PedidoConvenio_Model::where('IdHijoEmpleado', $IdHijo)
                  ->where('IdJugueteConvenio', $IdJugueteConvenio)
                  ->update(['CorreoEnviado' => 1]);

            }
        }

        $retorno = [
            "success" => true,
            "mensaje" => "Datos guardados correctamente",
            //"request" => $request->all(),
            "Result" => $Result
        ];
    

        return response()->json($data);

        // return response([
        //         "success" => true,
        //         "mensaje" => "Datos guardados correctamente",
        //         //"request" => $request->all(),
        //         "Result" => $Result
        //     ]);
    }

    public function CargarPedidoEmpleado($id)
    {
        session_start();

        $IdHijo = $id;

        $Empresa = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('HijoEmpleado.ID', '=', $IdHijo)
        ->where('HijoEmpleado.Estado', '=', '1')
        ->pluck('Empresa.ID');

        $IdEmpresa = $Empresa->first();

        $ConvenioVigente = Convenio_Model::where('IdEmpresa','=', $IdEmpresa)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->select('Convenio.ID', 'Convenio.FechaInicio');

        $FechaInicioConvenio = $ConvenioVigente->first()->FechaInicio;

        $Empleado = EmpleadoModel::join('HijoEmpleado', 'HijoEmpleado.IdEmpleado' ,'=','Empleado.ID')
        ->where('HijoEmpleado.ID','=',$IdHijo)->pluck('Empleado.ID');

        $IdEmpleado = $Empleado->first();

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');

        if($hijoEmpleado == null)
        {
            return redirect::to('/pedidoEmpleado/Index/CargarPedidoEmpleado/'.$IdEmpleado);
        }

        $hijoEmpleado->prepend( 'Selecciona...','0');

        $Annos = 0;

        if($IdHijo != 0)
        {

            $Datoshijo = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->get();
            $Hijo = $Datoshijo->first();

            $NombreHijo = $Hijo->Nombre;
            $Fecha = $Hijo->FechaNacimiento;
            $Genero = $Hijo->IdGenero;

            // $NombreHijo = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->pluck('Nombre');
            // $Fecha = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->pluck('FechaNacimiento');
            $FechaNacicmiento = date('Y-m-d', strtotime($Fecha));
            $FechaConvenio = date('Y-m-d', strtotime($FechaInicioConvenio));

            list($ano,$mes,$dia) = explode("-",$FechaNacicmiento);
            list($anoC,$mesC,$diaC) = explode("-",$FechaConvenio);

            //Cambio para validar la edad al momento del inicio del convenio
            // $Annos  = date("Y") - $ano;
            // $mes_diferencia = date("m") - $mes;
            // $dia_diferencia   = date("d") - $dia;

            $Annos  = $anoC - $ano;
            $mes_diferencia = $mesC - $mes;
            $dia_diferencia   = $diaC - $dia;

            if ($dia_diferencia < 0 || $mes_diferencia < 0)
            {
                if($mes_diferencia < 0)
                {
                    $Meses = 12 + $mes_diferencia;    
                }
                else
                {
                    $Meses = $mes_diferencia;
                }
                
                if($Meses == 12 && $dia_diferencia < 0)
                {
                    $Decimal = 0.11;
                }
                else
                {
                    if(strlen($Meses) == 1)
                    {
                        $Decimal = '0.0'.$Meses;
                    }
                    else
                    {
                        $Decimal = '0.'.$Meses;    
                    }
                    
                }
                //if($Annos != 0)
                //{
                //    $Annos--;
                //}
                
                $Annos = $Annos + $Decimal;
            }

        }
        
        $convenio = DB::select("call PedidoEmpleadoJugueteConvenio (".$IdEmpresa.",".$Annos.",".$Genero.")");

        if(count($convenio) <= 0)
        {
            $convenio = new Convenio_Model();
            $Convneio['IdConvenio'] = 0;
            $NombreHijo = "";
        }

        // return $convenio;

        return view('PedidoEmpleado.index') ->with(['convenio'=>$convenio, 'hijoEmpleado' => $hijoEmpleado, 'IdEmpleado' => $IdEmpleado, 'NombreHijo' =>$NombreHijo, 'IdHijo'=>$IdHijo]);

    }
    
    public function CargarPedidoEmpleadoClaro($id)
    {
        session_start();

        $IdHijo = $id;

        $Empresa = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa','Empresa.ID','=','Empleado.IdEmpresa')
        ->where('HijoEmpleado.ID', '=', $IdHijo)
        ->where('HijoEmpleado.Estado', '=', '1')
        ->pluck('Empresa.ID');

        $IdEmpresa = $Empresa->first();

        $ConvenioVigente = Convenio_Model::where('IdEmpresa','=', $IdEmpresa)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->select('Convenio.ID', 'Convenio.FechaInicio');

        $FechaInicioConvenio = $ConvenioVigente->first()->FechaInicio;

        $Empleado = EmpleadoModel::join('HijoEmpleado', 'HijoEmpleado.IdEmpleado' ,'=','Empleado.ID')
        ->where('HijoEmpleado.ID','=',$IdHijo)->pluck('Empleado.ID');

        $IdEmpleado = $Empleado->first();

        $hijoEmpleado = HijoEmpleado_Model::join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Empresa', 'Empresa.Id', '=', 'Empleado.IdEmpresa')
        ->join('Convenio', 'Convenio.IdEmpresa', '=', 'Empresa.ID')
        ->leftjoin('PedidoConvenio', 'PedidoConvenio.IdHijoEmpleado', '=', 'HijoEmpleado.ID')
        ->where('HijoEmpleado.IdEmpleado','=',$IdEmpleado)
        ->where('Convenio.FechaInicio','<=',date("Y-m-d"))
        ->where('Convenio.FechaFin','>=',date("Y-m-d"))
        ->whereNull('PedidoConvenio.ID')
        ->orderBy('ID','asc')
        ->pluck('HijoEmpleado.Nombre','HijoEmpleado.ID');

        if($hijoEmpleado == null)
        {
            return redirect::to('/pedidoEmpleado/Index/CargarPedidoEmpleadoClaro/'.$IdEmpleado);
        }

        $hijoEmpleado->prepend( 'Selecciona...','0');

        $Annos = 0;

        if($IdHijo != 0)
        {

            $Datoshijo = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->get();
            $Hijo = $Datoshijo->first();

            $NombreHijo = $Hijo->Nombre;
            $Fecha = $Hijo->FechaNacimiento;
            $Genero = $Hijo->IdGenero;

            // $NombreHijo = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->pluck('Nombre');
            // $Fecha = HijoEmpleado_Model::where('HijoEmpleado.ID','=',$IdHijo)->pluck('FechaNacimiento');
            $FechaNacicmiento = date('Y-m-d', strtotime($Fecha));
            $FechaConvenio = date('Y-m-d', strtotime($FechaInicioConvenio));

            list($ano,$mes,$dia) = explode("-",$FechaNacicmiento);
            list($anoC,$mesC,$diaC) = explode("-",$FechaConvenio);

            //Cambio para validar la edad al momento del inicio del convenio
            // $Annos  = date("Y") - $ano;
            // $mes_diferencia = date("m") - $mes;
            // $dia_diferencia   = date("d") - $dia;

            $Annos  = $anoC - $ano;
            $mes_diferencia = $mesC - $mes;
            $dia_diferencia   = $diaC - $dia;

            if ($dia_diferencia < 0 || $mes_diferencia < 0)
            {
                if($mes_diferencia < 0)
                {
                    $Meses = 12 + $mes_diferencia;    
                }
                else
                {
                    $Meses = $mes_diferencia;
                }
                
                if($Meses == 12 && $dia_diferencia < 0)
                {
                    $Decimal = 0.11;
                }
                else
                {
                    if(strlen($Meses) == 1)
                    {
                        $Decimal = '0.0'.$Meses;
                    }
                    else
                    {
                        $Decimal = '0.'.$Meses;    
                    }
                    
                }
                //if($Annos != 0)
                //{
                //    $Annos--;
                //}
                
                $Annos = $Annos + $Decimal;
            }

        }
        
        $convenio = DB::select("call PedidoEmpleadoJugueteConvenio (".$IdEmpresa.",".$Annos.",".$Genero.")");

        if(count($convenio) <= 0)
        {
            
            $convenio = new Convenio_Model();
            $Convneio['IdConvenio'] = 0;
            $NombreHijo = "";
        }

        // return $convenio;

        return view('PedidoEmpleado.index-claro') ->with(['convenio'=>$convenio, 'hijoEmpleado' => $hijoEmpleado, 'IdEmpleado' => $IdEmpleado, 'NombreHijo' =>$NombreHijo, 'IdHijo'=>$IdHijo]);

    }

    public function ReenvioCorreos(){

        $data = PedidoConvenio_Model::join('HijoEmpleado', 'HijoEmpleado.ID', '=', 'PedidoConvenio.IdHijoEmpleado')
        ->join('Empleado', 'Empleado.ID', '=', 'HijoEmpleado.IdEmpleado')
        ->join('Usuario', 'Usuario.ID', '=', 'Empleado.IdUsuario')
        ->join('JugueteConvenio', 'JugueteConvenio.ID', '=', 'PedidoConvenio.IdJugueteConvenio')
        ->join('Juguete', 'Juguete.ID', '=', 'JugueteConvenio.IdJuguete')
        ->join('Convenio', 'Convenio.ID', '=', 'JugueteConvenio.IdConvenio')
        ->where("CorreoEnviado",0)
        ->where("Convenio.ID", 66)
        ->select(
            'Usuario.Correo',
            'Usuario.ID',
            'HijoEmpleado.ID as IdHijo',
            'HijoEmpleado.Nombre as NombreHijo',
            'Juguete.Nombre as NombreJuguete',
            'Juguete.Id as IdJuguete',
            'JugueteConvenio.ID as IdJugueteConvenio',
            'Convenio.ID as IdConvenio'

        )->take(10)->get();

        if(count($data) > 0){
            $count = 0;

            foreach($data as $d){
                if($d['Correo'] != ""){

                    $JugueteIMG = JugueteIMG_Model::where('Estado','=',1)
                    ->where('IdJuguete','=', $d['IdJuguete'])
                    ->select('Ruta',
                            'Imagen');

                    $ImagenSeleccionado = $JugueteIMG->first()->Ruta . $JugueteIMG->first()->Imagen;

                    $InfoCorreo['Correo'] = $d['Correo'];
                    $InfoCorreo['NombreHijo'] = $d['NombreHijo'];
                    $InfoCorreo['NombreJuguete'] = $d['NombreJuguete'];
                    $InfoCorreo['ImgJuguete'] = $ImagenSeleccionado;
                    
                    Mail::send('Correos.CorreoSeleccion',['data' => $InfoCorreo],function($mensaje) use ($InfoCorreo){
                    $mensaje->from('community.maicao@gmail.com');
                    $mensaje->to($InfoCorreo['Correo'])->subject('Selecci¨®n de juguete para '.$InfoCorreo['NombreHijo'] );
                    });
                    
                    if( count(Mail::failures()) <= 0 ) {

                      PedidoConvenio_Model::where('IdHijoEmpleado', $d['IdHijo'])
                      ->where('IdJugueteConvenio', $d['IdJugueteConvenio'])
                      ->update(['CorreoEnviado' => 1]);

                    }
                    else{
                        
                        //var_dump($InfoCorreo);
                        
                    }

                    if(($count%10)==0){
                        sleep(5);
                        $count = 0;
                    }

                }
            }

        }
        else{

            $retorno = [
            "success" => false,
            "mensaje" => "No existen datos para reenviar",
            "Result" => $data
            ];

            return response()->json($retorno);

        }


        $retorno = [
            "success" => true,
            "mensaje" => "Datos enviados correctamente",
            "Result" => $data
        ];
    

        return response()->json($retorno);

    }

}

