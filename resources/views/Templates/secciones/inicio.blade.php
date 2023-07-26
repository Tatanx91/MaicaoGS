<?php
/*
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
*/
?>

<!DOCTYPE html>

<html>

    <head>

        <title>Maicao Gift Store</title>
        <script src="{{asset('css/booststrap/js/bootstrap.min.js')}}"></script>

        
        <div id="iniciohead" class="navbar navbar-inverse navbar-fixed-top" style="z-index:4; background-color:#295c93 !important; border-color: #295c93;margin-bottom: 5px !important">
        </div>
        

    </head>

    <body>
        <center>
        
            <div class="">
                <div class="mt-3">
                    <img src="{{asset('Imagenes/Background_Login.jpg')}}" style="width: 450px; height: 250px" />
                </div>
                <div class="mt-3">

                    {!! Form::open(['route' => 'login', 'method'=> 'POST']) !!}
                        {{--
                         <div class="form-group">
                            <i class="fa fa-at prefix" aria-hidden="true"></i>
                            {!!Form::text("Correo",null,["id"=>"Correo"])!!}
                            {!!Form::label("Correo","Correo electrónico")!!}
                        </div> --}}

                        <div class="form-group">
                            <i class="fa fa-at prefix" aria-hidden="true"></i>
                            {!!Form::text("Login",null,["id"=>"Login"])!!}
                            {!!Form::label("Login","Numero de documento")!!}
                        </div>



                        <div class="form-group">
                            <i class="fa fa-lock prefix" aria-hidden="true"></i>
                            {!!Form::password("Contrasena",["id"=>"Contrasena"])!!}
                            {!!Form::label("Contrasena","Contraseña")!!}
                        </div>

                        <div id="contenedor-boton-inicio">

                            <!--<a class="btn btn-info btn-md" id="btn-inicio-sesion" style="margin-top: 30px;" method="post" type="submit">Ingresar</a>-->
                            {!! Form::button('Iniciar Sesion', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                            {{--  'onclick' => 'return confirm("are you shure?")')) !!}--}}

                        </div>

                        <a href="{{url('/Contrasena/FormRecuperar')}}" class="col s12 blue-text text-darken-4 center" style="margin-top: 15px !important; font-size: small;">¿Olvidaste la contraseña?</a>
                        {!!Form::hidden(null,url("/"),["id"=>"base_url"])!!}
                    {!! Form::close() !!}
                </div>

            </div>
            
            <!--<div align="center">
                <label style="font-family: Swiss 721 important!">Algunos de nuestros convenios:</label>
            </div>
            <div>
                <img src="{{asset('Imagenes/Convenios_Empresas/BayerP.jpeg')}}" style="width: 128px; height: 128px" />
                <img src="{{asset('Imagenes/Convenios_Empresas/HolcimP.jpeg')}}" style="width: 128px; height: 128px" />
                <img src="{{asset('Imagenes/Convenios_Empresas/logo-claro-2019.jpeg')}}" style="width: 128px; height: 128px" />
                <img src="{{asset('Imagenes/Convenios_Empresas/fesenius-logo2.jpeg')}}" style="width: 128px; height: 128px" />
            </div>-->
            
            <div>


                    <p class="center" style="font-size: small;color: orange !important;"><a style="color: #0d47a1;" href="{{url("/")}}">Maicao Gift Store</a> recomienda su versión movil usando Google Chrome</p>
                    <p class="center" style="font-size: small;color: orange !important;">Copyright © {{date("Y")}} </p>
                
            </div>
        </center>

    </body>

</html>

