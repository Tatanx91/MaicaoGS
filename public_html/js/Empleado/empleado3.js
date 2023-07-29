var token = $("#_MTOKEN").val();
var Tipousuario = null;
function cargaValorTipoUsuario(tipoUsu){
	this.Tipousuario = tipoUsu;
}

function cargarTablaempleado(){
	var visible = "d-none";
	if(this.Tipousuario == 1)
		visible = '';		

	var url = $('#APP_URL').val() + "/empleado/datatableListEmpleado";//&_token=" + token;
	var Empleado = $("#Tablaempleado").dataTable({destroy:true});
	Empleado.fnDestroy();
	Empleado.DataTable({
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
			data:{empresa:$("#IdEmpresaG").val()}
		},
		"columns":[
			// {"data": "IdJuguete", "className": "text-center"},
			// {"data": "ID", "className": "text-center"},
			{"data": "Nombre", "className": "text-center"},
			{"data": "Apellido", "className": "text-center"},
			{"data": "NombreTipoDoc", "className": "text-center"},
			{"data": "NumeroDocumento", "className": "text-center"},
			{"data": "Correo", "className": "text-center"},
			{"data": "Direccion", "className": "text-center"},
			{"data": "Telefono", "className": "text-center"},
			{"data": "Ciudad", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false },
			{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false }

		],
		"createdRow":function(row, data, index){
			var estado = "activar";
			clase_estado = "fa-toggle-off";

			if(data.Estado == "1"){
				estado = "desactivar";
				clase_estado = "fa-toggle-on";
			}
            		$(row).attr('id','tr_'+index);
            		$("td", row).eq(8).html("<span style='cursor: pointer;' id=hijo class='fa fa-address-card fa-2x' onclick=cargaHijos('"+data.ID+"',event); title='Hijos del empleado'></span>")
            		if(visible === '')
            		{
						$("td", row).eq(9).html("<span style='cursor: pointer;' class='fa fa-edit fa-2x' data-id='"+data.ID+"' id='EDITAR' title='Editar empleado'></span>")
						$("td", row).eq(10).html("<span style='cursor: pointer;' id=estado_"+data.ID+" class='fa "+clase_estado+" fa-2x' onclick=activarDessactivarEmpleado('"+data.ID+"','"+data.Estado+"'); title='"+estado+" empleado'></span>")
						//$("td", row).eq(9).html("<span style='cursor: pointer;' id=Empleado class='fa fa-shopping-cart fa-2x' onclick=seleccionJugueteHijo('"+data.ID+"',event); title='Seleccione Juguete'></span>")
						$("td", row).eq(11).html("<a href='"+$("#APP_URL").val() +"/pedidoEmpleado/Index/"+data.ID+"'><span style='cursor: pointer;' class='fa fa-shopping-cart fa-2x' title='Seleccione Juguete'  ></span><a>")
						$("td", row).eq(12).html("<span style='cursor: pointer;' class='fa fa-close fa-2x' onclick=eliminarEmpleado('"+data.ID+"',event); title='Eliminar'  ></span><a>")
					}
					else{
						$("td", row).eq(9).html("")
						$("td", row).eq(10).html("")
						$("td", row).eq(11).html("")
						$("td", row).eq(12).html("")

					}
			
			
		},
		"aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"iDisplayLength": 10, "bLengthChange": true,
       
   });
}


function guardarEmpleado(){
	if(validaForm('empleado')){
		if($("#direccion").val() === ""){$("#direccion").val("Planta");}
		validaCampos('empleado')
		var url = $("#APP_URL").val() + "/empleado/postStore/";
		var idEmpresa = $("#IdEmpresaG").val() === undefined ? $("#IdEmpresaAct").val() : $("#IdEmpresaG").val();
		var params = $("#form-empleado").serialize();
		params += "&_token=" + token+"&IdEmpresa="+idEmpresa+"&FechaNacimiento="+$("#FechaNacimiento").val();
		$.post(url, params).done(function(data){
			cargarTablaempleado()
			if(data.error.includes('Duplicate')){
				let msgDuplicado = data.error.includes('Duplicate') ? "Error, el usuario ya se encuentra en la base de datos" : data.mensaje ;
				$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>' + msgDuplicado + '</b></center></div>')
               return false;
			}
			else{
				$('.close').click();
				$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			}
				
		}).fail(function(jqXHR){
			$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
		    
		});
	}else{
		$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Los campos subrayados en rojo son requeridos.</b></center></div>')
		return false;
	}
}

