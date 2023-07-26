<style type="text/css">
#DivAlerta{display: block}
#LogoEmpresa{
  width: 250;
  height: 250;
  float: left;
}

#DatosEmpresa{
  width: 250;
  height: 250;
  float: left;
}

#ListaEmpleado{
  width: 100%;
  height: 100%;
  float: left;
}

</style>

@extends('Templates.secciones.app')
@section('content')

<div id="mensaje" style="width: 100%;margin-bottom: 10px !important;"></div>
<div id="mensaje_error" style="width: 100%;margin-bottom: 10px !important;"></div>


{{ Form::hidden('id_modulo', 'empleado', array('id' => 'id_modulo')) }}
{!! Form::hidden('IdEmpresaG', $IdEmpresa, array('id' => 'IdEmpresaG'))!!}

<div id="mensaje"></div>
<div id="mensaje_error" style="width: 100%;"></div>

<div class="row" style="margin-bottom: 2% !important;">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-info" style="background-color:#F63521;">
        <h4>Datos de la Empresa</h4>
      </div>
      <div class="card-body">
        <div class="media">
          <img src="{{url("/") .'/'. $Logo}}" style="width: 200px;height: 200px;" class="mr-3">  
          <div id="DatosEmpresa">
              {{-- <div class="card-body"> --}}
                    @foreach ($Empresa as $item)
                    <label style='width: 100%'>Nombre Empresa: {{$item->NombreEmpresa}}</label>  
                    <label style='width: 100%'>Tipo Documento: {{$item->NombreTipoDoc}}</label>
                    <label style='width: 100%'>Numero Documento: {{$item->NumeroDocumento}}</label>
                    <label style='width: 100%'>Direccion: {{$item->Direccion}}</label>
                    <label style='width: 100%'>Nombre Contacto: {{$item->NombreContacto}}</label>
                    <label style='width: 100%'>Telefono Contacto: {{$item->TelefonoContacto}}</label>
                    @endforeach
              {{-- </div>         --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="Botones" align="right">
  <div style="margin-bottom: 2%">
    <a href="{{ url('/convenio/IndexListConvenio/'.$_SESSION['IdEmpresa']) }}" title="Convenios" style="color: #FFFFFF;" class="btn btn-primary">
      <label>Consultar Convenios</label>
    </a>

    <a href="{{ url('/Empleado/Index/'.$_SESSION['IdEmpresa']) }}" title="Convenios" style="color: #FFFFFF;" class="btn btn-primary">
      <label>Consultar Empleados</label>
    </a>
  </div>
</div>

{!! Html::script('js/Empleado/empleado.js') !!}

<script type="text/javascript">
 </script>
 @endsection