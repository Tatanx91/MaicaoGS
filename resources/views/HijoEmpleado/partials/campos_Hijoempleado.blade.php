<div class="panel-body">
		<div class="row">	
			<div id="mensaje_error" style="width: 100%;"></div>
		</div>
	<div class="row">
        {{ Form::hidden('Id',$datos->Id, array('id' => 'Id')) }}
        {{ Form::hidden('IdEmpleado',$IdEmpleado, array('id' => 'IdEmpleado')) }}

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Nombre', 'Nombre:') !!}
			{!! Form::text('Nombre', $datos->Nombre, array('id' => 'Nombre', 'class' => 'form-control requiere', 'placeholder' => 'Nombre')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Apellido', 'Apellido:') !!}
			{!! Form::text('Apellido', $datos->Apellido, array('id' => 'Apellido', 'class' => 'form-control', 'placeholder' => 'Apellido')) !!}			
		</div>
		{{-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('IdTipoDocumento', 'Tipo Documento:') !!}
			 {!! Form::select('IdTipoDocumento',$tipodoc ,$datos->IdTipoDocumento, array('id' => 'IdTipoDocumento','class'=>'form-control' )) !!}
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NumeroDocumento', 'NumeroDocumento:') !!}
			{!! Form::text('NumeroDocumento', $datos->NumeroDocumento, array('id' => 'NumeroDocumento', 'class' => 'form-control num-entero', 'placeholder' => 'NumeroDocumento')) !!}			
		</div> --}}

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">	
			{!! Form::label('IdGenero', 'genero:') !!}
			 {!! Form::select('IdGenero',$genero ,$datos->IdGenero, array('id' => 'IdGenero','class'=>'form-control requiere' )) !!}
		</div>
 		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('FechaNacimiento', 'FechaNacimiento:') !!}
            <div class="form-group">
                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                    <input type="text" id="FechaNacimiento" value="{{$datos->FechaNacimiento}}" class="form-control datetimepicker-input Datepicker" data-target="#datetimepicker" placeholder = 'Fecha Nacimiento'/>
                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">	
			{!! Form::label('Obsequio', 'obsequio:') !!}
			 {!! Form::text('Obsequio',$datos->Obsequio, array('id' => 'Obsequio','class'=>'form-control' )) !!}
		</div>

	</div>
	
</div> 
<script type="text/javascript">
 $(function () {
                $('#datetimepicker').datetimepicker({
                    // format: 'L',
		            ignoreReadonly: true,            
		            format: 'YYYY-MM-DD',
		            maxDate: 'now'
                });
            });
 </script>