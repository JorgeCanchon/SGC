    <?php 
    if (isset($barra_superior)) {
      	if ($barra_superior) {
          	$mostrar_barra='show';
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
                <table class="table table-bordered">
                    <tr>
                        <td class="col-sm-1" rowspan="2"><img class="img-responsive" src="<?php echo base_url();?>img/LOGO1.png"></td>
                        <td class="col-sm-10" ><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                    </tr>
                    <tr>
                        <td  rowspan="2" class="col-sm-10">
                            <center><h4><b><?php echo $title; ?></b></h4></center>
                        </td>
                    </tr>
                </table>
                <br>
                <div style="padding: 2px;" class="row">
                    <div class="col-lg-12">
                    	<div class="col-lg-3 <?php echo $mostrar_barra;?>">
                    		<a href="<?php echo base_url(); ?>calidad/buildPlanAccion" title="Crear plan de acción" class="btn btn-default">Crear nuevo plan</a> 
	                    </div>
	                    <div class="col-lg-6">&nbsp;</div> 
                    	<div class="col-lg-3">
                			<input type="button" id="btn_busqueda" class="btn btn-default" onclick="ver();" value="Busqueda Avanzada">
                    	</div>    
                    </div>
                </div>
                <br>
                <br>
                <div class="row hidden" id="busqueda" >
                	<form accept-charset="utf-8" id="form_busqueda" class="form-horizontal" name="form_busqueda" method="POST" action="<?php echo base_url().'calidad/planAccion' ?>">
	                	<div class="col-lg-12">
	                		<div class="col-lg-4">
	                		<label>Tipo acción</label>
		                		<select class="form-control" name="filtro[tipo_accion]" id="tipo_accion">
		                		<?php 
		                		foreach ($tipoAccion as $value) {
		                			if($value->id==1){
									echo  '<option value="">Seleccione...</option>';
		                			}else{
		                			echo  '<option value="'.$value->id.'">'.$value->nombre.'</option>';
		                			}
		                		}
		                		 ?>
		                		</select>
	                		</div>
	                		<div class="col-lg-4">
	                			<label>Proceso</label>
	                			<select name="filtro[id_proceso]" id="proceso" class="form-control">
								<?php 
									echo  '<option value="">Seleccione...</option>';
									foreach ($procesos as $value) {
									echo   '<option value="'.$value->id.'">'.$value->nombre.'</option>';
									}
								 ?>
								</select>
	                		</div>
	                		<div class="col-lg-4">
	                			<label>Fuente:</label>
	                			<select name="filtro[fuente]" id="fuente" class="form-control">
	                			<?php 
	                			echo  '<option value="">Seleccione...</option>';
									foreach ($fuente as $value) {
									echo   '<option value="'.$value->id.'">'.$value->nombre.'</option>';
									}
								 ?>	
	                			</select>
	                		</div>
	                		<div class="col-lg-12">
	                			&nbsp;
	                		</div>
							<div class="col-lg-4">
	            				<label>Desde:</label>
	            				<input type="date" name="filtro[fecha_inicial]" id="fechaI" class="form-control">
	            			</div>
	            			<div class="col-lg-4">
	            				<label>Hasta:</label>
	            				<input type="date" name="filtro[fecha_final]" id="fechaF" class="form-control">
	            			</div>
                            <div class="col-lg-4">
                                <label>Eficacia:</label>
                                <select name="filtro[eficacia]" id="fechaF" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
	                		<div class="col-lg-12">
	                			&nbsp;
	                		</div>
	                		<div class="col-lg-12">
	                			<center>
	                				<a href="<?php echo base_url().'calidad/planAccion' ?>" class="btn btn-default">Ver todas</a>
		                			<input type="submit" name="Buscar" class="btn btn-default" value="Filtrar">
		                		</center>
	                		</div>
	                	</div>
                	</form>
                </div>
                <table class="table" style="margin-top:30px;">
                    <thead style="background-color:rgb(51,122,183);color:#FFF;text-align: center;">
                        <tr>
                            <th>
                                Nº Acción
                            </th>
                            <th>
                                Fecha Hallazgo
                            </th>
                            <th>
                                Tipo Acción
                            </th>
                            <th>
                            	Proceso
                            </th>
                            <th>
                                Fuente Detección
                            </th>
                            <th width="12%">
                                Total filas:
                                <?php 
                                if($contenidoaccion!=false){
                                    echo count($contenidoaccion);
                                }else{
                                    echo '0';
                                } ?></th>
                        </tr>
                    </thead>
                    <tbody style="background-color: rgb(217,217,217);">
                        <?php 
                        if ($contenidoaccion!=FALSE) {
                            foreach ($contenidoaccion as $value) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $value->id; ?>
                            </td>
                            <td>
                                <?php echo $value->fechaHallazgo; ?>
                            </td>
                            <td>
                                <?php echo $value->nombreTipo; ?>
                            </td>
                            <td>
                                <?php echo $value->proceso; ?>
                            </td>
                            <td>
                                <?php 
                                    foreach ($relacionFuente as $valueF) {
                                        if ($valueF->codigoAccion==$value->id) {
                                            echo $valueF->nombreDeteccion.'<br>';
                                        }
                                    }
                                 ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Accion
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><?php     $site_urll = site_url('calidad/viewPlanAccion/').$value->id; ?><a href="<?php echo $site_urll; ?>">Ver</a></li>
                                        <?php 
                                        foreach ($procesosUsuario as $value_u) {
                                        if ($value_u->id==$value->idProceso) {
                                        ?>
                                        <li class="<?php echo $mostrar_barra;?>">
                                            <a href="#" id="<?php echo $value->id; ?>" class="eliminar">Eliminar</a>
                                        </li>
                                        <?php
                                            }
                                        }
                                         ?>
                                        
                                        <?php if ($seguimiento==1) {
                                            $site_urll = site_url('calidad/seguimientoPlanAccion/').$value->id;
                                            echo '<li><a href="'.$site_urll.'" id="'.$value->id.'">Seguimiento</a>
                                                </li>';
                                        } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }        
                        }else{  
                         ?>
                        <tr>
                            <td class="alert alert-danger" colspan="6">
                                No se encontraron resultados para la búsqueda
                            </td>
                        </tr>
                        <?php 
                        } ?>
                    </tbody>
                </table>
                <center><?=$this->pagination->create_links(); ?></center>
                <br>
                <br>  
            </div>
        </div>
    </div>    
</div>
<script>
	$('#form_busqueda').submit(function(){
		try{
			var fechaI=$('#fechaI').val();
			var fechaF=$('#fechaF').val();
			if ((fechaI=="" && fechaF=="")||(fechaI!="" && fechaF!="")) {
			}else{
                alert('Fechas no validas');
                return false;
            }
		}catch(err){
			return false;
		}
	});
    $(".eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivatePlanAccion/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
             }
    }); 
</script>