@extends('Templates.secciones.app')
@section('content_modal')
    <div class="modal-dialog" style="min-width: 80% !important;">
        <div class="modal-content">        	
			
				<div class="modal-header bg-primary">
				    <h4 class="modal-title">{{$titulo}}</h4>
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row center-block">
				        <div class="col-md-12" style="margin-bottom: 10px;">
                            <div id="mensaje_errorM">
                                
                            </div>
				        	{!! Form::open(['id' => 'form-masivoempleado', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStoremasivos']) !!}
				        	<div id="col-md-4"></div>
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

				<div class="modal-footer">

					<button class="btn btn-primary" id="guardar_masivo">Guardar</button>
					<a class="btn btn-default" data-dismiss="modal">Cerrar</a>	    
				</div>						         
        </div>
    </div>
    <script type="text/javascript">
    var maxfile = 1;

        Dropzone.autoDiscover = false;
        var urlForm = $('#APP_URL').val() +"/empleado/GuardarTxt/";
        console.log(urlForm)
        var token = $('#_MTOKEN').val();        
        var formLogo = new Dropzone("form#form-masivoempleado", { 
        url: urlForm,     
        acceptedFiles: "text/plain",
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
                var submitBtn = document.querySelector("#guardar_masivo");
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
                  formData.append('Id', {{$datos->IdEmpresa}});
                });
                this.on("complete", function(file) {
                    myDropzones.removeFile(file);

                });
                this.on("error", function(files, response) {
                   $("#mensaje_errorM").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al procesar archivo.</b></center></div>')
        
                });
                this.on("success", function(file, response) {
                    console.log(file);
                    console.log(response); 
                    if(response.error != null){
                   $("#mensaje_errorM").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')

               }else{
                    cargarTablaempleado();
                     $('.close').click();
                      $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+response.mensaje+'</b></center></div>')   
                  }
                });
            }
        });
    $(document).ready(function(){
       
        /**/
    });
  
</script>
@endsection
        {!! Html::script('js/Empleado/empleado.js') !!}
