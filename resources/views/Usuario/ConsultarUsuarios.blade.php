@extends('Templates.secciones.app')
@section('content')
	<div class="default" style="margin-bottom: 10px !important;">
        <div class="page-header">
            <div>
                <h3 class="title_general">
                    Usuarios Administradores

              
                        <button type="button" id="AGREGAR"  class="btn btn-primary derecha"  data-toggle="modal" data-placement="bottom" data-target="#popup" title="Agregar registro" >
                            <span class="fa fa-plus"></span>
                        </button>
                </h3>
            </div>
        </div>
    </div>

    <div id="mensaje"></div>
    {{ Form::hidden('id_modulo', 'usuario', array('id' => 'id_modulo')) }}

    <div class="table-responsive">
        <table class="table table-striped display responsive nowrap" cellspacing="0" id="TablaUsuariosRegistrados" width="100%">
            <thead  class="thead-dark">
                <tr class="text-center">                        
                    {{-- <th>Id</th> --}}
                    <th>Nombre Usuario</th>
                    <th>Numero documento</th>
                    <th>Correo</th>
                    {{-- <th>Tipo de Usuario</th> --}}
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    {!! Html::script('js/Usuario/usuario.js') !!}

    <script type="text/javascript">
        var token = $("#_MTOKEN").val();
        $(document).ready(function(){
            CargarTablaUsuarios();
        });
    </script>

		
@endsection