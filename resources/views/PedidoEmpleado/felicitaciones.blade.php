@extends('Templates.secciones.app')
@section('content_modal')
    <div class="modal-dialog" style="min-width: 65% !important;">
        <div class="modal-content">        	
			
				<div class="modal-header bg-primary">
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
                    <img src="{{asset('Imagenes/FelicitacionesSeleccion_1.jpg')}}" style="width: 100%; height: 100%" />
                </div>

				<div class="modal-footer">

					<button class="btn btn-primary" onclick="guardarEmpleado()">Guardar</button>
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>	    
				</div>						         
        </div>
    </div>
    
@endsection

<!--
<div class="container" style="z-index: 1050; position: fixed; margin-right:unset;" id="myModal">
  <!-- Modal usando el atributo data-show="true" --
  <div class="" role="dialog" data-show="true">
    <div class="modal-dialog">
      <!-- Modal content--
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <img src="{{asset('Imagenes/FelicitacionesSeleccion.jpg')}}" style="width: 100%; height: 100%" />
        </div>
      </div>
    </div>
  </div>
</div>
-->