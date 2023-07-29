@extends('Templates.secciones.app')
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

<div class="container" style="z-index: 1050; position: fixed; margin-right:unset; display:none" id="myModal">
  <!-- Modal usando el atributo data-show="true" -->
  <div class="" role="dialog" data-show="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <img src="{{asset('Imagenes/FelicitacionesSeleccion_2.jpg')}}" style="width: 100%; height: 100%" />
        </div>
      </div>
    </div>
  </div>
</div>


   <!-- Modal -->
<div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
    <a class="btn btn-primary " tile="Volver" href="{!! url('Empleado/IndexEmpleado/'.$IdEmpleado) !!}" style="cursor: pointer;">
        <span  class="fa fa-arrow-left"></span>
    </a>  
</div>

<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12" >
    <br/>
            {{--{!! Form::label('Id', 'Selecciona tu Hijo o Hija:') !!}--}}
             {!! Form::select('hijoEmpleado',$hijoEmpleado,"Selecciona...", array('id' => 'hijoEmpleado','class'=>'form-control' )) !!} 
            {{-- {!! Form::select('hijoEmpleado', $datos_select, array(['id' => 'hijoEmpleado','class'=>'form-control']))   !!} --}}
</div>

@if($NombreHijo != '')
    <h1>Por favor selecciona el obsequio para {{ $NombreHijo }}</h1>
    <div id="Lista_PedidoJuguete" class="row">
        @include('PedidoEmpleado.partials.JuguetePedidoEmpleado')
    </div>
@endif

{!! Form::close() !!}
{!! Html::script('js/PedidoEmpleado/PedidoEmpleados.js') !!}

<div id="selectButton" width="100%" style="text-align: center;">
    <br/>
    <div style="position: fixed;
            top: 200px;
            right: 0;
            height: 500px;
            width: 200PX">
            <div>
                <button
                    id="BtnGuardar"
                    class="btn btn-dark btnSelec"
                    onclick="GuardarPedidoEmpleado({{ $IdHijo }})">
                    Guarda tu selección
                </button>
            </div>
            <div id="SeleccionResumen"> 
            </div>            
    </div>
        
</div>


<script type="text/javascript">
 
 $(document).ready(function() {

    var CantHijos = document.getElementById("hijoEmpleado").length;
    //document.getElementById("myModal").style.display = "none";

        if(CantHijos == 1)
        {
            $(function() {
                document.getElementById("myModal").style.display = "block";
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
    const miModal = new bootstrap.Modal(document.getElementById('mensajeModal'));

    // Mostrar la modal
    
    if(confirm("Estás seguro del juguete seleccionado para " + NombreHijo + "?" )){
    document.getElementById('BtnGuardar').style.display = 'none';
    GuardaPedidoEmpleado(convenio, $IdHijo, 0);
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
 