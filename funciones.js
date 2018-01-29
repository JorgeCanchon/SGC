function validarCampoVacio(id_campo,nombre_campo){ 
 var campo_id=document.getElementById(id_campo).value;
 if (id_campo=="text") {
 	var campo_id=document.getElementById(id_campo).value.trim();
 }
 	if (campo_id==null || campo_id==' '|| campo_id=='' || campo_id==" " || campo_id=="" || campo_id.trim().length==0) {
 		alert("El campo "+ nombre_campo+" es obligatorio");
 		$(campo_id).focus();
 		return true;
 	}
}
function validarTodosCampos(id_formulario, texto){
	var $inputs = $('#'+id_formulario+' :input'); 
	var formvalido = true; 
	$inputs.each(function() { 		
		if(!isEmpty($(this).val())){
			$(this).css('border-color','red');			
			formvalido = false;
		}else{
			$(this).css('border-color',''); 
		}
	});
	if(!formvalido){
		alert(texto);
	}
	return formvalido; 
}
function addInputDateRevision(name,id,index){
	$('#'+id).remove();
	$('#div_'+id).append('<input type="date" name="'+name+'" id="'+id+'" class="form-control">');
	var slice2 = id.slice(0,-3);
	$('#'+slice2+'3_'+index).prop('disabled', false);
}
function isEmpty(val){
	if(jQuery.trim(val).length <= 0)
	return false;

	return true;
}
function validarC(){
	largopass = document.change.new.value.length;
	if (!validarCampoVacio('old','Old Password')) {
		if (largopass>5) {
			if (document.change.new.value == document.change.repeat.value) {
			  document.getElementById("error").innerHTML = "contraseñas coinciden";
			  return true;
			  }else{
			  document.getElementById("error").innerHTML = "contraseñas no coinciden";
			  return false;
			  }
		}else{
			document.getElementById("error").innerHTML = "El password debe ser al menos de 6 caracteres.";
			document.change.new.focus();
			return false;
		}
	}	
} 
function envio(){
	if(validarC()){
		var form=document.getElementById("change");
		form.submit();
	}
}
/**
 * [mensaje description]
 * @param  {[type]} location [description]
 * @param  {[type]} mensaje  [description]
 * @return {[type]}          [description]
 */
function mensaje(location,mensaje){
	alert(mensaje);
    window.location=location;
}
/**
 * [agregarAsistente description]
 * @param  {[type]} id  [description]
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function agregarAsistente(id,url) {
	if (id == 'agregarA') {
		var filas = $('div .fila');
		var numero_asistentes = filas.length;
		var id_objeto = numero_asistentes + 1;
		var ubicacion = url+"calidad/getAsistentesObjects";
		$('#loading').removeClass('hidden');
		$('#contenedor_botones').addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto}, function(data) {
			$('#contenedor_inputs').append(data);			
		});
		envio.done(function(){
			$('#loading').addClass('hidden');
			$('#contenedor_botones').removeClass('hidden'); 
		});	
	} else if(id == 'removerA') {
		var filas = $('div .fila');
		var ubicacion = url+"calidad/deleteAsistente";
		if (filas.length > 1) {
			var numero_asistentes = filas.length;
			var id_objeto = numero_asistentes;
			try {
			    var idA=document.getElementById('idAsistente['+id_objeto+']').value;
			}
			catch(err) {
			}
			if(idA!=null && idA!=undefined && isEmpty(idA))$.post(ubicacion,{ idA : idA}, function(data) {});
			$('#fila_'+id_objeto).remove();			
		};
	};
}
/**
 * [agregarPlanAccion description]
 * @param  {[type]} id  [description]
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function agregarPlanAccion(id,url) {
	if (id == 'agregarA') {
		var filas = $('#table_accion .fila_accion');
		var numero_accion = filas.length;
		var id_objeto = numero_accion + 1;
		var ubicacion = url+"calidad/getPlanAccionObjects";
		$('#loading').removeClass('hidden');
		$('#contenedor_botones').addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto}, function(data) {
			$('#table_accion').append(data);			
		});
		envio.done(function(){
			$('#loading').addClass('hidden');
			$('#contenedor_botones').removeClass('hidden'); 
		});	
	} else if(id == 'removerA') {
		var filas = $('#table_accion .fila_accion');
		var indexPlan=$('#indexPlan').val();
		if (filas.length > 1) { 
			var numero_accion = filas.length;
			var id_objeto = numero_accion;
			if (id_objeto==(indexPlan-1)) {
				$('#indexPlan').val(id_objeto);
				var id_plan=($('#idPlan_'+id_objeto).val());
				var ubicacion = url+"calidad/deletePlanAccion";
				var envio = $.post(ubicacion,{ id_plan : id_plan}, function(data) {	
				alert(data);		
				});
			}
			$('#fila_accion_'+id_objeto).remove();	
			$('#fila_accionContenido_'+id_objeto).remove();			
		};
	};
}
function agregarSeguimientoAccion(id,url) {
	if (id == 'agregarA') {
		var filas = $('#table_seguimiento .fila_seguimientoSubtitle');
		var numero_accion = filas.length;
		var id_objeto = numero_accion + 1;
		var ubicacion = url+"calidad/getSeguimientoAccionObjects";
		$('#loadingS').removeClass('hidden');
		$('#contenedor_botonesS').addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto}, function(data) {
			$('#table_seguimiento').append(data);			
		});
		envio.done(function(){
			$('#loadingS').addClass('hidden');
			$('#contenedor_botonesS').removeClass('hidden'); 
		});	
	} else if(id == 'removerA') {
		var filas = $('#table_seguimiento .fila_seguimientoSubtitle');
		var indexS=$('#indexSeguimiento').val();
		if (filas.length > 1) { 
			var numero_accion = filas.length;
			var id_objeto = numero_accion;
			if (id_objeto==(indexS-1)) {
				$('#indexSeguimiento').val(id_objeto);
				var id_seguimiento=($('#id_seguimiento_'+id_objeto).val());
				var ubicacion = url+"calidad/deleteSeguimientoAccion";
				var envio = $.post(ubicacion,{id_seguimiento:id_seguimiento}, function(data) {	
				alert(data);		
				});
			}
			$('#fila_seguimientoSubtitle_'+id_objeto).remove();	
			$('#fila_seguimientoC_'+id_objeto).remove();			
		};
	};
}
//buildMedicionIndicador
function agregarComportamiento(id,url,read,meta) {
	if (id == 'agregarC') {
		var filas = $('div .fila');
		var numero_comportamiento = filas.length;
		if(numero_comportamiento<10){
			var id_objeto = numero_comportamiento + 1;
			var ubicacion = url+"calidad/getComportamientoObjects";
			$('#loading').removeClass('hidden');
			$('#contenedor_botones').addClass('hidden');
			var envio = $.post(ubicacion,{ id_objeto : id_objeto,read:read,meta:meta}, function(data) {
				$('#tableComportamiento').append(data);			
			});
			envio.done(function(){
				$('#loading').addClass('hidden');
				$('#contenedor_botones').removeClass('hidden'); 
			});	
		}	
	} else if(id == 'removerC') {
		var filas = $('div .fila');
		if (filas.length > 1) {
			var numero_comportamiento = filas.length;
			var id_objeto = numero_comportamiento;
			$('#fila_'+id_objeto).remove();	
			$('#filaT_'+id_objeto).remove();
			$('#filaM_'+id_objeto).remove();	
			$('#filaTA_'+id_objeto).remove();	
			$('#filaS_'+id_objeto).remove();
			$('#filaBR_'+id_objeto).remove();		
		};
	};
}
//editMedicion
function agregarComportamientoNew(id,url,read,meta,index) {
	if (id == 'agregarC') {
		if($('#tableNew tr').length>1){

		}else{
		var filas = $('div .fila');
		var numero_comportamiento = filas.length;
		if(numero_comportamiento<10){
			var id_objeto = numero_comportamiento + 1;
			var ubicacion = url+"calidad/getComportamientoObjects";
			$('#loading').removeClass('hidden');
			$('#contenedor_botones').addClass('hidden');
			var envio = $.post(ubicacion,{ id_objeto : id_objeto,read:read,meta:meta}, function(data) {
				$('#tableNew').append(data);			
			});
			envio.done(function(){
				$('#loading').addClass('hidden');
				$('#contenedor_botones').removeClass('hidden'); 
			});	
		}

		}	
	} else if(id == 'removerC') {
		var filas = $('div .fila');
		var numero_comportamiento = filas.length;
		var id_objeto = numero_comportamiento;
		$('#fila_'+id_objeto).remove();	
		$('#filaT_'+id_objeto).remove();
		$('#filaM_'+id_objeto).remove();	
		$('#filaTA_'+id_objeto).remove();	
		$('#filaS_'+id_objeto).remove();
		$('#filaBR_'+id_objeto).remove();		
	};
}
/**
 * [sincronizarFechas Este metodo obtiene las fechas ssdel comportamiento
 * indicador y se las asigna a el analisis del indicador]
 * @param  {[type]} id  [description]
 * @param  {[type]} id1 [description]
 * @return {[type]}     [description]
 */
