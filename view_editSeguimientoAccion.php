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
	                    			 ?></td>
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
                        <form name="form_seguimiento" id="form_seguimiento" method="POST" action="<?php echo base_url() ?>calidad/editSeguimientoAccion">
                        <input type="hidden" name="idContenidoAccion" value="<?php echo $id; ?>">
                        <table id="table_seguimiento" class="tableActa">
                        	<tr>
                        		<td colspan="4" class="tableActaBack">SEGUIMIENTO Y VERIFICACIÓN</td>
                        	</tr>
                        	<tr>
                        		<td class="tableIndicadorHead" width="15%"><center>Fecha</center></td>
                        		<td class="tableIndicadorHead" width="50%"><center>Descripción de seguimiento</center></td>
                        		<td class="tableIndicadorHead" width="10%"><center>Eficacia</center></td>
                        		<td class="tableIndicadorHead" width="25%"><center>Cargo que verifica</center></td>
                        	</tr>
                        	<?php 
                        	if($seguimiento!=false){
                        		$index=1;
                        		$checked='';
                        		foreach ($seguimiento as $value_s) {
                        			if ($value_s->eficacia=='SI') {
                        				$checked='checked';
                        			}
                        			echo'
	                        	<tr">
	                        		<td class="tableActaBody">
	                        		<input type="hidden" value="'.$value_s->idSeguimiento.'" name="idSeguimiento['.$index.']" id="idSeguimiento">
	                        		<input class="form-control" type="date" name="fecha_seguimiento['.$index.']" id="fecha_seguimiento_'.$index.'" value="'.$value_s->fecha.'">
	                        		</td>
	                        		<td class="tableActaBody"><textarea name="descripcionSeguimiento['.$index.']" id="descripcionSeguimiento_'.$index.'" class="form-control">'.$value_s->descripcion.'</textarea></td>
	                        		<td class="tableActaBody"><center><input type="checkbox" name="eficacia['.$index.']" id="eficacia'.$index.'" value="SI" '.$checked.'></center></td>
	                        		<td class="tableActaBody">
	                        			<select name="cargoV['.$index.']" id="cargoV_'.$index.'" class="form-control">';
										foreach ($cargo as $value_c) {
											if($value_c->id==$value_s->idCargo){
								echo 			'<option value="'.$value_c->id.'" selected>'.$value_c->nombre.'</option>';								
											}else{
								echo 			'<option value="'.$value_c->id.'">'.$value_c->nombre.'</option>';
											}
										}
	                        	echo'	</select>
		                    		</td>
	                        	</tr>';
	                        	$checked='';
	                        	$index++;
                        		}
                        		
                        	}else{
                        		echo'
								<tr>
									<td class="tableActaBody" colspan="4">
									<center>No hay seguimiento disponible</center>
									</td>
								</tr>
                        		';
                        	}
                        	?>
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
	<script type="text/javascript">
		$("#form_seguimiento").on('submit',(function(e) {
            if (!validarTodosCampos('form_seguimiento', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        }));
	autosize(document.querySelectorAll('textarea'));
	</script>