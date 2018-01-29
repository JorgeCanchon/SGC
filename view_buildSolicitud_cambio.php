<?php 
    if (isset($barra_superior)) {
      	if ($barra_superior) {
        	$mostrar_barra=' ';
      	}else{
        	$mostrar_barra='hidden';
        }
    }
    if (isset($mensaje) && $mensaje!='') {
?>
       <script type="text/javascript">
           alert("<?php echo $mensaje; ?>");
       </script>
<?php
       $mensaje='';
    }
?> 
	<div id="wrapper">
        <div id="page-wrapper">   
            <br><br>
            <div class="row">
                <div class="col-lg-12">
                	<form action="<?php echo base_url() ?>calidad/editInfSolicitudCambio" method="POST" name="form_inf" id="form_inf">
                        <table class="table-bordered" style="margin-top:30px;">
					        <tr>
					            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
					            <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</center></h4></td>
					            <td class="col-sm-4" ><b>Código:</b>
					                <div style="width: 220px; height: 1px;">
					                </div>
					                <center>
					                  <?php 
					                    if ($option==1) {
					                    echo '<input type="text" name="codigoAccionInf" id="codigoAccionInf" class="form-control" value="'.@$inf->codigo.'">';
					                    }else{
					                        if(empty($inf->codigo)){
					                            echo 'CRM-GQ-01'; 
					                        echo '<input type="hidden" name="codigoAccionInf" id="codigoAccionInf" class="form-control" value="CRM-GQ-01">';
					                        }else{
					                            echo $inf->codigo;
					                            echo '<input type="hidden" name="codigoAccionInf" id="codigoAccionInf" class="form-control" value="'.$inf->codigo.'">';
					                        }
					                    }
					                  ?>
					                </center>  
					            </td>
					        </tr>
					        <tr> 
					            <td class="col-sm-4">
					                <b>Proceso:</b>
					                <center>
					                <?php 
					                    if ($option==1) {
					                    echo '
					                    <select name="codigoProcesoInf" id="codigoProcesoInf" class="form-control">';
					                        foreach ($procesos as $p) {
					                            if($p->id==$inf->idProceso){
					                    echo   '<option value="'.$p->id.'" selected>'.$p->nombre.'</option>';
					                            }else{
					                    echo   '<option value="'.$p->id.'">'.$p->nombre.'</option>';
					                            }
					                   
					                       }       
					                    echo '</select>';
					                    }else{
					                        if(empty($inf->nombreProceso)){
					                            echo 'Gestión de calidad'; 
					                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="8">';
					                        }else{
					                            echo $inf->nombreProceso;
					                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="'.$inf->idProceso.'">';
					                        }
					                    }
					                  ?>
					                </center>  
					            </td>
					        </tr>
					        <tr>
					            <td  rowspan="2">
					                <center><h5><b><?php echo $title; ?></b></h5></center>
					            </td>
					            <td class="col-sm-4">
					                <b>Versión:</b>
					                <center>
					                    <?php 
					                    if ($option==1) {
					                    echo '<input type="text" name="versionInf" id="versionInf" class="form-control" value="'.@$inf->version.'">';
					                    }else{
					                        if(empty($inf->version)){
					                            echo '1'; 
					                            echo '<input type="hidden" name="versionInf" id="versionInf" value="1">';
					                        }else{
					                            echo $inf->version;
					                            echo '<input type="hidden" name="versionInf" id="versionInf" value="'.$inf->version.'">';
					                        }
					                    }
					                  ?>
					                </center>  
					            </td>
					        </tr>
					        <tr>
					            <td class="col-sm-4">
					                <b>Fecha de vigencia:</b>
					                <center>
					                    <?php 
					                    if ($option==1) {
					                    echo '<input type="date" name="fechaVigenciaInf" id="fechaVigenciaInf" class="form-control" value="'.@$inf->fechaVigencia.'">';
					                    echo '<input type="submit" class="btn btn-default btn-xs dropdown-toggle" value="enviar">';
					                    }else{
					                        if(empty($inf->fechaVigencia)){
					                            echo strftime( "%d-%m-%Y", time() ); 
					                           echo '<input type="hidden" name="fechaVigenciaInf" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
					                        }else{
					                            echo date('d-m-Y', strtotime($inf->fechaVigencia));
					                            echo '<input type="hidden" name="fechaVigenciaInf" value="'.$inf->fechaVigencia.'" class="form-control">';
					                        }
					                    }
					                  ?>
					                </center>  
					            </td>
					        </tr> 
					    </table>
                    </form>
                    <br>
                	<form method="POST" action="<?php echo base_url(); ?>calidad/addSolicitudCambio" id="form_solicitud_cambio" name="form_solicitud_cambio">
                		<?php
                		//------------------------------------------------
                            if(empty($inf->codigo)){; 
                            echo '<input type="hidden" name="codigoAccionInf" id="codigoAccionInf" class="form-control" value="CRM-GQ-01">';
                            }else{
                                echo '<input type="hidden" name="codigoAccionInf" id="codigoAccion" class="form-control" value="'.$inf->codigo.'">';
                            }
                        //-------------------------------------
                        if(empty($inf->nombreProceso)){
                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="8">';
                        }else{
                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="'.$inf->idProceso.'">';
                        }
                        //-------------------------------------------------
                        if(empty($inf->version)){
                            echo '<input type="hidden" name="versionInf" id="versionInf" value="1">';
                        }else{
                            echo '<input type="hidden" name="versionInf" id="versionInf" value="'.$inf->version.'">';
                        }
                        //--------------------------------------------------------
                        if(empty($inf->fechaVigencia)){
                           echo '<input type="hidden" name="fechaVigenciaInf" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
                        }else{
                            echo '<input type="hidden" name="fechaVigenciaInf" value="'.$inf->fechaVigencia.'" class="form-control">';
                        }
                        //----------------------------------------------------------------
                       ?>
	                    <table class="tableActa" id="tablePlanAccion">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="8"><center>SOLICITUD</center></td>
	                    	</tr>
					    	<tr>
								<td class="tableActaBack" rowspan="2" width="15%">Fecha</td>
								<td class="tableActaBody" rowspan="2" width="10%"><input type="date" value="" name="fecha" id="fecha" class="form-control"></td>
								<td class="tableActaBack" rowspan="2" width="8%">Tipo de solicitud</td>
								<?php 
								$index_s=0;
									foreach ($tipo_solicitud as $value) {
			                			echo  '<td class="tableActaBody"><center><input value="'.$value->id.'" type="radio" onchange="sincronizarTipo(this)" name="tipo_solicitud" id="tipo_solicitud_'.$index_s.'" /></center></td>';
	                					$index_s++;
		                			}	
	                			echo '<input type="hidden" id="index_s" name="index_s" value="'.$index_s.'">';
								?>
								<td class="tableActaBack" rowspan="2">Proceso</td>
								<td class="tableActaBody" rowspan="2">
									<select name="proceso" class="form-control" onchange="sincronizarProceso(this.value,this.options[this.selectedIndex].text);">
									<option value="">Seleccione...</option>
									<?php 
										foreach ($procesoUser as $value) {
										echo   '<option value="'.$value->id.'">'.$value->nombreProceso.'</option>';
										}
									 ?>
									</select>
									<input type="hidden" name="procesoN" id="procesoN" value="">
								</td>
							</tr>
							<tr>
								<?php 
								foreach ($tipo_solicitud as $value) {
		                			echo  '<td class="tableActaBody">'.$value->nombre.'</td>
		                					<div class="hidden"><input type="radio" name="nombre_solicitudN" id="'.$value->id.'" value="'.$value->nombre.'"></div>';
	                			}	
								?>
							</tr>
						</table>
						<br>
						<table class="tableActa">	
							<tr>
								<td class="tableActaBack" >
									Nombre de solicitante
								</td>
								<td class="tableActaBody" colspan="2">
									<select name="solicitante" id="solicitante" class="form-control">
										<?php 
										foreach ($users as $value_users) {
											if($value_users->id==$id_usuario){
												echo '<option value="'.$value_users->id.'">'.$value_users->nombre.'</option>';
											}
										}
										?>
									</select>
								</td>
								<td class="tableActaBack">
									Cargo
								</td>
								<td class="tableActaBody" colspan="2">
									<select name="cargo_solicitante" id="cargo_solicitante" class="form-control">
										<?php 
										foreach ($users as $value_u) {
											foreach ($cargo as $value_cargo) {
												if ($value_cargo->id==$value_u->codigoCargo &&  $value_u->id==$id_usuario) {
													echo '<option value="'.$value_cargo->id.'">'.$value_cargo->nombre.'</option>';
												}
											}
										}
										 ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="tableActaBack" >
									Tipo de documento
								</td>
								<td class="tableActaBody" colspan="2">
									<select name="tipo_documento" id="tipo_documento" class="form-control" onchange="sincronizarTipoDocumento(this.value,this.options[this.selectedIndex].text);">
										<option value="">Seleccione...</option>
										<?php 
										foreach ($documento as $value_documento) {
											echo '<option value="'.$value_documento->id.'">'.$value_documento->nombre.'</option>';
										}
										 ?>
									</select>
									<input type="hidden" name="nombre_documentoN" id="nombre_documentoN">
								</td>
								<td class="tableActaBack" >
									Nombre del documento
								</td>
								<td class="tableActaBody" colspan="2">
									<input type="text" name="nombre_documento" id="nombre_documento" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="tableActaBack">
									Código del documento
								</td>
								<td class="tableActaBody">
									<input type="text" name="codigo_documento" id="codigo_documento" class="form-control">
								</td>
								<td class="tableActaBack">
									Versión
								</td>
								<td class="tableActaBody">
									<input type="text" name="version_documento" id="version_documento" class="form-control">
								</td>
								<td class="tableActaBack">
									Fecha de vigencia
								</td>
								<td class="tableActaBody">
									<input type="date" name="fechaV_documento" id="fechaV_documento" class="form-control">
								</td>
							</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" width="30%">
	                    			Descripción de la solicitud
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<textarea name="descripcion_solicitud" id="descripcion_solicitud" class="form-control"></textarea>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBack" width="30%">
	                    			Justificación de la solicitud
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<textarea name="justificacion_solicitud" id="justificacion_solicitud" class="form-control"></textarea>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
		                <div class="row">
		                	<div class="col-lg-12">
		                		<center>
		                			<button type="reset" class="btn btn-default" value="limpiar">Limpiar</button>
		                			<button type="submit" class="btn btn-default" value="guardar">Guardar</button>
		                		</center>
		                	</div>
		                </div>
		                <br>
	                </form>
	                <br>
	                <center>
	                	<a href="<?php echo $retorno ?>" class="btn btn-default">Volver</a>
	                </center>  
	                <br>
	                <br>
	                </div>
            </div>
        </div>    
	</div>
	<script src='<?php echo base_url();?>js/autosize.js'></script>
    <script>
        autosize(document.querySelectorAll('textarea'));
        function sincronizarProceso(value,text) {
        	document.getElementById('procesoN').value=text;
        }
        function sincronizarTipoDocumento(value,text) {
        	document.getElementById('nombre_documentoN').value=text;
        }
        function sincronizarTipo(e){
        	var id=e.value;
        	$('#'+parseInt(id)).prop('checked', true);
        }
       $("#form_solicitud_cambio").on('submit',(function(e) {
            if (!validarTodosCampos('form_solicitud_cambio', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
	        var res=false;
			for (var i = 0; i <$('#index_s').val(); i++) {
				if($('#tipo_solicitud_'+i).is(':checked')){
					res=true;
				}
			}
			if(!res){
				e.preventDefault();
				alert('Seleccione tipo de acción');
			}
        }));
       	
	</script>