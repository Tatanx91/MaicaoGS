@extends('Templates.secciones.app')

@section('content')

     <div class="default" style="margin-bottom: 10px !important;">
            <div class="page-header">
                <div>
                    <h3 class="title_general">
                        Empleado       
                        @if( $_SESSION['IdTipoUsuario'] == 1)
                            <a class="btn btn-primary " tile="Volver" href="{!! url('Empresa'); !!}" style="cursor: pointer;">
                                <span  class="fa fa-arrow-left"></span>
                            </a>        
                  
                            <button type="button" id="AGREGAR"  class="btn btn-primary derecha"  data-toggle="modal" data-placement="bottom" data-target="#popup" title="Agregar registro" >
                                <span class="fa fa-plus"></span>
                            </button>

                            <button type="button" id="MASIVO"  class="btn btn-primary derecha" style="margin-right:  2% !important;" data-toggle="modal" data-placement="bottom" data-target="#popup" title="Subir masivos" >
                                <span class="fa fa-upload"></span>
                            </button>

                           {{--  <a class="btn btn-primary derecha" id="btn-inicio-sesion" style="margin-top: 30px;margin-bottom: 10px !important;" method="post" href="{{ url("/empleado/postFormempleado")  }}" title="Agregar registro">
                                <span class="fa fa-plus"></span>
                            </a> --}}
                        @endif
                    </h3>
                </div>
            </div>
        </div>
        {!! Form::hidden('IdEmpresaG', $IdEmpresa, array('id' => 'IdEmpresaG'))!!}
        <div id="mensaje"></div>
		{{ Form::hidden('id_modulo', 'empleado', array('id' => 'id_modulo')) }}
        <div class="table-responsive">
            <table class="table table-striped display responsive nowrap" cellspacing="0" id="Tablaempleado" width="100%">
                <thead  class="thead-dark">
                    <tr class="text-center">                        
                       {{--  <th>Id</th> --}}
                        {{-- <th width="10%">ID</th> --}}
                        <th width="10%">Nombre</th>
                        <th width="10%">Apellido</th>
                        <th width="10%">Tipo Documento</th>
                        <th width="10%">NumeroDocumento</th>
                        <th width="10%">Correo</th>
                        <th width="10%">Direccion</th>
                        <th width="10%">Telefono</th>
                        <th width="10%">Ciudad</th>
                        <th width="10%">Hijos</th>                   
                        <th width="7%">Editar</th>
                        <th width="7%">Estado</th>
                        <th width="5%">Seleccion Juguete</th>
                        <th width="5%">Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>

        {!! Html::script('js/Empleado/empleado3.js') !!}
        <script type="text/javascript">
            var token = $("#_MTOKEN").val();
            var TIpoUsuario = {{ $_SESSION['IdTipoUsuario'] }};

            $(document).ready(function(){
                cargaValorTipoUsuario(TIpoUsuario)
                cargarTablaempleado()
            });
        </script>
@endsection