var token = $("#_MTOKEN").val();

function CargarTablaUsuarios()
{
	var url = $('#APP_URL').val() + "/Usuario/datatableListUsuario";//&_token=" + token;
	var TablaUsuariosRegistrados = $("#TablaUsuariosRegistrados").dataTable({destroy:true});
	TablaUsuariosRegistrados.fnDestroy();
	TablaUsuariosRegistrados.DataTable({
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
		},
		"columns":[
			// {"data": "ID", "className": "text-center"},
			{"data": "NombreUsuario", "className": "text-center"},
			{"data": "NumeroDocumento", "className": "text-center hidden"},
			{"data": "Correo", "className": "text-center"},
			// {"data": "TipoUsuario", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			//{"data": null, "defaultContent": "", "className": "text-center ","orderable": false }

		],
		"createdRow":function(row, data, index){
			var estado = "activar";
			clase_estado = "fa-toggle-off";

			if(data.Estado == "1"){
				estado = "desactivar";
				clase_estado = "fa-toggle-on";
			}
// console.log(data.Estado)
            		$(row).attr('id','tr_'+index);
					$("td", row).eq(3).html("<span style='cursor: pointer;' class='fa fa-edit fa-2x' data-id='"+data.ID+"' id='EDITARUSUARIO' title='Editar Usuario'></span>");
					$("td", row).eq(4).html("<span style='cursor: pointer;' id=Estado_"+data.ID+" class='fa "+clase_estado+" fa-2x' onclick=activarDessactivarUsuario('"+data.ID+"','"+data.Estado+"'); title='"+estado+" usuario'></span></button>")
					//$("td", row).eq(7).html("<span style='cursor: pointer;' class='fa fa-camera fa-2x'></span>")
				//<button type='button' onclick=\"habilitar_deshabilitar_juguete('"+data.IdJuguete+"', 'deshabilitar')\" class='btn btn-primary' ></button>
				//<button type='button' data-id='"+data.IdJuguete+"' id='EDITAR' class='btn btn-primary' data-toggle='modal' data-placement='bottom' data-target='#popup' title='Editar registro'><span class='fa fa-edit'></span></button>
				//
				//<a class='btn btn-primary' title='Agregar Imagenes' href='"+data.IdJuguete+"'>
				//fa-toggle-on

			
		},
		"aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"iDisplayLength": 10, "bLengthChange": true,
       
   });

}

function guardarUsuario(){
	if(validaForm('usuario')){
		validaCampos('usuario')
		var url = $("#APP_URL").val() + "/usuario/postStore/";
		var params = $("#form-usuario").serialize();
		params += "&_token=" + token;
		//console.log(url)
		$.post(url, params).done(function(data){
			CargarTablaUsuarios()
			$('.close').click();
			$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
				
		}).fail(function(jqXHR){
			$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
		    
		});
	}else{
		$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Los campos subrayados en rojo son requeridos.</b></center></div>')
		return false;
	}
}

function activarDessactivarUsuario(id,Estado){
	var estado_update = 1;

	if(Estado == "1"){
		
		estado_update = 0;
	}

	var url = $("#APP_URL").val() + "/Usuario/CambiaEstadoUsuario/";
	$.post(url,{Estado : estado_update,IdUsuario : id,_token:token})
	.done(function(data){
		CargarTablaUsuarios()
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			
	}).fail(function(jqXHR){
		$("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	    
	});

}