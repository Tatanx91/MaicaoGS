
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="{{ asset('css/estilos_modal.css') }}"
    </head>
<div id="header">
    @include('Templates.secciones._header')
    <style>
        .modal-dialog{
            z-index: 1100 !important;
            position: fixed !important;
            top: 0 !important;
        }
    </style>
    
    <style type="text/css" media="screen">
    .derecha{
       float: right;
   }
   
   .derecha{
       text-align: right;
   }

   #loader {
      position: fixed;
      display: none;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0,0,0,.5);
      z-index: 2;
      cursor: pointer;
      justify-content: center;
      align-items: center;
    }

    #loaderGif {
      
      border: 16px solid #f3f3f3;
      border-top: 16px solid #3498db;
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
      display: flex;
      margin-top: 50%;
      margin-left: 50%;    

    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>

</div>

<body style="padding-top: 0px;">
    <div id="head" class="navbar navbar-inverse navbar-fixed-top bg-primary" style="z-index:4; border-color: #295c93;margin-bottom: 5px !important;">
      <div id="loader">
        <div id="loaderGif"></div>
      </div>

        <nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand" style="color: #FFFFFF; font-family: sans-serif !important" href="{{ url('/inicio/menu') }}">Maicao Gift Store</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        @if( $_SESSION['IdTipoUsuario'] == 1)
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                    <a href="{{ url('Usuarios') }}" title="Usuarios" style="color: #FFFFFF;" class="nav-link fa fa-user">
                        <span aria-hidden="true" style="color:#FFFFFF; font-family: sans-serif !important" >Usuarios</span>
                    </a>
              </li>
              <li class="nav-item">
                    <a href="{{ url('Juguete') }}" title="Juguetes" style="color: #FFFFFF;" class="nav-link fa fa-space-shuttle">
                        <span aria-hidden="true" style="color:#FFFFFF; font-family: sans-serif !important">Juguetes</span>
                    </a>
              </li>
              <li class="nav-item">
                    <a href="{{ url('Empresa') }}" title="Empresa" style="color: #FFFFFF;" class="nav-link fa fa-building">
                        <span aria-hidden="true" style="color:#FFFFFF; font-family: sans-serif !important">Empresas</span>                
                    </a> 
              </li>

              <li class="nav-item">
                    <a href="{{ url('Reportes') }}" title="Empresa" style="color: #FFFFFF;" class="nav-link fa fa-list-alt">
                        <span aria-hidden="true" style="color:#FFFFFF; font-family: sans-serif !important">Reportes</span>
                    </a> 
              </li>

            </ul>
          </div>
        @endif
        </nav>       
        <a href="{{ url('/logout') }}" title="Cerrar Sesion" style="color: #FFFFFF;float: right;">
            Cerrar Sesion
        </a>   
    </div>


    <div class="container">

        <div id="body">        
            
            <input type="hidden" id="APP_URL" value="{{ url("/")  }}" />
            <input type="hidden" id="_MTOKEN" value="{{ csrf_token()  }}" />

            @yield('content')
            <div class="" id="popup" role="dialog">
                @section('content_modal')
                 <div class="modal-dialog">
                    <div class="modal-content" style="width:100vh">
                        <div class="modal-header bg-primary">
                        </div>
                        <div class="modal-body" style="overflow-y:scroll">
                            <div class="row center-block">
                            </div>                  
                        </div>
                        <div class="modal-footer"> 
                        </div>                               
                    </div>
                </div>
                @endsection
            </div>
           

        </div>    </div> <!-- /container -->
<script type="text/javascript">
      
$(document).ready(function(){
    $(function() {
      $('#myModal1').modal({
          show: true
      });
    });
    
   $('#popup').modal({
        backdrop: 'static',
        //keyboard: false  // to prevent closing with Esc button (if you want this too),
        show: false
    });
});

</script>
</body>
