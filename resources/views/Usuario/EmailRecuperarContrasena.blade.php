<!DOCTYPE>
<html lang="es">
<div id="header">
    <style type="text/css" media="screen">
    .derecha{
       float: right;
   }
   
   .derecha{
       text-align: right;
   }
    </style>

    {!! Html::style('/css/font-awesome.min.css') !!}
    <link rel="stylesheet" href="{{ asset('css/booststrap/css/bootstrap.css') }}">

</div>

<body style="padding-top: 0px;">
    <div id="head" class="navbar navbar-inverse navbar-fixed-top" style="z-index:4; background-color:#F63521 !important; border-color: #295c93;margin-bottom: 5px !important;">      

        <nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand" style="color: #FFFFFF; font-family: sans-serif !important" href="{{ url('/') }}">Maicao Gift Store</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        </nav>
    </div>


    <div class="container">

        <div id="body">
            {{ Form::hidden('id_modulo', 'RecuperarContrasena', array('id' => 'id_modulo')) }}

    <div class="default" style="margin-bottom: 10px !important;">
        <div class="page-header">
            <div>
                <h3 class="title_general" align="center">
                    Recuperar contraseña
                </h3>
            </div>
        </div>
        {!! Form::open(['id' => 'formEnvioRec','route' => 'EmailRecuperar', 'method'=> 'POST']) !!}


        <div class="form-group" align="center">
            {!! Form::label('Correo', 'Correo Electronico', ['class'=> 'control-label col.md-2']) !!}
            {!! Form::text('Correo', null, ['class'=> '']) !!}
        </div>

        <div class="form-group" align="center">
            {!! Form::label('NumeroDocumento', ' Numero de Documento', ['class'=> 'control-label col.md-2']) !!}
            {!! Form::text('NumeroDocumento', null, ['class'=> '']) !!}
        </div>

        <div id="contenedor-boton-inicio" align="center">

            {!! Form::submit('Enviar Codigo',['onClick' => 'return ValidarCampos()'])  !!}

        </div>
        {!! Form::close() !!}

    </div>
        </div>
    </div>

<script type="text/javascript">
      
$(document).ready(function(){
   $('#popup').modal({
        backdrop: 'static',
        //keyboard: false  // to prevent closing with Esc button (if you want this too),
        show: false
    });
});

function ValidarCampos(){

    if($('input:text[name=Correo]').val() === "" || $('input:text[name=NumeroDocumento]').val() === ""){

        alert("Debe ingresar correo y numero de documento");

        return false;
    }

    return true;

    
}

</script>
</body>