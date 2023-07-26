@extends('Templates.secciones.app')
@section('content')
     <div class="default" style="margin-bottom: 10px !important;">
            <div class="page-header">
                <div>
                    <br/>
                    <h3 class="title_general">
                        Empresas


                            <button type="button" id="AGREGAR"  class="btn btn-primary derecha"  data-toggle="modal" data-placement="bottom" data-target="#popup" title="Agregar registro" >
                            <span class="fa fa-plus"></span>
                            </button>

                            <button type="button" id="MASIVOEMPRESA"  class="btn btn-primary derecha" style="margin-right:  2% !important;" data-toggle="modal" data-placement="bottom" data-target="#popup" title="Subir masivos" >
                                <span class="fa fa-upload"></span>
                            </button>
                            
                             <button onclick="ReenviarCorreos()" type="button" class="btn btn-primary derecha" style="margin-right:  2% !important;" title="Reenviar Correos" >Reenvio Correos</button>
                    </h3>       
                </div>
            </div>
        </div>

        <div id="mensaje"></div>
		{{ Form::hidden('id_modulo', 'empresa', array('id' => 'id_modulo')) }}
        <div class="table-responsive">
            <table class="table table-striped display responsive nowrap" cellspacing="0" id="TablaEmpresas" width="100%">
                <thead  class="thead-dark">
                    <tr class="text-center">                        
                        <th class="d-none">ID</th>        
                        <th class="d-none">IdUsuario</th>
                        <th class="d-none">TipoDoc</th>
                        <th class="d-none">Logo</th>
                        <th class="d-none">Estado</th>
                        <th>Nombre Empresa</th>
                        <th>Tipo Documento</th>
                        <th>Numero Documento</th>
                        <th>Nombre Contacto</th>
                        <th>Telefono Contacto</th>
                        <th>Direccion</th>
                        <th>Correo</th>
                        <th>Correo Comercial</th>
                        <th>Logo</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Convenios</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>

        {!! Html::script('js/Empresa/empresa.js') !!}
        <script type="text/javascript">
            var token = $("#_MTOKEN").val();
            $(document).ready(function(){
                cargarTablaEmpresa()
                // var TablaEmpresasRegistradas = $("#TablaEmpresasRegistradas").dataTable({destroy:true});
                // TablaEmpresasRegistradas.fnDestroy();
                // TablaEmpresasRegistradas.DataTable(); 
            });
        </script>
@endsection