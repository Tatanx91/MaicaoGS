@extends('Templates.secciones.app')
@section('content_modal')

        <div class="col-md-12" style="margin-bottom: 10px;">
        	{!! Form::open(['id' => 'form-Hijoempleado', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}
				@include('HijoEmpleado.partials.campos_Hijoempleado')
        	{!! Form::close() !!}
			<center><button class="btn btn-primary" onclick="guardarHijoEmpleado()">Guardar</button></center>
    	</div>
    {!! Html::script('js/Empleado/Hijoempleado.js') !!}
@endsection
