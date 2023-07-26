<div class="panel-body">
		<div class="row">	
			<div id="mensaje_error" style="width: 100%;"></div>
		</div>
	<div class="row">

		{!! Form::hidden('ID', $empresa->ID, array('id' => 'ID'))!!}
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NombreEmpresa', 'Nombre Empresa:') !!}
			{!! Form::text('Nombre', $empresa->Nombre, array('id' => 'Nombre', 'class' => 'form-control', 'placeholder' => 'Nombre de la Empresa')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('IdTipoDocumento', 'Tipo Documento:') !!}
			 {!! Form::select('IdTipoDocumento',$tipodocumento ,$empresa->IdTipoDocumento, array('id' => 'IdTipoDocumento','class'=>'form-control' )) !!}
			{{-- {!! Form::text('IdTipoDocumento', $empresas->IdTipoDocumento, array('id' => 'IdTipoDocumento', 'class' => 'form-control num-entero', 'placeholder' => 'Tipo de Documento')) !!}		 --}}	
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NumeroDocumento', 'Numero Documento:') !!}
			{!! Form::text('NumeroDocumento', $empresa->NumeroDocumento, array('id' => 'NumeroDocumento', 'class' => 'form-control', 'placeholder' => 'Numero de documento de la Empresa')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NombreContacto', 'Nombre Contacto:') !!}
			{!! Form::text('NombreContacto', $empresa->NombreContacto, array('id' => 'NombreContacto', 'class' => 'form-control', 'placeholder' => 'Nombre del contacto con la Empresa')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('TelefonoContacto', 'Telefono Contacto:') !!}
			{!! Form::text('TelefonoContacto', $empresa->TelefonoContacto, array('id' => 'TelefonoContacto', 'class' => 'form-control', 'placeholder' => 'Numero de telefono contacto')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Correo', 'Correo:') !!}
			{!! Form::text('Correo', $Usuario->Correo, array('id' => 'Correo', 'class' => 'form-control', 'placeholder' => 'Correo de la Empresa')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Direccion', 'Direccion:') !!}
			{!! Form::text('Direccion', $empresa->Direccion, array('id' => 'Direccion', 'class' => 'form-control', 'placeholder' => 'direccion de la Empresa')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('CorreoComercial', 'Correo Comercial:') !!}
			{!! Form::text('CorreoComercial', $empresa->CorreoComercial, array('id' => 'CorreoComercial', 'class' => 'form-control', 'placeholder' => 'Correo del comercial a cargo de la empresa')) !!}			
		</div>

		{{-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Logo', 'Logo:') !!}
			{!! Form::text('Logo', $empresa->Logo, array('id' => 'Logo', 'class' => 'form-control', 'placeholder' => 'Logo de la Empresa')) !!}
		</div> --}}

	</div>
	
</div>