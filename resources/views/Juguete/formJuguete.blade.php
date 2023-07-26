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
				        	{!! Form::open(['id' => 'form-juguete', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}
								@include('Juguete.partials.campos_juguete')
				        	{!! Form::close() !!}
				    	</div>
				    </div>					
				</div>

				<div class="modal-footer">

					<button class="btn btn-primary" onclick="guardarJuguete()">Guardar</button>
					<a class="btn btn-default" data-dismiss="modal">Cerrar</a>	    
				</div>						         
        </div>
    </div>
    
@endsection
        {!! Html::script('js/Juguete/juguete.js') !!}
 