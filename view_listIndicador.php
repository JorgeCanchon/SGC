<?php 
	$barra_superiorI=FALSE;
	if (isset($barra_superior)) {
      	if ($barra_superior) {
	        $mostrar_barra=' ';
	        if($procesosUsuario!=FALSE){
	            foreach ($procesosUsuario as $valueU) { 
		            if($list!=false){ 
		            	foreach ($list as $value) {                                                      
			                if($valueU->id==$value->idPF){
			                    $barra_superiorI=TRUE;
			                }
		            	}
		            }   
	            }
        	}  
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
                <table style="margin-top:30px;">
                    <tr>
                        <td class="col-sm-1" rowspan="3"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                        <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</h4></center></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td colspan="2"><center><h4><b><?php echo $title; ?></b></h4></center></td>
                    </tr>
                </table>
                <br>
                <br>  
                <div class="col-lg-12">
                	<div class="row">
                		<div class="panel panel-default">
	                        <div class="panel-heading">
	                            <i class="fa fa-list"></i> Lista medicion indicadores
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                            <div>
	                            	<?php 
	                            	if($list!=false){
		                            	foreach($list as $value){
		                            		$index=0;
		                            		$fecha1='';
		                            		$fecha2='';
		                            		foreach ($comportamiento as $key ) {
		                            			if($value->id==$key->codigoFichaIndicador){
		                            				if($index==0){
		                            					$fecha1=$key->fechaMedicion;
		                            				}
		                            				$fecha2=$key->fechaMedicion;
		                            				$index++;
		                            			}
		                            		}
		                            	echo'
		                            		<div class="row">
		                            			<div class="col-lg-12">
		                            				<div class="col-lg-10">
														<center><label>Medición indicador intervalo '. $fecha1 .'/'. $fecha2 .' 
														</label></center>
		                            				</div>
				                            		<div class="col-lg-2">	
				                            			<div class="dropdown">
														    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Accion
														    <span class="caret"></span></button>
													    <ul class="dropdown-menu">';
										echo'				<li><a href="'.base_url().'calidad/verMedicion/'.$value->id.'">Ver</a></li>';
														    if($barra_superior&&$barra_superiorI){
														    	if($option==1){
										echo '				<li>
															    <a href="'.base_url().'calidad/buildSeguimientoMedicion/'.$value->id.'" >Seguimiento</a>
															</li>';				    		
														    	}
										echo'					        
															<li>
															    <a href="#" id="'.$value->id.'" name="eliminar" class="botonE">Eliminar</a>
															</li>';
															}
										echo'					       	
														</ul>
														</div>
													</div>
												</div>
											</div><hr>';
		                            	}
	                            	}else{
		                            		echo'<div class="row">
			                            			<div class="col-lg-12">
			                            				<div class="col-lg-10">
															<center><label>No se encontraron resultados para la busqueda</label></center>
			                            				</div>
			                            			</div>
			                            		</div>		
			                            		';
		                            	}
	                            	 ?>
	                            </div>
	                            <br>
	                            <br>
	                            <center>
	                            	<a href="<?php echo $retorno ?>" class="btn btn-default">Volver</a>
	                            </center>
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
                	</div>
                </div>
            </div>        
        </div>
    </div>
</div>            
<script type="text/javascript">
 $(".botonE").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivateMedicion/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
             }
        });    	
</script>