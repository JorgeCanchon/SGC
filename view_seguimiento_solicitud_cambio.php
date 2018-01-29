	<div id="wrapper">
        <div id="page-wrapper">   
            <br>
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
                                        echo '<input type="text" name="codigoAccion" id="codigoAccion" class="form-control" value="'.@$inf->codigo.'">';
                                        }else{
                                            if(empty($inf->codigo)){
                                                echo 'CRM-GQ-F-01'; 
                                            }else{
                                                echo $inf->codigo;
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
                                        <select name="idProceso" id="idProceso" class="form-control">';
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
                                            }else{
                                                echo $inf->nombreProceso;
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
                                            }else{
                                                echo $inf->version;
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
                                        echo '<input type="date" name="fechaV" id="fechaV" class="form-control" value="'.@$inf->fechaVigencia.'">';
                                        echo '<input type="submit" class="btn btn-default btn-xs dropdown-toggle">';
                                        }else{
                                            if(empty($inf->fechaVigencia)){
                                                echo strftime( "%Y-%m-%d", time() ); 
                                            }else{
                                                echo $inf->fechaVigencia;
                                            }
                                        }
                                      ?>
                                    </center>  
                                </td>
                            </tr> 
                        </table>
                    </form>
                    <table class="tableActa" id="tablePlanAccion">
                    	<tr>
                    		<td class="tableActaBack" colspan="8"><center>SOLICITUD</center></td>
                    	</tr>
				    	<tr>
							<td class="tableActaBack" rowspan="2" width="15%">Fecha</td>
							<td class="tableActaBody" rowspan="2" width="10%">
								<?php echo $solicitud->fechaSolicitud; ?>
							</td>
							<td class="tableActaBack" rowspan="2" width="8%">Tipo de solicitud</td>
							<?php 

								foreach ($tipo_solicitud as $value) {
									if($value->id==$solicitud->idTipo){
										echo  '<td class="tableActaBody"><center><input value="'.$value->id.'" type="radio" name="tipo_solicitud" id="tipo_solicitud" checked disabled/></center></td>';
									}else{
										echo  '<td class="tableActaBody"><center><input value="'.$value->id.'" type="radio" name="tipo_solicitud" id="tipo_solicitud" disabled /></center></td>';
									}
		                			
	                			}	
							?>
							<td class="tableActaBack" rowspan="2">Proceso</td>
							<td class="tableActaBody" rowspan="2">
								<?php 
								echo $solicitud->nombreProceso; ?>
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
								<?php 
									echo $solicitud->nombre;
								 ?>
							</td>
							<td class="tableActaBack">
								Cargo
							</td>
							<td class="tableActaBody" colspan="2">
								<?php 
									echo $solicitud->cargo;
								?>
							</td>
						</tr>
						<tr>
							<td class="tableActaBack" >
								Tipo de documento
							</td>
							<td class="tableActaBody" colspan="2">
								<?php 
									echo $solicitud->tipo_documento;
								 ?>
							</td>
							<td class="tableActaBack" >
								Nombre del documento
							</td>
							<td class="tableActaBody" colspan="2">
								<?php 
									echo $solicitud->nombreDocumento;
								 ?>
							</td>
						</tr>
						<tr>
							<td class="tableActaBack">
								Código del documento
							</td>
							<td class="tableActaBody">
								<?php 
									echo $solicitud->codigoDocumento;
								 ?>
							</td>
							<td class="tableActaBack">
								Versión
							</td>
							<td class="tableActaBody">
								<?php 
									echo $solicitud->version;
								 ?>
							</td>
							<td class="tableActaBack">
								Fecha de vigencia
							</td>
							<td class="tableActaBody">
								<?php 
									echo $solicitud->fechaVigencia;
								 ?>
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
                    			<?php 
									echo $solicitud->descripcion;
								 ?>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="tableActaBack" width="30%">
                    			Justificación de la solicitud
                    		</td>
                    		<td class="tableActaBody">
                    			<?php 
									echo $solicitud->justificacion;
								 ?>
                    		</td>
                    	</tr>
                    </table>
                    <br>
                    	<?php
                    	if($option==1){
                            echo'
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <center>
                                        <label for="realizada">Realizada</label>
                                        <input type="radio" name="opcion" id="btn-realizada">
                                        </center>
                                    </div>
                                    <div class="col-lg-6">
                                        <center>
                                        <label for="elaborar">Elaborar</label>
                                        <input type="radio" name="opcion" id="btn-elaborar">
                                        </center>
                                    </div>
                                </div>
                            </div>
                            ';
                    		echo'
                    <div class="hidden" id="div_elaborar">
                        <form action="'.base_url().'calidad/AddSeguimientoSolicitudCambio" method="POST" name="form_seguimiento_cambio" id="form_seguimiento_cambio">
                            <table class="tableActa">
		                    	<tr>
									<td class="tableActaBack" colspan="6">
									ELABORACIÓN
                                    <input type="hidden" name="idSolicitud" id="idSolicitud" value="'.$idSolicitud.'">
                                    <input type="hidden" name="idProceso" id="idProceso" value="'.$solicitud->codigoProceso.'">
                                    <input type="hidden" name="nombreProceso" id="nombreProceso" value="'.$solicitud->nombreProceso.'">
                                    <input type="hidden" name="tipo_solicitud" id="tipo_solicitud" value="'.$solicitud->tipo_solicitud.'">
									</td>
		                    	</tr>
		                    	<tr>
									<td class="tableActaBack" width="16%">
                                        Nombre
                                    </td>
                                    <td class="tableActaBody" width="16%">
                                        <select name="elaboro" id="elaboro" class="form-control">';
                                        foreach ($users as $value_u) {
                                            if ($value_u->id==$id_usuario) {
                                                echo '<option value="'.$value_u->id.'">'.$value_u->nombre.'</option>';
                                            }
                                        }
                            echo'            </select>
                                    </td>
                                    <td class="tableActaBack" width="16%">
                                        Cargo
                                    </td>
                                    <td class="tableActaBody" width="16%">
                                        <select name="cargo_e" id="cargo_e" class="form-control">';
                                        foreach ($users as $value_u) {
                                            foreach ($cargo as $value_cargo) {
                                                if ($value_cargo->id==$value_u->codigoCargo &&  $value_u->id==$id_usuario) {
                                                    echo '<option value="'.$value_cargo->id.'">'.$value_cargo->nombre.'</option>';
                                                }
                                            }
                                        }
                            echo'       </select>
                                    </td>
                                    <td class="tableActaBack" width="16%">
                                        Fecha
                                    </td>
                                    <td class="tableActaBody" width="16%">
                                        <input type="date" name="fecha_e" id="fecha_e" class="form-control" value="'.strftime( "%Y-%m-%d", time() ).'">
                                    </td>
		                    	</tr>
                            </table> 
                            <br> 
                            <table class="tableActa">
                                <tr>
                                    <td class="tableActaBack" colspan="8">
                                        REVISIÓN Y APROBACIÓN
                                    </td>
                                </tr>  
                                <tr>
                                    <td class="tableActaBack" colspan="2" width="50%">
                                        Revisión (Dueño del proceso)
                                    </td>
                                    <td class="tableActaBack" colspan="2" width="50%">
                                        Aprobación(Representante de Dirección)
                                    </td>
                                </tr> 
                                <tr>
                                    <td class="tableActaBack" width="10%">
                                        Nombre
                                    </td>
                                    <td class="tableActaBody">
                                        <select name="nombre_r" id="nombre_r" class="form-control" onchange="getCargo(this.value,this.id)">
                                            <option value="">Seleccione...</option>';
                                        foreach ($users as $value_u) {
                                                echo '<option value="'.$value_u->id.'">'.$value_u->nombre.'</option>';
                                        }
                            echo'      </select>      
                                    </td>
                                    <td class="tableActaBack" width="10%">
                                        Nombre
                                    </td>
                                    <td class="tableActaBody">
                                        <select name="nombre_a" id="nombre_a" class="form-control" onchange="getCargo(this.value,this.id)" >
                                            <option value="">Seleccione...</option>';
                                        foreach ($users as $value_u) {
                                                echo '<option value="'.$value_u->id.'">'.$value_u->nombre.'</option>';
                                        }
                            echo'      </select> 
                                    </td>
                                </tr>   
                                <tr>    
                                    <td class="tableActaBack">
                                        Cargo
                                    </td>
                                    <td class="tableActaBody">
                                        <select name="cargo_r" id="cargo_r" class="form-control" disabled> 
                                            <option value="">Seleccione...</option>';
                                            foreach ($cargo as $value_cargo) {
                                                echo '<option value="'.$value_cargo->id.'">'.$value_cargo->nombre.'</option>';
                                            }
                            echo'                
                                        </select>
                                    </td>
                                    <td class="tableActaBack">
                                        Cargo
                                    </td>
                                    <td class="tableActaBody">
                                        <select name="cargo_a" id="cargo_a" class="form-control" disabled>
                                            <option value="">Seleccione...</option>';
                                            foreach ($cargo as $value_cargo) {
                                                echo '<option value="'.$value_cargo->id.'">'.$value_cargo->nombre.'</option>';
                                            }
                            echo'                
                                        </select>
                                    </td>
                                </tr>   
                                <tr>  
                                    <td class="tableActaBack">
                                        Fecha
                                    </td>
                                    <td class="tableActaBody">
                                        <input type="date" name="fecha_r" id="fecha_r" class="form-control">
                                    </td> 
                                    <td class="tableActaBack">
                                        Fecha
                                    </td>
                                    <td class="tableActaBody">
                                        <input type="date" name="fecha_a" id="fecha_a" class="form-control">
                                    </td>
                                </tr>   
                                <tr>  
                                    <td class="tableActaBack">
                                       Observación
                                    </td>
                                    <td class="tableActaBody">
                                        <textarea name="observacion_r" id="observacion_r" class="form-control"></textarea>
                                    </td>
                                    <td class="tableActaBack">
                                       Observación
                                    </td>
                                    <td class="tableActaBody">
                                        <textarea name="observacion_a" id="observacion_a" class="form-control"></textarea>
                                    </td>
                                </tr>
                            </table>  
                            <br>
                            <table class="tableActa">
                                <tr>
                                    <td class="tableActaBack" colspan="3">
                                        DIVULGACIÓN
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tableActaBack">
                                        Fecha de divulgación 
                                    </td>
                                    <td class="tableActaBack">
                                        Tipo de divulgación    
                                    </td>
                                    <td class="tableActaBack">
                                        Fecha de implementación    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tableActaBody">
                                        <input type="date" name="fecha_divulgacion" id="fecha_divulgacion" class="form-control">
                                    </td>
                                    <td class="tableActaBody">
                                        <select name="tipoDivulgacion" id="tipoDivulgacion" class="form-control">
                                            <option value="">Seleccione...</option>';
                                            foreach ($tipoDivulgacion as $value_t) {
                                                echo '<option value="'.$value_t->id.'">'.$value_t->nombre.'</option>';
                                            }
                    echo'                        
                                        </select>
                                    </td>
                                    <td class="tableActaBody">
                                        <input type="date" name="fecha_implementacion" id="fecha_implementacion" class="form-control">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <input class="btn btn-default" type="reset" value="Limpiar">
                                        <button type="submit" name="enviar" id="enviar" value="enviar" class="btn btn-default">Agregar</button>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>   
                    <div class="hidden" id="div_realizada">
                    <form action="http://localhost/SGC/calidad/envioCambioRealizado/'.$solicitud->id.'" method="POST" name="form_noAprobado" id="form_noAprobado">
                        <center>
                        <label>Descripción cambio realizado</label>
                        </center>
                        <br>
                        <input type="hidden" name="nombreProceso" value="Diseño y Desarrollo">
                        <input type="hidden" name="tipoAccion" id="tipoAccion" value="Mejora">
                        <input type="hidden" name="procesoId" id="procesoId" value="11">
                        <input type="hidden" name="idAccion" id="idAccion" value="10">
                        <textarea name="text_noAprobado" id="text_noAprobado" class="form-control" required></textarea>
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
	                    	';
                    	}else{ 
                    	echo '
                        <table class="tableActa">
                    		<tr>
                    			<td class="tableActaBack">
									ELABORACIÓN
                    			</td>
                    		</tr>
                    		<tr>	
                    			<td class="tableActaBody">
                    				<center>No hay seguimiento disponible</center>
                    			</td>
                    		</tr>
                        </table>
                            ';
                    	}?>
                    </table>
                    <br>
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
	<script>
        $("#btn-realizada").on("click", function (e) { 
            $('#div_elaborar').addClass('hidden');
            $('#div_realizada').removeClass('hidden');
        }); 
        $("#btn-elaborar").on("click", function (e) { 
            $('#div_realizada').addClass('hidden');
            $('#div_elaborar').removeClass('hidden');
        }); 
        function getCargo(id_usuario,id){
            var url='<?php  echo $base_url; ?>';
            var ubicacion=url+'calidad/getCargoUsuario';
            var id_usuario=parseInt(id_usuario);
            if(id=='nombre_r'){id='cargo_r';}else {id='cargo_a';}
                var envio = $.post(ubicacion,{ id_usuario : id_usuario}, function(data) { 
                    $("#"+id).val(data);          
                }); 
        }
       $("#form_seguimiento_cambio").on('submit',(function(e) {
            if (!validarTodosCampos('form_seguimiento_cambio', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        })); 
        $("#form_seguimiento_cambioE").on('submit',(function(e) {
            if (!validarTodosCampos('form_seguimiento_cambioE', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        })); 	
	</script>