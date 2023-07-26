@extends('Templates.secciones.app')
@section('content')

    {{ Form::hidden('id_modulo', 'CambiarContraseña', array('id' => 'id_modulo')) }}

	<div class="default" style="margin-bottom: 10px !important;">
        <div class="page-header">
            <div>
                <h3 class="title_general" align="center">
                    Cambio de contraseña
                </h3>
            </div>
        </div>
        {!! Form::open(['route' => 'CambiarContrasena', 'method'=> 'POST', 'IdUsuario'=> 'IdUsuario' ]) !!}

        {{ Form::hidden('IdUsuario', $IdUsuario) }}

        <div class="form-group" align="center">
        	{!! Form::label('ContrasenaActual', 'Contraseña actual', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::password('ContrasenaActual', null, ['class'=> '']) !!}
        </div>

        <div class="form-group" align="center">
        	{!! Form::label('NuevaContrasena', 'Nueva Contraseña', ['class'=> 'control-label col.md-2']) !!}
			{{-- {!! Form::text('NuevaContrasena', null, ['class'=> 'form-control']) !!} --}}
            {!! Form::password('NuevaContrasena', null, ['class'=> '']) !!}
        </div>

        <div id="contenedor-boton-inicio" align="center">

            <!--<a class="btn btn-info btn-md" id="btn-inicio-sesion" style="margin-top: 30px;" method="post" type="submit">Ingresar</a>-->
            {{-- {!! Form::button('<i class = "btn btn-info btn-md"></i> Aceptar', array('type' => 'submit', 'class' => 'button')) !!} --}}
            {!! Form::submit('Aceptar') !!}
            {{--  'onclick' => 'return confirm("are you shure?")')) !!}--}}

        </div>
        {!! Form::close() !!}

    </div>

		
@endsection