<!DOCTYPE html>
<html lang="es">

    <div id="CorreoNovedad">
        <p class="text-info">Gracias por realizar la selección de tus obsequios por medio de nuestra plataforma virtual. Si tienes alguna novedad por favor comunicarse al área de recursos humanos de tu empresa o a nuestros contactos:</p>
        {{--
        
    	<p class="text-info">Ha seleccionado correctamente el juguete {{ $data['NombreJuguete'] }} para su hijo(a) {{ $data['NombreHijo'] }}</p>
    	<div>
    	    <img src="{{ $message->embed($data['ImgJuguete'])}}" style="width: 30px; heigth:50px;>
	    </div>
	    --}}
    </div>
    
    <div style="text-align: center;">
        <a 
            href="https://wa.me/+573146096721"
            target="_blank"
            data-saferedirecturl="https://www.google.com/url?q=https://wa.me/%2B573146096721&amp;source=gmail&amp;ust=1667256932840000&amp;usg=AOvVaw1uQDx3B5SOgiMNunUWYvLp">
        
            <img src="{{ $message->embed('Imagenes/WP_Contact.jpg')}}" style="width: 140px;height: 47px;">
        </a>
    </div>

    <div style="text-align: center;">
    	<img src="{{ $message->embed('Imagenes/logo_mail.jpg')}}">
    	<a href="mailto:community.maicao@gmail.com" target="_blank">community.maicao@gmail.com</a>
    </div>

</html>