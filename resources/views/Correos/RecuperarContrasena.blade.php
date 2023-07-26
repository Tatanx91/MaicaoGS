@extends('Templates.secciones.app')

@section('content')

    <div id="ConfirmCorreo"></div>
	{{ Form::hidden('id_modulo', 'Recuperar', array('id' => 'id_modulo')) }}
    <div class="table-responsive">
        <h2>Para continuar con la asignacion de su nueva contraseña, por favor dirijase a el siguiente link</h2>
        <a href="{{ url('/Contrasena/RecuperarContrasena/'.$codigoConf) }}">
        	Recuperar contraseña
        </a>

        {{-- <img src="{{asset('Imagenes/Logo_web_Maicao.png')}}" style="width: 128px; height: 128px" /> --}}
    </div>
@endsection