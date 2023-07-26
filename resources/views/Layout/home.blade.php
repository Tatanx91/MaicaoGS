<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Maicao Gift Store</title>
        

        <link rel="stylesheet" type="text/css" href="{{asset('css/grid.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/camera.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/owl-carousel.css')}}">

        <script src="{{asset('js/jquery.js ')}}" ></script>
        <script src="{{asset('js/jquery-migrate-1.2.1.js')}}" ></script>

        <!-- Bootstrap core CSS -->
        {!! Html::style('/css/font-awesome.min.css') !!}
        <link rel="stylesheet" href="{{ asset('css/booststrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTable/dataTables.bootstrap4.min.css') }}">

        </style>

    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/general.js')}}"></script>
    <script src="{{asset('css/booststrap/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/datatable/dataTables.bootstrap4.min.js')}}"></script>


    <style type="text/css">
        textarea{
      resize: vertical !important;
    }

</head>
        
    </head>
    <body>
        @yield('content')
    </body>
    <footer>
    <h1>Derechos de autor Jonathan Ballen, Carlos Jimenez, Leonardo Gomez</h1>
    </footer>
</html>
