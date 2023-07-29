<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Jugueteria\Empresa;
use App\Http\Requests;
use Jugueteria\model\Empresa_Model;
use Jugueteria\model\EmpleadoModel;
use Jugueteria\model\TipoDocumento_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jugueteria\model\UsuariosModel;
use Illuminate\Support\Facades\Session;
use File;
use Mail;

class EmpresaController extends Controller
{
    public function __construct(){
        //$this->middleware('auth', ['except' => ['Index,datatableJuguete,datatableListJuguete,postStore,postFormJuguete']]);
         $this->middleware(['auth:web' || 'auth:api']); 
    }

    public function Masivoempresa(Request $request){
        session_start();
        $titulo = "masivo Empresa";
        $datos =  new Empresa_Model();
        $datos['IdEmpresa'] = 1;
        $view = view('Empresa.MasivoEmpresa')->with(['titulo' => $titulo,'datos'=>$datos]);
        
        return $view->renderSections()['content_modal'];

          if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
        //return view('Empresa.index');
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

        return view('Empresa.index');
        
        
    }

    public function IndexEmpresa($Id)
    {
        session_start();
        $Empresa = Empresa_Model::join('TipoDocumento', 'TipoDocumento.ID', '=', 'Empresa.IdTipoDocumento')
                                ->select('Empresa.Nombre as NombreEmpresa',
                                        'Empresa.NumeroDocumento',
                                        'Empresa.Direccion',
                                        'Empresa.Logo',
                                        'Empresa.NombreContacto',
                                        'Empresa.TelefonoContacto',
                                        'TipoDocumento.Nombre as NombreTipoDoc'
                                        )
                                ->where('Empresa.ID','=',$Id)
                                ->get();

        $DatosEmpresa = $Empresa->first();

        $Logo = $DatosEmpresa->Logo;
        

        return view('Empresa.indexEmpresa')->with(['Empresa'=>$Empresa, 'Logo' => $Logo, 'IdEmpresa'=>$Id]);

    }

