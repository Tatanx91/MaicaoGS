<!DOCTYPE html>
<html lang="en">
|	<div id="Encabezado">
    	<P>Se identifico que el juguete eliminado del convenio con la empresa</P>
    	<p>ya se habia seleccionado para los siguientes hijos de los empleados:</p>
    </div>

    <div class="table-responsive">
    	<table class="table table-striped display responsive nowrap" cellspacing="0" id="Tablaempleado" width="100%">
    		<tr>
	    		<th>Empresa</th>
	    		<th>Empleado</th>
	    		<th>Numero Documento</th>
	    		<th>Hijo</th>
	    		<th>Juguete</th>
	    	</tr>
    	@foreach ($ListaEmpleados as $item)

    		<tr>
	    		<th>{{ $item->NombreEmpresa }}</th>
	    		<th>{{ $item->NombreEmpleado }}</th>
	    		<th>{{ $item->NumeroDocumento }}</th>
	    		<th>{{ $item->NombreHijo }}</th>
	    		<th>{{ $item->NombreJuguete }}</th>
	    	</tr>
    	
    	@endforeach

	</div>
</html>