function sincronizarFechas(){
  	var filas = $('div .fila');
	for (var i = 1; i <= filas.length; i++) {
	    try{
	    	var periodo=document.getElementById('periodo1_'+i).value
	    	var periodo1=document.getElementById('periodo2_'+i).value
	    	document.getElementById('periodoA1_'+i).value=periodo;
	    	document.getElementById('periodoA2_'+i).value=periodo1;
	    }catch(err){}
	}     
}
/**
 * [agregarAccion description]
 * @param  {[type]} id  [description]
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function agregarAccion(id,url,id_proceso){
	var str = id;
	var id_proceso=id_proceso;
    var idA= str.substring(7,(id.length));
    var id_accion=$('#'+id).val();
    var ubicacion=url+'calidad/getAccionObjects';
    if(id_accion==1){
		$('#contenedorAccion_'+idA).empty();
		$('#btn-crear_'+parseInt(idA)).addClass('hidden');
    }else{
    	$('#btn-crear_'+parseInt(idA)).removeClass('hidden');
    	$('#contenedorAccion_'+idA).empty();
    	var envio = $.post(ubicacion,{id_objeto:idA,id_accion:id_accion,id_proceso:id_proceso}, function(data) {
			$('#contenedorAccion_'+idA).append(data);
		});	
    }	
}
function validarFecha(fecha1,fecha2){
	if(fecha2<fecha1){
		alert('La fecha '+ fecha1 + ' es menor a '+ fecha2 +', por favor rectifiqué');
		return false;
	}
	return true;
}
function bringPicture(event,index,index_id,url,idImg){
	event.preventDefault();
	$('#img'+index+'_'+index_id+'').html("");
	var ubicacion = url;
		var envio = $.post(ubicacion,{index:index,index_id:index_id,idImg:idImg}, function(data) {
			$('#img'+index+'_'+index_id+'').append(data);
		});	
	setTimeout('cargarScript()',500);
}
function envioObject(event,idC,url){
	var id = event.target.id;
	var str=idC;
	var idActa=document.getElementById('idActa').value;
	var index= parseInt(str.slice(9,11));
	var index_id;
	var valores=contador(id,index);
	var arrayCount=[];
		for (var i in valores) {
		    if (valores.hasOwnProperty(i)) {
		       arrayCount[i] = valores[i];
		    }
		}
		index_id=arrayCount[id];
	if (id=='Subtitulo') {
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectSubtitulo";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});	
	}
	else if (id=='Encabezado') {
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectEncabezado";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);			
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});	
	}
	else if (id=='Texto') {
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectTexto";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);			
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});	
	}
	else if (id=='Imagen') {
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectImg";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id,idActa:idActa}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
		setTimeout('cargarScript()',500);	
	}else if(id=='Texto-Imagen'){
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectTextoImg";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id,idActa:idActa}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
		setTimeout('cargarScript()',500);	
	}else if(id=='Imagen-Texto'){
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectImgTexto";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id,idActa:idActa}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
		setTimeout('cargarScript()',500);	
	}else if(id=='Table2'){
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectTableTwo";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
	}else if(id=='Table3'){
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectTableThree";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
	}else if(id=='Table4'){
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var numero_div = filas;
		var datan='';
		var id_objeto = numero_div + 1;
		var ubicacion = url+"calidad/getObjectTableFour";
		$('#loading_'+index).removeClass('hidden');
		$('#contenedor_botones_'+index).addClass('hidden');
		var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id}, function(data) {
			$('#contenedor_content_'+index).append(data);
		});
		envio.done(function(){
			$('#loading_'+index).addClass('hidden');
			$('#contenedor_botones_'+index).removeClass('hidden'); 
		});		
	}else if(id=='TableOtro'){
		var filasT=0;
		var columnas=0;
			columnas=parseInt(prompt('Ingrese numero columnas'));
			filasT=parseInt(prompt('Ingrese numero filas'));
			if (filasT<=0 || columnas<=0 || isNaN(filasT) || isNaN(columnas)) {
				alert('Numeros no validos');
			}else if(columnas<4 || columnas>7){
				alert('El numero de columnas debe ser mayor a 4 y menor o igual a 7');
			}else if(filasT>21){
				alert('El numero de filas debe ser menor a o igual a 20');
			}else{
				var filas = ($('#contenedor_content_'+index+' .fila_content').length);
				var numero_div = filas;
				var datan='';
				var id_objeto = numero_div + 1;
				var ubicacion = url+"calidad/getObjectTableOtro";
				$('#loading_'+index).removeClass('hidden');
				$('#contenedor_botones_'+index).addClass('hidden');
				var envio = $.post(ubicacion,{ id_objeto : id_objeto,index:index,index_id:index_id,fila:filasT,columna:columnas}, function(data) {
					$('#contenedor_content_'+index).append(data);
				});
				envio.done(function(){
					$('#loading_'+index).addClass('hidden');
					$('#contenedor_botones_'+index).removeClass('hidden'); 
				});	
			}
	}else if(id=='Grafico1'){
		var ubicacion = url+"calidad/getGraphic";
		var datos=0;
		var idG=1;
			datos=parseInt(prompt('Ingrese numero de series'));
			if (datos<=0 ||  isNaN(datos) ) {
				alert('Numeros no validos');
			}else if(datos>15){ 
				alert('El valor maximo es 15');
			}else{
				var filas = ($('#contenedor_content_'+index+' .fila_content').length);
				var numero_div = filas;
				var datan='';
				var id_objeto = numero_div + 1;
				var envio = $.post(ubicacion,{id:idG,id_objeto : id_objeto,index:index,index_id:index_id,datos:datos}, function(data) {
					$('#contenedor_content_'+index).append(data);
				});
				envio.done(function(){
					$('#loading_'+index).addClass('hidden');
					$('#contenedor_botones_'+index).removeClass('hidden'); 
				});	
			}
	}else if(id=='Grafico2'){
		var ubicacion = url+"calidad/getGraphic";
		var datos=0;
		var idG=2;
			datos=parseInt(prompt('Ingrese numero de series'));
			if (datos<=0 ||  isNaN(datos) ) {
				alert('Numeros no validos');
			}else if(datos>15){ 
				alert('El valor maximo es 15');
			}else{
				var filas = ($('#contenedor_content_'+index+' .fila_content').length);
				var numero_div = filas;
				var datan='';
				var id_objeto = numero_div + 1;
				var envio = $.post(ubicacion,{id:idG,id_objeto : id_objeto,index:index,index_id:index_id,datos:datos}, function(data) {
					$('#contenedor_content_'+index).append(data);
				});
				envio.done(function(){
					$('#loading_'+index).addClass('hidden');
					$('#contenedor_botones_'+index).removeClass('hidden'); 
				});	
			}
	}else if(id=='Grafico3'){
		var ubicacion = url+"calidad/getGraphic";
		var datos=0;
		var idG=3;
			datos=parseInt(prompt('Ingrese numero de series'));
			if (datos<=0 ||  isNaN(datos) ) {
				alert('Numeros no validos');
			}else if(datos>15){ 
				alert('El valor maximo es 15');
			}else{
				var filas = ($('#contenedor_content_'+index+' .fila_content').length);
				var numero_div = filas;
				var datan='';
				var id_objeto = numero_div + 1;
				var envio = $.post(ubicacion,{id:idG,id_objeto : id_objeto,index:index,index_id:index_id,datos:datos}, function(data) {
					$('#contenedor_content_'+index).append(data);
				});
				envio.done(function(){
					$('#loading_'+index).addClass('hidden');
					$('#contenedor_botones_'+index).removeClass('hidden'); 
				});	
			}
	}
	else if(id == ('removerA_'+index)) {
		var filas = ($('#contenedor_content_'+index+' .fila_content').length);
		var ubicacion = url;
		try {
			    var accion=document.getElementById('accion_'+index+'['+filas+']').value;
			    if (accion=='subtitulo') {
			    	var idSubtitulo=document.getElementById('idSubtitulo_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteSubtitulo";
			    	if(idSubtitulo!=null && idSubtitulo!=undefined && isEmpty(idSubtitulo))$.post(ubicacion,{ idSubtitulo : idSubtitulo}, function(data) {});	
			    }else if(accion=='encabezado'){
			    	var idEncabezado=document.getElementById('idEncabezado_'+filas+'['+index+']').value;
			    	ubicacion+="calidad/deleteEncabezado";
			    	if(idEncabezado!=null && idEncabezado!=undefined && isEmpty(idEncabezado))$.post(ubicacion,{ idEncabezado : idEncabezado}, function(data) {});
			    }else if(accion=='texto'){
			    	var idTexto=document.getElementById('idTexto_'+filas+'['+index+']').value;
			    	ubicacion+="calidad/deleteTexto";
			    	if(idTexto!=null && idTexto!=undefined && isEmpty(idTexto))$.post(ubicacion,{ idTexto : idTexto}, function(data) {});
			    }else if(accion=='imagen'){
			    	var idImg=document.getElementById('idImg_'+index+'['+filas+']').value;
			    	var nameImg=document.getElementById('nameImg_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteImg";
			    	if(idImg!=null && idImg!=undefined && isEmpty(idImg))$.post(ubicacion,{nameImg:nameImg,idActa:idActa,idImg:idImg,index:index}, function(data) {});
			    }else if(accion=='textoImagen'){
			    	var idTextoImg=document.getElementById('idTextoImg_'+index+'['+filas+']').value;
			    	var nameTextoImg=document.getElementById('nameTextoImg_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTextoImg";
			    	if(idTextoImg!=null && idTextoImg!=undefined && isEmpty(idTextoImg))$.post(ubicacion,{nameTextoImg:nameTextoImg,idActa:idActa,idTextoImg:idTextoImg,index:index}, function(data) {});
			    }
			    else if(accion=='imagenTexto'){
			    	var idImgTexto=document.getElementById('idImgTexto_'+index+'['+filas+']').value;
			    	var nameImgTexto=document.getElementById('nameImgTexto_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteImgTexto";
			    	if(idImgTexto!=null && idImgTexto!=undefined && isEmpty(idImgTexto))$.post(ubicacion,{nameImgTexto:nameImgTexto,idActa:idActa,idImgTexto:idImgTexto,index:index}, function(data) {});
			    }else if(accion=='tableTwo'){
			    	var idTableTwo=document.getElementById('idTableTwo_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableTwo";
			    	if(idTableTwo!=null && idTableTwo!=undefined && isEmpty(idTableTwo))$.post(ubicacion,{idTableTwo:idTableTwo}, function(data) {});
			    }else if(accion=='tableThree'){
			    	var idTableThree=document.getElementById('idTableThree_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableThree";
			    	if(idTableThree!=null && idTableThree!=undefined && isEmpty(idTableThree))$.post(ubicacion,{idTableThree:idTableThree}, function(data) {});
			    }else if(accion=='tableFour'){
			    	var idTableFour=document.getElementById('idTableFour_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableFour";
			    	if(idTableFour!=null && idTableFour!=undefined && isEmpty(idTableFour))$.post(ubicacion,{idTableFour:idTableFour}, function(data) {});
			    }else if(accion=='tableFive'){ 
					var idTableFive=document.getElementById('idTableFive_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableFive";
			    	if(idTableFive!=null && idTableFive!=undefined && isEmpty(idTableFive))$.post(ubicacion,{idTableFive:idTableFive}, function(data) {});
				}else if(accion=='tableSix'){ 
					var idTableSix=document.getElementById('idTableSix_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableSix";
			    	if(idTableSix!=null && idTableSix!=undefined && isEmpty(idTableSix))$.post(ubicacion,{idTableSix:idTableSix}, function(data) {});
				}else if(accion=='tableSeven'){ 
					var idTableSeven=document.getElementById('idTableSeven_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteTableSeven";
			    	if(idTableSeven!=null && idTableSeven!=undefined && isEmpty(idTableSeven))$.post(ubicacion,{idTableSeven:idTableSeven}, function(data) {});
				}else if(accion=='graphic'){ 
					var idGraphic=document.getElementById('idGraphicE_'+index+'['+filas+']').value;
			    	ubicacion+="calidad/deleteGraphic";
			    	if(idGraphic!=null && idGraphic!=undefined && isEmpty(idGraphic))$.post(ubicacion,{idGraphic:idGraphic}, function(data) {});
				}	
			}
		catch(err) {
			}
			$('#contenedor_content_'+index+' #content_'+filas).remove();
	}
}
function cargarScript(){
	$(document).on('change', '.btn-file :file', function() {
	  var input = $(this),
	      numFiles = input.get(0).files ? input.get(0).files.length : 1,
	      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	  input.trigger('fileselect', [numFiles, label]);
	});
	$(document).ready( function() {
	    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
	        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;	        
	        if( input.length ) {
	            input.val(log);
	        } else {
	            if( log ) alert(log);
	        } 
	    });
	});
}
function EnviarIn(){
	//alert(':D');
}
var cont=1;
var id_fila_selected;
var indexF;
//-----------------Metodos para crear tabla dinamica 2 columnas------//
function agregarTD(event,index,id_object){
	var id=cont++;
	event.preventDefault();
	var fila='<tr id="filaT'+id+'" onclick="seleccionar(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD_'+id_object+'['+index+']"></textarea></td></tr>';
	$('#tableTwo_'+index+'_'+id_object).append(fila);
	indexF=index;
	id_objectF=id_object;
	reordenar();
}
function seleccionar(id_fila){
	if ($('#'+id_fila).hasClass('seleccionada')) {
		$('#'+id_fila).removeClass('seleccionada');
	}else{
		$('#'+id_fila).addClass('seleccionada');
	}
	id_fila_selected=id_fila;
}
function eliminar(event){
	if (cont>1) {
		cont--;
	}
	event.preventDefault();
	$('#'+id_fila_selected).remove();
	reordenar();
}
function eliminarT(event,index,id_object,url,index_object){
	var ubicacion=url;
	event.preventDefault();
	try{
		 var accion=document.getElementById('accion_'+index+'['+id_object+']').value;
		 if(accion=='tableTwo'){
		 		var idCon=id_fila_selected.split("_");
		 		var idTableTwo=document.getElementById('idTableTwoE_'+index+'['+index_object+']').value;
				var idFilaTwo=document.getElementById('idFilaTwoE'+index_object+'_'+idCon[2]+'['+index+']').value;
	    		ubicacion+="calidad/deleteFilaTwo";
    			if(idTableTwo!=null && idTableTwo!=undefined && isEmpty(idTableTwo)&&idFilaTwo!=null && idFilaTwo!=undefined && isEmpty(idFilaTwo))$.post(ubicacion,{idTableTwo:idTableTwo,idFilaTwo:idFilaTwo}, function(data) {});
				$('#'+id_fila_selected).remove();
		}else if(accion=='tableThree'){
				var idCon=id_fila_selected3.split("_");
		 		var idTableThree=document.getElementById('idTableThreeE_'+index+'['+index_object+']').value;
				var idFilaThree=document.getElementById('idFilaThreeE'+index_object+'_'+idCon[2]+'['+index+']').value;
	    		ubicacion+="calidad/deleteFilaThree";
    			if(idTableThree!=null && idTableThree!=undefined && isEmpty(idTableThree)&&idFilaThree!=null && idFilaThree!=undefined && isEmpty(idFilaThree))$.post(ubicacion,{idTableThree:idTableThree,idFilaThree:idFilaThree}, function(data) {});
				$('#'+id_fila_selected3).remove();
				var ajuste=document.getElementById('filaThreeE_index_id'+index_object+'['+index+']').value;
				document.getElementById('filaThreeE_index_id'+index_object+'['+index+']').value=(parseInt(ajuste)-1);
		}else  if(accion=='tableFour'){
				var idCon=id_fila_selected4.split("_");
		 		var idTableFour=document.getElementById('idTableFourE_'+index+'['+index_object+']').value;
				var idFilaFour=document.getElementById('idFilaFourE'+index_object+'_'+idCon[2]+'['+index+']').value;
	    		ubicacion+="calidad/deleteFilaFour";
    			if(idTableFour!=null && idTableFour!=undefined && isEmpty(idTableFour)&&idFilaFour!=null && idFilaFour!=undefined && isEmpty(idFilaFour))$.post(ubicacion,{idTableFour:idTableFour,idFilaFour:idFilaFour}, function(data) {});
				$('#'+id_fila_selected4).remove();
		}
	}catch(err){
		if(id_fila_selected !=undefined && id_fila_selected!=null)$('#'+id_fila_selected).remove();
		if(id_fila_selected3 !=undefined && id_fila_selected3!=null)$('#'+id_fila_selected3).remove();
		if(id_fila_selected4 !=undefined && id_fila_selected4!=null)$('#'+id_fila_selected4).remove();
	}
}
var contT=0;
var idCon=0;
var inicial=1;
function agregarTDT(event,index,id_object,index_object){
	event.preventDefault();
	var filas = $('div table .filaTwoE');
	var id=filas.length+1;
	var idAgregar=(index+'_'+id_object);
	if(contT==idAgregar){
		inicial=(inicial+1);
		document.getElementById('con_'+index_object+'['+index+']').value=inicial;
	}else{
		idCon=parseInt(document.getElementById('con_'+index_object+'['+index+']').value);
        contT=event.target.id;
        inicial=(idCon+1);
        document.getElementById('con_'+index_object+'['+index+']').value=inicial;
	}
	var fila='<tr class="filaTwoE" id="filaTE_'+index_object+'_'+id+'_'+index+'" onclick="seleccionar(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITDN_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTDN_'+index_object+'_'+inicial+'['+index+']"></textarea></td></tr>';
	$('#tableTwoE_'+index+'_'+id_object).append(fila);
	indexF=index;
	id_objectF=id_object;
	document.getElementById('posTableTwoE_'+id_object+'['+index+']').value=id;
	//reordenar();
}
//-----------
var contT3=0;
var idCon3=0;
var inicial3=1;
function agregarTDT3(event,index,id_object,index_object){
	event.preventDefault();
	var filas = $('div table .filaThreeE');
	var id=filas.length+1;
	var idAgregar=(index+'_'+id_object);
    if(contT3==idAgregar){
        inicial3=(inicial3+1);
        document.getElementById('con3_'+index_object+'['+index+']').value=inicial;
    }else{
        idCon=parseInt(document.getElementById('con3_'+index_object+'['+index+']').value);
        contT3=event.target.id;
        inicial=(idCon+1);
        document.getElementById('con3_'+index_object+'['+index+']').value=inicial;
    }
	var fila='<tr class="filaThreeE" id="filaTE3_'+id+'" onclick="seleccionar3(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD3N_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCTD3N_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD3N_'+index_object+'_'+inicial+'['+index+']"></textarea></td></tr>';
	$('#tableThreeE_'+index+'_'+id_object).append(fila);
	indexF3=index;
	id_objectF3=id_object;
	//reordenar3();
}
var contT4=0;
var idCon4=0;
var inicial4=1;
function agregarTDT4(event,index,id_object,index_object){
	event.preventDefault();
	var filas = $('div table .filaFourE');
	var id=filas.length+1;
	var idAgregar=(index+'_'+id_object);
    if(contT4==idAgregar){
        inicial4=(inicial4+1);
        document.getElementById('con4_'+index_object+'['+index+']').value=inicial;
    }else{
        idCon=parseInt(document.getElementById('con4_'+index_object+'['+index+']').value);
        contT4=event.target.id;
        inicial=(idCon+1);
        document.getElementById('con4_'+index_object+'['+index+']').value=inicial;
    }
	var fila='<tr class="filaFourE" id="filaTE4_'+id+'" onclick="seleccionar4(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD4N_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCITD4N_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCDTD4N_'+index_object+'_'+inicial+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD4N_'+index_object+'_'+inicial+'['+index+']"></textarea></td></tr>';
	$('#tableFourE_'+index+'_'+id_object).append(fila);
	indexF4=index;
	id_objectF4=id_object;
	//reordenar4();
}
//------------
function reordenar(){
	var num=1;
	try{
		$('#tableTwo_'+indexF+'_'+id_objectF+' tr td textarea').each(function() {
			$(this).eq(0).attr('name','textoTD_'+id_objectF+'['+indexF+']'+'['+num+']');
			num++;
		});
		document.getElementById('posTableTwo_'+id_objectF+'['+indexF+']').value=num-1;
	}catch(err){}
}
//--------Metodos para crear tabla dinamica tres columnas
var cont3=1;
var id_fila_selected3;
var indexF3;
function agregarTD3(event,index,id_object){
	var id=cont3++;
	event.preventDefault();
	var fila='<tr id="filaT3_'+id+'" onclick="seleccionar3(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCTD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD_'+id_object+'['+index+']"></textarea></td></tr>';
	$('#tableThree_'+index+'_'+id_object).append(fila);
	indexF3=index;
	id_objectF3=id_object;
	reordenar3();
}
function seleccionar3(id_fila){
	if ($('#'+id_fila).hasClass('seleccionada')) {
		$('#'+id_fila).removeClass('seleccionada');
	}else{
		$('#'+id_fila).addClass('seleccionada');
	}
	id_fila_selected3=id_fila;
}
function eliminar3(event){
	if (cont3>1) {
		cont3--;
	}
	event.preventDefault();
	$('#'+id_fila_selected3).remove();
	reordenar3();
}
function reordenar3(){
	var num=1;
	$('#tableThree_'+indexF3+'_'+id_objectF3+' tr td textarea').each(function() {
		$(this).eq(0).attr('name','textoTD3_'+id_objectF3+'['+indexF3+']'+'['+num+']');
		num++;
	});
	document.getElementById('posTableThree_'+id_objectF3+'['+indexF3+']').value=num-1;
}

//--------Metodos para crear tabla dinamica cuatro columnas
var cont4=1;
var id_fila_selected4;
var indexF4;
function agregarTD4(event,index,id_object){
	var id=cont4++;
	event.preventDefault();
	var fila='<tr id="filaT4_'+id+'" onclick="seleccionar4(this.id);"><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCITD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCDTD_'+id_object+'['+index+']"></textarea></td><td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD_'+id_object+'['+index+']"></textarea></td></tr>';
	$('#tableFour_'+index+'_'+id_object).append(fila);
	indexF4=index;
	id_objectF4=id_object;
	reordenar4();
}

function seleccionar4(id_fila){
	if ($('#'+id_fila).hasClass('seleccionada')) {
		$('#'+id_fila).removeClass('seleccionada');
	}else{
		$('#'+id_fila).addClass('seleccionada');
	}
	id_fila_selected4=id_fila;
}
function eliminar4(event){
	if (cont4>1) {
		cont4--;
	}
	event.preventDefault();
	$('#'+id_fila_selected4).remove();
	reordenar4();
}
function reordenar4(){
	var num=1;
	$('#tableFour_'+indexF4+'_'+id_objectF4+' tr td textarea').each(function() {
		$(this).eq(0).attr('name','textoTD4_'+id_objectF4+'['+indexF4+']'+'['+num+']');
		num++;
	});
	document.getElementById('posTableFour_'+id_objectF4+'['+indexF4+']').value=num-1;
}
//Este metodo obtiene la cantidad de veces 
//que se ha clickeado una opcion del menu agregar
var arrayMenu_1=[];
var arrayMenu_2=[];
var arrayMenu_3=[];
var arrayMenu_4=[];
var arrayMenu_5=[];
var arrayMenu_6=[];
var arrayMenu_7=[];
function contador(id,index){
	var array=[];
	var latest;
	switch(index){
		case 1:
			if (id!='removerA_'+index)(arrayMenu_1).push(id);
				else latest=arrayMenu_1.pop(); delete arrayMenu_1[latest];
			array=arrayMenu_1;
			break;
		case 2:
			if (id!='removerA_'+index)(arrayMenu_2).push(id);
			else latest=arrayMenu_2.pop(); delete arrayMenu_2[latest];
			array=arrayMenu_2;
			break;
		case 3:
			if (id!='removerA_'+index)(arrayMenu_3).push(id);
			else latest=arrayMenu_3.pop(); delete arrayMenu_3[latest];
			array=arrayMenu_3;
			break;
		case 4:
			if (id!='removerA_'+index)(arrayMenu_4).push(id);
			else latest=arrayMenu_4.pop(); delete arrayMenu_4[latest];
			array=arrayMenu_4;
			break;
		case 5:
			if (id!='removerA_'+index)(arrayMenu_5).push(id);
			else latest=arrayMenu_5.pop(); delete arrayMenu_5[latest];
			array=arrayMenu_5;
			break;
		case 6:
			if (id!='removerA_'+index)(arrayMenu_6).push(id);
			else latest=arrayMenu_6.pop(); delete arrayMenu_6[latest];
			array=arrayMenu_6;
			break;	
		case 7:
			if (id!='removerA_'+index)(arrayMenu_7).push(id);
			else latest=arrayMenu_7.pop(); delete arrayMenu_7[latest];
			array=arrayMenu_7;
			break;
	}
	
	return arrayCountValues(array);
}
function arrayCountValues (arr) {
    var v, freqs = {};
    // for each v in the array increment the frequency count in the table
    for (var i = arr.length; i--; ) { 
        v = arr[i];
        if (freqs[v]) freqs[v] += 1;
        else freqs[v] = 1;
    }
    // return the frequency table
    return freqs;
}
function log() {
	var x = localStorage.getItem("x");//window.history.length;
	if (x!=1) {
		location.reload();
	}
}
function verGraficaE(event,cont,index_id,index,idPos,url){
	 event.preventDefault();
	     var datos;
	     var ubicacion=url+'calidad/viewGraphicE';
    if (idPos==1) {
    	var titulo=document.getElementById('tituloGraficoE_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGraficoE_'+index_id+'['+index+']').value;
    	var tituloGraficoY=document.getElementById('tituloGraficoYE_'+index_id+'['+index+']').value;
    	var start=document.getElementById('startE_'+index_id+'['+index+']').value;
    	var posBarra=document.getElementById('posBarraE_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	for (var i =1; i <posBarra; i++) {
    		tituloColumna[i]=document.getElementById('dataTBarraE'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataBarraE'+i+'_'+index_id+'['+index+']').value;
    	}
	    	if(tituloColumna[1]=="" ||datosColumna[1]=="" ||!isEmpty(start) || !isEmpty(titulo) ||!isEmpty(subtitulo)||!isEmpty(tituloGraficoY)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,tituloGraficoY:tituloGraficoY,start:start,index_id:index_id,index:index};
    }else if (idPos==2) {
    	var titulo=document.getElementById('tituloGraficoPE_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGraficoPE_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	var posPie=document.getElementById('posPieE_'+index_id+'['+index+']').value;
    	for (var i =1; i <posPie; i++) {
    		tituloColumna[i]=document.getElementById('dataTPieE'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataPieE'+i+'_'+index_id+'['+index+']').value;
    	}
    		if(tituloColumna[1]=="" ||datosColumna[1]=="" || !isEmpty(titulo) ||!isEmpty(subtitulo)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,index_id:index_id,index:index};
    }else if(idPos==3){
		var titulo=document.getElementById('tituloGraficoLE_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGraficoLE_'+index_id+'['+index+']').value;
    	var tituloGraficoY=document.getElementById('tituloGraficoYLE_'+index_id+'['+index+']').value;
    	var start=document.getElementById('startLE_'+index_id+'['+index+']').value;
    	var posLinea=document.getElementById('posLineaE_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	for (var i =1; i <posLinea; i++) {
    		tituloColumna[i]=document.getElementById('dataTLineaE'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataLineaE'+i+'_'+index_id+'['+index+']').value;
    	}
    		if(tituloColumna[1]=="" ||datosColumna[1]=="" ||!isEmpty(start) || !isEmpty(titulo) ||!isEmpty(subtitulo)||!isEmpty(tituloGraficoY)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,tituloGraficoY:tituloGraficoY,start:start,index_id:index_id,index:index};
    }
	    $.ajax({
		    url: ubicacion,
		    type: "POST",
		    data:datos,
		    success: function(data)
		    {
		    	$('#contenedor_content_'+index).append(data);
		    },
		    error: function() 
		    {
		        alert('Upsss ocurrio algo :(');
		    }           
	    });
}
function verGrafica(event,cont,index_id,index,idPos,url){
	 event.preventDefault();
	     var datos;
	     var ubicacion=url+'calidad/viewGraphic';
    if (idPos==1) {
    	var titulo=document.getElementById('tituloGrafico_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGrafico_'+index_id+'['+index+']').value;
    	var tituloGraficoY=document.getElementById('tituloGraficoY_'+index_id+'['+index+']').value;
    	var start=document.getElementById('start_'+index_id+'['+index+']').value;
    	var posBarra=document.getElementById('posBarra_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	for (var i =1; i <posBarra; i++) {
    		tituloColumna[i]=document.getElementById('dataTBarra'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataBarra'+i+'_'+index_id+'['+index+']').value;
    	}
	    	if(tituloColumna[1]=="" ||datosColumna[1]=="" ||!isEmpty(start) || !isEmpty(titulo) ||!isEmpty(subtitulo)||!isEmpty(tituloGraficoY)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,tituloGraficoY:tituloGraficoY,start:start,index_id:index_id,index:index};
    }else if (idPos==2) {
    	var titulo=document.getElementById('tituloGraficoP_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGraficoP_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	var posPie=document.getElementById('posPie_'+index_id+'['+index+']').value;
    	for (var i =1; i <posPie; i++) {
    		tituloColumna[i]=document.getElementById('dataTPie'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataPie'+i+'_'+index_id+'['+index+']').value;
    	}
    		if(tituloColumna[1]=="" ||datosColumna[1]=="" || !isEmpty(titulo) ||!isEmpty(subtitulo)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,index_id:index_id,index:index};
    }else if(idPos==3){
		var titulo=document.getElementById('tituloGraficoL_'+index_id+'['+index+']').value;
    	var subtitulo=document.getElementById('subtituloGraficoL_'+index_id+'['+index+']').value;
    	var tituloGraficoY=document.getElementById('tituloGraficoYL_'+index_id+'['+index+']').value;
    	var start=document.getElementById('startL_'+index_id+'['+index+']').value;
    	var posLinea=document.getElementById('posLinea_'+index_id+'['+index+']').value;
    	var tituloColumna=[];
    	var datosColumna=[];
    	for (var i =1; i <posLinea; i++) {
    		tituloColumna[i]=document.getElementById('dataTLinea'+i+'_'+index_id+'['+index+']').value;
    		datosColumna[i]=document.getElementById('dataLinea'+i+'_'+index_id+'['+index+']').value;
    	}
    		if(tituloColumna[1]=="" ||datosColumna[1]=="" ||!isEmpty(start) || !isEmpty(titulo) ||!isEmpty(subtitulo)||!isEmpty(tituloGraficoY)){
    			alert('Ningun campo debe estar vacio');
    			return false;
			}
    	datos={tituloColumna:tituloColumna,datosColumna:datosColumna,id:idPos,titulo:titulo,subtitulo:subtitulo,tituloGraficoY:tituloGraficoY,start:start,index_id:index_id,index:index};
    }
    $.ajax({
    url:ubicacion,
    type: "POST",
    data:datos,
    success: function(data)
    {
    	$('#contenedor_content_'+index).append(data);
    },
    error: function() 
    {
        alert('Upsss ocurrio algo :(');
    }           
    });
}
function validarData(event) {
	var id=event.target.id;
	var value=document.getElementById(id).value;
	var valor='';
	if (!/^([0-9])*$/.test(value)) {
		for (var i = 0; i <value.length; i++) {
			valor+=value[i].replace(/^[a-zA-Z]|[$&#*!¿?¡'-()ª"%=^/]$/g,"");
		}
		document.getElementById(id).value=valor;
    }
}
function sendToServer(hr){
	var url=document.getElementById('url').value;
	var id=document.getElementById('idActa').value;
	var ubicacion=url+'calidad/downloadPdf';
	var img=[];
	var imgPie=[];
	var imgLinea=[];
	var index_id;
	var indexPie_id;
	var indexLinea_id;
	for (var i=1;i<=7;i++) {
		try{
			index_id=document.getElementById('index_'+i).value;
			img[i]=[];
		for (var j=1;j<=index_id;j++) {
			img[i][j]=(document.getElementById('inputcontainerColumn'+i+'_'+j).value);
		}
		}catch(err){}
		try{
			indexPie_id=document.getElementById('indexPie_'+i).value;
			imgPie[i]=[];
			for (var j=1;j<=indexPie_id;j++) {
				imgPie[i][j]=(document.getElementById('inputcontainerPie'+i+'_'+j).value);
			}
		}catch(err1){}
		try{
			indexLinea_id=document.getElementById('indexLinea_'+i).value;
			imgLinea[i]=[];
			for (var j=1;j<=indexLinea_id;j++) {
			imgLinea[i][j]=(document.getElementById('inputcontainerLinea'+i+'_'+j).value);
			}
		}catch(err2){}
	}
	var envio = $.post(ubicacion,{img:img,imgPie:imgPie,imgLinea:imgLinea}, function(data) {
		window.open(hr,'_blank');	
	});
   return false;
}
var localHeight=0;
var ajuste=0;
function setHeight(proceso,indicador,rows,index,j){
	var length=index.length;
    for (var i=0; i <length; i++) {
    	if(ajuste%2==0){
			document.getElementById('rowsIndicador_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
    		document.getElementById('rowsIndicador1_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador2_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador3_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador4_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador5_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador6_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicador7_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
    	}
    	if(indicador>proceso){
    		document.getElementById('rowsTD['+j+']').style.height=indicador+"px";
			//console.log(j+'/'+proceso+'/'+indicador+'/'+rows+'/'+index[i]);
    	}else{
    		document.getElementById('rowsIndicador_'+rows+'['+index[i]+']').style.height=(proceso/length)+"px"; 
    		localHeight+=document.getElementById('rowsIndicador_'+rows+'['+index[i]+']').offsetHeight;
    	}
    	if(document.getElementById('rowsTD['+j+']').offsetHeight<localHeight)
    		document.getElementById('rowsTD['+j+']').style.height=localHeight+"px";
    }
    ajuste++;
    localHeight=0;
}
var localHeightA=0;
function setHeightAccion(proceso,indicador,rows,index,j){
	var length=index.length;
    for (var i=0; i <length; i++) {
    	if(indicador>proceso){
    		document.getElementById('rowsEncabezado['+j+']').style.height=indicador+"px";
    	}else{
    		document.getElementById('rowsCuerpo_'+rows+'['+index[i]+']').style.height=(proceso/length)+"px"; 
    		localHeight+=document.getElementById('rowsCuerpo_'+rows+'['+index[i]+']').offsetHeight;
    	}
    	if(document.getElementById('rowsEncabezado['+j+']').offsetHeight<localHeight)
    		document.getElementById('rowsEncabezado['+j+']').style.height=localHeightA+"px";
    }
    localHeightA=0;
}
var localHeightSG=0;
var ajusteSG=0;
/*
[1,1,2,3,4,5,6,8,8,7]
				1[0]
funciones.js:966 1[1]
funciones.js:966 1[0]
funciones.js:966 1[1]
funciones.js:966 2[2]
funciones.js:966 3[3]
funciones.js:966 4[4]
funciones.js:966 5[5]
funciones.js:966 6[6]
funciones.js:966 8[7]
funciones.js:966 8[8]
 */
