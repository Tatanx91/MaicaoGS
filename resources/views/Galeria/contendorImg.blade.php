

@foreach ($img as $item)
<div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
    <div class="card text-center">
      <div class="card-header">
       <span style='cursor: pointer;float: right;' id=estado_"{{$item->Imagen}}" class='fa fa-cogs fa-2x ' onclick=activarDessactivarJugueteImg('{{$item->idJugueteImg}}','{{$item->estado}}'); title='desactivar imagen'></span>
      </div>
      <div class="card-body">
        <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 200px;height: 200px;" class="img-thumbnail">  
      </div>
      <div class="card-footer text-muted">
      <span style='cursor: pointer;float: right;' id=estado_"{{$item->Imagen}}" class='fa fa-toggle-on fa-2x ' onclick=activarDessactivarJugueteImg('{{$item->idJugueteImg}}','{{$item->estado}}'); title='desactivar imagen'></span>
      </div>
    </div>
</div>                 
@endforeach
