<?php

namespace Jugueteria\Http\Controllers;

use Illuminate\Http\Request;
use Jugueteria\model\Juguete_model;
use Jugueteria\model\rel_juguete_img;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use File;

class GaleriaImgController extends Controller
{
    public function getGaleriaImg(Request $request)
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

        $jugueteID = $request->input('Id');
        $img = rel_juguete_img::join('Juguete','Juguete.ID','=','JugueteImg.IdJuguete')
         ->select('JugueteImg.Ruta',
            'JugueteImg.Imagen',
            'JugueteImg.ID',
            'JugueteImg.Estado')
         ->where('JugueteImg.IdJuguete','=',$jugueteID)
         ->where('JugueteImg.estado','=',1)
         ->get();

        $juguete = $jugueteID == "" ? new Juguete_model() : Juguete_model::find($jugueteID);
        $juguete['IdJuguete']=$jugueteID;
        $countimg = $img->count();
           return view('Galeria.index') ->with([
            'juguete'=>$juguete,'img'=>$img ,'countimg'=>$countimg]);
    }
    
    public function GuardarImg(Request $request){
    	try{
                $root = $_SERVER["DOCUMENT_ROOT"];
                $data = $request->all();
                $jugueteID = $request->input('Id');
                $Idimg = $request->input('idJugueteImg');

                $juguete = Juguete_model::find($jugueteID);
                $img = $Idimg == "" ? new rel_juguete_img() : rel_juguete_img::find($Idimg);

		        //$file = $request->file('file');
		        $file = $_FILES['file'];
		        $tmpfile = $_FILES["file"]["tmp_name"];
		        $allowedFiles = array('jpeg', 'jpg', 'png');
		        //$path = public_path().'/uploads/ImgJuguete/'.$jugueteID.'/'; 
		        $path = $root.'/uploads/ImgJuguete/'.$jugueteID.'/'; 

	 			if(($img['ID'] != "" || $img['ID'] != null)) {
	                $filename = public_path().'/uploads/ImgJuguete/'.$jugueteID.'/'.$img['ID'];
	                File::delete($filename);
	            }

	            if( $file != null ){
	                //$archivo =  str_replace(" ", "_", $file->getClientOriginalName());
	                $archivo =  str_replace(" ", "_", $file['name']);
	                $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
	                if(in_array($extension,$allowedFiles)){                    
	                    if(!file_exists($path)){
	                      mkdir($path,0777,true);
	                      chmod($path, 0777); 
	                    }               	    
					if($Idimg == ''){
						$img['IdJuguete']= $jugueteID;
					}
					$img['ruta']='uploads/ImgJuguete/'.$jugueteID.'/';
					$img['Extension']= $extension;
					$img['estado']= 1;

		            $img->fill($data);
		            $img->save();
                	//$fileName = str_replace(" ", "_", $file->getClientOriginalName());
                	$fileName = str_replace(" ", "_", $archivo);
                    //$file->move($path, 'JugueteImg'.$img['ID'].'.'.$extension);
                    $move = rename($tmpfile, $path.'JugueteImg'.$img['ID'].'.'.$extension);
		            chmod($path.'JugueteImg'.$img['ID'].'.'.$extension, 0777);

					$img['Imagen']= 'JugueteImg'.$img['ID'].'.'.$extension;
					$img->fill($data);
		            $img->save();
                }else{
                    return response()->json([
                    'mensaje'=>"Error al guardar. Extensión no válida."        
                    
                    ]);
                }
            }
         	return response()->json([
               'mensaje'=> "Datos guardados Correctamente", 
               'ImgJuguete_ID' => $jugueteID,
               'success' => 'success'
             ]);

        }catch (Exception $e) {
            return response()->json([
                'mensaje'=>"Error  al guardar. Por favor intenta de nuevo.",         
                'error' => $e->getMessage()
            ]);
        }
    }

    public function CargarContenedorImg(Request $request)
    {
        $jugueteID = $request->input('IdJuguete');
        $img = rel_juguete_img::join('Juguete','Juguete.ID','=','JugueteImg.IdJuguete')
         ->select('JugueteImg.*')->where('JugueteImg.IdJuguete','=',$jugueteID)->where('JugueteImg.estado','=',1)->get();
       

        $view = view('Galeria.contendorImg')->with(['img'=>$img]);
        return $view;
    }
 

    public function EliminaRegistro(Request $request)
    {
        try {
            
            $ID = $request->input('ID');
            $estado = $request->input('estado');
            $juguete = rel_juguete_img::find($ID);
            $juguete['estado'] = 0;
            $data = $request->all();
            $juguete->fill($data);
            $juguete->save();
    
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
                "juguete" => $juguete
            ]);
    }   
    
}
