var token = $("#_MTOKEN").val();

function cargaValorTipoUsuario(tipoUsu){
	this.Tipousuario = tipoUsu;
}

function ValidaConvenio(params)
{
	var CumpleValidaciones = true;
	var CountChk = 0;
	// var img = params;

	var IdConvenio = $('#IdConvenio').val();
	var img= tabla;

	console.log(IdConvenio);
	if(IdConvenio <= 0){
		$FechaIni = $("#DtpFechaIni").val();
		$FechaFin = $("#DtpFechaFin").val();

		if($FechaIni == "")
		{
			document.getElementById("DtpFechaIni").style.borderColor = "red";
			CumpleValidaciones = false;
		}
		else
			document.getElementById("DtpFechaIni").style.borderColor = "";

		if($FechaFin == "")
		{
			document.getElementById("DtpFechaFin").style.borderColor = "red";
			CumpleValidaciones = false;
		}		
		else
			document.getElementById("DtpFechaFin").style.borderColor = "";
	}
	

    if(CumpleValidaciones)
    {	
	    img.forEach(function(element) {
	        if ($("#chk_" + element['IdJuguete']).is(":checked") == true)
	        {
	        	CountChk = CountChk + 1;
	        	// GuardarTempInfo("chk_" + element['IdJuguete']);
	            
	            if($("#txt_" + element['IdJuguete']).val() > element['Cantidad'])
	            {       
	                document.getElementById("txt_" + element['IdJuguete']).style.borderColor = "red";
	                CumpleValidaciones = false;
	            }
	            else if($("#txt_" + element['IdJuguete']).val() == '')
	            {
	            	document.getElementById("txt_" + element['IdJuguete']).style.borderColor = "red";
	                CumpleValidaciones = false;
	            }
	            else
	            	document.getElementById("txt_" + element['IdJuguete']).style.borderColor = "";
	            
	            if(($("#txtEdadIni_" + element['IdJuguete']).val() == '')||($("#txtEdadFin_" + element['IdJuguete']).val() == ''))
	            {
	            	document.getElementById("txtEdadIni_" + element['IdJuguete']).style.borderColor = "red";
	            	document.getElementById("txtEdadFin_" + element['IdJuguete']).style.borderColor = "red";
	                CumpleValidaciones = false;
	            }
	            else if(parseFloat($("#txtEdadIni_" + element['IdJuguete']).val()) >= parseFloat($("#txtEdadFin_" + element['IdJuguete']).val()))
	            {
	            	document.getElementById("txtEdadIni_" + element['IdJuguete']).style.borderColor = "red";
	            	document.getElementById("txtEdadFin_" + element['IdJuguete']).style.borderColor = "red";
	                CumpleValidaciones = false;		
            	}
            	else
            	{
            		document.getElementById("txtEdadIni_" + element['IdJuguete']).style.borderColor = "";
	            	document.getElementById("txtEdadFin_" + element['IdJuguete']).style.borderColor = "";
            	}	
            	
            	if(document.getElementById('SelectGenero_' + element['IdJuguete']).selectedIndex == 0)
	            {
	            	document.getElementById('SelectGenero_' + element['IdJuguete']).style.borderColor = "red";
	                CumpleValidaciones = false;		
            	}
            	else
            		document.getElementById('SelectGenero_' + element['IdJuguete']).style.borderColor = "";
	            
	            if(CumpleValidaciones)
	            {
	                element['CantidadNew'] = $("#txt_" + element['IdJuguete']).val();
	                element['EdadInicial'] = $("#txtEdadIni_" + element['IdJuguete']).val();
	                element['EdadFinal'] = $("#txtEdadFin_" + element['IdJuguete']).val();
	                element['IDGenero'] = document.getElementById('SelectGenero_' + element['IdJuguete']).selectedIndex;
	            }
	        }
	    });
    }

    if(CumpleValidaciones && CountChk != 0)
 		GuardarConvenio(img);
 	else if (CountChk == 0)
		alert('Debe seleccionar al menos un producto para proceder con la creacion del convenio asi como seleccionar las fechas de inico & fin de convenio.')	
    else 
    	alert('Valide los campos sombreados en ROJO puede que excedan la cantidad permitida o se encuentren seleccionados sin ninguna cantidad.')
}

