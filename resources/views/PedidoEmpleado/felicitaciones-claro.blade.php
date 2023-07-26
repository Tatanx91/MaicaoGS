@extends('Templates.secciones.app')
@section('content_modal')
    <div class="modal-dialog" style="min-width: 65% !important;">
        <div class="modal-content">        	
			
				<div class="modal-header bg-primary">
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
                    {{--<img src="{{asset('Imagenes/FelicitacionesSeleccionClaro.jpg')}}" style="width: 100%; height: 100%" />--}}
                    <video width="467" height="500" autoplay>
                        <source src="https://maicaogs.com/Imagenes/Felicitaciones_Seleccion_Claro.mp4" type="video/mp4">
                    </video>
                    
                </div>

				<div class="modal-footer">

					<button class="btn btn-primary" onclick="guardarEmpleado()">Guardar</button>
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>	    
				</div>						         
        </div>
    </div>
    
@endsection

<!--
<div class="" style="z-index: 1050; position: fixed; margin-left:25%;" display="true">
  <div class="" role="dialog" data-show="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            {{--<img src="{{asset('Imagenes/FelicitacionesSeleccionClaro.jpg')}}" style="width: 100%; height: 100%" />--}}
            <video width="467" height="500" autoplay>
                <source src="https://maicaogs.com/Imagenes/Felicitaciones_Seleccion_Claro.mp4" type="video/mp4">
            </video>
            
        </div>
      </div>
    </div>
  </div>
</div>
-->