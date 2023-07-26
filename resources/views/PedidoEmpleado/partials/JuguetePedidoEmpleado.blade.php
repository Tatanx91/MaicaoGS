
@foreach ($convenio as $item)
  <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
      <div class="card text-center">
        <div class="card-body">
          <img id="ImagenJ" src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 200px;height: 200px;cursor: pointer;" class="img-thumbnail" onclick="CargaTodasLasImagenesPE('{{ $item->IdJuguete }}');">  
        </div>
        <div class="card-footer text-muted">
            <input style="width: 25px; height: 25px" type="radio" name="JugueteSelect" id=chk_{{$item->IdJugueteConvenio}}>

            <label style='width: 100%'>Obsequio: {{$item->Nombre}}</label>
            <label style='width: 100%'>Descripcion: {{$item->Descripcion}}</label>
        </div>
      </div>
  </div>
@endforeach