    public function datatableListEmpresa(Request $request){

        session_start();
        $search = $request->get("search");
        $order = $request->get("order");
        $sortColumnIndex = $order[0]['column'];
        $length = $request->get('length');
        $start = $request->get('start');
        $columna = $request->get('columns');
        $orderBy = $columna[$sortColumnIndex]['data'] == 'ID' ? 'Empresa.Created_At' :  $columna[$sortColumnIndex]['data'];
        $sortColumnDir = $columna[$sortColumnIndex]['data'] == 'ID' ? 'desc' :  $order[0]['dir'];

        $tipoUsuario = null;
        // $tipoUsuario = $_SESSION['IdTipoUsuario'];
        // if(Session::get("PRIVILEGIOS") != null)
        //     $tipoUsuario = Session::get("PRIVILEGIOS")->IdTipoUsuario;

        // $IdEmpresa = $_SESSION['IdEmpresa'];
        
        $empresas = Empresa_Model::join('TipoDocumento','TipoDocumento.Id','=','Empresa.IdTipoDocumento')
                    ->join('Usuario', 'Usuario.ID', '=', 'Empresa.IdUsuario')
                 ->select(
                        'Empresa.ID',
                        'Empresa.IdUsuario',
                        'Empresa.Nombre',
                        'Empresa.IdTipoDocumento',
                        'TipoDocumento.Nombre AS NombreTipoDocumento',
                        'Empresa.NumeroDocumento',
                        'Empresa.NombreContacto',
                        'Empresa.TelefonoContacto',
                        'Empresa.Direccion',
                        'Empresa.Logo',
                        'Empresa.Estado',
                        'Usuario.Correo',
                        'Empresa.CorreoComercial',
                        'Empresa.Created_At');
                        //->orderBy("IdEmpresa", "desc");)

        $empresas = $empresas->orderBy($orderBy, $sortColumnDir);  

        switch ($tipoUsuario ) {
            case '2':
                 // $empresas = $empresas->where('Empresa.ID',Session::get("PRIVILEGIOS")->IdEmpresa);
                $empresas = $empresas->where('Empresa.ID',$IdEmpresa);
                break;
            case '3':
                // $empresas = $empresas->where('Empresa.ID',Session::get("PRIVILEGIOS")->IdEmpresa);
                $empresas = $empresas->where('Empresa.ID',$IdEmpresa);
                break;
            default:
                break;
        } 
      
        $totalRegistros = $empresas->count();
        //BUSCAR            
            if($search['value'] != null){
                $empresas = $empresas->whereRaw(
                        "(Empresa.Id LIKE '%".$search["value"]."%' OR ". 
                         "Empresa.Nombre LIKE '%". $search['value'] . "%' OR " .
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
                'tipoUSU' =>$tipoUsuario,
                'orderBy'=>$orderBy,
                'recordsFiltered' =>$parcialRegistros,
                'data' =>$empresas->get()];

        return response()->json($data);
    }

    public function postStore(Request $request)
    {
        try {

            $IdEmpresa = $request->input('ID');
            $usuario = new UsuariosModel();

            $nombreUsuario = $request['Nombre'];
            $numeroDocumento = $request['NumeroDocumento'];
            //Se elimina algoritmo por solicitud del cliente
            // $largo = strlen($numeroDocumento);

            // $PrimeraContraseña = strtoupper(substr($nombreUsuario,0,1));
            // $PrimeraContraseña = $PrimeraContraseña .substr($numeroDocumento,$largo - 4,4);

            // $usuario['Contrasena'] = md5($PrimeraContraseña);

            $usuario['Contrasena'] = md5($request['NumeroDocumento']);
            $usuario['IdTipoUsuario'] = 2;
            $usuario['Confirmado'] = 0;
            $usuario['CodigoConf'] = str_random(25);
            $usuario['Correo'] = $request['Correo'];
            $usuario['Login'] = $numeroDocumento;
            $usuario->save();

            $empresas = $IdEmpresa == "" ? new Empresa_Model() : Empresa_Model::find($IdEmpresa);
            $empresas['IdUsuario'] = $usuario->ID;
            $empresas['CorreoComercial'] = $request['CorreoComercial'];
            $empresas['Estado'] = 1;
            $data = $request->all();
            $empresas->fill($data);
            $empresas->save();

            $correoEmpresa = $request['Correo'] == null ? 'ventascorporativas@maicaogiftstore.com' : $request['Correo'];
            
            try{
                // envio correo de confirmacion
                Mail::send('Correos.CorreoConfirmacion',['data' => $usuario, 'empresas' => $empresas, 'correoEmpresa' => $correoEmpresa],function($mensaje) use ($usuario,$empresas,$correoEmpresa){
                    $mensaje->from('jonathandev123@gmail.com');
                    $mensaje->to($correoEmpresa)->subject('Confirmacion registro plataforma Maicao Gift Strore');
                });
                
            }
            catch (\Exception $e){
                $retorno = [
                    "mensaje" => "Error al enviar correo, por favor comunícate con el administrador.",
                    "error" => $e->getMessage()
                ];
                
                return response()->json($retorno);
            }
    
        } catch (\Exception $e) {
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
        session_start();
        $titulo = "Empresas";
        $empresaID = $request->input('IdJuguete');

        $empresas = $empresaID == "" ? new Empresa_Model() : Empresa_Model::find($empresaID);

        $IdUsuario = $empresas->IdUsuario > 0 ? $empresas->IdUsuario : 0;

        $Usuario = $empresaID == "" ? new UsuariosModel() : UsuariosModel::find($IdUsuario);

        if($empresaID > 0)

        $tipodocumento = [null=>'Seleccione...'];
        $tipodocumento = TipoDocumento_Model::orderBy('ID','asc')->pluck('Nombre','ID');

        $view = view('Empresa.formEmpresa')->with(['empresa' => $empresas, 'Usuario'=>$Usuario, 'titulo' => $titulo,'tipodocumento'=>$tipodocumento]);

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
        
        $retorno = [
        "success" => true,
        "mensaje" => "Estado actualizado",
        //"request" => $request->all(),
        "usuario" => $empresas
        ];

        return response()->json($retorno);
    }

    
    public function eliminarEmpresa(Request $request)
    {

        try{

            session_start();
            $fecha_actual = date("d/m/Y");
            $IdEmpresa = $request->input("IdEmpresa");

            $ListaEmpleados = DB::table('Empleado')->where('Empleado.IdEmpresa', '=', $IdEmpresa)->get();

            if($ListaEmpleados->count() > 0)
            {
                foreach ($ListaEmpleados as $key) 
                {
                    $IdEmpleado = $key->ID;

                    $return = DB::select("call DevolverStockEmpleado (".$IdEmpleado.")");
                    //DB::table('Empleado')->where('Empleado.ID', '=', $IdEmpleado)->delete();
                    //EmpleadoModel::destroy($IdEmpleado);
                    $Empleado = EmpleadoModel::select('IdUsuario')
                                ->where('Empleado.ID', '=', $IdEmpleado)
                                ->first();

                    $IdUsuarioEmp = $Empleado->IdUsuario;

                    DB::table('Usuario')->where('Usuario.ID', '=', $IdUsuarioEmp)->Delete();

                }
            }

            $ListaConvenios = DB::table('Convenio')->where('Convenio.IdEmpresa', '=', $IdEmpresa)->get();

            if($ListaConvenios->count() > 0)
            {
                foreach ($ListaConvenios as $keyCon) 
                {
                    if($keyCon->FechaInicio < $fecha_actual && $keyCon->FechaFin >= $fecha_actual)
                    {
                        $IdConvenio = $keyCon->ID;

                        $stock = DB::select("call DevolverStock (".$IdConvenio.")");
                        //DB::table('Empleado')->where('Empleado.ID', '=', $IdEmpleado)->delete();
                        //EmpleadoModel::destroy($IdEmpleado);
                    }

                }
            }

            $Empresa = EmpleadoModel::select('IdUsuario')
                                ->where('Empresa.ID', '=', $IdEmpresa)
                                ->first();

            Empresa_Model::destroy($IdEmpresa);            

                    $IdUsuario = $Empresa->IdUsuario;

                    DB::table('Usuario')->where('Usuario.ID', '=', $IdUsuario)->Delete();
            
            return response()->json($IdEmpresa);
            
        }

        catch (\Exception $e){

            return response([
                    "mensaje" => "Error al eliminar, por favor intenta de nuevo o comunícate con el administrador.",
                    "error" => $e->getMessage()
                ]);

        }

    }

    public function destroy(Empresas $empresas)
    {
        //
    }

    public function GuardarTxt(Request $request){
        try{

                $root = $_SERVER["DOCUMENT_ROOT"];
                $data = $request->all();
                $fecha = \DateTime::createFromFormat('Y-m-d', date('Y-m-d H:i:s'));

                //$file = $request->file('file');
                $file = $_FILES['file'];
                $tmpfile = $_FILES["file"]["tmp_name"];
                $allowedFiles = array('txt');
                //$path = public_path().'/uploads/Masivo/empresa/'.$fecha.'/'; 
                $path = $root.'/uploads/Masivo/empresa/'.$fecha.'/';

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
                    //$file->move($path, 'empresa.'.$extension);
                    //$leerarchivo = explode("\n",File::get($path. '/empresa.'.$extension));
                    
                    $fileName = str_replace(" ", "_", $archivo);
                    $move = rename($tmpfile, $path.'empresa.'.$extension);
                    $leerarchivo = explode("\n",File::get($path. '/empresa.'.$extension));
                    
                    /*
                    return response()->json([
                        'mensaje'=> $path.'empresa.'.$extension,
                        'archivo' => $leerarchivo,
                        'moved' => $move
                    ]);
                    */
                    

                    $result_texto = '';
                   // var_dump($leerarchivo);
                    foreach ($leerarchivo as $key=>$line){
                        $datosLinea = explode(',', $line);
                        //echo count($datosLinea);
                         $datos =  new Empresa_Model();
                         $datosusu = new UsuariosModel();
                        if(count($datosLinea) > 0  && count($datosLinea) == 5){
                            if(is_string($datosLinea[0])){
                                $datos['Nombre'] = $datosLinea[0];
                                if(is_string($datosLinea[1])){
                                    $id_codigo = TipoDocumento_Model::where('Codigo',$datosLinea[1])->select('ID')->first();
                                    $datos['IdTipoDocumento'] = ($id_codigo['ID'] != null)?$id_codigo['ID']:1;
                                    if(is_string($datosLinea[2])){  
                                        $datos['NumeroDocumento'] = $datosLinea[2];
                                        if( $this->email($datosLinea[3])){
                                            $datosusu['Correo'] = $datosLinea[3];
                                            if(is_string($datosLinea[4])){
                                                $datos['CorreoComercial'] = $datosLinea[4];
                                             }
                                             else{
                                                $result_texto .= '| Email de comercial, no valido, linea:'.$key.' |';
                                             }
                                        }else{
                                            $result_texto .= '| Email no valido, linea:'.$key.' |';
                                        }
                                    }else{
                                        $result_texto .= '| NumeroDocumento no valido, linea:'.$key.' |';
                                    }
                                }else{
                                    $result_texto .= '| IdTipoDocumento no valido, linea:'.$key.' |';
                                }
                            }else{
                                $result_texto .= '| Nombre no valido, linea:'.$key.' |';
                            }
                            if($result_texto == ''){
                                $datosusu['Login'] = $datos['NumeroDocumento'];

                                //Se elimina algoritmo por solicitud del cliente
                                // $largo = strlen($datos['NumeroDocumento']);

                                // $PrimeraContraseña = strtoupper(substr($datos['Nombre'],0,1));
                                // $PrimeraContraseña = $PrimeraContraseña .substr($datos['NumeroDocumento'],$largo - 4,4);

                                // $datosusu['Contrasena'] = md5($PrimeraContraseña);

                                $datosusu['Contrasena'] = md5($datos['NumeroDocumento']);
                                $datosusu['Confirmado'] = 0;
                                $datosusu['CodigoConf'] = "";
                                $datosusu['IdTipoUsuario'] = 3;
                                $datosusu->save();
                                $datos['IdUsuario'] = $datosusu->ID;

                                //$datos['IdUsuario'] = 1;
                                $datos->save();
                                //var_dump($datos);
                            }
                        }else{
                            $result_texto .= 'Error  al guardar. Cadena de texto no conside, linea: '.$key ;
                        }
                    }

                    if($result_texto != ''){
                        return response()->json([
                                'mensaje'=>$result_texto,    
                                'error' => 'error'
                            ]);
                    }
                }else{
                    return response()->json([
                    'mensaje'=>"Error al guardar. Extensión no válida."        
                    
                    ]);
                }
            return response()->json([
               'mensaje'=> "Datos guardados Correctamente", 
               'success' => 'success'
             ]);

        }catch (Exception $e) {
            return response()->json([
                'mensaje'=>"Error  al guardar. Por favor intenta de nuevo.",         
                'error' => $e->getMessage()
            ]);
        }
    }

    function email($str){
      return (false !== strpos($str, "@") && false !== strpos($str, "."));
    }

    public function SubirlogoEmpresa(Request $request)
    {
        session_start();
        $ID = $request->input('id');
        $img = Empresa_Model::find($ID);//Empresa_Model::where('ID','=',$ID)->get();

        $view = view('Empresa.Logo')->with(['datos'=>$img]);
        
        return $view->renderSections()['content_modal'];

          if($request->ajax()){
            return $view->renderSections()['content_modal'];
        }else{
            return $view;
        }  
    }
    public function postStoreLogo(Request $request){
        try{
            
                $root = $_SERVER["DOCUMENT_ROOT"];
                $data = $request->all();
                $ID = $request->input('Id');
                
                $img = Empresa_Model::find($ID);

                //$file = $request->file('file');
                $file = $_FILES['file'];
                $tmpfile = $_FILES["file"]["tmp_name"];
                $allowedFiles = array('jpeg', 'jpg', 'png');
                //$path = public_path().'/uploads/Empresas/'.$ID.'/';
                $path = $root.'/uploads/Empresas/'.$ID.'/';
                
                if( $file != null ){
                    //$archivo =  str_replace(" ", "_", $file->getClientOriginalName());
                    $archivo =  str_replace(" ", "_", $file['name']);
                    $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                    if(in_array($extension,$allowedFiles)){
                        if(!file_exists($path)){
                          mkdir($path,0777,true);
                          chmod($path, 0777); 
                        }

                        $img->fill($data);
                        $img->save();
                        //$fileName = str_replace(" ", "_", $file->getClientOriginalName());
                        $fileName = str_replace(" ", "_", $archivo);

                        //$file->move($path, 'Empresa_'.$img['ID'].'.'.$extension);
                        //move_uploaded_file($fileName, $path.$fileName.'.'.$extension);
                        //$move = move_uploaded_file($fileName, $path.$fileName);
                        $move = rename($tmpfile, $path.'Empresa_'.$img['ID'].'.'.$extension);
                        chmod($path.'Empresa_'.$img['ID'].'.'.$extension, 0777);
    
                        $img['Logo']= 'uploads/Empresas/'.$ID.'/Empresa_'.$img['ID'].'.'.$extension;
                        $img->fill($data);
                        $img->save();
                    }else{
                        return response()->json([
                        'mensaje'=>"Error al guardar. Extensión no válida.",
                        'extension'=>$extension
                    
                        ]);
                }
            }
            return response()->json([
               'mensaje'=> "Datos guardados Correctamente", 
               'ImgJuguete_ID' => $ID,
               'success' => 'success'
             ]);

        }catch (Exception $e) {
            return response()->json([
                'mensaje'=>"Error  al guardar. Por favor intenta de nuevo.",         
                'error' => $e->getMessage()
            ]);
        }
    }

}
