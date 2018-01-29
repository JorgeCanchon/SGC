	<div id="wrapper">
        <div id="page-wrapper">   
            <br>
            <div class="row">
                <div class="col-lg-12">
	                    <table class="table-bordered" style="margin-top:30px;">
	                        <tr>
	                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
	                            <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</center></h4></td>
	                            <td class="col-sm-4" ><b>Código:</b>
	                                <div style="width: 220px; height: 1px;">
	                                </div>
	                                <center>
		                                <?php 
		                                	echo $contenidoaccion->codigoAccion;   
		                                ?>
	                                </center>  
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="col-sm-4">
	                                <b>Proceso:</b>
	                                <center>
	                                <?php 
	                                	echo $contenidoaccion->procesoInf;   
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
	                                  	echo $contenidoaccion->version; 
	                                ?>
	                                </center>  
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="col-sm-4">
	                                <b>Fecha de vigencia:</b>
	                                <center>
	                                    <?php 
											echo $contenidoaccion->fechaVigencia; 
	                                    ?>
	                                </center>  
	                            </td>
	                        </tr> 
	                    </table>
	                    <br>
	                    <?php
	                    $res=false; 
	                    foreach ($procesosUsuario as $value_p) {
	                    	if($value_p->id==$contenidoaccion->idProceso){ 
	                    		$res=true;
	                    	}
	                    }
	                    if($res){
	                    ?>
	                    <form method="POST" id="form_editPlanAccion" name="form_editPlanAccion" action="<?php echo $base_url ?>calidad/updatePlanAccion">
	                   <input type="hidden" name="idAccion" id="idAccion" value="<?php echo $id; ?>">
	                    <table class="tableActa" id="tablePlanAccion">
					    	<tr>
								<td class="tableActaBack" rowspan="2" width="15%">FECHA DE HALLAZGO</td>
								<td class="tableActaBody" rowspan="2" width="10%"><input type="date" value="<?php 
									echo $contenidoaccion->fechaHallazgo;
								?>" name="fechaHallazgo" id="fechaHallazgo" class="form-control"></td>
								<td class="tableActaBack" rowspan="2" width="8%">TIPO ACCIÓN</td>
								<td></td>
								<td class="tableActaBack">PROCESO</td>
								<td class="tableActaBody">
									<center>
								 <?php 
								 	echo $contenidoaccion->proceso;
								  ?><input type="hidden" name="procesoN" value="<?php echo $contenidoaccion->proceso; ?>">
								  </center>
								</td>
							</tr>
							<tr>
								<td>
									<center>
									<?php 
									echo $contenidoaccion->nombreTipo;
									 ?>
									 <input type="hidden" name="nombreTipoN" value="<?php echo $contenidoaccion->nombreTipo; ?>">
									</center>
								</td>
								<td class="tableActaBack">Nº ACCIÓN</td>
								<td class="tableActaBody">
									<center>
									<?php 
									 echo $id;
									?>
									</center>
								</td>
							</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack">FUENTE DE DETECCIÓN</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody">
	                    			<div class="row">
	                    				<div class="col-lg-12">
	                    					<div class="col-lg-6">
	                    				<?php 
	                    					$inicio=count($fuente);
	                    					$fin=$inicio/2;
	                    					$index=0;
	                    					foreach ($fuente as $value) {
	                    						if($index<$fin){
	                    							$checked=' ';
	                    							foreach ($fuente_id as $valueI) {
	                    								if ($valueI->id==$value->id) {
	                    									$checked='checked';
	                    								}
	                    								
	                    							}
	                    							echo $value->nombre.'&nbsp;<input  type="checkbox" '.$checked.' name="fuenteD[]" id="fuenteD_'.$index.'" value="'.$value->id.'"><br>';
	                    							$checked=' ';
		                    					}
		                    					$index++;
		                    				}
	                    				?>
	                    					</div>
	                    					<div class="col-lg-6">
	                    				<?php 
	                    					$inicio=count($fuente);
	                    					$fin=$inicio/2;
	                    					$index=0;
	                    					foreach ($fuente as $value) {
	                    						if($fin<$index){
	                    							$checked=' ';
	                    							foreach ($fuente_id as $valueI) {
	                    								if ($valueI->id==$value->id) {
	                    									$checked='checked';
	                    								}
	                    								
	                    							}
	                    							echo $value->nombre.'&nbsp;<input  type="checkbox" '.$checked.'  name="fuenteD[]" id="fuenteD_'.$index.'" value="'.$value->id.'"><br>';
	                    								$checked=' ';
		                    					}
		                    					$index++;
		                    				}
		                    				echo '<input type="hidden" name="indexFuente" id="indexFuente" value="'.$index.'">';	
	                    				?>
	                    					</div>
	                    				</div>
	                    			</div>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" rowspan="3">DESCRIPCIÓN DEL HALLAZGO</td>
	                    		<td class="tableActaBack" colspan="4">INVESTIGACIÓN DE LAS CAUSAS (METODOLOGÍA DE 6'M Y TRES POR QUÉ)</td>
	                    	</tr>
	                    	<tr>
	                    		<td colspan="4"> 
	                    			<?php 
	                    			$index=0;
	                    				foreach ($metodologia as $value) {
	                    					$checked=' ';
                							foreach ($metodologia_id as $valueI) {
                								if ($valueI->id==$value->id) {
                									$checked='checked';
                								}
                								
                							}
	                    					echo ' <label>'.$value->nombre.'</label> <input type="checkbox" '.$checked.' name="causa[]" id="causa_'.$index.'" value="'.$value->id.'"> ';
	                    					$checked=' ';
	                    					$index++;
	                    				}
	                    				echo '<input type="hidden" name="indexCausa" id="indexCausa" value="'.$index.'">';
	                    			 ?>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBack">Tres Por Qué</td>
	                    		<td class="tableActaBack">Descripción</td>
	                    		<td class="tableActaBack">Frecuencia</td>
	                    		<td class="tableActaBack">Causa raíz</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody" rowspan="4" >
	                    			<input type="hidden" value="<?php echo $contenidoaccion->codigoPorque; ?>" name="idPorque" id="idPorque">
	                    			<textarea name="descripcionHallazgo" id="descripcionHallazgo" class="form-control"><?php echo $contenidoaccion->descripcionHallazgo; ?></textarea>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Primer Por Qué</center></td>
	                    		<td class="tableActaBody" ><textarea name="primer" id="primer" class="form-control"><?php echo $contenidoaccion->primer; ?></textarea></td>
	                    		<td class="tableActaBody" ><textarea  name="frecuenciaPrimer" id="frecuenciaPrimer" class="form-control"><?php echo $contenidoaccion->frecuenciaPrimer; ?></textarea></td>
	                    		<td class="tableActaBody" rowspan="4" ><textarea name="causaRaiz" id="causaRaiz" class="form-control"><?php echo $contenidoaccion->causaRaizHallazgo; ?></textarea></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Segundo Por Qué</center></td>
	                    		<td class="tableActaBody"><textarea name="segundo" id="segundo" class="form-control"><?php echo $contenidoaccion->segundo; ?></textarea></td>
	                    		<td class="tableActaBody"><textarea name="frecuenciaSegundo" id="frecuenciaSegundo" class="form-control"><?php echo $contenidoaccion->frecuenciaSegunda;?></textarea></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Tercer Por Qué</center></td>
	                    		<td class="tableActaBody" ><textarea name="tercer" id="tercer" class="form-control"><?php echo $contenidoaccion->tercera; ?></textarea></td>
	                    		<td class="tableActaBody" ><textarea name="frecuenciaTercer" id="frecuenciaTercer" class="form-control"><?php echo $contenidoaccion->frecuenciaTercera; ?></textarea></td>
	                    	</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack">
	                    			BENEFICIOS (aplica para las acciones de mejora)
									CONSECUENCIAS (aplica para acciones correctivas y preventivas)
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody" >
	                    			<textarea class="form-control" name="beneficio_consecuencia" id=""><?php echo $contenidoaccion->beneficio_consecuencia; ?></textarea>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
	                    <?php 
	                    if ($correccion_id!=false) {
	                    ?>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="2">
	                    			CORRECIÓN(Cuando aplique)
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableIndicadorHead" colspan="2">
	                    			<center>TRATAMIENTO</center>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<?php 
	                    		foreach ($correccion as $value) {
	                    			$checked=' ';
        							foreach ($correccion_id as $valueI) {
        								if ($valueI->id==$value->id) {
        									$checked='checked';
        								}
        							}
									echo '<tr><td class="tableActaBody" width="90%">'.$value->nombre.'</td>';
	                    			echo '<td class="tableActaBody" width="10%"><center><input type="checkbox" name="correccion[]" id="correccion_'.$index++.'" value="'.$value->id.'" '.$checked.'></center></td><tr>';                    	
	                    			$checked=' ';
	                    		}
	                    		 ?>
	                    	</tr>
	                    </table>
	                    <?php 
	                    }else{
	                    ?>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="2">
	                    			CORRECIÓN(Cuando aplique)
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableIndicadorHead" colspan="2">
	                    			<center>TRATAMIENTO</center>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<?php 
	                    		$index=0;
	                    		foreach ($correccion as $value) {
									echo '<tr><td class="tableActaBody" width="90%">'.$value->nombre.'</td>';
	                    			echo '<td class="tableActaBody" width="10%"><center><input type="checkbox" name="correccion[]" id="correccion_'.$index++.'" value="'.$value->id.'"></center></td><tr>';
	                    		}
	                    		 ?>
	                    	</tr>
	                    </table>
	                    <?php	
	                    } 
	                     ?>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="2">
	                    			DESCRIPCIÓN
	                    		</td>
	                    	</tr>
	                    	<tr>	
	                    		<td class="tableActaBody" colspan="2" >
	                    			<textarea class="form-control" name="descripcion" id="descripcion"><?php  echo $contenidoaccion->descripcion;?></textarea>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody" width="50%">
	                    			<b>PROCESO A CORREGIR:</b>
	                    			<?php 
	                    				echo $contenidoaccion->proceso;
	                    			 ?>
	                    		</td>
	                    		<td class="tableActaBody" width="50%">
	                    			<b>RESPONSABLE:</b>
	                    			<select class="form-control" name="responsable_corregir" id="responsable_corregir">
	                    				<?php 
	                    				foreach ($cargo as $value) {
	                    					if($value->id==$contenidoaccion->codigoCargoResponsable){
												echo '<option value="'.$value->id.'" selected>'.$value->nombre.'</option>';
	                    					}else{
												echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
	                    					}
	                    				}
	                    			 	?>
	                    			</select>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa" id="table_accion">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="5">PLANES DE ACCIÓN</td>
	                    	</tr>
                    		<?php 
                    		$index=1;
                    		foreach ($plan as $value) {
                    			echo '
                    			<tr id="fila_accion_'.$index.'" class="fila_accion">
		                    		<td class="tableIndicadorHead">
		                    			<center>Actividades a desarrollar</center>
		                    		</td>
		                    		<td class="tableIndicadorHead"><center>Fecha de ejecución</center></td>
		                    		<td class="tableIndicadorHead"><center>Fecha de revisión</center></td>
		                    		<td class="tableIndicadorHead"><center>Recursos</center></td>
		                    		<td class="tableIndicadorHead"><center>Responsable</center></td>
	                    		</tr>
                    			<tr id="fila_accionContenido_'.$index.'">
									<td class="tableActaBody">
									<input type="hidden" value="'.$value->idAccion.'" name="idPlan['.$index.']" id="idPlan_'.$index.'"><textarea name="actividad_desarrollarE['.$index.']" id="actividad_desarrollarE" class="form-control">'.$value->actividad.'</textarea></td>
									<td class="tableActaBody"><input type="date" class="form-control" id="fecha_ejecucionE" name="fecha_ejecucionE['.$index.']" value="'.$value->fechaEjecucion.'"></td>
									<td class="tableActaBody">';
									foreach ($fecha_revision as $value_r) {
										$disabled=' ';
										if($value_r->id==$value->idAccion){
											echo '<input type="date" name="fecha_revision_1['.$index.']" id="fecha_revision_1_'.$index.'" value="'.$value_r->fecha_1.'" class="form-control">';
											if(isset($value_r->fecha_2)){
												echo '<input type="date" name="fecha_revision_2['.$index.']" id="fecha_revision_2_'.$index.'" value="'.$value_r->fecha_2.'" class="form-control">';
											}else{
											echo'	
												<div id="div_fecha_revision_2_'.$index.'">
				                    				<input type="button" class="form-control" name="fecha_revision_2['.$index.']" id="fecha_revision_2_'.$index.'" onclick="addInputDateRevision(this.name,this.id,'.$index.');" value="Agregar">
				                    			</div>';
				                    			$disabled='disabled';
											}
											if (isset($value_r->fecha_3)) {
												echo '<input type="date" name="fecha_revisionE_3['.$index.']" id="fecha_revisionE_3_'.$index.'" value="'.$value_r->fecha_3.'" class="form-control">';
											}else{
											echo'	
												<div id="div_fecha_revision_3_'.$index.'">
				                    				<input type="button" class="form-control" name="fecha_revision_3['.$index.']" id="fecha_revision_3_'.$index.'" onclick="addInputDateRevision(this.name,this.id,'.$index.');" value="Agregar" '.$disabled.'> 
				                    			</div>';
											}
										}
									}
								echo'		
									</td>
									<td class="tableActaBody">
									<select name="recursoE_'.$index.'[]" id="recursoE_'.$index.'" class="form-control" multiple="true">';
										$idR='';
										foreach ($recursos as $value_r) {
											foreach ($recurso as $key ) {
												if ($key->codigo==$value->idAccion) {
													if($value_r->id==$key->idRecurso){
														$idR.=$key->idRecurso.',';
													}
												}
											}
											echo '<option value="'.$value_r->id.'">'.$value_r->nombre.'</option>';
										}
										echo '<input type="hidden" value="'.$idR.'" name="indexRecurso" id="indexRecurso_'.$index.'" >';
								echo	'
										</select>
									</td>
									<td class="tableActaBody">
										<select name="responsable_seguimientoE['.$index.']" id="responsable_seguimientoE" class="form-control">
										';
										foreach ($cargo as $value_c) {
											if($value_c->id==$value->codigoCargoResponsable){
								echo		'<option value="'.$value_c->id.'" selected>'.$value_c->nombre.'</option>';
											}else{
								echo		'<option value="'.$value_c->id.'">'.$value_c->nombre.'</option>';
											}
										}
								echo	'
										</select>
									</td>
								</tr>
                    			';
                    			$index++;
                    		}
                    		echo '<input type="hidden" name="indexPlan" id="indexPlan" value="'.$index.'">'	
                    		 ?>
	                    </table>
                        <br>
            			<br>
            			<div class="row">
                            <div class="col-lg-12" id="contenedor_botones">
                                <div class="row">
                                    <div class="col-md-5">&nbsp;</div>
                                    <div class="col-md-1"><input type="button" id="agregarA" class="btn btn-default" value="+" title="Agregar" onClick="agregarPlanAccion(this.id,'<?php echo $base_url ?>');"></div>
                                    <div class="col-md-1"><input type="button" id="removerA" class="btn btn-default" value="-" title="Remover" onClick="agregarPlanAccion(this.id,'<?php echo $base_url ?>');"></div>
                                    <div class="col-md-5">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="loading" class="hidden">
                            <div class="row">
                                <div class="col-md-5">&nbsp;</div>
                                <div class="col-md-2 ">
                                    <div class="row">
                                        <div class="col-md-4">&nbsp;</div>
                                        <div class="col-md-4"><img src="<?php echo base_url(); ?>img/progress.gif" alt="" /><h1></h1></div>
                                        <div class="col-md-4">&nbsp;</div>
                                    </div>
                                </div>          
                                <div class="col-md-5">&nbsp;</div>
                            </div>
                        </div>
                        <br>
                        <?php 
                        if ($seguimiento!=false) {
                        ?>
                        <table id="table_seguimiento" class="tableActa ">
                        	<tr id="fila_seguimientoTitle_1" class="fila_seguimientoTitle">
                        		<td colspan="4" class="tableActaBack">SEGUIMIENTO Y VERIFICACIÓN</td>
                        	</tr>
                        	<tr id="fila_seguimientoSubtitle_1" class="fila_seguimientoSubtitle">
                        		<td class="tableIndicadorHead" width="15%"><center>Fecha</center></td>
                        		<td class="tableIndicadorHead" width="50%"><center>Descripción de seguimiento</center></td>
                        		<td class="tableIndicadorHead" width="10%"><center>Eficacia</center></td>
                        		<td class="tableIndicadorHead" width="25%"><center>Cargo que verifica</center></td>
                        	</tr>
                        	<?php
                        	foreach ($seguimiento as $value_s) {
						echo'
                        	<tr id="fila_seguimientoC_1" class="fila_seguimientoC">
                        		<td class="tableActaBody">'.$value_s->fecha.'</td>
                        		<td class="tableActaBody">'.$value_s->descripcion.'</td>
                        		<td class="tableActaBody"><center>'.$value_s->eficacia.'</center></td>
                        		<td class="tableActaBody">
                        			'.$value_s->cargo.'
	                    		</td>
                        	</tr>';
                        	}
                        ?>
                        </table>
                        <br>
                        <?php 
                        if ($conclusion!=false) {
                        ?>
                         <table class="tableActa">
                        	<tr>
                        		<td class="tableActaBack">CONCLUSIÓN</td>
                        		<td class="tableActaBack">NUMERAL DE LA NORMA AL QUE APLICA</td>
                        	</tr>
                        	<tr>
                        		<td class="tableActaBody" width="65%"><?php echo $conclusion->conclusion; ?></td>
                        		<td class="tableActaBody" width="35%"><?php echo $conclusion->numeralNorma; ?></td>
                        	</tr>
                        </table>
                        <table class="tableActa ">
                        	<tr>
                        		<td class="tableActaBack" rowspan="2">Fecha de cierre</td>
                        		<td class="tableActaBody"><?php echo $conclusion->fechaCierre; ?></td>
                        		<td class="tableActaBack">Responsable de cierre</td>
                        		<td class="tableActaBody">
                        			<?php echo $conclusion->cargo; ?>
                        		</td>
                        	</tr>
                        	<tr>
                        		<td class="tableActaBody"><b>Día/Mes/Año</b></td>
                        		<td class="tableActaBack">Eficacia de acción</td>
                        		<td class="tableActaBody"><center><?php echo $conclusion->eficacia; ?></td>
                        	</tr>
                        </table>
                        <?php
                        }else{
                        echo '
                        <table class="tableActa">
                        	<tr>
                        		<td class="tableActaBack">CONCLUSIÓN</td>
                        	</tr>
                        	<tr>
								<td class="tableActaBody">
									<center>No hay conclusión disponible</center>
								</td>
                        	</tr>
                        </table>
                        ';
                        }
                        ?>
                       
						<?php
                        }else{
                        	echo '
						<table id="table_seguimiento" class="tableActa ">
                        	<tr id="fila_seguimientoTitle_1" class="fila_seguimientoTitle">
                        		<td colspan="4" class="tableActaBack">SEGUIMIENTO Y VERIFICACIÓN</td>
                        	</tr>
                        	<tr>
								<td colpan="4"><center>No hay seguimiento disponible</center></td>
                        	</tr>
                        </table>
                        	';
                        }
                         ?>
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
                    <?php 
	                }else{
	                	redirect('calidad/planaccion');
	                } ?>
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
        $('#form_editPlanAccion').submit(function(event){
        	if (!validarTodosCampos('form_editPlanAccion', 'Todos los campos deben estar llenos')) {
        	 	event.preventDefault();
        	}
			var res=false;
			for (var i = 0; i <$('#indexFuente').val(); i++) {
				if($('#fuenteD_'+i).is(':checked')){
					res=true;
				}
			}
			if(!res){
				event.preventDefault();
				alert('Seleccione al menos una fuente de detección');
			}
			var res=false;
			for (var i = 0; i <$('#indexCausa').val(); i++) {
				if($('#causa_'+i).is(':checked')){
					res=true;
				}
			}
			if(!res){
				event.preventDefault();
				alert('Seleccione al menos una metodologia');
			}
        });
        $(document).ready(function() {
        	var indexPlan = $('#indexPlan').val();
         	for (var i = 1; i <indexPlan; i++) {
     			var idRecurso = $('#indexRecurso_'+i).val();
                    $('#recursoE_'+i).val(idRecurso.split(','));
            }
        });
    </script>