function activarDessactivarEmpleado(id,estado){
		var estado_update = 1;
		var texto = "¿Esta seguro de activar empleado?";

		if(estado == "1"){
			estado_update = 0; 
			texto = "¿Esta seguro de desactivar empleado?";
		}

	if(confirmacion(texto)){
		var url = $("#APP_URL").val() + "/empleado/cambiaEstado/";
		$.post(url,{estado : estado_update,Id : id,_token:token})
		.done(function(data){
			cargarTablaempleado()
			$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
				
		}).fail(function(jqXHR){
			$("#mensaje").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
		    
		});
	}else{
		return false;
	}

}

function cargaHijos(id,event){
		event.stopPropagation();
        IdEmpleado=id;
        $.post($("#APP_URL").val()+"/HijoEmpleado/Index",{ "_token" :  $("#_MTOKEN").val(), "IdEmpleado" : IdEmpleado },function(data){
        	//console.log(data)
	        $('#popup').empty().append($(data));
            $('#popup').modal('show');
        });
}

function eliminarEmpleado(id,event){
		event.stopPropagation();
		
		if(confirm('Desea eliminar el empleado?')){
		    var IdEmpresa = $("#IdEmpresaG").val();
            IdEmpleado=id;
            $.post($("#APP_URL").val()+"/empleado/eliminarEmpleado",{ "_token" :  $("#_MTOKEN").val(), "IdEmpleado" : IdEmpleado, "IdEmpresa" : IdEmpresa },function(data){
            	location.reload();
            	console.log(data);
    	        //$('#popup').empty().append($(data));
                //$('#popup').modal('show');
            });    
		}
		
}

// function seleccionJugueteHijo(id,event){
// 		// event.stopPropagation();
//         IdEmpleado=id;
//         $.post($("#APP_URL").val()+"/pedidoEmpleado/Index/"+IdEmpleado,{ "_token" :  $("#_MTOKEN").val(), "IdEmpleado" : IdEmpleado },function(data){

//         	alert ('hola');
//         	//console.log(data)
// 	        // $('#popup').empty().append($(data));
//             // $('#popup').modal('show');
//         });
// }


function VerNovedad()
{
	document.getElementById('DivAlerta').style.display= 'none';
	document.getElementById('DivNovedad').style.display= 'block';
	document.getElementById('BtnNovedad').style.display= 'block';
}

function GuardarNovedad(IDEmpleado)
{
	Empleado = IDEmpleado;

	if(document.getElementById('txtaNv').value.trim() === '')
	{		
		alert('Debe ingresar la novedad antes de guardarla.')
	}
	else
	{
		var url = $("#APP_URL").val() + "/empleado/GuardarNovedad";
		params = '_Novedad=' + document.getElementById('txtaNv').value.trim();
		params += '&_IDEmpleado=' + Empleado;
		params += "&_token=" + token;

		$.post(url, params).done(function(data){		
			$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Novedad registrada correctamente</b></center></div>')		
			document.getElementById('DivAlerta').style.display= 'block';
			document.getElementById('DivNovedad').style.display= 'none';
			document.getElementById('BtnNovedad').style.display= 'none';				
			document.getElementById('txtaNv').value = '';
		}).fail(function(jqXHR){
			$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar Novedad, contace al administrador. '+data.error+'</b></center></div>')
		});
	}
}

window.onload = function validacionActDatos()
{
	var IDEmpleado = $("#IDEmpleado").val();
	if(window.location.href.indexOf("IndexEmpleado") !== -1){

		var url = $("#APP_URL").val() + "/empleado/ConfirmarDatosEmpleado";
		params = '&_IDEmpleado=' + IDEmpleado;
		params += "&_token=" + token;

	$.post(url, params).done(function(data){
	    console.log("JonathanBC");
			//$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Novedad registrada correctamente</b></center></div>')
			if(data.ConfirmDatos === "0"){
					//document.getElementById('DivActualizar').style.display= 'block';
					$.get($("#APP_URL").val()+"/empleado/postFormempleadoAct",{datos: data.data},function(data){
					    $('#popup').empty().append($(data));
                        $('#popup').modal('show');
                        /*
						$('#myModal').empty().append($(data));
         				$('#myModal').modal('show');
         				*/

					});
					
			}
		})
		.fail(function(jqXHR){
			return false;
			//$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar Novedad, contace al administrador. '+data.error+'</b></center></div>')
		});

	}
	
}