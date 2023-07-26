@extends('Templates.secciones.app')

@section('content')

<div class="default">
    <div class="page-header">
        <div>
            <h3>
                REPORTES 
            </h3>
        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    
<div id="msj_error_reporte"></div>
{{ Form::hidden('id_modulo', 'Reportes', array('id' => 'id_modulo')) }}

<div>
    <div id="reportes">
        <div role="tabpanel">
            <ul class="nav nav-tabs  responsive-tabs">
                <li id="tab1" role="presentation" class="nav-item active">
                    <a class="nav-link active"  href="#tab_1" aria-controls="tab_1" role="tab" data-toggle="tab">Convenios</a>
                </li>   
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="panel-body  col-md-12">
                            <div id="msj_tab_1"></div>
                            <div class="panel panel-default">
                                <div class="panel-body col-md-12">
                                      @include('Reportes.partials.campos')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .center{
        float: none !important;
        margin:0 auto;
    }
</style>
@endsection
