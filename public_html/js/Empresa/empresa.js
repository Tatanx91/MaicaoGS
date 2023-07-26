var token = $("#_MTOKEN").val();
var Tipousuario = null;
function cargaValorTipoUsuario(tipoUsu){
	this.Tipousuario = tipoUsu;
}

function cargarTablaEmpresa(){
	var visible = "d-none";
	if(this.Tipousuario == 1)
		visible = '';
		
	var url = $('#APP_URL').val() + "/empresa/datatableListEmpresa";//&_token=" + token;

	var TablaEmpresas = $("#TablaEmpresas").dataTable({destroy:true});
	TablaEmpresas.fnDestroy();
	TablaEmpresas.DataTable({
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
		},
		"columns":[
			{"data": "ID", "className": "text-center d-none"},
			{"data": "IdUsuario", "className": "text-center d-none"},
			{"data": "IdTipoDocumento", "className": "text-center d-none"},
			{"data": "Logo", "className": "text-center d-none"},
			{"data": "Estado", "className": "text-center d-none"},
			{"data": "Nombre", "className": "text-center"},
			{"data": "NombreTipoDocumento", "className": "text-center"},
			{"data": "NumeroDocumento", "className": "text-center"},
			{"data": "NombreContacto", "className": "text-center"},
			{"data": "TelefonoContacto", "className": "text-center"},
			{"data": "Direccion", "className": "text-center"},
			{"data": "Correo", "className": "text-center"},
			{"data": "CorreoComercial", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false }

		],
		"createdRow":function(row, data, index){
			var Estado = "activar";
			clase_estado = "fa-toggle-off";

			if(data.Estado == "1"){
				Estado = "desactivar";
				clase_estado = "fa-toggle-on";
			}
			console.log(Estado);
    		$(row).attr('id','tr_'+index);
    		$("td", row).eq(13).html("<span style='cursor: pointer;' id=Img_"+data.ID+" class='fa fa fa-camera fa-2x' onclick=SubirlogoEmpresa('"+data.ID+"'); title='Subir logo de la empresa'></span></button>")
			$("td", row).eq(14).html("<span style='cursor: pointer;' class='fa fa-edit fa-2x' data-id='"+data.ID+"' id='EDITAR' title='Editar Empresa'></span>");
			if(visible === '')
				$("td", row).eq(15).html("<span style='cursor: pointer;' id=estado_"+data.ID+" class='fa "+clase_estado+" fa-2x' onclick=activarDessactivarEmpresa('"+data.ID+"','"+data.Estado+"'); title='"+Estado+" Empresa'></span></button>")
			else
				$("td", row).eq(15).html("");

			$("td", row).eq(16).html("<a href='"+$("#APP_URL").val() +"/Empleado/Index/"+data.ID+"'><span style='cursor: pointer;' class='fa fa-users fa-2x'title='Empleado'  ></span><a>")
			// $("td", row).eq(11).html("<a href='"+$("#APP_URL").val() +"/Convenios/"+data.ID+"'><span style='cursor: pointer;' class='fa fa-handshake-o fa-2x'title='Convenios'  ></span><a>")
			$("td", row).eq(17).html("<a href='"+$("#APP_URL").val() +"/convenio/IndexListConvenio/"+data.ID+"'><span style='cursor: pointer;' class='fa fa-handshake-o fa-2x'title='Convenios'  ></span><a>")
			//$("td", row).eq(10).html("<span style='cursor: pointer;' class='fa fa-users fa-2x' onclick=empleado('"+data.ID+"');></span>")
			$("td", row).eq(18).html("<span style='cursor: pointer;' class='fa fa-close fa-2x' onclick=eliminarEmpresa('"+data.ID+"',event); title='Eliminar'  ></span><a>")
		
		},
		"aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"iDisplayLength": 10, "bLengthChange": true,
       
   });
}


function guardarEmpresa(){

	validaCampos('empresa')
	var url = $("#APP_URL").val() + "/empresa/postStore/";
	var params = $("#form-empresa").serialize();
	params += "&_token=" + token;
	//console.log(url)
	$.post(url, params).done(function(data){
	    alert("GUARDADO, POR FAVOR REVISAR ANTES DE VOLVER A GUARDAR");
		cargarTablaEmpresa()
		$('.close').click();
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			
	}).fail(function(jqXHR, e){
	    console.log("JonathanBC2");
	    console.log(e);
	    console.log(jqXHR);
        $('.close').click();
        cargarTablaEmpresa()
		$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	});
}
function activarDessactivarEmpresa(id,Estado){
	var estado_update = 1;

	if(Estado == "1"){
		estado_update = 0; 
	}

	var url = $("#APP_URL").val() + "/empresa/cambiaEstado/";
	$.post(url,{Estado : estado_update,ID : id,_token:token})
	.done(function(data){
		cargarTablaEmpresa()
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			
	}).fail(function(jqXHR){
	    setTimeout(function(){
            $('.close').click();
        }, 2000);
		$("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	    
	});

}

function eliminarEmpresa(id,event){
		event.stopPropagation();
		if(confirm('¿Desea elimimnar la empresa?. esta acción eliminara tanto los empleados como los convenios. ')){
		    IdEmpresa=id;
            $.post($("#APP_URL").val()+"/empresa/eliminarEmpresa",{ "_token" :  $("#_MTOKEN").val(), "IdEmpresa" : IdEmpresa },function(data){
            	location.reload();
            	//console.log(data)
    	        //$('#popup').empty().append($(data));
                //$('#popup').modal('show');
            });
		}
        
}

function SubirlogoEmpresa(id){
	event.stopPropagation();
	var url = $("#APP_URL").val() + "/empresa/SubirlogoEmpresa/";
	$.post(url,{ "_token" :  $("#_MTOKEN").val(), "id" : id },function(data){
	     $('#popup').empty().append($(data));
	     $('#popup').modal('show');
	});
}

function ReenviarCorreos(){

	var url = $('#APP_URL').val() + "/pedidoEmpleado/ReenvioCorreos";//&_token=" + token;

	$.post(url,{_token:token}).done(function(data){
		
		$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')

	}).fail(function(jqXHR){
		alert('Error al reprocesar reenvio de correos, por favor intente mas tarde');
		console.log(jqXHR);
	});
}