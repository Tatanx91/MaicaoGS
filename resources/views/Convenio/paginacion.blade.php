    @foreach ($img as $item)
      <div class="col-lg-4 col-md-4 col-sm-3 col-sm-2" style="margin-bottom: 5% !important;">
          <img src="{{url("/") .'/'. $item->Ruta.$item->Imagen}}" style="width: 200px;height: 200px;cursor: pointer;" class="img-thumbnail" onclick="CargaTodasLasImagenes('{{ $item->IdJuguete }}');" >  
            <input type="checkbox" onclick="HabilitaInputText(this.id)" id=chk_{{$item->IdJuguete}}>
            <label style='width: 100%'>Juguete: {{$item->Nombre}}</label>
            <label style='width: 100%'>Cantidad Maxima: {{$item->Cantidad}}</label>
            {!! Form::select('Genero',$Genero,"Seleccione..", array('ID' => 'SelectGenero_'.$item->IdJuguete,'class'=>'form-control', 'disabled' => 'disabled' )) !!} 
            <input placeholder="Edad Inicial"  type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txtEdadIni_{{$item->IdJuguete}}>
            <input placeholder="Edad Final"  type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txtEdadFin_{{$item->IdJuguete}}>
            <input placeholder="Cantidad" style="width: 100%" type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" readonly="true" class="form-control" id=txt_{{$item->IdJuguete}}>  
      </div>
    @endforeach