@extends('Templates.secciones.app')
@section('content_modal')
{!! Html::script('js/Empleado/empleados3.js') !!}

    <div class="modal-dialog" style="min-width: 65% !important;">
        <div class="modal-content" style="height: 98vh; overflow-y: scroll;">
			
				<div class="modal-header" style="background-color: #F63521">
				    <font color="white"><h4 class="modal-title">{{$titulo}}</h4></font>
				    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
				</div>
				<div class="modal-body">
					<div class="row center-block">
				        <div class="col-md-12" style="margin-bottom: 10px;">
				        	<p>¡Hola! <br>
Te invitamos a verificar la siguiente información. <br>
MaicaoGiftStore/Global&MarkSAS como respaldo de confidencialidad aplica el Derecho de Habeas Data incluido en los Artículos 15 y 20 de la Constitución Política de Colombia, la Ley Estatutaria 1581 de 2012 y el Decreto 1377 de 2013 ”<a href="https://drive.google.com/drive/folders/1LRkHh7ipeaRt0TMRnSn4MQHyD92PHFPG?usp=sharing" target="_blank">ver documento</a>” que contemplan  las disposiciones generales para la protección de datos personales incluidos en el presente convenio. Declaro haber leído y entendido el documento sobre el manejo de datos y autorizo a la entidad elegida (MaicaoGiftStore/Global&MarkSAS) por la empresa a la que formalmente laboro, para el tratamiento de datos, los cuales serán usados para el proceso de selección de juguetes y/o regalos corporativos por medio de esta plataforma virtual.</p>
				        	<h4>Por favor confirma que tus datos esten correctos</h4>
				        	{!! Form::open(['id' => 'form-empleado', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}
								@include('Empleado.partials.campos_Actualizar_Datos_Empleado')
				        	{!! Form::close() !!}
				    	</div>
				    </div>					
				</div>

				<div class="modal-footer">

					<button class="btn btn-primary" data-dismiss="modal" onclick="guardarEmpleado()">Confirmar</button>
					{{-- <a class="btn btn-default" data-dismiss="modal">Cerrar</a>	     --}}
				</div>						         
        </div>
    </div>
    
@endsection
