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
		        <!-- /.row -->
		            <div class="row">
		                <div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                           	Procesos
		                            <div class="pull-right <?php echo $mostrar_barra; ?>">
		                            	<div class="btn-group">
		                            		<a href="<?php echo base_url() ?>calidad/buildSolicitudCambio" class="btn btn-default btn-xs dropdown-toggle">Crear</a>
		                            	</div>
		                            </div>
		                        </div>
		                        <!-- .panel-heading -->
		                        <div class="panel-body">
		                            <div class="panel-group" id="accordion">
									<?php
									$html='';
									$proceso='';
									foreach ($procesos as $value) {
									$html.='
		                                <div class="panel panel-default">
		                                    <div class="panel-heading">
		                                        <h4 class="panel-title">
		                                            <a class="panel-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$value->id.'">';
		                            $html.=                	$value->nombre; 
		                            $html.='                
		                                            </a>
		                                        </h4>
		                                    </div>
		                                    <div id="collapse_'.$value->id.'" class="panel-collapse collapse out">
		                                        <div class="panel-body">';
		                                        $res=FALSE;
		                                         $solicitud_res=false;
		                                        if($solicitud!=false){
												foreach ($solicitud as $value_s) {                   
		                                            if($value_s->codigoProceso==$value->id){
		                                            $solicitud_res=true;
		                            $proceso.=' <div class="row">             	
		                            				<div class="col-lg-12">
		                            					<div class="col-lg-10">
	                            						<i class="fa fa-file-text" aria-hidden="true"></i>
	                            						#'.$value_s->id.'
	                            							Solicitud de '.$value_s->tipo_solicitud.' - '.$value_s->nombreDocumento.'
	                            						</div>
	                            						<div class="col-lg-2">';
	                            					if($option==1){
	                            	$proceso.='			<div class="dropdown">
														    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Accion
														    <span class="caret"></span></button>
														    <ul class="dropdown-menu">';
							        $proceso.='					<li><a href="'.base_url().'calidad/verSolicitud/'.$value_s->id.'">Ver solicitud</a></li>';							
									$proceso.='					        
														        <li><a href="'.base_url().'calidad/buildSeguimientoSolicitudCambio/'.$value_s->id.'">Seguimiento</a></li>
														        <li><a href="#" class="eliminar" id="'.$value_s->id.'">Eliminar</a></li>';
									$proceso.='					       	
														    </ul>
														</div>';
	                            					}else{

        							$proceso.='			<a href="'.base_url().'calidad/verSolicitud/'.$value_s->id.'" class="btn btn-default">Ver solicitud</a>';
	                            					}	
	                            	$proceso.='			</div>	
	                            					</div>
	                            				</div>
	                            					';            	
		                                            }                                         
		                                        }
		                            if($solicitud_res==false){
		                            $html.='<b>No hay solicitudes disponibles</b>';	
		                                }
		                            $solicitud_res=false; 
		                            
		                                }else{
		                            $html.='<b>No hay solicitudes disponibles</b>';
		                                }
		                            $html.=$proceso;            
		                            $html.='    
		                            			</div>
		                                    </div>
		                                </div>';
		                                $proceso='';      
		                            } 
		                            echo $html;   
		                            ?>
		                            </div>
		                        </div>
		                        <!-- .panel-body -->
		                    </div>
		                    <!-- /.panel -->
		                </div>
		                <!-- /.col-lg-12 -->
		            </div>
		            <!-- /.row -->
                    <br>
                    <br>  
                </div>
            </div>
        </div>    
	</div>
	<script>
		$(".eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 
                 window.location="<?php echo base_url()."calidad/deleteSolicitud/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
             }
        });  
	</script>