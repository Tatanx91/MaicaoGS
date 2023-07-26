var token = $("#_MTOKEN").val();
var Tipousuario = null;
function cargaValorTipoUsuario(tipoUsu){
	this.Tipousuario = tipoUsu;
}
function cargarTablaempleadoHijo(){
	var visible = "d-none";
	if(this.Tipousuario == 1)
		visible = '';
		
	var url = $('#APP_URL').val() + "/HijoEmpleado/datatableListEmpleadoHijo";
	var Empleado = $("#TablaempleadoHijo").dataTable({destroy:true});
	Empleado.fnDestroy();
	Empleado.DataTable({
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
			data:{IdEmpleadoP:$("#IdEmpleadoP").val(),_token: + token}
		},
		"columns":[
			// {"data": "IdJuguete", "className": "text-center"},
			// {"data": "ID", "className": "text-center"},
			{"data": "Nombre", "className": "text-center"},
			{"data": "Apellido", "className": "text-center"},
			// {"data": "NumeroDocumento", "className": "text-center"},
			{"data": "NombreGenero", "className": "text-center"},
			{"data": "FechaNacimiento", "className": "text-center"},
			{"data": "Obsequio", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center "+visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+visible,"orderable": false }

		],
		"createdRow":function(row, data, index){
			var estado = "activar";
			clase_estado = "fa-toggle-off";

			if(data.Estado == "1"){
				estado = "desactivar";
				clase_estado = "fa-toggle-on";
			}
            		$(row).attr('id','tr_'+index);
            		if(visible === '')
            		{
						$("td", row).eq(5).html("<span style='cursor: pointer;' class='fa fa fa-edit fa-2x' onclick=EditarrHijo('"+data.ID+"','"+data.IdEmpleado+"',event); title='Editar Hijos del empleado'></span>");
						$("td", row).eq(6).html("<span style='cursor: pointer;' id=estado_"+data.ID+" class='fa "+clase_estado+" fa-2x' onclick=activarDessactivarEmpleadoHijo('"+data.ID+"','"+data.Estado+"'); title='"+estado+" hijo empleado'></span>");
						$("td", row).eq(7).html("<span style='cursor: pointer;' class='fa fa-close fa-2x' onclick=eliminarHijo('"+data.ID+"','"+data.IdEmpleado+"',event); title='Eliminar hijo'></span>");
					}
					else
					{
						$("td", row).eq(5).html("");
						$("td", row).eq(6).html("");
						$("td", row).eq(7).html("");
					}
		},
		"aLengthMenu": false,//[[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"iDisplayLength": 5, "bLengthChange": false,
       
   });
}


function guardarHijoEmpleado(){
	if(validaForm('Hijoempleado')){
		validaCampos('Hijoempleado');
		var url = $("#APP_URL").val() + "/HijoEmpleado/postStore/";
		var params = $("#form-Hijoempleado").serialize();
		params += "&_token=" + token+"&FechaNacimiento="+$("#FechaNacimiento").val();
		$.post(url, params).done(function(data){
			cargarTablaempleadoHijo();
			VolverTabla();
			$("#mensaje_hijo").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>');
				
		}).fail(function(jqXHR){
			$("#mensaje_hijo").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>');
		    
		});
	}else{
		$("#mensaje_hijo").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Los campos subrayados en rojo son requeridos.</b></center></div>');
		return false;
	}
}

function activarDessactivarEmpleadoHijo(id,estado){
		var estado_update = 1;
		var texto = "Esta seguro de activar hijo del empleado, activara al empleado?";

		if(estado == "1"){
			estado_update = 0; 
			texto = "Esta seguro de desactivar hijo del empleado?";
		}

	if(confirmacion(texto)){
		var url = $("#APP_URL").val() + "/HijoEmpleado/cambiaEstado/";
		$.post(url,{estado : estado_update,Id : id,_token:token})
		.done(function(data){
			cargarTablaempleadoHijo();
			if(estado_update == 1){
				cargarTablaempleado();
			}
			VolverTabla();
			$("#mensaje_hijo").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>');
				
		}).fail(function(jqXHR){
			$("#mensaje_hijo").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>');
		    
		});
	}else{
		return false;
	}

}

function crearHijo(id){

	var url = $("#APP_URL").val() + "/HijoEmpleado/postForm/";
	$.post(url,{ "_token" :  $("#_MTOKEN").val(), "IdEmpleado" : id },function(data){
		$("#div_tablaHijo").addClass('d-none');	
		$("#agregarHijo").addClass('d-none');
		$("#div_crearHijo").html(data);
		$("#div_crearHijo").removeClass('d-none');
		$("#volverHijo").removeClass('d-none');	
		$("#mensaje_hijo").html("");
    });
}

function EditarrHijo(id,IdEmpleado,event){
	var url = $("#APP_URL").val() + "/HijoEmpleado/postForm/";
	$.post(url,{ "_token" :  $("#_MTOKEN").val(), "ID":id,"IdEmpleado" : IdEmpleado },function(data){
		$("#div_tablaHijo").addClass('d-none');	
		$("#agregarHijo").addClass('d-none');
		$("#div_crearHijo").html(data);
		$("#div_crearHijo").removeClass('d-none');
		$("#volverHijo").removeClass('d-none');	
		$("#mensaje_hijo").html("");
    });
}

function eliminarHijo(id,IdEmpleado,event){
	event.stopPropagation();
	
	if(confirm('Desea eliminar el hijo?')){
	    var IdEmpresa = $("#IdEmpresaG").val();
        IdHijo=id;
        $.post($("#APP_URL").val()+"/HijoEmpleado/eliminarHijo",{ "_token" :  $("#_MTOKEN").val(), "IdHijo" : IdHijo, "IdEmpleado": IdEmpleado, "IdEmpresa" : IdEmpresa })
        .done(function(data){
			cargarTablaempleadoHijo();
			VolverTabla();
			$("#mensaje_hijo").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>');
				
		}).fail(function(jqXHR){
			$("#mensaje_hijo").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>');
		    
		});
        /*
        function(data){
        	location.reload();
	        //$('#popup').empty().append($(data));
            //$('#popup').modal('show');
        });    
        */
	}
		
}


function VolverTabla(){
	$("#volverHijo").addClass('d-none');	
	$("#div_crearHijo").addClass('d-none');
	$("#agregarHijo").removeClass('d-none');
	$("#div_tablaHijo").removeClass('d-none');	
}


