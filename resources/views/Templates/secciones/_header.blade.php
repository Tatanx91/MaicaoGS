<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">


    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>Maicao Gift Store</title>



    <!-- Bootstrap core CSS -->
    {!! Html::style('/css/font-awesome.min.css') !!}
    <link rel="stylesheet" href="{{ asset('css/booststrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">

<style type="text/css">
    textarea{
  resize: vertical !important;
}
</style>

    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/general.js')}}"></script>
    <script src="{{asset('css/booststrap/js/bootstrap.min.js')}}"></script>

    {{-- <script src="{{asset('http://code.jquery.com/jquery-latest.js')}}"></script> --}}
    <script src="{{asset('js/jquery.easyPaginate.js')}}"></script>

    <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('js/dropzone.js')}}"></script>

</head>