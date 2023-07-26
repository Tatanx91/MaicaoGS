<!DOCTYPE html>
<html lang="es">

    <div id="CorreoNovedad">
    	<p class="text-info">Ha seleccionado correctamente el juguete {{ $data['NombreJuguete'] }} para su hijo(a) {{ $data['NombreHijo'] }}</p>
    	{{--
    	<div>
    	    <img src="{{ $message->embed($data['ImgJuguete'])}}" style="width: 30px; heigth:50px;>
	    </div>
	    --}}
    </div>

    <div style="text-align: center;">
    	<img src="{{ $message->embed('Imagenes/Imagen_Correo.png')}}" style="width: 800px;height: 420px;">
    </div>

</html>