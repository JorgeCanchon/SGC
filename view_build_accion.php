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
                	<form action="<?php echo base_url() ?>calidad/editInfPlanAccion" method="POST" name="form_inf" id="form_inf">
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
					                    echo '<input type="text" name="codigoAccion" id="codigoAccion" class="form-control" value="'.@$inf->codigo.'">';
					                    }else{
					                        if(empty($inf->codigo)){
					                            echo 'CRM-GQ-09'; 
					                        echo '<input type="hidden" name="codigoAccion" id="codigoAccion" class="form-control" value="CRM-GQ-09">';
					                        }else{
					                            echo $inf->codigo;
					                            echo '<input type="hidden" name="codigoAccion" id="codigoAccion" class="form-control" value="'.$inf->codigo.'">';
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
					                    echo '<input type="text" name="version" id="version" class="form-control" value="'.@$inf->version.'">';
					                    }else{
					                        if(empty($inf->version)){
					                            echo '1'; 
					                            echo '<input type="hidden" name="version" id="version" value="1">';
					                        }else{
					                            echo $inf->version;
					                            echo '<input type="hidden" name="version" id="version" value="'.$inf->version.'">';
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
					                    echo '<input type="date" name="fechaVigencia" id="fechaVigencia" class="form-control" value="'.@$inf->fechaVigencia.'">';
					                    echo '<input type="submit" class="btn btn-default btn-xs dropdown-toggle" value="enviar">';
					                    }else{
					                        if(empty($inf->fechaVigencia)){
					                            echo strftime( "%d-%m-%Y", time() ); 
					                           echo '<input type="hidden" name="fechaVigencia" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
					                        }else{
					                            echo date('d-m-Y', strtotime($inf->fechaVigencia));
					                            echo '<input type="hidden" name="fechaVigencia" value="'.$inf->fechaVigencia.'" class="form-control">';
					                        }
					                    }
					                  ?>
					                </center>  
					            </td>
					        </tr> 
					    </table>
					</form>
                	<form method="POST" action="<?php echo base_url(); ?>calidad/addPlanAccion" id="form_planAccion" name="form_planAccion">
                		<?php
                		//------------------------------------------------
                            if(empty($inf->codigo)){; 
                            echo '<input type="hidden" name="codigoAccion" id="codigoAccion" class="form-control" value="CRM-GQ-09">';
                            }else{
                                echo '<input type="hidden" name="codigoAccion" id="codigoAccion" class="form-control" value="'.$inf->codigo.'">';
                            }
                        //-------------------------------------
                        if(empty($inf->nombreProceso)){
                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="8">';
                        }else{
                            echo '<input type="hidden" name="codigoProcesoInf" id="codigoProcesoInf" value="'.$inf->idProceso.'">';
                        }
                        //-------------------------------------------------
                        if(empty($inf->version)){
                            echo '<input type="hidden" name="version" id="version" value="1">';
                        }else{
                            echo '<input type="hidden" name="version" id="version" value="'.$inf->version.'">';
                        }
                        //--------------------------------------------------------
                        if(empty($inf->fechaVigencia)){
                           echo '<input type="hidden" name="fechaVigencia" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
                        }else{
                            echo '<input type="hidden" name="fechaVigencia" value="'.$inf->fechaVigencia.'" class="form-control">';
                        }
                        //----------------------------------------------------------------
                       ?>
	                    <br>
	                    <table class="tableActa" id="tablePlanAccion">
					    	<tr>
								<td class="tableActaBack" rowspan="2" width="15%">FECHA DE HALLAZGO</td>
								<td class="tableActaBody" rowspan="2" width="10%"><input type="date" value="" name="fechaHallazgo" id="fechaHallazgo" class="form-control"></td>
								<td class="tableActaBack" rowspan="2" width="8%">TIPO ACCIÓN</td>
								<?php 
								foreach ($tipoAccion as $value) {
		                			if($value->id==1){

		                			}else{
		                			echo  '<td class="tableActaBody"><center><input value="'.$value->id.'" type="radio"  onchange="sincronizarTipo(this)" name="tipoAccion" id="tipoAccion" /></center></td>';
		                			}
	                			}	
								?>
								<td class="tableActaBack">PROCESO</td>
								<td class="tableActaBody">
									<select name="proceso" class="form-control" onchange="sincronizarProceso(this.value,this.options[this.selectedIndex].text);">
									<option value="">Seleccione...</option>
									<?php 
										foreach ($procesoUser as $value) {
										echo   '<option value="'.$value->id.'">'.$value->nombreProceso.'</option>';
										}
									 ?>
									</select>
								</td>
							</tr>
							<tr>
								<?php 
								foreach ($tipoAccion as $value) {
		                			if($value->id==1){

		                			}else{
		                			echo  '<td class="tableActaBody">'.$value->nombre.'</td>
		                					<div class="hidden"><input type="radio" name="nombreTipoN" id="'.$value->id.'" value="'.$value->nombre.'"></div>';
		                			}
	                			}	
								?>
								
								<td class="tableActaBack">Nº ACCIÓN</td>
								<td class="tableActaBody">
									<center>
									<?php 
									$id=0;
									if($contenidoaccion!=false){
										foreach ($contenidoaccion as $value) {
											$id=$value->id;
										}
									}
										
										echo ($id+1);
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
	                    							echo $value->nombre.'&nbsp;<input  type="checkbox" name="fuenteD[]" id="fuenteD_'.$index.'" value="'.$value->id.'"><br>';
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
	                    							echo $value->nombre.'&nbsp;<input type="checkbox" name="fuenteD[]" id="fuenteD_'.$index.'" value="'.$value->id.'"><br>';
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
	                    					echo ' <label>'.$value->nombre.'</label> <input type="checkbox" name="causa[]" id="causa_'.$index++.'" value="'.$value->id.'"> ';
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
	                    		<td class="tableActaBody" rowspan="4"><textarea class="form-control" name="descripcionHallazgo" id="descripcionHallazgo"></textarea></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Primer Por Qué</center></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="primer" id="primer"></textarea></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="frecuenciaPrimer" id="frecuenciaPrimer"></textarea></td>
	                    		<td class="tableActaBody" rowspan="4"><textarea class="form-control" name="causaRaiz" id="causaRaiz"></textarea></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Segundo Por Qué</center></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="segundo" id="segundo"></textarea></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="frecuenciaSegundo" id="frecuenciaSegundo"></textarea></td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody"><center>Tercer Por Qué</center></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="tercer" id="tercer"></textarea></td>
	                    		<td class="tableActaBody"><textarea class="form-control" name="frecuenciaTercer" id="frecuenciaTercer"></textarea></td>
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
	                    		<td class="tableActaBody">
	                    			<textarea class="form-control" name="beneficio_consecuencia" id="beneficio_consecuencia"></textarea>
	                    		</td>
	                    	</tr>
	                    </table>
	                    <br>
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
	                    			echo '<input type="hidden" name="indexCorreccion" id="indexCorreccion" value="'.$index++.'">';
	                    		}
	                    		 ?>
	                    	</tr>
	                    </table>
	                    <table class="tableActa">
	                    	<tr>
	                    		<td class="tableActaBack" colspan="2">
	                    			DESCRIPCIÓN
	                    		</td>
	                    	</tr>
	                    	<tr>	
	                    		<td class="tableActaBody" colspan="2">
	                    			<textarea class="form-control" name="descripcion" id="descripcion"></textarea>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td class="tableActaBody" width="50%">
	                    			<b>PROCESO A CORREGIR:</b>
	                    			<select name="proceso_corregir" id="proceso_corregir" class="form-control" disabled>
	                    				<option value="">Seleccione...</option>
	                    				<?php 
	                    				foreach ($procesoUser as $value) {
										echo   '<option value="'.$value->id.'">'.$value->nombreProceso.'</option>';
										}
	                    				 ?>
	                    			</select>
	                    			<input type="hidden" name="procesoN" id="procesoN" value="">
	                    		</td>
	                    		<td class="tableActaBody" width="50%">
	                    			<b>RESPONSABLE:</b>
	                    			<select name="responsable_corregir" id="responsable_corregir" class="form-control">
	                    				<option value="">Seleccione...</option>
	                    				<?php 
	                    				foreach ($cargo as $value) {
	                    					echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
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
	                    	<tr id="fila_accion_1" class="fila_accion">
	                    		<td class="tableIndicadorHead"><center>Actividades a desarrollar</center></td>
	                    		<td class="tableIndicadorHead"><center>Fecha de ejecución</center></td>
	                    		<td class="tableIndicadorHead"><center>Fecha de revisión</center></td>
	                    		<td class="tableIndicadorHead"><center>Recursos</center></td>
	                    		<td class="tableIndicadorHead"><center>Responsable</center></td>
	                    	</tr>
	                    	<tr id="fila_accionContenido_1" class="fila_accionContenido">
	                    		<td class="tableActaBody">
	                    			<textarea class="form-control" name="actividad_desarrollar[1]" id="actividad_desarrollar"></textarea>
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<input type="date" class="form-control" name="fecha_ejecucion[1]" id="fecha_ejecucion">
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<input type="date" class="form-control" name="fecha_revision_1[1]" id="fecha_revision_1_1" required/>
	                    			<div id="div_fecha_revision_2_1">
	                    				<input type="button" class="form-control" name="fecha_revision_2[1]" id="fecha_revision_2_1" onClick="addInputDateRevision(this.name,this.id,1);" value="Agregar">
	                    			</div>
	                    			<div id="div_fecha_revision_3_1">
	                    				<input type="button" class="form-control" name="fecha_revision_3[1]" id="fecha_revision_3_1" onClick="addInputDateRevision(this.name,this.id,1);" value="Agregar" disabled>
	                    			</div>
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<select name="recurso_1[]" id="recurso" class="form-control" multiple="true">
	                    				<?php
	                    				foreach ($recurso as $value) {
	                    					echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
	                    				}
	                    				 ?>	
	                    			</select>
	                    		</td>
	                    		<td class="tableActaBody">
	                    			<select name="responsable_seguimiento[1]" id="responsable_seguimiento" class="form-control">
										<option value="">Seleccione...</option>
	                    				<?php 
	                    				foreach ($cargo as $value) {
	                    					echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
	                    				}
	                    				 ?>	
	                    			</select>
	                    		</td>
	                    	</tr>
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
        $('#form_inf').submit(function(e){
	       if (!validarTodosCampos('form_inf', 'Todos los campos deben estar llenos')) {
	           e.preventDefault();
	        }
	    });

      	function sincronizarProceso(value,text) {
        	document.getElementById('proceso_corregir').value=value;
        	document.getElementById('procesoN').value=text;
        }
        function sincronizarTipo(e){
        	var id=e.value;
        	$('#'+parseInt(id)).prop('checked', true);
        }
        $('#form_planAccion').submit(function(event){
        	if (!validarTodosCampos('form_planAccion', 'Todos los campos deben estar llenos')) {
        	 	event.preventDefault();
        	}
        	if(!$("#form_planAccion input[name='tipoAccion']:radio").is(':checked')) {  
        		alert("Seleccione un tipo de accion"); 
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
    </script>