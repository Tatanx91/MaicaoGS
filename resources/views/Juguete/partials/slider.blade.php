@extends('Templates.secciones.app')
@section('content_modal')

<style type="text/css">

</style>

    <div class="modal-dialog" style="min-width: 50% !important; margin-left:25%;">
        <div class="modal-content">        	
			
				<div class="modal-header text-center" style="background-color: #F63521; color: white">
				    <h4 class="modal-title">Galeria - {{ $data[0]->Nombre }}</h4>
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row center-block">
				        <div class="col-md-12" style="margin-bottom: 10px;">      
			        	 	<div class="panel-body">




							<?php $contador = 0;$clase='active'; ?>		
								<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

									<ol class="carousel-indicators">
										@foreach ($data as $img)
										<li data-target="#carouselExampleIndicators" data-slide-to="{{ $contador }}" class="{{ $clase }}"></li>

										<?php $contador++;$clase=''; ?>		
										@endforeach
								  	</ol>
									<?php $contador = 0;$clase='active'; ?>		

								 	<div class="carousel-inner">

										@foreach ($data as $item)
									    <div class="carousel-item {{ $clase }}" >
									    	<center>
									      		<img class="d-block w-100" src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" alt="First slide" style="width: 80% !important;height: 80% !important;">
									      		 {{-- <div class="carousel-caption d-none d-md-block">
												    <h5>{{ $item->Nombre }}</h5> --}}
												{{--     <p>{{ $item->Descripcion }}</p>  --}}
												{{-- </div> --}}
									      	</center>
									    </div>
										<?php $contador++;$clase=''; ?>		
										@endforeach

										  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
										    <span class="previmg" aria-hidden="true" style="font-size: 55px;color: red;"><</span>
										    <span class="sr-only">Previous</span>
										  </a>
										  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
										    <span id="nextimg" aria-hidden="true" style="font-size: 55px;color: red;">></span>
										    <span class="sr-only">Next</span>
										  </a>
									</div>
								  



							</div>
				    	</div>
				    </div>					
				</div>
				<div class="modal-footer">
				    @if( $_SESSION['IdTipoUsuario'] == 1)
					<button class="btn btn-primary" onclick="guardarJuguete()">Guardar</button>
					@endif
					<a class="btn btn-default" data-dismiss="modal">Cerrar</a>	    
				</div>						         
        </div>
    </div>
    
@endsection

