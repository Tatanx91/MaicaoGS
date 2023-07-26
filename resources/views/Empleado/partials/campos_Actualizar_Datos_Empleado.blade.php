<div class="panel-body">
		<div class="row">	
			<div id="mensaje_error" style="width: 100%;"></div>
		</div>
	<div class="row">

		{!! Form::hidden('ID', $ID, array('id' => 'ID'))!!}
		{!! Form::hidden('IdEmpresa', $datos['IdEmpresa'], array('id' => 'IdEmpresaAct'))!!}
		{!! Form::hidden('Actualizacion', 1, array('id' => 'Actualizacion'))!!}
		{{--  
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Nombre', 'Nombre:') !!}
			{!! Form::text('Nombre', $datos->Nombre, array('id' => 'Nombre', 'class' => 'form-control requiere', 'placeholder' => 'Nombre')) !!}			
		</div>


		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Apellido', 'Apellido:') !!}
			{!! Form::text('Apellido', $datos->Apellido, array('id' => 'Apellido', 'class' => 'form-control', 'placeholder' => 'Apellido')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('IdTipoDocumento', 'Tipo Documento:') !!}
			 {!! Form::select('IdTipoDocumento',$tipodoc ,$datos->IdTipoDocumento, array('id' => 'IdTipoDocumento','class'=>'form-control requiere' )) !!}
			{{- {!! Form::text('IdTipoDocumento', $datos->IdTipoDocumento, array('id' => 'IdTipoDocumento', 'class' => 'form-control requiere num-entero', 'placeholder' => 'genero del juguete')) !!}		 -}}	
		</div>
		
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NumeroDocumento', 'NumeroDocumento:') !!}
			{!! Form::text('NumeroDocumento', $datos->NumeroDocumento, array('id' => 'NumeroDocumento', 'class' => 'form-control requiere', 'placeholder' => 'NumeroDocumento')) !!}			
		</div>

		--}}

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Direccion', 'Direccion:') !!}
			{!! Form::text('Direccion', $datos['DireccionEmpleado'], array('id' => 'Direccion', 'class' => 'form-control requiere', 'placeholder' => 'Planta')) !!}
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Ciudad', 'Ciudad:') !!}
			{!! Form::text('Ciudad', $datos['CiudadEmpleado'], array('id' => 'Ciudad', 'class' => 'form-control requiere','placeholder' => 'Ciudad')) !!}
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Telefono', 'Telefono:') !!}
			{!! Form::text('Telefono', $datos['TelefonoEmpleado'], array('id' => 'Telefono', 'class' => 'form-control requiere', 'placeholder' => 'Telefono')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Correo', 'Correo:') !!}
			{!! Form::text('Correo', $datos['CorreoEmpleado'], array('id' => 'Correo', 'class' => 'form-control requiere','onblur'=>'validarCorreo()', 'placeholder' => 'Correo')) !!}			
		</div>

	</div>
	
</div> 