var token = $("#_MTOKEN").val();

function cargarTablaJuguete(){

	var url = $('#APP_URL').val() + "/juguete/datatableListJuguete";//&_token=" + token;
	var TablaJuguete = $("#TablaJuguete").dataTable({destroy:true});
	TablaJuguete.fnDestroy();
	TablaJuguete.DataTable({
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
		},
		"columns":[
			// {"data": "IdJuguete", "className": "text-center"},
			{"data": "NumeroReferencia", "className": "text-center"},
			{"data": "Nombre", "className": "text-center"},
			{"data": "Dimensiones", "className": "text-center"},
			{"data": "EdadInicial", "className": "text-center"},
			{"data": "EdadFinal", "className": "text-center"},
			{"data": "cantidad", "className": "text-center"},
			{"data": "descripcion", "className": "text-center"},
			{"data": "Nombre", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false }

		],
		"createdRow":function(row, data, index){
			var estado = "activar";
			clase_estado = "fa-toggle-off";

			if(data.estado == "1"){
				estado = "desactivar";
				clase_estado = "fa-toggle-on";
			}
            		$(row).attr('id','tr_'+index);
					$("td", row).eq(8).html("<span style='cursor: pointer;' class='fa fa-edit fa-2x' data-id='"+data.ID+"' id='EDITAR' title='Editar juguete'></span>");
					$("td", row).eq(9).html("<span style='cursor: pointer;' id=estado_"+data.ID+" class='fa "+clase_estado+" fa-2x' onclick=activarDessactivarJuguete('"+data.ID+"','"+data.estado+"'); title='"+estado+" juguete'></span>")
					$("td", row).eq(10).html("<a href='"+$("#APP_URL").val() +"/Galeria/getGaleriaImg?Id="+data.ID+"'><span style='cursor: pointer;' class='fa fa-camera fa-2x'title='Galeria de Imagenes'  ></span><a>")
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


function guardarJuguete(){

	validaCampos('juguete')
	var url = $("#APP_URL").val() + "/juguete/postStore/";
	var params = $("#form-juguete").serialize();
	params += "&_token=" + token;
	$.post(url, params).done(function(data){
		cargarTablaJuguete()
		$('.close').click();
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			
	}).fail(function(jqXHR){
		$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	    
	});
}
function activarDessactivarJuguete(id,estado){
	var estado_update = 1;

	if(estado == "1"){
		estado_update = 0; 
	}

	var url = $("#APP_URL").val() + "/juguete/cambiaEstado/";
	$.post(url,{estado : estado_update,ID : id,_token:token})
	.done(function(data){
		cargarTablaJuguete()
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			
	}).fail(function(jqXHR){
		$("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	    
	});

}
