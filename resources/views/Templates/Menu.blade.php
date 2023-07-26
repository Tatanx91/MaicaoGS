@extends('Templates.secciones.app')
@section('content')
    <div>
        <center>
            <img src="{{asset('Imagenes/Logo_web_Maicao.png')}}" style="width: 128px; height: 128px" />
        </center>
    </div>
    
{{-- style="background-image: url('{{asset('Imagenes/Logo_web_Maicao.png')}}');background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;opacity: 0.5" --}}
    <div class="container" >
        <div class="row"">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="vira-card">
                    <div class="vira-card-header">
                        <a href="/Usuarios" style="cursor:pointer;" role="button" aria-expanded="false" title="ususarios">
                            <div class="card-icon">
                                <span class="fa fa-user" aria-hidden="true"></span>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
            {{-- 
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="vira-card">
                    <div class="vira-card-header">
                        <a href="/Empleados" style="cursor:pointer;" role="button" aria-expanded="false" title="Empleados">
                            <div class="card-icon">
                                <span class="fa fa-users" aria-hidden="true"></span>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div> 
            --}}
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="vira-card">
                    <div class="vira-card-header">
                        <a href="/Empresa" style="cursor:pointer;" role="button" aria-expanded="false" title="Empresas">
                            <div class="card-icon">
                                <span class="fa fa-building" aria-hidden="true"></span>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="vira-card">
                    <div class="vira-card-header">
                        <a href="/Juguete" style="cursor:pointer;" role="button" aria-expanded="false" title="Juguetes">
                            <div class="card-icon">
                                <span class="fa fa-space-shuttle" aria-hidden="true"></span>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
        
@endsection