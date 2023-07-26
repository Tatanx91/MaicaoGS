@extends('Templates.secciones.app')
@section('content')

<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Detalle Convenio
            </h3>              
        </div>
    </div>
</div>        

<div id="mensaje"></div>
<div id="mensaje_error" style="width: 100%;"></div>

{!! Form::hidden('IdEmpresa', $IdEmpresa, array('id' => 'IdEmpresa'))!!}
{!! Form::hidden('IdConvenio', $IdConvenio, array('id' => 'IdConvenio'))!!}
{!! Form::hidden('FechaFin', $FechaFin, array('id' => 'FechaFin'))!!}

@if( $_SESSION['IdTipoUsuario'] == 1)

  {!! Form::label('FechaInicio', 'Fecha Inicio:') !!}
  <div class="form-group">
      <div class="input-group date" id="DivFechaIni" data-target-input="nearest">
          <input type="text" readonly="true" id="DtpFechaIni" class="form-control datetimepicker-input Datepicker" data-target="#DtpFechaIni" placeholder = 'Fecha Inicio Convenio' value="{{ $FechaInicio }}" />
          {{-- <div class="input-group-append" data-target="#DtpFechaIni" data-toggle="datetimepicker"> --}}
              {{-- <div class="input-group-text"><i class="fa fa-calendar"></i></div> --}}
          {{-- </div> --}}
      </div>
  </div>

  {!! Form::label('FechaFin', 'Fecha Fin:') !!}
  <div class="form-group">
      <div class="input-group date" id="DivFechaFin" data-target-input="nearest">
          <input type="text" id="DtpFechaFin" class="form-control datetimepicker-input Datepicker" data-target="#DtpFechaFin" placeholder = '{{ $FechaFin }}' value="{{ $FechaFin }}" />
          <div class="input-group-append" data-target="#DtpFechaFin" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
      </div>
  </div>
@endif


{!! Form::open(['id' => 'form-convenioDet', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}

<div id="contenedor_img" class="row">     
    @foreach ($img as $item)
    <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
        <div class="card text-center">
          <div class="card-body">
            <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 100%;height: 100%;" class="img-thumbnail" onclick="CargaTodasLasImagenes('{{ $item->IdJuguete }}');">  
          </div>
          <div class="card-footer text-muted">
          <label style='width: 100%'>Juguete: {{$item->Nombre}}</label>
          <label style='width: 100%'>Descripcion: {{$item->Descripcion}}</label>
          <div class="row" style="margin-top: 2px !important; margin-bottom:2px !important; margin-left:2px !important;">
            <label style="width: 30%">Genero: </label>
            {!! Form::select('Genero',$Genero,$item->IdGenero, array('id' => 'SelectGenero_'.$item->IdJuguete,'class'=>'form-control', 'disabled' => 'disabled', 'style'=>'width: 65%', 'onchange' => "GuardarTempInfo($item->IdJuguete, this.id)" )) !!} 
          </div>
          <div class="row" style="margin-top: 2px !important; margin-bottom:2px !important; margin-left:2px !important;">
            <label style="width: 30%">Edad Inicial: </label>
            <input placeholder="Edad Inicial" type="text" style='width: 65%' onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" value="{{$item->EdadInicial}}" disabled="disabled" readonly="true" class="form-control" id=txtEdadIni_{{$item->IdJuguete}}>
          </div>
          <div class="row" style="margin-top: 2px !important; margin-bottom:2px !important; margin-left:2px !important;">
            <label style="width: 30%">Edad Final: </label>
            <input placeholder="Edad Final" type="text" style='width: 65%' onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" value="{{$item->EdadFinal}}" disabled="disabled" readonly="true" class="form-control" id=txtEdadFin_{{$item->IdJuguete}}>
          </div>
          <div class="row" style="margin-top: 2px !important; margin-bottom:2px !important; margin-left:2px !important;">
            <label style="width: 30%">Cantidad: </label>
            <input placeholder="Cantidad" style="width: 65%" type="text" onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" value="{{$item->CantidadSolicitada}}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" disabled="disabled" readonly="true" class="form-control" id=txt_{{$item->IdJuguete}}>  
          </div>
          <div class="row" style="margin-top: 2px !important; margin-bottom:2px !important; margin-left:2px !important;">
            <label style="width: 30%">Saldo: </label>
            <input placeholder="Cantidad" style="width: 65%" type="text" value="{{$item->StockActual}}" disabled="disabled" readonly="true" class="form-control" id=StockActual_{{$item->IdJuguete}}>  
          </div>
          </div>
          @if( $_SESSION['IdTipoUsuario'] == 1)
            <div id="BotonesAccion">
              <input type="checkbox" hidden="true" readonly="true" id=chk_{{$item->IdJuguete}}>
              <label class="btn btn-primary" style="width: 25%" onclick="EditarDetalle({{$item->IdJuguete}},this.id), HabilitaInputText(this.id)" id="chk_{{$item->IdJuguete}}">Editar</label>
              <label class="btn btn-primary" style="width: 25%" onclick="EliminarJuguete({{$item->IdJugueteConvenio}})" >Eliminar</label>
            </div>
          @endif
        </div>
    </div>
    @endforeach
</div>

{!! Form::close() !!}
{!! Html::script('js/Convenio/convenio.js') !!}

<div>
  @if( $_SESSION['IdTipoUsuario'] == 1)
    <label class="btn btn-primary" style="width: 10%" onclick="GuardarEdicion()"  id="BtnGuardarEdicion">Guardar</label>
    {{-- <label class="btn btn-primary" style="width: 10%" onclick="DevolverStock()"  id="BtnDevolverStock">Act. Stock</label> --}}
    <a href={{url("/").'/convenio/DevolverStockConvenio/'.$IdConvenio}} class="btn btn-primary" style="width: 10%; margin-bottom: .5rem">Act. Stock</a>
  @endif
  <a href={{url("/").'/convenio/IndexListConvenio/'.$IdEmpresa}} class="btn btn-primary" style="width: 10%; margin-bottom: .5rem">Regresar</a>
</div>

<script type="text/javascript">

  function CargaTodasLasImagenes(idJuguete){
    event.stopPropagation();
    $.post($("#APP_URL").val()+"/Juguete/galeria",{ "_token" :  $("#_MTOKEN").val(), "idJuguete" : idJuguete },function(data){
         $('#popup').empty().append($(data));
         $('#popup').modal('show');
    });
}

$('#DtpFechaFin').datetimepicker({
    format: 'YYYY-MM-DD'
    //ignoreReadonly: true,
    //maxDate: 'now'
    //minDate: 'now'
});

 </script>
 @endsection