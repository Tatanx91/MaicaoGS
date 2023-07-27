var token = $("#_MTOKEN").val();

function GuardaPedidoEmpleado(params, IdHijo, Empresa)
{
	var convenio = params;

	// $IdHijo = $('select[name="hijoEmpleado"]').val();
	$IdHijo = IdHijo
	$IdJugueteConvenio = 0;
	// $IdJugueteConvenio = 1;

	convenio.forEach(function(element) {
	        if ($("#chk_" + element['IdJugueteConvenio']).is(":checked") === true)
	        {

	        	$IdJugueteConvenio = element['IdJugueteConvenio'];
	        	// alert($IdJugueteConvenio);
	        	// alert($IdHijo);
	        }
	        
	    });

	if($IdJugueteConvenio > 0)
	{
		GuardarPedidoEmp(convenio, Empresa);
		
		// window.location.href=$("#APP_URL").val() + '/inicio/menu';
	}
	else
	{
		alert('Debe seleccionar un juguete');
	}	

}
function seleccion(rutaimg, nombrejuguete){

	const btn = document.getElementById("BtnGuardar");
	btn.classList.toggle("animateColor");

	var resumen = document.getElementById("SeleccionResumen");
	var nuevoDiv = document.createElement("div");
	nuevoDiv.setAttribute("class", "card text-center");

	var img = document.createElement("img");
	img.setAttribute("src", rutaimg);

	var nombre = document.createElement("p");
	nombre.textContent = nombrejuguete;

	nuevoDiv.appendChild(img);
	nuevoDiv.appendChild(nombre);
	resumen.replaceChildren(nuevoDiv);
	//resumen.replaceChild(nuevoDiv, resumen);
	
}

function GuardarPedidoEmp(params, empresa){
	var url = $("#APP_URL").val() + "/pedidoEmpleado/postStorePedidoEmpleado";
	var IdEmpleado = $("#IdEmpleado").val();
	var redirect = "/pedidoEmpleado/Index/";
	
	if(empresa !== 0){
	    redirect = '/pedidoEmpleado/IndexClaro/'
	}

	$.post(url, {_pedidoEmpleado:params, _token:token, _IdJugueteConvenio:$IdJugueteConvenio, _IdHijoEmpleado:$IdHijo}).done(function(data){
		
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
		$('#contenedor_img').css('display','block');
		alert('Seleccion guardada correctamente');
		window.location.href=$("#APP_URL").val() + redirect +IdEmpleado;

	}).fail(function(jqXHR){
		//$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
		alert('Seleccion guardada correctamente');
		window.location.href=$("#APP_URL").val() + redirect +IdEmpleado;
	});
}


$('#hijoEmpleado').change(function(e){
	IdHijo = $('#hijoEmpleado').val();
    // IdEmpleado = $('#IdEmpleado').val();
    // alert(e.target.value);
    // alert(IdHijo);
    // $(this).change();

    // $.get("/pedidoEmpleado/Index/CargarPedidoEmpleado/"+IdHijo+"",function(response,hijoEmpleado){	
    // 	alert('hola');
    // });

	window.location.href=$("#APP_URL").val() + '/pedidoEmpleado/Index/CargarPedidoEmpleado/'+IdHijo;
    
})

$('#hijoEmpleadoClaro').change(function(e){
	IdHijo = $('#hijoEmpleadoClaro').val();
    
	window.location.href=$("#APP_URL").val() + '/pedidoEmpleado/Index/CargarPedidoEmpleadoClaro/'+IdHijo;
    
})