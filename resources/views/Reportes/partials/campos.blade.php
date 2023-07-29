@php
        $col_excel = 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
        $col_pdf = 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
@endphp

<div class="row" style="margin-bottom: 25px;margin-top: 25px;">
    <div class="col-lg-4">
        {!! Form::label('TipoReporte', 'Tipo de Reporte:') !!}
        {!! Form::select('TipoReporte', ['1' => 'Juguetes Seleccionados', '2' => 'Juguetes No Seleccionados'], null, ['placeholder' => 'Seleccione el tipo de reporte...', 'id'=>'TipoReporte', 'class'=>'form-control']) !!}
    </div>
    <div class="col-lg-4">
        {!! Form::label('empresa_id', 'Empresa:') !!}
        {!! Form::select('empresa_id',$empresas ,"Seleccione..", array('id' => 'empresa_id','class'=>'form-control' )) !!}

    </div>
    <div class="col-lg-3">
        {!! Form::label('FechaInicio', 'Fecha Inicio:') !!}
        <div class="form-group">
            <div class="input-group date" id="DivFechaIni" data-target-input="nearest">
                <input type="text" readonly="true" id="FechaIni" class="form-control datetimepicker-input Datepicker" data-target="#FechaIni" placeholder = 'Fecha Inicio Convenio'/>
                <div class="input-group-append" data-target="#FechaIni" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="col-lg-3">
        {!! Form::label('FechaFin', 'Fecha Fin:') !!}
        <div class="form-group">
            <div class="input-group date" id="DivFechaFin" data-target-input="nearest">
                <input type="text" readonly="true" id="FechaFin" class="form-control datetimepicker-input Datepicker" data-target="#FechaFin" placeholder = 'Fecha Fin Convenio'/>
                <div class="input-group-append" data-target="#FechaFin" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2" style="margin-top: 3%;text-align: right;">
            <button class="btn btn-primary" id="buscar_reporte" onclick="BuscarReporte()" >Buscar <span class="fa fa-search"></span></button>
    </div>
</div>
<div class="col-lg-12 d-none" id="div_tabla_reporte">
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-lg-11"></div>
        <div class="col-lg-1"> 
            <a class="btn btn-success btn-lg" href="#" title='Generar Excel' onclick="descarga_reporte(event,'excel')" style="float:right;cursor: pointer;">
                <span  class="fa fa-file-excel-o"></span>
            </a> 
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="display responsive nowrap" cellspacing="0" id="t_reporte" width="100%">
            {{-- <table class="table table-striped" id="t_reporte_facturacion" width="100%"> --}}
                <thead>
                    <tr class="text-center">
                        {{-- <th>No</th> --}}
                        <th>Empresa</th>
                        <th>Nombre Empleado</th>
                        <th>Apellido Empleado</th>
                        <th>Documento Empleado</th>
                        <th>Nombre Hijo</th>
                        <th>Apellido Hijo</th>
                        <th>Fecha Nacimiento</th>
                        <th>Edad</th>
                        <th>Dirección Empleado</th>
                        <th>Telefono/Celular</th>
                        <th>Ciudad</th>
                        <th>Nombre Juguete</th>
                        <th>Fecha inicial</th>
                        <th>Fecha Fin</th>
                        <th>Fecha Seleccionado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<style type="text/css">
    @media(max-width: 576px){
        .dropdown-menu{
            top: 85% !important;
            left: 0% !important;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

            $('#FechaIni').datetimepicker({
                format: 'YYYY-MM-DD',
                ignoreReadonly: true,            
                // maxDate: 'now'
            });

            $('#FechaFin').datetimepicker({
                format: 'YYYY-MM-DD',
                ignoreReadonly: true,            
                // maxDate: 'now'
            });
        $("#FechaIni").on("change.datetimepicker", function (e) {
            $('#FechaFin').datetimepicker('minDate', e.date);
        });
        $("#FechaFin").on("change.datetimepicker", function (e) {
            $('#FechaIni').datetimepicker('maxDate', e.date);
        });
    });
    function BuscarReporte(){

        if($("#TipoReporte").val() != ''){
            if($("#empresa_id").val() != '0'){
                $("#div_tabla_reporte").removeClass('d-none');
                cargarTablaEmpresa();
                //var Empleado =$("#t_reporte").dataTable({destroy:true});
                //Empleado.fnDestroy();
                //Empleado.DataTable();
            }else{
                alert("por favor seleccione una empresa");
                $("#empresa_id").focus();
            }
        }
        else{
            alert("por favor seleccione un tipo de reporte");
        }
    }




