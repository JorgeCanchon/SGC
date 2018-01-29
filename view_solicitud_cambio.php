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
        	 <br>
			<?php 
				foreach ($procesoUser as $value_u) {
					if($barra_superior && ($solicitud->codigoProceso==$value_u->id)){
					 ?>
		            <br>
		            <div style="padding: 2px;">
		                <div class="pull-right">
		                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/editSolicitudCambio/').$solicitud->id?> href="<?php echo $site_urll; ?>">
		                        <i class="ace-icon fa fa-arrow-right icon-on-right"><span class="fa-letra"> Editar</span></i> 
		                    </a> 
		                </div>
		            </div>
		            <br>
            <?php 
	            	}
	            }
             ?>
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
                                        echo $solicitud->codigoSolicitudInf;
                                      ?>
                                    </center>  
                                </td>
                            </tr>
                            <tr> 
                                <td class="col-sm-4">
                                    <b>Proceso:</b>
                                    <center>
                                    <?php 
                                        echo $solicitud->procesoInf;
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
                                        echo $solicitud->versionInf;
                                      ?>
                                    </center>  
                                </td>
                            </tr>
                            <tr>
                                <td class="col-sm-4">
                                    <b>Fecha de vigencia:</b>
                                    <center>
                                       <?php 
                                        echo $solicitud->fechaVigenciaInf;
                                      ?>
                                    </center>  
                                </td>
                            </tr> 
                        </table>
                    </form>
                    <br>
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
							<td class="tableActaBody" >
								<?php 
									echo $solicitud->nombre;
								 ?>
							</td>
							<td class="tableActaBack">
								Cargo
							</td>
							<td class="tableActaBody" >
								<?php 
									echo $solicitud->cargo;
								?>
							</td>
						</tr>
						<tr>
							<td class="tableActaBack" >
								Tipo de documento
							</td>
							<td class="tableActaBody" >
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
                        </tr>
                        <tr> 
							<td class="tableActaBack">
								Fecha de vigencia
							</td>
							<td class="tableActaBody">
								<?php 
									echo $solicitud->fechaVigencia;
								 ?>
							</td>
                            <td class="tableActaBack">
                                Estado
                            </td>
                            <td class="tableActaBody">
                                <?php 
                                    echo $solicitud->estado;
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
                    	if($seguimiento!=false){
                    	echo'
                    	<table class="tableActa">
                            <tr>
                                <td class="tableActaBack" colspan="6">
                                ELABORACIÓN
                                <input type="hidden" name="idSolicitud" id="idSolicitud" value="'.$solicitud->id.'">
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
                                   '.$seguimiento->elaboro.'
                                </td>
                                <td class="tableActaBack" width="16%">
                                    Cargo
                                </td>
                                <td class="tableActaBody" width="16%">
                                    '.$seguimiento->cargo_elaboro.'
                                </td>
                                <td class="tableActaBack" width="16%">
                                    Fecha
                                </td>
                                <td class="tableActaBody" width="16%">
                                    <center>'.$seguimiento->fechaElaboracion.'</center>
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
                                    '.$seguimiento->reviso.'   
                                </td>
                                <td class="tableActaBack" width="10%">
                                    Nombre
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->aprobo.' 
                                </td>
                            </tr>   
                            <tr>    
                                <td class="tableActaBack">
                                    Cargo
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->cargoReviso.'
                                </td>
                                <td class="tableActaBack">
                                    Cargo
                                </td>
                                <td class="tableActaBody">
                                     '.$seguimiento->cargoAprobo.'
                                </td>
                            </tr>   
                            <tr>  
                                <td class="tableActaBack">
                                    Fecha
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->fechaR.'
                                </td> 
                                <td class="tableActaBack">
                                    Fecha
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->fechaA.'
                                </td>
                            </tr>   
                            <tr>  
                                <td class="tableActaBack">
                                   Observación
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->observacionR.'
                                </td>
                                <td class="tableActaBack">
                                   Observación
                                </td>
                                <td class="tableActaBody">
                                    '.$seguimiento->observacionA.'
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
                                    <center>'.$seguimiento->fechaDivulgacion.'</center>
                                </td>
                                <td class="tableActaBody">
                                    <center>'.$seguimiento->tipo_divulgacion.'</center>
                                </td>
                                <td class="tableActaBody">
                                   <center>'.$seguimiento->fechaImplementacion.'</center>
                                </td>
                            </tr>
                        </table>
                        <br>
                    	';
                    	}
                    	else{ 
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
                        </table>';
                    	}?>
                   
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
        $('#form_inf').submit(function(e){
           if (!validarTodosCampos('form_inf', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        });
    </script>