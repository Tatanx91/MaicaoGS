@extends('Templates.secciones.app')

@section('content')

     <div class="default" style="margin-bottom: 10px !important;">
            <div class="page-header">
                <div>
                    <h3 class="title_general">
                        Juguetes         

                  
                            <button type="button" id="AGREGAR"  class="btn btn-primary derecha"  data-toggle="modal" data-placement="bottom" data-target="#popup" title="Agregar registro" >
                                <span class="fa fa-plus"></span>
                            </button>

                           {{--  <a class="btn btn-primary derecha" id="btn-inicio-sesion" style="margin-top: 30px;margin-bottom: 10px !important;" method="post" href="{{ url("/juguete/postFormJuguete")  }}" title="Agregar registro">
                                <span class="fa fa-plus"></span>
                            </a> --}}
                    </h3>
                </div>
            </div>
        </div>

        <div id="mensaje"></div>
		{{ Form::hidden('id_modulo', 'juguete', array('id' => 'id_modulo')) }}
        <div class="table-responsive">
            <table class="table table-striped display responsive nowrap" cellspacing="0" id="TablaJuguete" width="100%">
                <thead  class="thead-dark">
                    <tr class="text-center">                        
                        <th class="d-none">ID</th>      
                        <th width="10%">Referencia</th>
                        <th width="10%">Nombre</th>
                        <th width="10%">Dimensiones</th>
                        <th width="10%">EdadInc</th>
                        <th width="10%">EdadFinal</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Descripción</th>
                        <th width="10%">Genero</th>                        
                        <th width="7%"></th>
                        <th width="7%"></th>
                        <th width="7%"></th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>

        {!! Html::script('js/Juguete/juguete2.js') !!}
        <script type="text/javascript">
            var token = $("#_MTOKEN").val();
            $(document).ready(function(){
                cargarTablaJuguete()
                // var TablaJuguete = $("#TablaJuguete").dataTable({destroy:true});
                // TablaJuguete.fnDestroy();
                // TablaJuguete.DataTable();
            });
        </script>
@endsection