function cargarTablaEmpresa(){
    var visible = "d-none";
    var url = $('#APP_URL').val() + "/Reportes/datatableList";//&_token=" + token;

    if($("#TipoReporte").val() == 1) {
        visible = '';

        var t_reporte = $("#t_reporte").dataTable({destroy:true});
        t_reporte.fnClearTable();
        t_reporte.empty();
        t_reporte.fnDestroy();

        t_reporte.DataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                "url":url,
                "type":"GET",
                "data":{
                    tipoReporte: $("#TipoReporte").val(),
                    empresa  : $("#empresa_id").val(),
                    FechaIni : $("#FechaIni").val(),
                    FechaFin : $("#FechaFin").val(),
                }
            },
            "columns":[
                // {"data": "IdConvenio", "className": "text-center"},
                {"data": "NombreEmpresa", "className": "text-center"},
                {"data": "NombreEmpleado", "className": "text-center"},
                {"data": "ApellidoEmpleado", "className": "text-center"},
                {"data": "NumeroDocumento", "className": "text-center"},
                {"data": "NombreHijo", "className": "text-center"},
                {"data": "ApellidoHijo", "className": "text-center"},
                {"data": "FechaNacimiento", "className": "text-center"},
                {"data": "Edad", "className": "text-center"},
                {"data": "Direccion", "className": "text-center"},
                {"data": "Telefono", "className": "text-center"},
                {"data": "Ciudad", "className": "text-center"},
                {"data": "NombreJuguete", "className": "text-center "+visible},            
                {"data": "FechaInicio", "className": "text-center "+visible},
                {"data": "FechaFin", "className": "text-center "+visible},
                {"data": "FechaSeleccion", "className": "text-center "+visible},
            ],
            "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            "iDisplayLength": 11, "bLengthChange": true,
        });
    }
    else
    {
        var t_reporte = $("#t_reporte").dataTable({destroy:true});
        t_reporte.fnClearTable();
        t_reporte.empty();
        t_reporte.fnDestroy();

        t_reporte.DataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                "url":url,
                "type":"GET",
                "data":{
                    tipoReporte: $("#TipoReporte").val(),
                    empresa  : $("#empresa_id").val(),
                    FechaIni : $("#FechaIni").val(),
                    FechaFin : $("#FechaFin").val(),
                }
            },
            "columns":[
                // {"data": "IdConvenio", "className": "text-center"},
                {"data": "NombreEmpresa", "className": "text-center"},
                {"data": "NombreEmpleado", "className": "text-center"},
                {"data": "ApellidoEmpleado", "className": "text-center"},
                {"data": "NumeroDocumento", "className": "text-center"},
                {"data": "NombreHijo", "className": "text-center"},
                {"data": "ApellidoHijo", "className": "text-center"},
                {"data": "FechaNacimiento", "className": "text-center"},
                {"data": "Edad", "className": "text-center"},
                {"data": "Direccion", "className": "text-center"},
                {"data": "Telefono", "className": "text-center"},
                {"data": "Ciudad", "className": "text-center"},
                {"data": "NombreJuguete", "className": "text-center "+visible},            
                // {"data": "FechaInicio", "className": "text-center "+visible},
                // {"data": "FechaFin", "className": "text-center "+visible},
                // {"data": "FechaSeleccion", "className": "text-center "+visible},
            ],
            "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            "iDisplayLength": 11, "bLengthChange": true,
        });

    }

    if($("#TipoReporte").val() == 1) //juguete
        $("#t_reporte thead tr th").removeClass('d-none');
}

function descarga_reporte(event,tipo_archivo) { 
        event.preventDefault();
        var params = '&empresa_id='+$('#empresa_id').val()+
        '&FechaIni='+$('#FechaIni').val()+
        '&FechaFin='+$('#FechaFin').val()+
        '&tipo_archivo='+tipo_archivo+
        "&_token="+$("#_MTOKEN").val()+
        "&tipoReporte="+$("#TipoReporte").val()+
        '&filtro_tabla='+$('#t_reporte.dataTables_filter label input').val();
        var url = $("#APP_URL").val()+"/Reportes/generaDescarga?"+params;
        $.get(url,function(data){
            if(data != '0'){
                
                window.open(url);
            } 
        });
    }




</script>