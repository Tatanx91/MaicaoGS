@extends('layout.home')
@section('content')
	{!! Form::model($usuario, (['route' =>['usuario.Editar', $usuario->idUsuario], 'method'=> 'PATCH', 'class'=>'form-horizontal'])) !!}
		<div class="form-group">
			{!! Form::label('NombreUsuario', 'Nombre usuario', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::text('NombreUsuario', null, ['class'=> 'form-control']) !!}
			{!! $errors->has('NombreUsuario')?$errors->first('NombreUsuario'):'' !!}
		</div>

		<div class="form-group">
			{!! Form::label('ApellidoUsuario', 'Apellido', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::text('ApellidoUsuario', null, ['class'=> 'form-control']) !!}
			{!! $errors->has('ApellidoUsuario')?$errors->first('ApellidoUsuario'):'' !!}
		</div>

		<div class="form-group">
			{!! Form::label('NumeroDocumento', 'Numero de documento', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::text('NumeroDocumento', null, ['class'=> 'form-control']) !!}
			{!! $errors->has('NumeroDocumento')?$errors->first('NumeroDocumento'):'' !!}
		</div>

		<div class="form-group">
			{!! Form::label('Contrasena', 'Contraseña', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::text('Contrasena', null, ['class'=> 'form-control']) !!}
			<!--<input type="password" class="form-control" name="Contrasena">-->
			{!! $errors->has('Contrasena')?$errors->first('Contrasena'):'' !!}
		</div>

		<div class="form-group">
			{!! Form::label('Descripcion', 'Descripcion', ['class'=> 'control-label col.md-2']) !!}
			{!! Form::textarea('Descripcion', null, ['class'=> 'form-control']) !!}
		</div>
		<button class="btn btn-primary" type="submit">Guardar</button>
	{!! Form::close() !!}

@endsection