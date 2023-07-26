<html>
<head>
    <title>Claro Colombia</title>
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/booststrap/css/bootstrap.css') }}">
    <script src="{{asset('css/booststrap/js/bootstrap.min.js')}}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
    
        body {
            background-image: url("Imagenes/BackgroundClaro/LandscapeClaro4.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        
        .row{
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        @media only screen and (max-width: 767px) {
            body {
                background-image: url("Imagenes/BackgroundClaro/MobileClaro_4.jpg");
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }
        }
            
    </style>
        
</head>
<body>
    <div class="row">
        <div class="col-lg-1 col-md-1"></div>
        <div class="col-lg-10 col-md-10">
            @include("Templates.secciones.inicio-claro")
        </div>
        <div class="col-lg-1 col-md-1"></div>
    </div>

</body>
</html>