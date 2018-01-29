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