@extends('Templates.secciones.app')

@section('content')
<?php
$class_from='col-lg-12 ';
if($countimg>=5){
    $class_from .= 'd-none';
}
?>
     <div class="default" style="margin-bottom: 35px !important;">
            <div class="page-header">
                <div>
                    <h3 class="title_general">
                        Galeria        
                        <a class="btn btn-primary " tile="Volver" href="{!! url('Juguete'); !!}" style="float:right;cursor: pointer;">
                            <span  class="fa fa-arrow-left fa-2x"></span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>

        <div id="mensaje"></div>
		{{ Form::hidden('id_modulo', 'galeriaIMG', array('id' => 'id_modulo')) }}
        <div id="form_img" class="{{$class_from}}"  style="margin-bottom: 35px !important;">
            <div  class="row" style="margin-bottom: 5px;">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <center>
                    {!! Form::open(["id"=>"form-Img","class"=>"col-lg-12 dropzone text-center","enctype"=>"multipart/form-data"]) !!}
                        <div id="div_logo">
                            <div class="dz-message">
                                Arrastra aquí tu imagen o haz clic aquí para agregar uno.
                            </div>                
                            <div class="dropzone-previews"></div>
                        </div>
                    {!! Form::close() !!}
                    </center>  
                </div>
                <div class="col-lg-4"></div>
                
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">                
                    <center>
                        <button class="btn btn-success text-center" id="btn_logo">Guardar</button>
                    </center> 
                </div>
                <div class="col-lg-4"></div> 
            </div>
            
        </div>

        <div id="contenedor_img" class="row">
            @foreach ($img as $item)
            <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
                <div class="card text-center">
                  <div class="card-header">
                       {{-- <span style='cursor: pointer;float: right;' id=estado_"{{$item->Imagen}}" class='fa fa-cogs fa-2x ' onclick=activarDessactivarJuguete('{{$item->ID}}','{{$item->Estado}}'); title='desactivar imagen'></span>
                      </div> --}}
                        <div class="card-body">
                            <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 100%;height: 100%;" class="img-thumbnail">  
                        </div>
                        <a>{{ $item }}</a>
                        <div class="card-footer text-muted">
                            <span style='cursor: pointer;float: right;' id=estado_"{{$item->Imagen}}" class='fa fa-toggle-on fa-2x ' onclick=activarDessactivarJugueteImg('{{$item->ID}}','{{$item->Estado}}'); title='desactivar imagen'></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

<script type="text/javascript">
    var contadorImg = '{{$countimg}}';
    var maxfile = 5;

        Dropzone.autoDiscover = false;
        var urlForm = $('#APP_URL').val() +"/Galeria/GuardarImg/";
        var token = $('#_MTOKEN').val();        
        var formLogo = new Dropzone("form#form-Img", { 
        url: urlForm,     
        acceptedFiles: "image/jpeg,image/png",
        autoProcessQueue: false,
        uploadMultiple: false,
        maxFilesize: 2,
        maxFilezise: maxfile,
        maxFiles: maxfile,
        addRemoveLinks: true,
        parallelUploads: 1,
        dictRemoveFile: '<span class="glyphicon glyphicon-remove-circle" style="margin-top: -140px; float: right; color:#39805F !important"></<span>',

            init: function() {
                contadorImgd = '{{$countimg}}';
                var submitBtn = document.querySelector("#btn_logo");
                myDropzones = this;            
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    if ( myDropzones.getQueuedFiles().length > 0 ){
                        myDropzones.processQueue();
                    }else{
                        alert('Por favor seleccione una imagen a subir...')
                    }
                });
                
                this.on("sending", function(file, xhr, formData) {                                                                    
                  formData.append('_token', token);
                  formData.append('Id', {{$juguete->ID}});
                });
                this.on("complete", function(file) {
                    myDropzones.removeFile(file);

                });
                this.on("error", function(files, response) {
                   $("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')
        
                });
                this.on("success", function(file, response) {
                    console.log(file);
                    console.log(response);      
                      $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')   
                      cargaImgs({{$juguete->ID}});
                     contadorImgd++;
                     // alert(contadorImgd)
                      validaForm(contadorImgd);
                });
            }
        });
    $(document).ready(function(){
       
        /**/
    });
    function  validaForm(contador){
        this.contadorImg = contador;
        // alert(this.contadorImg+'>='+this.maxfile)
        if(this.contadorImg >= this.maxfile){
            $("#form_img").addClass('d-none');
        }
    }
    function cargaImgs(id){
     var url = $("#APP_URL").val() + "/Galeria/CargarContenedorImg/";
        $.post(url,{IdJuguete : id,_token:token})
            .done(function(data){
                console.log(data);
                $("#contenedor_img").html(data);    
                    
            }).fail(function(jqXHR){
                $("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al actualizar imagenes</b></center></div>')
                
            });
    } 
    
function activarDessactivarJugueteImg(id,estado){
    var estado_update = 1;

    if(estado == "1"){
        estado_update = 0;  
    }

    var url = $("#APP_URL").val() + "/Galeria/EliminaRegistro";
    $.post(url,{estado : estado_update,ID : id,_token:token})
    .done(function(data){
        // cargarTablaJuguete()
        $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')
        location.reload();        
            
    }).fail(function(jqXHR){
        $("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
        
    });

}

</script>
@endsection