function GuardarConvenio(params){
	var url = $("#APP_URL").val() + "/convenio/postStore";
	var IdEmpresa = $('#IdEmpresa').val();

	$.post(url, {
		_img:params, 
		_token:token,
		_IdEmpresa:$("#IdEmpresa").val(),
		_DtpFechaIni:$("#DtpFechaIni").val(),
		_DtpFechaFin:$("#DtpFechaFin").val(),
		_IdConvenio:$("#IdConvenio").val(),
		}
	).done(function(data){
		if (data.Result == 1) 
		{
			$("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			$('#contenedor_img').css('display','block');
			// CargarGaleria();
			localStorage.clear();//Para borrar la memoria
			window.location.href=$("#APP_URL").val() + '/convenio/IndexListConvenio/' + IdEmpresa;
		}
		else
			$("#mensaje").html('<div class="alert alert-warning alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
	}).fail(function(jqXHR){
		$("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar</b></center></div>')
	});
}

function EditarDetalle(IdJuguete,nombreControl)
{
	var type = document.getElementById(nombreControl).type;
	$("#"+nombreControl).attr("checked", true);

	for(var i=0; i<tabla.length; i++){
 		if(tabla[i].IdJuguete === IdJuguete)
 		{
 			Cantidad = tabla[i].Cantidad;
			CantidadNew = tabla[i].CantidadNew;
			EdadFinal = tabla[i].EdadFinal;
			EdadInicial = tabla[i].EdadInicial;
			IDGenero = tabla[i].IDGenero;

 			tabla.splice(i,1);
 		}
 	}

	var Cantidad = 0;
	var CantidadNew = 0;
	var EdadFinal = 0;
	var EdadInicial = 0;
	var IDGenero = 0;


	IDGenero = $('#SelectGenero_'+IdJuguete).val();
	EdadInicial = $('#txtEdadIni_'+IdJuguete).val();
	EdadFinal = $('#txtEdadFin_'+IdJuguete).val();
	CantidadNew = $('#txt_'+IdJuguete).val();
	Cantidad = $('#txt_'+IdJuguete).val();

 	var Obj ={
		IdJuguete: IdJuguete,
		nombreControl:nombreControl,
		valor:true,
		tipo: type,

		Cantidad: Cantidad,
		CantidadNew: CantidadNew,
		EdadFinal: EdadFinal,
		EdadInicial: EdadInicial,
		IDGenero: IDGenero
 	};

 	tabla.push(Obj);

 	localStorage.setItem('Juguetes',JSON.stringify(tabla));

	
	// $("#BotonesAccion").hide();

}

function GuardarEdicion()
{

	var img = tabla;
	var FechaIni =  $("#DtpFechaIni").val();;
	var FechaFin =  $("#DtpFechaFin").val();;

	if(FechaFin == null || FechaFin == "")
	{
		FechaFin = $("#FechaFin").val();
	}
	
	var url = $("#APP_URL").val() + "/convenio/EditarConvenio";
	var IdConvenio = $('#IdConvenio').val();

	$.post(url, {_img:img, _token:token, _IdConvenio:$("#IdConvenio").val(), _FechaIni:FechaIni, _FechaFin:FechaFin}).done(function(data){

		if(data.success == false)
		{
			// $("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje_error+'</b></center></div>')
			alert(data.mensaje_error);
		}
		else
		{
			// $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			alert(data.mensaje);
		}

		window.location.href=$('#APP_URL').val() + "/convenio/CargarDtlleConvenio/"+IdConvenio;
		localStorage.clear();
	})
}

// function DevolverStock()
// {
// 	var IdConvenio = $('#IdConvenio').val();
// 	var url = $("#APP_URL").val() + "/convenio/DevolverStockConvenio";

// 	$.post(url, {_IdConvenio:$("#IdConvenio").val()}).done(function(data){
// 		alert('done');
// 	})

// }

function HabilitaInputText(nombreControl)
 {
    var TextCantidad = 'txt_' + nombreControl.substring(nombreControl.indexOf("_") + 1);
    var TextEdadInicial = 'txtEdadIni_' + nombreControl.substring(nombreControl.indexOf("_") + 1);
    var TextEdadFinal = 'txtEdadFin_' + nombreControl.substring(nombreControl.indexOf("_") + 1);
    var SelectGenero = 'SelectGenero_' + nombreControl.substring(nombreControl.indexOf("_") + 1);

    if($("#" + nombreControl).is(":checked") == true)
    {
        $("#" + TextCantidad).attr("readonly", false);
	    $("#" + TextEdadInicial).attr("readonly", false);
	    $("#" + TextEdadFinal).attr("readonly", false);
	    document.getElementById(TextCantidad).disabled=false;
	    document.getElementById(TextEdadInicial).disabled=false;
	    document.getElementById(TextEdadFinal).disabled=false;
	    document.getElementById(SelectGenero).disabled=false;
	}
    else
    {
    	$("#" + TextCantidad).attr("readonly", true);
	    $("#" + TextEdadInicial).attr("readonly", true);
	    $("#" + TextEdadFinal).attr("readonly", true);      
        $("#" + TextCantidad).val(""); 
        $("#" + TextEdadInicial).val(""); 
        $("#" + TextEdadFinal).val(""); 
        document.getElementById(SelectGenero).disabled=true;
        document.getElementById(SelectGenero).selectedIndex=0;
        document.getElementById(TextCantidad).style.borderColor = "";
        document.getElementById(TextEdadInicial).style.borderColor = "";
        document.getElementById(TextEdadFinal).style.borderColor = "";
    }
 }

 $(document).ready(function() {

 	obtenerTemp();
    
});

 function obtenerTemp(){

 	var local2 = JSON.parse(localStorage.getItem('Juguetes'));
 	//console.log(local2);

 	for (var item in local2){

 		var idJuguete = local2[item].IdJuguete;

 		if($("#chk_" + idJuguete).is(":visible") == true)
 		{
 			if(local2[item].valor == true){
 				$("#chk_" + idJuguete).attr("checked", true);
 				HabilitaInputText("chk_" + idJuguete);
 			}
 			else{
 				$("#chk_" + idJuguete).attr("checked", false);
 			}

 			if($("#chk_" + idJuguete).is(":checked") == true)
 			{
 				$('#SelectGenero_'+idJuguete).val(local2[item].IDGenero);
 				$('#txtEdadIni_'+idJuguete).val(local2[item].EdadInicial);
 				$('#txtEdadFin_'+idJuguete).val(local2[item].EdadFinal);
 				$('#txt_'+idJuguete).val(local2[item].Cantidad);
 			}
 		}
 	} 	

 	//localStorage.clear();//Para borrar la memoria

 }

var tabla = [];
tabla = JSON.parse(localStorage.getItem('Juguetes')) == null ? [] : JSON.parse(localStorage.getItem('Juguetes'));

 function GuardarTempInfo(idJuguete, nombreControl)
 {
 	var type = document.getElementById(nombreControl).type;
 	// var result = tabla.find(juguete =>juguete.nombreControl === nombreControl);

 	var Cantidad = 0;
	var CantidadNew = 0;
	var EdadFinal = 0;
	var EdadInicial = 0;
	var IDGenero = 0;

 	for(var i=0; i<tabla.length; i++){
 		if(tabla[i].IdJuguete === idJuguete)
 		{
 			Cantidad = tabla[i].Cantidad;
			CantidadNew = tabla[i].CantidadNew;
			EdadFinal = tabla[i].EdadFinal;
			EdadInicial = tabla[i].EdadInicial;
			IDGenero = tabla[i].IDGenero;

 			tabla.splice(i,1);
 		}
 	}

 	// alert(nombreControl);

 	if(type == "checkbox"){
 		if($("#"+nombreControl).is(":checked") == true){

 			var valor = true;
		 	var Control = nombreControl;

		 	var Obj ={
		 		IdJuguete: idJuguete,
		 		nombreControl:Control,
		 		valor:valor,
		 		tipo: type,

		 		Cantidad: 0,
				CantidadNew: 0,
				EdadFinal: 0,
				EdadInicial: 0,
				IDGenero: 0
 			};

 			tabla.push(Obj);

 		}
 		else{

 			var valor = false;
		 	var Control = nombreControl;

		 	var Obj ={
		 		IdJuguete: idJuguete,
		 		nombreControl:Control,
		 		valor:valor,
		 		tipo: type,

		 		Cantidad: 0,
				CantidadNew: 0,
				EdadFinal: 0,
				EdadInicial: 0,
				IDGenero: 0
 			};

 			tabla.push(Obj);

 		}

 	}
 	else{

 		var valor = $("#" + nombreControl).val();
	 	var Control = nombreControl;

		if(nombreControl == 'SelectGenero_'+idJuguete)
		{
			IDGenero = valor;
		}

		if(nombreControl == 'txtEdadIni_'+idJuguete)
		{
			EdadInicial = valor;
		}

		if(nombreControl == 'txtEdadFin_'+idJuguete)
		{
			EdadFinal = valor;
		}

		if(nombreControl == 'txt_'+idJuguete)
		{
			CantidadNew = valor;
			Cantidad = valor;
		}

	 	var Obj ={
	 		IdJuguete: idJuguete,
	 		nombreControl:Control,
	 		valor:true,
	 		tipo: type,

	 		Cantidad: Cantidad,
			CantidadNew: CantidadNew,
			EdadFinal: EdadFinal,
			EdadInicial: EdadInicial,
			IDGenero: IDGenero
	 	};

	 	tabla.push(Obj);

 	}
 	// console.log(tabla);
 	localStorage.setItem('Juguetes',JSON.stringify(tabla));

}

 function CargarTablaConvenioXEmpresa(){

	var visible = "d-none";
	if(this.Tipousuario == 1)
		visible = '';
	
    var IdEmpresa = $('#IdEmpresa').val();
	var url = $('#APP_URL').val() + "/convenio/datatableListConveniosXEmpresa/" + IdEmpresa;//&_token=" + token;
	var TablaConveniosXEmpresa = $("#TablaConveniosXEmpresa").dataTable({destroy:true});
	TablaConveniosXEmpresa.fnDestroy();
	TablaConveniosXEmpresa.DataTable({ 
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":url,
			"type":"GET",
		},
		"columns":[
			{"data": "ID", "className": "text-center d-none"},
			{"data": "FechaInicio", "className": "text-center"},
			{"data": "FechaFin", "className": "text-center"},
			{"data": null, "defaultContent": "", "className": "text-center ","orderable": false },
			{"data": "ID", "className": "text-center"},
			//{"data": null, "defaultContent": "", "className": "text-center "+ visible,"orderable": false },
		],
		"createdRow":function(row, data, index){
    		$(row).attr('ID','tr_'+index);
			// $("td", row).eq(3).html("<span style='cursor: pointer;' onclick='CargarDtlleConvenioXEmpresa("+data.ID+")' class='fa fa-list-ol fa-2x' data-id='"+data.ID+"' id='VerDtlle' title='Ver detalle'></span>");
			$("td", row).eq(3).html("<a href='"+$("#APP_URL").val() +"/convenio/CargarDtlleConvenio/"+data.ID+"'><span style='cursor: pointer;' class='fa fa-list-ol fa-2x' title='Ver Detalle'  ></span><a>")
			//if(visible == ''){
		    $("td", row).eq(4).html("<span style='cursor: pointer;' class='fa fa-close fa-2x' onclick=eliminarConvenio('"+data.ID+"',event); title='Eliminar'  ></span><a>")    
			//}
			
		},
		"aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"iDisplayLength": 10, "bLengthChange": true,
       
   });
}

function CargarDtlleConvenioXEmpresa(idConvenio){
	var url = $("#APP_URL").val() + "/convenio/CargarDtlleConvenio";
	$.post(url, {idConvenio:idConvenio, _token:token});
}

$('#easyPaginate').easyPaginate({
    paginateElement: 'div',
    elementsPerPage: 50,
    effect: 'climb'
});


$(".next").click(function(e){
	obtenerTemp();
 //  	newButton_Click($(this),e)
})

$(".prev").click(function(e){
	obtenerTemp();
 //  	newButton_Click($(this),e)
})

$(".first").click(function(e){
	obtenerTemp();
 //  	newButton_Click($(this),e)
})

$(".last").click(function(e){
	obtenerTemp();
 //  	newButton_Click($(this),e)
})

$(".page").click(function(e){
	obtenerTemp();
 //  	newButton_Click($(this),e)
})


function FiltrarJuguetes(){

	var IdEmpresa = $('#IdEmpresa').val();
	var Texto = $('#TextoBuscar').val()
	var IdConvenio = $('#IdConvenio').val();

	if(Texto == "")
		return false;

	$('#Filtro').click(function(){
		window.location.href=$('#APP_URL').val() + "/Convenios/"+IdEmpresa;	
	});

	window.location.href=$('#APP_URL').val() + "/Convenio/FiltroJuguetes/"+Texto+"/"+IdEmpresa+"/"+IdConvenio;

}

function LimpiarFiltro(){

	var IdEmpresa = $('#IdEmpresa').val();
	window.location.href=$("#APP_URL").val() + '/Convenios/' + IdEmpresa;
}

function EliminarJuguete(IdJugueteConvenio){

	// alert(IdJugueteConvenio);
	var IdConvenio = $('#IdConvenio').val();
	var url = $("#APP_URL").val() + "/convenio/EliminarJugueteConvenio";

	$.post(url, {_token:token, _IdJugueteConvenio:IdJugueteConvenio}).done(function(data){

		if(data.success == false)
		{
			// $("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje_error+'</b></center></div>')
			alert(data.mensaje_error);
		}
		else
		{
			// $("#mensaje").html('<div class="alert alert-success alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>'+data.mensaje+'</b></center></div>')		
			alert(data.mensaje);
		}

		window.location.href=$('#APP_URL').val() + "/convenio/CargarDtlleConvenio/"+IdConvenio;
		localStorage.clear();
	})

}

function eliminarConvenio(id,event){
		event.stopPropagation();
		
		if(confirm('¿Esta seguro de eliminar el convenio?')){
			document.getElementById("loader").style.display="block";
		    var IdEmpresa = $('#IdEmpresa').val();
            IdConvenio=id;
            $.post($("#APP_URL").val()+"/convenio/eliminarConvenio",{ "_token" :  $("#_MTOKEN").val(), "IdConvenio" : IdConvenio, "IdEmpresa" : IdEmpresa },function(data){
                console.log("Entro");
        	    location.reload();
        	    //console.log(data)
	            //$('#popup').empty().append($(data));
                //$('#popup').modal('show');
            })
            .done(function(){
        		document.getElementById("loader").style.display="none";
            })
            .fail(function(data){
                document.getElementById("loader").style.display="none";
                /*
			    $("#mensaje_error").html('<div class="alert alert-danger alert-dismissible div-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><center><b>Error al guardar Novedad, contace al administrador. '+data+'</b></center></div>')
			    */
            });
		}
		
}

// function CargarJuguetesConvenio(){
// 	var url = $('#APP_URL').val() + "/Convenio/CargarJuguetesConvenio";//&_token=" + token;
// 	var TablaJuguetes = $("#TablaJuguetes");//.dataTable({destroy:true});

// 	"ajax":{
// 			"url":url,
// 			"type":"GET",
// 		},

// }