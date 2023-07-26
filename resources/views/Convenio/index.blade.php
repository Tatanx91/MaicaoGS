@extends('Templates.secciones.app')
@section('content')

<style type="text/css">
  #easyPaginate {width:100%;}
  #easyPaginate img {display:block;margin-bottom:10px;}
  .easyPaginateNav a {padding:5px;}
  .easyPaginateNav a.current {font-weight:bold;text-decoration:underline;}
</style>


<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Convenio 
            </h3>              
        </div>
    </div>
</div>        

<div id="mensaje"></div>
<div id="mensaje_error" style="width: 100%;"></div>

{!! Form::hidden('IdEmpresa', $IdEmpresa, array('id' => 'IdEmpresa'))!!}
{!! Form::open(['id' => 'form-convenio', 'method' => 'POST', 'autocomplete' => 'off','route' => 'postStore']) !!}
{!! Form::label('FechaInicio', 'Fecha Inicio:') !!}
<div class="form-group">
    <div class="input-group date" id="DivFechaIni" data-target-input="nearest">
        <input type="text" readonly="true" id="DtpFechaIni" class="form-control datetimepicker-input Datepicker" data-target="#DtpFechaIni" placeholder = 'Fecha Inicio Convenio'/>
        <div class="input-group-append" data-target="#DtpFechaIni" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>

{!! Form::label('FechaFin', 'Fecha Fin:') !!}
<div class="form-group">
    <div class="input-group date" id="DivFechaFin" data-target-input="nearest">
        <input type="text" readonly="true" id="DtpFechaFin" class="form-control datetimepicker-input Datepicker" data-target="#DtpFechaFin" placeholder = 'Fecha Fin Convenio'/>
        <div class="input-group-append" data-target="#DtpFechaFin" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>

<div class="default" style="margin-bottom: 10px !important;width: 100%">
        <div class="page-header">
            <div>
                <br/>
                <h3 class="title_general">
                    Seleccion de Juguetes
                </h3>              
            </div>
        </div>
    </div>
{{-- 
<div id="easyPaginate" class="row"> --}}

{{-- <div class="row">
    @foreach ($paginacion['datos'] as $item)
      <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
          <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 200px;height: 200px;cursor: pointer;" class="img-thumbnail" onclick="CargaTodasLasImagenes('{{ $item->IdJuguete }}');" >  
            <input type="checkbox" onclick="HabilitaInputText(this.id)" id=chk_{{$item->IdJuguete}}>
            <label style='width: 100%'>Juguete: {{$item->Nombre}}</label>
            <label style='width: 100%'>Cantidad Maxima: {{$item->Cantidad}}</label>
            {!! Form::select('Genero',$Genero,"Seleccione..", array('ID' => 'SelectGenero_'.$item->IdJuguete,'class'=>'form-control', 'disabled' => 'disabled' )) !!} 
            <input placeholder="Edad Inicial"  type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txtEdadIni_{{$item->IdJuguete}}>
            <input placeholder="Edad Final"  type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txtEdadFin_{{$item->IdJuguete}}>
            <input placeholder="Cantidad" style="width: 100%" type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txt_{{$item->IdJuguete}}>  
      </div>
    @endforeach
</div>
    <div class="row">
            <div class="col-md-6">
                <small style="float: right;">total de Registros {{$paginacion['img_count']  }}</small>
            </div>
            <div class="col-md-6" style="float: right;" >
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-secondary {{ $estilo_atras }}" onclick="cargaPaginacion('{{ $paginacion['pagina_actual'] }}')">Atras</button>
                    @for ($i = $tamano_inicial; $i <= $tamanofor; $i++)
                        @if($paginacion['pagina_actual'] == $i)
                          <button type="button" class="btn btn-secondary active" onclick="cargaPaginacion('{{$i}}')">{{ $i }}</button>
                        @else
                          <button type="button" class="btn btn-secondary" onclick="cargaPaginacion('{{$i}}')">{{ $i }}</button>
                        @endif
                    @endfor
                      <button type="button" class="btn btn-secondary {{ $estilo_adelante }}" onclick="cargaPaginacion('{{ $paginacion['pagina_actual'] }}')">siguiente</button>
                </div>
            </div>
    </div> --}}
{{-- </div> --}}

<div>
    <label>Buscar Juguete</label>
    <input type="text" name="FiltroTxt" id="TextoBuscar">
    <input type="button" name="Filtro" value="Buscar" id="Filtro" onclick="FiltrarJuguetes()">
    <input type="button" name="Limpiar" value="Limpiar" id="Filtro" onclick="LimpiarFiltro()">
</div>

<div id="easyPaginate" class="row">
    @foreach ($img as $item)
        <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
              <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 200px;height: 200px;cursor: pointer;" class="img-thumbnail" onclick="CargaTodasLasImagenes('{{ $item->IdJuguete }}');" >  
                <input type="checkbox" onclick="HabilitaInputText(this.id), GuardarTempInfo({{$item->IdJuguete}}, this.id)" id=chk_{{$item->IdJuguete}}>
                <label style='width: 100%'>Juguete: {{$item->Nombre}}</label>
                <label style='width: 100%'>Referencia: {{$item->NumeroReferencia}}</label>
                <label style='width: 100%'>Cantidad Maxima: {{$item->Cantidad}}</label>
                {!! Form::select('Genero',$Genero,"Seleccione..", array('id' => 'SelectGenero_'.$item->IdJuguete,'class'=>'form-control', 'disabled' => 'disabled', 'onchange' => "GuardarTempInfo($item->IdJuguete, this.id)" )) !!} 
                <input placeholder="Edad Inicial" type="text" onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" readonly="true" class="form-control" id=txtEdadIni_{{$item->IdJuguete}}>
                <input placeholder="Edad Final" type="text" onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" readonly="true" class="form-control" id=txtEdadFin_{{$item->IdJuguete}}>
                <input placeholder="Cantidad" style="width: 100%" type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" onblur="GuardarTempInfo({{$item->IdJuguete}}, this.id)" readonly="true" class="form-control" id=txt_{{$item->IdJuguete}}>  
          </div>
    @endforeach
</div>

{!! Form::close() !!}
{!! Html::script('js/Convenio/convenio.js') !!}

<table width="100%" style="text-align: center;">
  <tr>
    <br/>
    <td style="text-align: center;" colspan="3"><button id="Guardar" class="btn btn-primary" onclick="ValidarConvenio()">Guardar</button></td>        
  </tr> 
</table>

<script type="text/javascript">
 $(function () {
                $('#DtpFechaIni').datetimepicker({
                    format: 'YYYY-MM-DD',
                    ignoreReadonly: true,            
                   //maxDate: 'now'
                });

                $('#DtpFechaFin').datetimepicker({
                    format: 'YYYY-MM-DD',
                    ignoreReadonly: true,            
                    //maxDate: 'now'
                });
            });

 function ValidarConvenio() 
 {
     var img = {!! json_encode($img) !!};
     ValidaConvenio(img);
 }

function CargaTodasLasImagenes(idJuguete){
    event.stopPropagation();
    $.post($("#APP_URL").val()+"/Juguete/galeria",{ "_token" :  $("#_MTOKEN").val(), "idJuguete" : idJuguete },function(data){
         $('#popup').empty().append($(data));
         $('#popup').modal('show');
    });
}

 </script>
 @endsection