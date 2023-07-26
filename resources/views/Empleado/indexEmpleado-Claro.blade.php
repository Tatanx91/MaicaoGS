<style type="text/css">
#DivAlerta{display: block}
#DivNovedad{display: none}
#BtnNovedad{display: none}
#LogoEmpresa{
  width: 250;
  height: 250;
  float: left;
}
</style>

@extends('Templates.secciones.app-claro')
@section('content')

<div id="mensaje" style="width: 100%;margin-bottom: 10px !important;"></div>
<div id="mensaje_error" style="width: 100%;margin-bottom: 10px !important;"></div>
{{-- 
<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Informacion Empleado 
            </h3>              
        </div>
    </div>
</div>    --}}

<div id="mensaje"></div>
<div id="mensaje_error" style="width: 100%;"></div>
<div id="DivAlerta">
    <label> Si existe algun tipo de error en tu informacion, por favor registralo en una <span onclick="VerNovedad()" style="color:blue;font-style:oblique;cursor: pointer;">Novedad</span> para que sea corregido por nosotros. </label>
</div>
{{ Form::hidden('IdEmpresa', 'IdEmpresa', array('id' => 'IdEmpresa')) }}
{{ Form::hidden('IDEmpleado', $IDEmpleado , array('id' => 'IDEmpleado')) }}
<div class="row">
  <div class="col-md-12">
    {{-- <div id="LogoEmpresa">
      <img src="{{url("/") .'/'. $LogoEmpresa}}" style="width: 200px;height: 200px;" class="img-thumbnail">  
    </div> --}}
        {{-- <a href="{{ url('/empleado/validarConvenioVigente/'.$_SESSION['IdEmpleado']) }}" title="Convenios" style="color: #000000;float: center;" class="fa fa-shopping-cart fa-2x"> --}}
          {{-- <button id="BtnPedido" class="fa fa-shopping-cart fa-2x" onclick="validarConvenioVigente($IDEmpleado)"></button> --}}
      <button id="BtnPedidoEmpleado" style="float: right;" class="btn btn-secondary derecha" onclick="validarConv('{{ $IDEmpleado}}', '0')">Seleccionar Obsequio</button>
            {{-- <label>Selecciona juguetes</label> --}}
        {{-- </a> --}}
  </div>
</div>
<div class="row" style="margin-bottom: 2% !important;">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="background-color:#F63521;">
        <h4><font color="white">Tus datos</font></h4>
      </div>
        <div class="card-body">
          <div class="media">
            <div style="width: 70%">
                <img class="mr-3" src="{{url("/") .'/'. $LogoEmpresa}}" alt="Generic placeholder image" style="width: 95%">
            </div>
              <div class="media-body">
                @foreach ($Empleado as $item)
                <label style='width: 100%'><b>Empresa: </b>{{$item->NombreEmpresa}}</label>  
                <label style='width: 100%'><b>Nombres: </b>{{$item->Nombre}}</label>
                <label style='width: 100%'><b>Apellidos: </b>{{$item->Apellido}}</label>
                <label style='width: 100%'><b>Tipo Documento: </b>{{$item->NombreTipoDoc}}</label>
                <label style='width: 100%'><b>Numero Documento: </b>{{$item->NumeroDocumento}}</label>
                <label style='width: 100%'><b>Direccion: </b>{{$item->Direccion}}</label>
                <label style='width: 100%'><b>Telefono: </b>{{$item->Telefono}}</label>
               {{-- <label style='width: 100%'><b>FechaNacimiento: </b>{{$item->FechaNacimiento}}</label>--}}
                @endforeach
              </div>
            </div>    
        </div>        
    </div>
  </div>
</div>
{{-- 
<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Hijos Empleado 
            </h3>              
        </div>
    </div>
</div> --}}
<div class="row">
  <div class="col-md-12">
    <div id="contenedor_img" class="row">   
        <?php $conta = 1; ?>  
        @foreach ($Hijo as $item)
        <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
     
            <div class="card text-left">
                  <div class="card-header" style="background-color:#F63521;">
                   {{--<h4><font color="white">Hijo/a {{$conta}}</font></h4>--}}
                   <h4><font color="white">Selección {{$conta}}</font></h4>
                  </div>
              <div class="card-footer text-muted">
                <label style='width: 100%'><b>Obsequio: </b>{{$item->Obsequio}}</label>
                <label style='width: 100%'><b>Nombres: </b>{{$item->Nombre}}</label>
                <label style='width: 100%'><b>Apellidos: </b>{{$item->Apellido}}</label>
                {{-- <label style='width: 100%'><b>Genero: </b>{{$item->NombreGenero}}</label> --}}
                {{-- <label style='width: 100%'><b>Tipo Documento: </b>{{$item->NombreTipoDoc}}</label> --}}
                {{-- <label style='width: 100%'><b>Numero Documento: </b>{{$item->NumeroDocumento}}</label> --}}
                {{--<label style='width: 100%'><b>Fecha Nacimiento: </b>{{$item->FechaNacimiento}}</label>--}}
                <button id="BtnSelJugueteHijo" style="float: right;" class="btn btn-secondary derecha" onclick="validarConv('{{$IDEmpleado}}' , '{{$item->Id }}')">Seleccionar</button>
              </div>
            </div>
        </div>     
        <?php $conta++; ?>            
        @endforeach
    </div>
  </div>
</div>




<div id="DivNovedad">
    <table>
    <tr>
        <div class="page-header">
            <div>
                <h3 class="title_general">
                    Novedad 
                </h3>              
            </div>
        </div>
        <textarea maxlength="999" id="txtaNv" style="width: 100%">
        </textarea>
    </tr>
    </table>
</div>
{!! Html::script('js/Empleado/empleados8.js') !!}

<button id="BtnNovedad" class="btn btn-dark" onclick="Guardar_Novedad()">Guardar Novedad</button>        

<script type="text/javascript">

   function Guardar_Novedad() 
   {
       var IDEmpleado = {!! json_encode($IDEmpleado) !!};
       GuardarNovedad(IDEmpleado);
   }

   function validarConv(IDEmpleado, IdHijo)
   {

    var IDEmpleado = {!! json_encode($IDEmpleado) !!};
      $.get($("#APP_URL").val()+"/empleado/validarConvenioVigenteClaro/"+IDEmpleado+"/"+IdHijo).done(function(data){
          if(data.success){
            if(IdHijo !== "0"){
              window.location.href=$("#APP_URL").val() + '/pedidoEmpleado/Index/CargarPedidoEmpleadoClaro/'+IdHijo;
            }
            else{
              window.location = $("#APP_URL").val()+data.mensaje;
            }
               
          }else{
            $("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')    
          }

      });

    }
    /*
    $(function() {
      $('#myModal').modal({
          show: true
      });
    });
    */

 </script>
 @endsection