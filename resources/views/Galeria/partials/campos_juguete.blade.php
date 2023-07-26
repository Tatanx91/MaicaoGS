<div class="panel-body">
		<div class="row">	
			<div id="mensaje_error" style="width: 100%;"></div>
		</div>
	<div class="row">

		{!! Form::hidden('IdJuguete', $juguete->IdJuguete, array('id' => 'IdJuguete'))!!}
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NumeroReferencia', 'NumeroReferencia:') !!}
			{!! Form::text('NumeroReferencia', $juguete->NumeroReferencia, array('id' => 'NumeroReferencia', 'class' => 'form-control', 'placeholder' => 'NumeroReferencia del juguete')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('NombreJuguete', 'NombreJuguete:') !!}
			{!! Form::text('NombreJuguete', $juguete->NombreJuguete, array('id' => 'NombreJuguete', 'class' => 'form-control', 'placeholder' => 'NombreJuguete del juguete')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('Dimensiones', 'Dimensiones :') !!}
			{!! Form::text('Dimensiones', $juguete->Dimensiones, array('id' => 'Dimensiones', 'class' => 'form-control', 'placeholder' => 'Dimensiones del juguete')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('EdadInicial', 'EdadInicial:') !!}
			{!! Form::text('EdadInicial', $juguete->EdadInicial, array('id' => 'EdadInicial', 'class' => 'form-control num-entero', 'placeholder' => 'EdadInicial del juguete')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('EdadFinal', 'EdadFinal:') !!}
			{!! Form::text('EdadFinal', $juguete->EdadFinal, array('id' => 'EdadFinal', 'class' => 'form-control num-entero', 'placeholder' => 'EdadFinal del juguete')) !!}			
		</div>

		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			{!! Form::label('IdGenero', 'genero:') !!}
			 {!! Form::select('IdGenero',$genero ,$juguete->IdGenero, array('id' => 'IdGenero','class'=>'form-control' )) !!}
			{{-- {!! Form::text('IdGenero', $juguete->IdGenero, array('id' => 'IdGenero', 'class' => 'form-control num-entero', 'placeholder' => 'genero del juguete')) !!}		 --}}	
		</div>

	</div>
	
</div>