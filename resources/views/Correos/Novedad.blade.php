<!DOCTYPE html>
<html lang="es">
    <div id="CorreoNovedad">
    	<p class="text-info">Se ha generado una novedad para el empleado {{ $data['NombreUsuario'] }} asociado a la empresa {{ $data['NombreEmpresa'] }} con la siguiente informacion</p>
    </div>
    

    <div id="Novedad">
	    <p class="text-primary">{{ $data['Novedad'] }}</p>
    </div>

</html>