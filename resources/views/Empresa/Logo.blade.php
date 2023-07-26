@extends('Templates.secciones.app')
@section('content_modal')
 <?php 
 $clase_Img ='d-none';
 $clase_Logo ='d-none';
 if($datos->Logo != null && $datos->Logo != ''){
    $clase_Img = '';
 }else{

    $clase_Logo ='';
 }
 ?>
    <div class="modal-dialog" style="min-width: 65% !important;">
        <div class="modal-content">        	
			
				<div class="modal-header bg-primary">
				    <h4 class="modal-title">Logo</h4>
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row center-block">
				        <div class="col-md-12" style="margin-bottom: 10px;">
                            <div id="mensaje_errorM">
                                
                            </div>
                            <div id="MuestraImg" class=" col-md-12 {{$clase_Img}}">
                                <div id="col-md-4">
                                </div>
                                <div id="col-md-4">
                                     <div class="card text-center">
                                          <div class="card-body">
                                            <img src="{{url("/") .'/'. $datos->Logo}}" style="width: 200px;height: 200px;" class="img-thumbnail">  
                                          </div>
                                          <div class="card-footer text-muted">
                                          <span style='cursor: pointer;float: right;' class='fa fa-trash fa-2x ' onclick=activarDessactivarLogoEmpresa('{{$datos->ID}}'); title='Eliminar imagen'></span>
                                          </div>
                                        </div>
                                </div>
                                <div id="col-md-4">
                                </div>
                                
                            </div>

                            <div id="MuestraUpload" class="{{$clase_Logo}}">
                                {{--
                                {!! Form::open(['method'=>'POST','route'=>['empresa/postStoreLogo'],'files'=>'true']) !!}
                                    {!! Form::text('nombre',null,['placeholder'=>'Ingrese nombre']) !!}    
                                    {!! Form::file('imagen',null) !!}
                                    {!! Form::submit("GUARDAR") !!}
                                {!! Form::close() !!}
                                --}}
                                
                                
    				        	{!! Form::open(['id' => 'form-LogoEmpresa', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStoreLogo', 'enctype'=>'multipart/form-data']) !!}
    				        	<div id="col-md-4">
                                </div>
    				        	<div id="col-md-4">
    				        		<center>
    	                            <div class="dz-message">
    	                                Arrastra aquí tu archivo plano o haz clic aquí para agregar uno.
    	                            </div>                
    	                            <div class="dropzone-previews"></div>
    	                            </center>
    	                        </div>
    				        	<div id="col-md-4"></div>
    				        	{!! Form::close() !!}
                            </div>
				    	</div>
				    </div>					
				</div>

				<div class="modal-footer">

					<button class="btn btn-primary" id="guardar_logo">Guardar</button>
					<a class="btn btn-default" data-dismiss="modal">Cerrar</a>	    
				</div>						         
        </div>
    </div>
    <script type="text/javascript">
    var maxfile = 1;

        Dropzone.autoDiscover = false;
        //var urlForm = $('#APP_URL').val() +"/empresa/postStoreLogo";
        var token = $('#_MTOKEN').val();        
        var formLogo = new Dropzone("form#form-LogoEmpresa", { 
        //url: urlForm,     
        acceptedFiles: "image/jpeg,image/png",
        autoProcessQueue: false,
        uploadMultiple: false,
        maxFilesize: 2,
        maxFilezise: maxfile,
        removeFile: false,
        maxFiles: maxfile,
        addRemoveLinks: false,
        parallelUploads: 1,
        dictRemoveFile: '<span class="glyphicon glyphicon-remove-circle" style="margin-top: -140px; float: right; color:#39805F !important"></<span>',

            init: function() {
                var submitBtn = document.querySelector("#guardar_logo");
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
                  formData.append('Id', {{$datos->ID}});
                });
                this.on("complete", function(file) {
                    myDropzones.removeFile(file);

                });
                this.on("error", function(files, response) {
                   $("#mensaje_errorM").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al procesar archivo.</b></center></div>')
        
                });
                this.on("success", function(file, response) {
                    
                    if(response.error != null){
                   $("#mensaje_errorM").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')

               }else{
                     $('.close').click();
                      $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')   
                  }
                });
            }
        });
    $(document).ready(function(){
       
        /**/
    });
    function activarDessactivarLogoEmpresa(ID){
        if(confirmacion('¿Esta Seguro de realizar esta accion?')){
                $('#MuestraImg').addClass('d-none');
                $('#MuestraUpload').removeClass('d-none');
        }
    }
  
</script>
@endsection
        {!! Html::script('js/Empleado/empleado.js') !!}