function setHeightSG(proceso,indicador,rows,index,j){
	var length=index.length;
    for (var i=0; i <length; i++) {
    	if(ajusteSG%2==0){
			document.getElementById('rowsIndicadorSG_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG1_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG2_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG3_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG4_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG5_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG6_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
            document.getElementById('rowsIndicadorSG7_'+rows+'['+index[i]+']').style.backgroundColor="#E0ECF8";
    	}
    	if(indicador>proceso){
    		document.getElementById('rowsTDSG['+j+']').style.height=indicador+"px";
			//console.log(j+'/'+proceso+'/'+indicador+'/'+rows+'/'+index[i]);
    	}else{
    		document.getElementById('rowsIndicadorSG_'+rows+'['+index[i]+']').style.height=(proceso/length)+"px"; 
    		localHeightSG+=document.getElementById('rowsIndicadorSG_'+rows+'['+index[i]+']').offsetHeight;
    	}
    	if(document.getElementById('rowsTDSG['+j+']').offsetHeight<localHeightSG)
    		document.getElementById('rowsTDSG['+j+']').style.height=localHeightSG+"px";
    	console.log(rows+'['+index[i]+']');
    }
    ajusteSG++;
    localHeightSG=0;
}
Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});
function ver() {
	if($('#busqueda').hasClass('hidden')){
		$('#busqueda').removeClass('hidden');
		$('#btn_busqueda').val('Ocultar');
	}else{
		$('#busqueda').addClass('hidden');
		$('#btn_busqueda').val('Búsqueda avanzada');
	}
}