<div class="panel-body">
		<div class="row">	
			<div id="mensaje_error" style="width: 100%;"></div>
		</div>
	<div class="row">

		{!! Form::hidden('ID', $datos->ID, array('id' => 'ID'))!!}
		{!! Form::hidden('IdUsuario', $datos->IdUsuario, array('id' => 'IdUsuario'))!!}
		{!! Form::hidden('IdEmpresa', $datos->IdEmpresa, array('id' => 'IdEmpresa'))!!}
		{!! Form::hidden('Actualizacion', $datos->IdEmpresa, array('Actualizacion' => 'IdUsuario'))!!}
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
			{{-- {!! Form::text('IdTipoDocumento', $datos->IdTipoDocumento, array('id' => 'IdTipoDocumento', 'class' => 'form-control requiere num-entero', 'placeholder' => 'genero del juguete')) !!}		 --}}	
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NumeroDocumento', 'NumeroDocumento:') !!}
			{!! Form::text('NumeroDocumento', $datos->NumeroDocumento, array('id' => 'NumeroDocumento', 'class' => 'form-control requiere', 'placeholder' => 'NumeroDocumento')) !!}			
		</div>


		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Correo', 'Correo:') !!}
			{!! Form::text('Correo', $datosUsu->Correo, array('id' => 'Correo', 'class' => 'form-control', {{--'onblur'=>'validarCorreo()',--}} 'placeholder' => 'Correo')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Direccion', 'Direccion:') !!}
			{!! Form::text('Direccion', $datos->Direccion, array('id' => 'Direccion', 'class' => 'form-control requiere', 'placeholder' => 'Planta')) !!}
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Telefono', 'Teléfono:') !!}
			{!! Form::text('Telefono', $datos->Telefono, array('id' => 'Telefono', 'class' => 'form-control requiere', 'placeholder' => 'Telefono')) !!}
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Ciudad', 'Ciudad:') !!}
			{!! Form::text('Ciudad', $datos->Ciudad, array('id' => 'Ciudad', 'class' => 'form-control requiere','placeholder' => 'Ciudad')) !!}
		</div>


 		{{-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('FechaNacimiento', 'FechaNacimiento:') !!}
            <div class="form-group">
                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                    <input type="text" id="FechaNacimiento" value="{{$datos->FechaNacimiento}}" class="form-control datetimepicker-input Datepicker" data-target="#datetimepicker" placeholder = 'Fecha Nacimiento'/>
                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
		</div> --}}

	</div>
	
</div> 
<script type="text/javascript">
 $(function () {
                $('#datetimepicker').datetimepicker({
                    format: 'L',
		            ignoreReadonly: true,            
		            format: 'YYYY-MM-DD',
		            maxDate: 'now'
                });
            });
 </script>