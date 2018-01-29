    <div id="wrapper">
        <div id="page-wrapper">
        <br><br>
            <div class="row">
                <div class="col-lg-12">
	                <form action="<?php echo base_url();?>calidad/updateMision" method="POST" id="form_editar_mision" name="form_editar_mision">
	                	<input type="hidden" name="id" value="<?php echo $idMision; ?>">
	                  	<table class="table-bordered" style="margin-top:30px;">
			                    <tr>
			                        <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
			                        <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
			                        <td class="col-sm-4" ><b>Código:</b>
			                            <div style="width: 220px; height:1px;">
			                            </div>
			                            <center>
			                              <input type="text" class="form-control" name="codigoMision" id="codigoMision" value="<?php echo $mision->codigoMision; ?>" required>
			                            </center>  
									</div>
		                        </td>
		                    </tr>
		                    <tr>
		                        <td class="col-sm-4" >
		                            <b>Proceso:</b>
		                            <div style="width: 220px; height:20px;">
			                            <center>
			                            	<?php echo $mision->proceso; ?>
			                            </center>  
			                        </div>    
		                        </td>
		                    </tr>
		                    <tr>
		                        <td rowspan="2" class="col-sm-10" >
		                            <center><h5><b><?php echo $title; ?></b></h5></center>
		                        </td>
		                        <td class="col-sm-4">
		                            <b>Versión:</b>
		                            <center>
		                            <?php echo $mision->version; ?>
		                            </center>  
		                        </td>
		                    </tr>
		                    <tr>
		                        <td class="col-sm-4">
		                            <b>Fecha de vigencia:</b>
		                            <center>
		                            <?php echo date('d-m-Y', strtotime($mision->fechaVigencia));  ?>
		                            </center>  
		                        </td>
		                    </tr> 
		                    <tr>
		                        <td colspan="3">
		                            <div class="row">
		                            </br>
		                                <div class="cuadro">
		                                	<textarea name="text" id="text" rows="3" class="form-control" required><?php echo $mision->texto; ?></textarea> 
		                                </div>
		                            </br>               
		                            </div>
		                        </td>         
		                    </tr>
		                    <tr>
		                        <td style="height:40px;" colspan="3">
		                           &nbsp; 
		                        </td>
		                    </tr>
		                    <tr>
		                        <td colspan="3">
		                            <center><h4><b>Control de cambios</b></h4></center>        
		                        </td>
		                    </tr>
		                    <tr>
		                        <td>
		                            <center><b>Versión</b></center>
		                        </td>
		                        <td>
		                            <center><b>Descripcion de ajustes</b></center>
		                        </td>
		                        <td>
		                            <center><b>Fecha de Vigencia</b></center>
		                        </td>
		                    </tr>
		                    <?php 
		                    $version=0;
		                    foreach ($control as $value ) {
		                    ?>
		                    <tr>
		                        <td>
		                            &nbsp;
		                            <?php 
		                            $version=$value->version;
		                            echo $value->version;
		                             ?>
		                        </td>
		                        <td>
		                           &nbsp;<?php echo $value->desc; ?>
		                        </td>
		                        <td>
		                            &nbsp;<?php echo $value->fechaVigencia; ?>
		                        </td>   
		                    </tr>
		                    <?php  
		                    }
		                     ?> 
		                     <tr>
		                     	<td>
		                     		&nbsp; <?php echo ++$version;?>
		                     		<input type="hidden" name="version" value="<?php echo $version;?>">
		                     	</td>
		                     	<td>
		                     		<input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese descripción en caso de cambio" required>
		                     	</td>
		                     	<td>
		                     		<input type="date" id="date" name="fechaVigencia" value="<?php echo date("Y-m-d");?>" id="fechaVigencia" class="form-control" required>
		                     	</td>
		                     </tr>
		                     <tr>
		                         <td colspan="3">&nbsp;</td>
		                     </tr>
		                     </table>
		                     <table class="table-bordered">
		                     <tbody>
			                     <tr>
			                        <td>
			                        <center><b>Elaborado por:</b></center>     
			                        </td>
			                        <td>
			                            <center><b>Revisado por:</b></center>
			                        </td>
			                        <td>
			                            <center><b>Aprobado por:</b></center>
			                        </td>
			                    </tr>
			                    <tr>
			                         <td class="col-sm-2">
			                            <select class="form-control" name="elaborado" id="elaborado" required><?php 
			                            foreach ($users as $value) {
			                            	if ($value->id==$user) {
			                            		?>
			                            		<option value="<?php echo $value->id; ?>" selected><?php echo $value->nombre;?></option>
			                            	<?php } 
			                            	}?>	
			                            </select>
			                         </td>
			                         <td class="col-sm-2">
			                            <select class="form-control" name="revisado" id="revisado" required><?php 
			                            foreach ($users as $value) {
			                            		if ($value->id==$revisado->id) {
			                            		?>
			                            		<option value="<?php echo $value->id; ?>" selected><?php echo $value->nombre;?></option>
			                            	<?php } 
			                             ?>
			                            	<option value="<?php echo $value->id; ?>"><?php echo $value->nombre; ?></option>
			                            	<?php  } ?>
			                            </select>
			                         </td>
			                         <td class="col-sm-2">
			                            <select class="form-control" name="aprobado" id="aprobado" required><?php 
			                            foreach ($users as $value) {
			                            	if ($value->id==$revisado->id) {
			                            		?>
			                            		<option value="<?php echo $value->id; ?>" selected><?php echo $value->nombre;?></option>
			                            	<?php } 
			                             ?>

			                            	<option value="<?php echo $value->id;?>"><?php echo $value->nombre; ?></option>
			                            	<?php  } ?>
			                            </select>
			                         </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		<center><b>Fecha:</b></center>
			                    	</td>
			                    	<td>
			                    		<center><b>Fecha:</b></center>
			                    	</td>
			                    	<td>
			                    		<center><b>Fecha:</b></center>
			                    	</td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		<input class="form-control" type="date" id="fechaE" name="fechaE" value="<?php echo $elaborado->fechaRevision;?>" required>
			                    	</td>
			                    	<td>
			                    		<input class="form-control" type="date" id="fechaR" name="fechaR" value="<?php echo $revisado->fechaRevision; ?>" required>
			                    	</td>
			                    	<td>
			                    		<input class="form-control" type="date" id="fechaA" name="fechaA" value="<?php echo $aprobado->fechaRevision; ?>" required>
			                    	</td>
			                    </tr>
		                    </tbody>
	                  	</table>
	                  	<br>
		                <center>
		                <a href="<?php echo base_url();?>calidad/mision" class="btn btn-default">Cancelar</a>
		                <button type="button" onclick="validarCampo();" name="enviar" id="enviar" class="btn btn-default">Editar</button>
		                </center>
	                </form>  	
                  <br><br><br><br><br>
                </div>
            </div>
		</div>
	</div>	
<script type="text/javascript">
	function validarCampo(){
		if(validarCampoVacio('codigoMision','Código'))
		{
			return false;
		}
		if(validarCampoVacio('text','Misión'))
		{
			return false;
		}
		if(validarCampoVacio('desc','Descripcion de ajustes'))
		{
			return false;
		}
		if(validarCampoVacio('date','Fecha vigencia'))
		{
			return false;
		}
		if(validarCampoVacio('fechaE','Fecha E'))
		{
			return false;
		}
		if(validarCampoVacio('fechaR','Fecha R'))
		{
			return false;
		}
		if(validarCampoVacio('fechaA','Fecha A'))
		{
			return false;
		}
		document.form_editar_mision.submit();
	}
</script>
