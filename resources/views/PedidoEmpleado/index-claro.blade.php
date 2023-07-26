@extends('Templates.secciones.app-claro')
@section('content')

<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Haz tu pedido
            </h3>              
        </div>
    </div>
</div>

<div class="" style="z-index: 1050; position: fixed;" id="myModal" display="true">
  <!-- Modal usando el atributo data-show="true" -->
  <div class="" role="dialog" data-show="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            {{--<img src="{{asset('Imagenes/FelicitacionesSeleccionClaro.jpg')}}" style="width: 100%; height: 100%" />--}}
            <video width="100%" height="100%" autoplay>
                <source src="https://maicaogs.com/Imagenes/Felicitaciones_Seleccion_Claro.mp4" type="video/mp4">
            </video>
            
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <div id="mensaje"></div> --}}
<div id="mensaje_error" style="width: 100%;"></div>

{{-- {!! Form::hidden('IdEmpresa', $IdEmpresa, array('id' => 'IdEmpresa'))!!} --}}

{!! Form::open(['id' => 'form-pedidoempleado', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}

{!! Form::hidden('IdEmpleado', $IdEmpleado, array('id' => 'IdEmpleado'))!!}
{!! Form::hidden('IdHijo', $IdHijo, array('id' => 'IdHijo'))!!}


<div>
    <a class="btn btn-primary " tile="Volver" href="{!! url('Empleado/IndexEmpleadoClaro/'.$IdEmpleado) !!}" style="cursor: pointer;">
        <span  class="fa fa-arrow-left"></span>
    </a>  
</div>

<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12" >
    <br/>
            {{--{!! Form::label('Id', 'Selecciona tu Hijo o Hija:') !!}--}}
             {!! Form::select('hijoEmpleadoClaro',$hijoEmpleado,"Selecciona...", array('id' => 'hijoEmpleadoClaro','class'=>'form-control' )) !!} 
            {{-- {!! Form::select('hijoEmpleado', $datos_select, array(['id' => 'hijoEmpleado','class'=>'form-control']))   !!} --}}
</div>

@if($NombreHijo != '')
    <h1>Por favor selecciona el obsequio para {{ $NombreHijo }}</h1>
    <div id="Lista_PedidoJuguete" class="row">
        @include('PedidoEmpleado.partials.JuguetePedidoEmpleado')
    </div>
@endif

{!! Form::close() !!}
{!! Html::script('js/PedidoEmpleado/PedidoEmpleados2.js') !!}

<div id="selectButton" width="100%" style="text-align: center;">
    <br/>
    <button
        style="position: fixed;
            top: 200px;
            right: 0;"
        id="BtnGuardar"
        class="btn btn-dark"
        onclick="GuardarPedidoEmpleado({{ $IdHijo }})">Guardar</button>
</div>


<script type="text/javascript">
 
 $(document).ready(function() {
 
 console.log(document.getElementById("hijoEmpleadoClaro").length);

    var CantHijos = document.getElementById("hijoEmpleadoClaro").length;
    document.getElementById("myModal").style.display = "none";

        if(CantHijos == 1)
        {
            $(function() {
              $('#myModal').modal('show');
            });

        }
    
    }); 
    
function GuardarPedidoEmpleado($IdHijo) 
 {
     var convenio = {!! json_encode($convenio) !!};
     var NombreHijo = {!! json_encode($NombreHijo) !!};
     if($IdHijo == 0){
         alert("Debe seleccionar una opcion");
         return false;
     }
     if(confirm("Estás seguro del juguete seleccionado para " + NombreHijo + "?" )){
      document.getElementById('BtnGuardar').style.display = 'none';
      GuardaPedidoEmpleado(convenio, $IdHijo, 1);
     }
     
 }
 
 function CargaTodasLasImagenesPE(idJuguete){

    event.stopPropagation();
    $.post($("#APP_URL").val()+"/Juguete/galeria",{ "_token" :  $("#_MTOKEN").val(), "idJuguete" : idJuguete },function(data){
         $('#popup').empty().append($(data));
         $('#popup').modal('show');
    });
}
     
 </script>
 
 @endsection
 