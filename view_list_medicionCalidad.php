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
		                            <h4>Procesos</h4>
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
		                                        $resFicha=FALSE;
		                                        foreach ($indicador as $valueI) {
		                                        	if(is_array($fichaIndicador)){
														foreach ($fichaIndicador as $valueFicha){
			                                        		if($valueFicha->idIndicador==$valueI->idIndicador){
			                                        			$resFicha=TRUE;
			                                        		}    
			                                        	}
		                                        	}else{
		                                        		if($fichaIndicador->idIndicador==$valueI->idIndicador){
			                                        			$resFicha=TRUE;
			                                        		} 
		                                        	}
		                                        		                                        
		                                            if($valueI->codigoProceso==$value->id){
		                            $proceso.=' <div class="row">             	
		                            				<div class="col-lg-12">
		                            					<div class="col-lg-10">
	                            						<i class="fa fa-line-chart" aria-hidden="true"></i>
	                            							'.$valueI->nombreIndicador.'
	                            						</div>
	                            						<div class="col-lg-2">';
	                            						if($procesosUsuario!=FALSE){
			                            					foreach ($procesosUsuario as $valueU) {               						
			                            						if($valueU->id==$value->id){
			                            							$res=TRUE;
			                            						}
			                            					}
		                            					}
	                            					if($res){
	                            	$proceso.='			<div class="dropdown">
														    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Accion
														    <span class="caret"></span></button>
														    <ul class="dropdown-menu">';
															if($resFicha){    
							        $proceso.='					<li><a href="'.base_url().'calidad/verListMedicion/'.$valueI->idIndicador.'">Ver mediciones</a></li>';
															}else{
									$proceso.='					<li><a href="'.base_url().'calidad/medicionCalidad">No hay medición disponible</a></li>';
															}
															if (isset($barra_superior)) {
      															if ($barra_superior) {									
									$proceso.='					        
														        <li><a href="'.base_url().'calidad/buildMedicionIndicador/'.$valueI->idIndicador.'">Crear</a></li>';
																}
															}	
									$proceso.='					       	
														    </ul>
														</div>';
	                            					}else{
	                            						if($resFicha){
        							$proceso.='				<a href="'.base_url().'calidad/verListMedicion/'.$valueI->idIndicador.'" class="btn btn-default">Ver mediciones</a>';
	                            						}else{
									$proceso.='				<label>No hay medición disponible</label>';
	                            						}
	                            					}
	                            						
	                            	$proceso.='			</div>	
	                            					</div>
	                            				</div>
	                            					';                 	
		                                            }$resFicha=FALSE;
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