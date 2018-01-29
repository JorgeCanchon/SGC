    <?php 
            $barra_superiorI=FALSE;
            if($procesosUsuario!=FALSE){
                foreach ($procesosUsuario as $valueU) {                                     
                    if($valueU->id==$fichaIndicador->idPR){
                        $barra_superiorI=TRUE;
                    }
                }
            }
			if ($barra_superior&&$barra_superiorI) {
					$mostrar_barra=' ';
			}else{
				$mostrar_barra='hidden';
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
                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/editMedicion/').$fichaIndicador->id;?> href="<?php echo $site_urll; ?>">
                        <i class="ace-icon fa fa-arrow-right icon-on-right"><span class="fa-letra"> Editar</span></i> 
                    </a> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table-bordered button-editar" style="margin-top:30px;">
                        <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                  <?php echo $fichaIndicador->codigoIndicador; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                  <?php echo $fichaIndicador->proceso; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td  rowspan="2" class="col-sm-10">
                                <center><h5><b><?php echo $title; ?></b></h5></center>
                            </td>
                            <td class="col-sm-4">
                                <b>Versión:</b>
                                <center>
                                  <?php echo $fichaIndicador->version; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4">
                                <b>Fecha de vigencia:</b>
                                <center>
                                  <?php echo $fichaIndicador->fechaVigencia; ?>
                                </center>  
                            </td>
                        </tr> 
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaBack" colspan="2">
                                INFORMACIÓN DEL INDICADOR
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Proceso: 
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->procesoInf; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Nombre del Indicador:
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->nombreIndicador; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Frecuencia de Medición: 
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->frecuencia; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Objetivo de la medición: 
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->objetivo; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Nombre y Cargo responsable de la Medición: 
                            </td>
                            <td class="tableActaBody">
                                <?php 
                                echo $fichaIndicador->medir;
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Nombre y Cargo responsable de la Gestión: 
                            </td>
                            <td class="tableActaBody">
                                <?php 
                                 echo $fichaIndicador->gestionar;
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaBack" colspan="3">
                                MEDICIÓN
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" rowspan="2" width="30%">
                              Formula del Indicador  
                            </td>
                            <td class="tableActaBody">
                                <b>Numerador</b>
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->numeradorFormula; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody">
                                <b>Denominador</b>
                            </td>
                            <td class="tableActaBody">
                                <?php echo $fichaIndicador->denominadorFormula; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                                Escala/unidad
                            </td>
                            <td class="tableActaBody" colspan="2">
                               <?php 
                               $porcentaje=FALSE;
                                    if (strpos($indicador->meta, '%')) {
                                        echo 'Porcentaje';
                                        $porcentaje=TRUE;
                                    }else{
                                        echo 'Decimal';
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaBack" colspan="8">COMPORTAMIENTO DE INDICADOR</td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead">P</td>
                            <td class="tableIndicadorHead">FECHA MEDICIÓN</td>
                            <td class="tableIndicadorHead">FECHA DE PERIODO EVALUADO</td>
                            <td class="tableIndicadorHead">META</td>
                            <td class="tableIndicadorHead">VALOR NUMERADOR</td>
                            <td class="tableIndicadorHead">VALOR DENOMINADOR</td>
                            <td class="tableIndicadorHead">RESULTADOS</td>
                            <td class="tableIndicadorHead">ESTADO</td>
                        </tr>
                            <?php 
                            if($comportamiento!=false){
                            $p=1;
                            $estado=true;
                                foreach ($comportamiento as $value) {
                                    if($value->codigoFichaIndicador==$fichaIndicador->id){
                                echo '<tr>';
                                   echo '<td class="tableActaBody">'.$p++.'</td>';
                                   echo '<td class="tableActaBody">'.$value->fechaMedicion.'</td>';
                                   echo '<td class="tableActaBody">'.$value->fechaPEvaluado.'</td>';
                                   echo '<td class="tableActaBody">'.$value->meta.'</td>';
                                   echo '<td class="tableActaBody">'.$value->valorN.'</td>';
                                   echo '<td class="tableActaBody">'.$value->valorD.'</td>';
                                   echo '<td class="tableActaBody">'.$value->resultado.'</td>';
                                   echo '<td class="tableActaBody">';
                                   if($value->estado==0){
                                    echo 'No aprobado';
                                    $estado=true;
                                   }elseif($value->estado==1){
                                    echo 'Aprobado';
                                    $estado=false;
                                   }elseif($value->estado==2){
                                    echo 'En revisión';
                                    $estado=true;
                                   }
                                   echo '</td>';
                                echo ' </tr>';

                                    }
                                }
                    echo'            <script type="text/javascript">
                                    $(document).ready(function() { ;
                                            var json={};
                                            json.chart={
                                                type: "column"
                                            }
                                            json.title={
                                                text:""
                                            }
                                            json.subtitle={
                                                text:""
                                            },
                                            json.yAxis={
                                                title: {
                                                    text: ""
                                                }';
                                            if($porcentaje){
                    echo'                   ,
                                                labels: {
                                                    formatter: function() {
                                                        return this.value + "%";
                                                    }
                                                },
                                                min: 0,     
                                                max: 100';
                                            }
                    echo'                   }
                                            json.legend={
                                                layout: "vertical",
                                                align: "right",
                                                verticalAlign: "middle"
                                            }
                                            json.plotOptions={
                                                series: {
                                                            label: {
                                                                connectorAllowed: false
                                                            },
                                                            pointStart:1
                                                        }
                                            }
                                            json.series= [
                                            
                                                       {
                                                            name: "Meta",
                                                            data:[';
                                                            foreach ($comportamiento as $value) {
                                                                if($value->codigoFichaIndicador==$fichaIndicador->id){
                    echo'                                        ['.(int)$value->meta.'],';
                                                                }
                                                            }   
                    echo'
                                                            ]
                                                        },{
                                                            name: "Resultado",
                                                            data:[';
                                                            foreach ($comportamiento as $value) {
                                                                if($value->codigoFichaIndicador==$fichaIndicador->id){
                    echo'                                        ['.(int)$value->resultado.'],';
                                                                }
                                                            }
                    echo'                                        
                                                            ]
                                                        }';          
                    echo'        
                                                ]
                                                json.responsive={
                                                    rules: [{
                                                        condition: {
                                                            maxWidth: 500
                                                        },
                                                        chartOptions: {
                                                            legend: {
                                                                layout: "horizontal",
                                                                align: "center",
                                                                verticalAlign: "bottom"
                                                            }
                                                        }
                                                    }]  
                                                }
                                    $("#grafico").highcharts(json);});
                                    </script>';
                                }else{
                                    echo '
                                    <tr>
                                            <td colspan="7">No hay resultados para la busqueda</td>
                                    </tr>';
                                }
                             ?>
                    </table>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaBack"><center>GRAFICO</center></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="grafico">No datos para el grafico</div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaBack">PERIODO</td>
                            <td class="tableActaBack">ANALISIS Y PLAN DE MEJORA</td>
                            <td class="tableActaBack">N°ACCIÓN</td>
                        </tr>
                        
                        <?php 
                        if($comportamiento!=false){
                            $idComportamiento=0;
                            foreach ($comportamiento as $value) {
                                if($value->codigoFichaIndicador==$fichaIndicador->id){
                                    $idComportamiento=$value->idComportamiento;
                                    echo'<tr> 
                                            <td class="tableActaBody" width="20%">
                                                <center>'.$value->periodo.'</center>
                                            </td>
                                            <td class="tableActaBody" width="60%" style="align-text:justify;"> '.$value->analisis.'</td>
                                            <td class="tableActaBody" width="20%">';
                                    if($value->nombre=='N/A'){
                                        echo '<center>'.$value->nombre.'</center>';
                                    }else{
                                        echo'<center><a href="'.base_url().'calidad/viewPlanAccion/'.$value->codigoAccion.'" target="_blank">Accion '.$value->nombre.' nº'.$value->codigoAccion.'<a></center>';
                                    }
                                    echo    '</td>';
                                    echo '</tr>';
                                }
                            }
                        }else{
                                    echo '
                                    <tr>
                                            <td colspan="8" class="tableActaBody">No hay resultados para la busqueda</td>
                                    </tr>';
                            }
                         ?>
                    </table>
                    <?php 
                    if($estado){
                     ?>
                    <br>
                    <form method="POST" action="<?php echo base_url() ?>calidad/addSeguientoMedicion" >
                        <table class="tableActa">
                            <?php 
                            if($comportamiento!=false){
                                echo  '
                                <tr>
                                    <td class="tableActaBack" colspan="2">SEGUIMIENTO MEDICIÓN DE INDICADOR</td>
                                </tr>
                                <tr>
                                    <td class="tableActaBody">
                                        <input type="hidden" name="id_comportamiento" value="'.$idComportamiento.'">
                                        <input type="hidden" name="nombreProceso" value="'.$fichaIndicador->procesoInf.'">
                                        <input type="hidden" name="idProceso" value="'.$fichaIndicador->idPR.'">
                                        <input type="hidden" name="nombreIndicador" value="'.$fichaIndicador->nombreIndicador.'">
                                       <label>Aprobado</label> <input type="radio" checked  name="estado" value="1">
                                       <br>
                                        <label>No aprobado</label> <input type="radio" name="estado" value="0">
                                    </td>
                                    <td class="tableActaBody">
                                        <textarea name="comentario" id="comentario" class="form-control" required></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="tableActaBody">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <center>
                                                    <input class="btn btn-default" type="reset" value="Limpiar">
                                                    <button type="submit" name="enviar" id="enviar" value="enviar" class="btn btn-default">Enviar</button>
                                                </center>
                                            </div>
                                        </div>
                                        <br>
                                    </td>
                                </tr>
                                ';
                            }else{
                            echo '
                                <tr>
                                    <td colspan="8" class="tableActaBody">No hay resultados para la busqueda
                                    </td>
                                </tr>
                                ';
                            } ?>
                        </table>
                    </form>
                    <?php 
                     }
                     ?>
                    <br>
                    <br>
                    <center>
                        <a href="<?php echo $retorno ?>" class="btn btn-default">Volver</a>
                    </center>
                    <br><br><br><br><br>
                </div>
            </div>
        </div>    
	</div>