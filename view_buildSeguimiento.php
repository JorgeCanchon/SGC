	<div id="wrapper">
        <div id="page-wrapper">   
            <br>
			<?php 
			if($barra_superior){
			 ?>
            <br>
            <div style="padding: 2px;">
                <div class="pull-right">
                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/editPlanSeguimiento/').$contenidoaccion->id?> href="<?php echo $site_urll; ?>">
                        <i class="ace-icon fa fa-arrow-right icon-on-right"><span class="fa-letra"> Editar</span></i> 
                    </a> 
                </div>
            </div>
            <br>
            <?php 
            }
             ?>
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
	                    <table class="tableActa" id="tablePlanAccion">
					    	<tr>
								<td class="tableActaBack" rowspan="2" width="15%">FECHA DE HALLAZGO</td>
								<td class="tableActaBody" rowspan="2" width="10%">
								<?php 
									echo $contenidoaccion->fechaHallazgo;
								?>
								</td>
								<td class="tableActaBack" rowspan="2" width="8%">TIPO ACCIÓN</td>
								<td></td>
								<td class="tableActaBack">PROCESO</td>
								<td class="tableActaBody">
									<center>
								 <?php 
								 	echo $contenidoaccion->proceso;
								  ?>
								  </center>
								</td>
							</tr>
							<tr>
								<td>
									<center>
									<?php 
									echo $contenidoaccion->nombreTipo;
									 ?>
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
	                    							echo $value->nombre.'&nbsp;<input  type="checkbox" '.$checked.' disabled><br>';
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
	                    							echo $value->nombre.'&nbsp;<input  type="checkbox" '.$checked.' disabled><br>';
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
	                    				foreach ($metodologia as $value) {
	                    					$checked=' ';
                							foreach ($metodologia_id as $valueI) {
                								if ($valueI->id==$value->id) {
                									$checked='checked';
                								}
                								
                							}
	                    					echo ' <label>'.$value->nombre.'</label> <input type="checkbox" '.$checked.' disabled> ';
	                    					$checked=' ';
	                    				}
	                    			 ?>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBack">Tres Por Qué</td>
	                    		<td class="tableActaBack">Descripción</td>
	                    		<td class="tableActaBack">Frecuencia</td>
	                    		<td class="tableActaBack">Causa raíz</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody" rowspan="4" style="text-align:justify;"><?php 
	                    			echo $contenidoaccion->descripcionHallazgo;
	                    			 ?>	
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Primer Por Qué</center></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->primer; ?></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->frecuenciaPrimer; ?></textarea></td>
	                    		<td class="tableActaBody" rowspan="4" style="text-align:justify;"><?php echo $contenidoaccion->causaRaizHallazgo; ?></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Segundo Por Qué</center></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->segundo; ?></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->frecuenciaSegunda;?></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Tercer Por Qué</center></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->tercera; ?></td>
	                    		<td class="tableActaBody" style="text-align:justify;"><?php echo $contenidoaccion->frecuenciaTercera; ?></td>
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
	                    		<td class="tableActaBody" style="text-align:justify;">
	                    			<?php echo $contenidoaccion->beneficio_consecuencia; ?>
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
	                    			echo '<td class="tableActaBody" width="10%"><center><input type="checkbox" '.$checked.' disabled></center></td><tr>';                    	
	                    			$checked=' ';
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
	                    		<td class="tableActaBody" colspan="2" style="text-align: justify;">
	                    			<?php  
	                    				echo $contenidoaccion->descripcion;
	                    			?>
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
	                    			<?php 
	                    				echo $contenidoaccion->cargo_responsable;
	                    			 ?>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
	                    <table class="tableActa" id="table_accion">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="5">PLANES DE ACCIÓN</td>
	                    	</tr>
	                    	<tr id="fila_accion_1" class="fila_accion">
	                    		<td class="tableIndicadorHead"><center>Actividades a desarrollar</center></td>
	                    		<td class="tableIndicadorHead"><center>Fecha de ejecución</center></td>
	                    		<td class="tableIndicadorHead"><center>Fecha de revisión</center></td>
	                    		<td class="tableIndicadorHead"><center>Recursos</center></td>
	                    		<td class="tableIndicadorHead"><center>Responsable</center></td>
	                    	</tr>
                    		<?php 
                    		foreach ($plan as $value) {
                    			echo '
                    			<tr>
									<td class="tableActaBody">'.$value->actividad.'</td>
									<td class="tableActaBody">'.$value->fechaEjecucion.'</td>
									<td class="tableActaBody">';
									foreach ($fecha_revision as $value_f ) {
										if ($value_f->id==$value->idAccion) {
											echo $value_f->fecha_1.'<br>';
											if(isset($value_f->fecha_2)){
												echo $value_f->fecha_2.'<br>';
											}
											if(isset($value_f->fecha_3)){
												echo $value_f->fecha_3.'<br>';
											}
										}
									}
								echo	'</td>
								<td class="tableActaBody">';
									foreach ($recursos as $key ) {
										if ($key->codigo==$value->idAccion) {
											echo $key->nombreRecurso.'<br>';
										}
									}
								echo	'</td>
									<td class="tableActaBody">'.$value->cargo.'</td>
								</tr>
                    			';
                    		}
                    		 ?>
	                    </table>
                        <br>
                        <?php 
                        if($conclusion==false){
                        	 $mostrar_barra='';
                        }else{
                        	$mostrar_barra='hidden';
                        } ?>
                        <div class="row <?php echo $mostrar_barra ?>"> 
                        	<div class="col-lg-12">
                        		<div class="col-lg-6">
                        			<center>
	                        			<label>Aprobado</label>
	                        			<br>
	                        			<input type="radio" name="aprobado" id="btn-aprobado">
                        			</center>
                        		</div>
                        		<div class="col-lg-6">
									<center>
	                        			<label>No aprobado</label>
	                        			<br>
	                        			<input type="radio" name="aprobado" id="btn-noAprobado">
                        			</center>
                        		</div>
                        	</div>
                        </div>
                        <div class="hidden" id="noAprobado">
                        	<div class="row">
                        		<div class="col-lg-12">
                        			<form action="<?php echo base_url();?>calidad/envioNoAprobado/<?php echo $contenidoaccion->id; ?>" method="POST" name="form_noAprobado" id="form_noAprobado">
                        				<center>
	                        			<label>Descripción No aprobado</label>
	                        			</center>
	                        			<br>
	                        			<input type="hidden" name="nombreProceso" value="<?php echo $contenidoaccion->proceso; ?>">
	                        			<input type="hidden" name="tipoAccion" id="tipoAccion" value="<?php echo $contenidoaccion->nombreTipo; ?>">
	                        			<input type="hidden" name="procesoId" id="procesoId" value="<?php echo $contenidoaccion->idProceso; ?>">
	                        			<input type="hidden" name="idAccion" id="idAccion" value="<?php echo $contenidoaccion->id; ?>">
	                        			<textarea name="text_noAprobado" id="text_noAprobado" class="form-control"></textarea>
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
                        		</div>
                        	</div>
                        </div>
                        <div id="aprobado">
	                        <form name="form_seguimiento" id="form_seguimiento" method="POST" action="<?php echo base_url() ?>calidad/addSeguimientoAccion">
                        	<input type="hidden" name="idProceso" id="idProceso" value="<?php echo $contenidoaccion->idProceso; ?>">
	                        <input type="hidden" name="idContenidoAccion" value="<?php echo $id; ?>">
	                        <input type="hidden" name="tipoAccion" id="tipoAccion" value="<?php echo $contenidoaccion->nombreTipo;?>">
	                        <table id="table_seguimiento" class="tableActa">
                        		<tr id="fila_seguimientoTitle_1" class="fila_seguimientoTitle">
	                        		<td colspan="4" class="tableActaBack">SEGUIMIENTO Y VERIFICACIÓN</td>
	                        	</tr>
	                        	<?php 
	                        	if($seguimiento!=false){
	                        	$index=1;
	                        		foreach ($seguimiento as $value_s) {
	                        			echo'
		                        	<tr id="fila_seguimientoSubtitle_'.$index.'" class="fila_seguimientoSubtitle">
		                        		<td class="tableIndicadorHead" width="15%"><center>Fecha</center></td>
		                        		<td class="tableIndicadorHead" width="50%"><center>Descripción de seguimiento</center></td>
		                        		<td class="tableIndicadorHead" width="10%"><center>Eficacia</center></td>
		                        		<td class="tableIndicadorHead" width="25%"><center>Cargo que verifica</center></td>
		                        	</tr>	
		                        	<tr id="fila_seguimientoC_'.$index.'" class="fila_seguimientoC">
		                        		<td class="tableActaBody"><input type="hidden" name="id_seguimiento['.$index.']" id="id_seguimiento_'.$index.'" value="'.$value_s->idSeguimiento.'">'.$value_s->fecha.'</td>
		                        		<td class="tableActaBody">'.$value_s->descripcion.'</td>
		                        		<td class="tableActaBody"><center>'.$value_s->eficacia.'</center></td>
		                        		<td class="tableActaBody">
		                        			'.$value_s->cargo.'
			                    		</td>
		                        	</tr>';
		                        	$index++;
	                        		}
	                        	echo '<input type="hidden" name="indexSeguimiento" id="indexSeguimiento" value="'.$index.'">';	
	                        	}else{
	                        		echo '<tr id="fila_seguimientoSubtitle_1" class="fila_seguimientoSubtitle">
							        		<td class="tableIndicadorHead" width="15%"><center>Fecha</center></td>
							        		<td class="tableIndicadorHead" width="50%"><center>Descripción de seguimiento</center></td>
							        		<td class="tableIndicadorHead" width="10%"><center>Eficacia</center></td>
							        		<td class="tableIndicadorHead" width="25%"><center>Cargo que verifica</center></td>
							        	</tr>
							        	<tr id="fila_seguimientoC_1" class="fila_seguimientoC">
							        		<td class="tableActaBody"><input type="date" name="fecha_seguimiento[1]" id="fecha_seguimiento_1" class="form-control"></td>
							        		<td class="tableActaBody"><textarea class="form-control" name="descripcionSeguimiento[1]" id="descripcionSeguimiento_1"></textarea></td>
							        		<td class="tableActaBody"><center><input value="SI" type="checkbox" name="eficacia[1]" id="eficacia"></center></td>
							        		<td class="tableActaBody">
							        			<select name="cargoV[1]" id="cargoV_1" class="form-control">';
							        	echo'		<option value="">Seleccione...</option>';
							        				foreach ($cargo as $value) {
							  	
							        	echo'		<option value="'.$value->id.'">'.$value->nombre.'</option>';
							        				}
							        	echo'
							        			</select>
							        		</td>
							        	</tr>';
	                        	echo '<input type="hidden" name="indexSeguimiento" id="indexSeguimiento" value="1">';
	                        	}
	                        ?>
	                        </table>
	                        <?php 
	                        if ($barra_superior) {
	                        	?>
	                        <br>
	            			<br>
	            			<div class="row">
	                            <div class="col-lg-12" id="contenedor_botonesS">
	                                <div class="row">
	                                    <div class="col-md-5">&nbsp;</div>
	                                    <div class="col-md-1"><input type="button" id="agregarA" class="btn btn-default" value="+" title="Agregar" onClick="agregarSeguimientoAccion(this.id,'<?php echo $base_url ?>');"></div>
	                                    <div class="col-md-1"><input type="button" id="removerA" class="btn btn-default" value="-" title="Remover" onClick="agregarSeguimientoAccion(this.id,'<?php echo $base_url ?>');"></div>
	                                    <div class="col-md-5">&nbsp;</div>
	                                </div>
	                            </div>
	                        </div>
	                        <br>
	                        <div id="loadingS" class="hidden">
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
	                        <?php 
	                        } ?>
	                        <br>
	                        <?php 
	                        if ($conclusion==false) {	
	                         ?>
	                        <table class="tableActa">
	                        	<tr>
	                        		<td class="tableActaBack">CONCLUSIÓN</td>
	                        		<td class="tableActaBack">NUMERAL DE LA NORMA AL QUE APLICA</td>
	                        	</tr>
	                        	<tr>
	                        		<td class="tableActaBody" width="65%"><textarea name="conclusion" id="conclusion" class="form-control" value="null"></textarea></td>
	                        		<td class="tableActaBody" width="35%">
	                        			<select name="norma" id="norma" class="form-control">
	                        				<?php 
	                        				foreach ($norma as $value_n) {
	                        					echo '<option value="'.$value_n->id.'">'.$value_n->nombre.'</option>';
	                        				}
	                        				 ?>
	                        			</select>
	                        			</td>
	                        	</tr>
	                        </table>
	                        <table class="tableActa">
	                        	<tr>
	                        		<td class="tableActaBack" rowspan="2">Fecha de cierre</td>
	                        		<td class="tableActaBody"><input type="date" name="fechaCierre" id="fechaCierre" class="form-control" value="<?php echo strftime( "%Y-%m-%d", time() ); ?>" readonly></td>
	                        		<td class="tableActaBack">Responsable de cierre</td>
	                        		<td class="tableActaBody">
	                        			<select name="responsable_cierre" id="responsable_cierre" class="form-control">
	                        				<option value="">Seleccione...</option>
	                        				<?php 
		                    				foreach ($cargo as $value) {
		                    					echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
		                    				}
		                    				 ?>	
		                    			</select></td>
	                        	</tr>
	                        	<tr>
	                        		<td class="tableActaBody"><b>Día/Mes/Año</b></td>
	                        		<td class="tableActaBack">Eficacia de acción</td>
	                        		<td class="tableActaBody"><center>SI &nbsp;<input type="radio" name="eficacia_accion" id="eficacia_accion" value="SI"> &nbsp;&nbsp;NO &nbsp;<input type="radio" name="eficacia_accion" id="eficacia_accion" value="NO"></center></td>
	                        	</tr>
	                        </table>
	                        <?php 
	                        }else{
	                        ?>
	                        <table class="tableActa">
	                        	<tr>
	                        		<td class="tableActaBack">CONCLUSIÓN</td>
	                        		<td class="tableActaBack">NUMERAL DE LA NORMA AL QUE APLICA</td>
	                        	</tr>
	                        	<tr>
	                        		<td class="tableActaBody" width="65%"><?php echo $conclusion->conclusion; ?></td>
	                        		<td class="tableActaBody" width="35%">
	                        			<?php 
	                    				foreach ($norma as $value_n) {
	                    					if($value_n->id==$conclusion->numeralNorma){
												echo $value_n->nombre;
	                    					}
	                    				}
	                    				 ?>
                    				</td>
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
	                        } ?>
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
	                    </div>
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
	<script type="text/javascript">
		$("#btn-aprobado").on("click", function (e) { 
			$('#noAprobado').addClass('hidden');
			$('#aprobado').removeClass('hidden');
    	}); 
    	$("#btn-noAprobado").on("click", function (e) { 
			$('#aprobado').addClass('hidden');
			$('#noAprobado').removeClass('hidden');
    	}); 
    	$('#form_noAprobado').submit(function(event){
    		if($('#text_noAprobado').val()=='' || $('#text_noAprobado').length==0){
				event.preventDefault();
				alert('El campo Descripción no aprobado es obligatorio');
    		}
    		
    	});
		 $('#form_seguimiento').submit(function(event){
		 	var fila=$('.fila_seguimientoC');
		 	var indexS=$('#indexSeguimiento').val();
		 	if(fila.length>(parseInt(indexS)-1)){
			 	for (var i = indexS; i <=(fila.length); i++) {
			 		if(validarCampoVacio('fecha_seguimiento_'+i,'Fecha de seguimiento')){
						event.preventDefault();
			 		}
			 		if(validarCampoVacio('descripcionSeguimiento_'+i,'Descripción de seguimiento')){
						event.preventDefault();
			 		}
			 		if(validarCampoVacio('cargoV_'+i,'Cargo que verifica')){
						event.preventDefault();
			 		}
			 	}
		 	}
		});
	</script>