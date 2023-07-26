@extends('Templates.secciones.app')
@section('content')

{!! Form::hidden('NombreEmpresa', $NombreEmpresa, array('id' => 'NombreEmpresa'))!!}

<div class="default" style="margin-bottom: 10px !important;">
    <div class="page-header">
        <div>
            <br/>
            <h3 class="title_general">
                Historico Convenios / Empresa : {{ $NombreEmpresa }}
            </h3>
            <br/>              
        </div>
    </div>
</div>

@if( $_SESSION['IdTipoUsuario'] == 1)
    <a class="btn btn-primary derecha" tile="Volver" href="{!! url('Empresa') !!}" style="cursor: pointer; margin-left: 1%">
        <span  class="fa fa-arrow-left"></span>
    </a> 
    <button type="button" onclick="crearConvenio()"  class="btn btn-primary derecha"  data-placement="bottom" title="Agregar registro" >
        <span class="fa fa-plus"></span>
    </button>
@endif

<div id="mensaje"></div>
<div id="mensaje_error" style="width: 100%;"></div>
{!! Form::hidden('IdEmpresa', $IdEmpresa, array('id' => 'IdEmpresa'))!!}
{{ Form::hidden('id_modulo', 'convenio', array('id' => 'id_modulo')) }}
        <div class="table-responsive">
            <table class="table table-striped display responsive nowrap" cellspacing="0" id="TablaConveniosXEmpresa" width="100%">
                <thead  class="thead-dark">
                    <tr class="text-center">                        
                        <th class="d-none">IDConvenio</th>        
                        <th>Fecha Inicio Vigencia</th>
                        <th>Fecha Fin Vigencia</th>
                        <th></th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>

{!! Html::script('js/Convenio/convenio.js') !!}

<script type="text/javascript">
    var token = $("#_MTOKEN").val();

    var TIpoUsuario = {{ $_SESSION['IdTipoUsuario'] }};

    $(document).ready(function(){
        cargaValorTipoUsuario(TIpoUsuario)
        CargarTablaConvenioXEmpresa()
    });
function crearConvenio(){

    IdEmpresa = $('#IdEmpresa').val();

    // var url = $('#APP_URL').val() + "/pedidoEmpleado/Index/" + IdEmpresa;//&_token=" + token;
    window.location.href=$("#APP_URL").val() + '/Convenios/'+IdEmpresa;

}

</script>

@endsection