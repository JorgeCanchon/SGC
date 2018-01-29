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
            <div style="padding: 2px;" class="<?php echo $mostrar_barra;?>">
                <div class="pull-right">
                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/editDOFA/').$dofa->idDOFA?> href="<?php echo $site_urll; ?>">
                        <i class="ace-icon fa fa-arrow-right icon-on-right"><span class="fa-letra"> Editar</span></i> 
                    </a> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table-bordered" id="table" style="margin-top:30px;">
                    <tbody>
                        <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                  <?php echo $dofa->codigoDOFA; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                  <?php echo $dofa->proceso; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td  rowspan="2" class="col-sm-10">
                                <center><h4><b><?php echo $title; ?></b></h4></center>
                            </td>
                            <td class="col-sm-4" >
                                <b>Versión:</b>
                                <center>
                                  <?php echo $dofa->version; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Fecha de vigencia:</b>
                                <center>
                                  <?php echo date('d-m-Y', strtotime($dofa->fechaVigencia)); ?>
                                </center>  
                            </td>
                        </tr>
                  </table>
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <b>FECHA DE IDENTIFICACIÓN:</b>
                                    &nbsp;<?php echo $dofa->fechaIdentificacion; ?>
                            </td>
                            <td colspan="2">
                                <b>RESPONSABLE(S):</b>
                                &nbsp;
                                    <?php 
                                    $stringName='';
                                    foreach ($responsable as $value) {
                                        $stringName.=$value->nombre.'-';
                                    }
                                    echo  trim($stringName, '-');
                                    ?>
                            </td>
                        </tr> 
                        <tr> <!--Esta oración se colocó de esta manera
        por que tiene el estilo white-space: pre;-->
                            <td rowspan="<?php echo count($factorI)+1;?>">
        <div class="verticalText" id="textV">  
            A
            N
            Á
            L
            I
            S
            I
            S

            I
            N
            T
            E
            R
            N
            O
        </div> 
<div class="verticalText" id="textVe">              
A    
N
Á
L
I
S
I
S

E
X
T
E
R
N
O 
</div>                           
                            </td>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;width:15%;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                FORTALEZAS(F)
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                DEBILIDADES(D)
                            </td>
                        </tr>   
                        
                        <?php 
                            foreach ($factorI  as $value) {

                        ?>
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;">
                                <?php echo $value->factor; ?>
                            </td>
                            <td style="text-align:justify;">
                                <?php echo $value->fortaleza;
                                ?>  
                            </td>
                            <td style="text-align:justify;">
                                <?php 
                                    echo $value->debilidad;
                                ?> 
                            </td>
                           
                        </tr> 
                        <?php     
                            }
                         ?> 
                        </tbody>
                        </table>
                        <table class="table table-bordered"> 
                        <tr>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                OPORTUNIDADES (O)
                            </td>
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS FO(OFENSIVAS)
                            </td> 
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS DO(REORIENTACIÓN)
                            </td>   
                        </tr> 
                        <?php 
                        $ofensivas=null;
                        $reorientacion=null;
                        $index=1;
                            foreach ($factorE  as $value) {
                        ?>
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;width:20%">
                             </br></br></br>
                                <?php echo $value->factor; ?>
                            </td>
                            <td style="text-align:justify;width:30%; "> 
                                <?php echo $value->oportunidad;?>
                            </td>
                            <?php if (isset($ofensivas) && isset($reorientacion)){
                                $index++;  
                            }else{
                                $ofensivas=$value->ofensivas;
                                $reorientacion=$value->reorientacion;
                            ?>
                            <td style="text-align:justify;margin-top:50px;width:25%; " id="fo">
                                <?php echo $ofensivas;?>
                            </td>
                            <td style="text-align:justify;width:25%" id="do">
                                <?php echo $reorientacion; ?>
                            </td>
                            <?php
                                } 
                            }
                             ?>
                        <input type="hidden" id="index" value="<?php echo $index;?>">
                        </tr>
                        </table>
                        <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                AMENAZA (A)
                            </td>
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS FA(DEFENSIVAS)
                            </td> 
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;">
                                ESTRATÉGIAS DA(SUPERVIVENCIA)
                            </td>   
                        </tr> 
                        <?php 
                        $defensivas=null;
                        $supervivencia=null;
                        $index=1;
                            foreach ($factorE  as $value) {
                        ?>                        
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;width:20%">
                             </br></br></br>
                                <?php echo $value->factor; ?>
                            </td>
                            <td style="text-align:justify;width:30%; "> 
                                <?php echo $value->Amenazas;?>
                            </td>
                            <?php if (isset($defensivas) && isset($supervivencia)){
                                $index++;  
                            }else{
                                $defensivas=$value->defensivas;
                                $supervivencia=$value->supervivencia;
                            ?>
                            <td style="text-align:justify;margin-top:50px;width:25%; " id="fa">
                                <?php echo $defensivas;?>
                            </td>
                            <td style="text-align:justify;width:25%" id="da">
                                <?php echo $supervivencia; ?>
                            </td>
                            <?php
                                } 
                            }
                             ?>
                        <input type="hidden" id="index" value="<?php echo $index;?>">
                        </tr>
                        <tr>
                            <td colspan="4">
                                <center>
                                  <?php echo $dofa->nota; ?>
                                </center>  
                            </td>
                        </tr>                    
                    </tbody> 
                  </table>
                </div>
            </div>
        </div>    
	</div>
    <script type="text/javascript">
    $(document).ready(function(){
    var elmnt=document.getElementById("table");
    var index=document.getElementById("index").value;
        document.getElementById("textV").style.marginTop=(elmnt.offsetHeight/6)+"em";
        document.getElementById("textVe").style.marginTop=(elmnt.offsetHeight/4)+"em";
        document.getElementById("fo").rowSpan=index;
        document.getElementById("do").rowSpan=index;
        document.getElementById("fa").rowSpan=index;
        document.getElementById("da").rowSpan=index;
    });
    </script>