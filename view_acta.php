    <div id="wrapper">
        <div id="page-wrapper">    
            <br><br>
            <div style="padding: 2px;">
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?php echo $retorno; ?>">
                        <i class="fa fa-arrow-left"></i><span class="fa-letra"> Volver</span>  
                    </a> 
                </div>
            </div>
            <br>
            <?php 
             $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
             ?>
            <div class="row">
                <div class="col-lg-12">
                    <table style="border:1px solid #000;margin-top:30px;" class="table-bordered" >
                         <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                  <?php echo $actaHeader->codigoActa; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                  <?php echo $actaHeader->proceso; ?>
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
                                  <?php echo $actaHeader->version; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4">
                                <b>Fecha de vigencia:</b>
                                <center>
                                  <?php 
                                    echo date('d-m-Y', strtotime($actaHeader->fechaVigencia)); 
                                     ?>
                                </center>  
                            </td>
                        </tr> 
                    </table>
                    <br>
                    <form method="POST" id="form_acta_pdf" action="<?php echo base_url();?>calidad/downloadPdf/<?php echo $idActa; ?>">
                    <div style="padding: 2px;">
                        <div class="pull-right">
                            <a href="<?php echo base_url();?>calidad/downloadPdf/<?php echo $idActa; ?>" onclick="return sendToServer(this);" title="PDF - Acta de la revisión por la dirección" target="_blank"><img src='<?php echo base_url();?>img/ico_pdf.jpg' style="width:50px; height:50px;"></a> 
                            </a> 
                            <input type="hidden" id="idActa" name="idActa" value="<?php echo $idActa;?>">
                        </div>
                    </div>
                    </form>
                    <br>
                    <?php 
                        $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $date=$actaHeader->periodo;
                        $date1=explode("/",$date);
                        $fecha0=explode('-',$date1[0]);
                        $fecha1=explode('-',$date1[1]);
                     ?>
                     <br><br>
                    <table class="tableActa">
                        <tr>
                            <td width="30%" class="tableActaHead">PERIODO EVALUADO:</td>
                            <td width="70%" class="tableActaBody"><?php echo $meses[(int)$fecha0[0]].'-'.$fecha0[1].'/'.$meses[(int)$fecha1[0]].'-'.$fecha1[1]; ?></td>
                        </tr>
                        <tr>    
                            <td width="30%" class="tableActaHead">FECHA DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody">
                            <?php 
                                $date=$actaHeader->fecha;
                                $fecha0=explode('-',$date);
                                echo $fecha0[2].'/'.$meses[(int)$fecha0[1]].'/'.$fecha0[0];
                             ?>  
                             </td>
                        </tr>
                        <tr> 
                            <td width="30%" class="tableActaHead">LUGAR DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody"><?php echo $actaHeader->lugar; ?></td>
                        </tr>
                        <tr> 
                            <td width="30%" class="tableActaHead">HORA DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody"><?php echo $actaHeader->hora;?></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td colspan="3" class="tableActaHead">ASISTENTES</td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck">NOMBRE</td>
                            <td class="tableActaNeck">CARGO</td>
                            <td class="tableActaNeck">PROCESO(S)</td>
                        </tr>
                        <?php
                            foreach ($asistentes as $value) { 
                        ?>                             
                        <tr>
                            <td class="tableActaBody"><center><?php echo $value->nombre; ?></center></td>
                            <td class="tableActaBody"><center><?php echo $value->cargo; ?></center></td>
                            <td class="tableActaBody"><center><?php echo $value->proceso; ?></center></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaHead">AGENDA DE LA REVISIÓN</td>
                        </tr>
                        <tr>
                            <td class="tableActaBody">Preámbulo – Planteamiento estratégico (Misión, visión, política de calidad, objetivos de calidad, si aplica política y objetivos de seguridad y salud en el trabajo).</td>
                        </tr>
                        <?php
                        foreach ($modulo as $value) {    
                        ?>                             
                        <tr>
                            <td class="tableActaBody">
                                <?php echo $value->titulo; ?>
                                <br>
                                <?php 
                                if(count($encabezado)>=1 && $encabezado!=FALSE){
                                    $index=1;
                                    foreach ($encabezado as $en) {
                                        if($value->id==$en->modulo)
                                            {
                                                echo '<div class="col-lg-1">&nbsp;</div>';
                                                echo $value->id.'.'.$index++.'.'.$en->texto.'<br>';
                                            }
                                        }//fin foreach encabezado
                                }//fin if
                                ?>
                            </td>
                        </tr>
                        <?php
                        }//Fin foreach modulo
                        ?>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaHead" >
                                PREAMBULO
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" style="text-align: justify;">
                                <?php echo $actaHeader->preambulo; ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa" >
                        <tr>
                            <td class="tableActaHead" colspan="2">
                                PLANTEAMIENTO ESTRATÉGICO 
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                MISIÓN
                            </td>
                            <td class="tableActaBody" width="50">
                                <?php echo $actaHeader->mision; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                <?php echo $actaHeader->vision; ?>
                            </td>
                            <td class="tableActaNeck" width="50">
                                VISIÓN
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                POLITICA DE CALIDAD
                            </td>
                            <td class="tableActaBody" width="50">
                                <?php echo $actaHeader->politica; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                <?php 
                                echo $actaHeader->objetivoscalidad;
                                ?>
                            </td>
                            <td class="tableActaNeck" width="50">
                                OBJETIVOS DE CALIDAD
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                POLITICA SG-SST
                            </td>
                            <td class="tableActaBody" width="50">
                                <?php echo $actaHeader->politicaSG; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                <?php 
                                echo $actaHeader->objetivosSG;
                                ?>
                            </td>
                            <td class="tableActaNeck" width="50">
                                OBJETIVOS DE SG-SST
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="url" name="url" value="<?php echo base_url(); ?>">
                    <br>
                    <br>
                    <table class="tableActa">
        <?php 
            $htmlActa='';
                        foreach ($modulo as $value) {
                        $index=1; 
                        $indexPie=1; 
                        $indexLinea=1; 
            $htmlActa.='<tr>
                            <td class="tableActaHead" >
                                '.$value->titulo.'
                            </td>
                        </tr>';
                        for ($i=1; $i <=count(@$buildActa[$value->id]) ; $i++) { 
                            $class='';
                            $tipo=@$buildTipo[$value->id][$i];
                            if($tipo=='subtitulo'){
                                $class='tableActaNeck';
                            }elseif ($tipo=='encabezado') {
                                $class='tableActaBack';
                            }elseif ($tipo=='texto') {
                                $class='tableActaBody';
                            }
                            if ($tipo=='subtitulo' || $tipo=='encabezado' || $tipo=='texto') {
            $htmlActa.='<tr> 
                            <td class="'.$class.'">
                                '.nl2br(@$buildActa[$value->id][$i]).'
                            </td>
                        </tr>';
                            }elseif ($tipo=='img') {
            $htmlActa.='<tr>    
                            <td class="tableActaBody">
                                <center>  
                                <img class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.@$buildActa[$value->id][$i].'" alt="imagen Acta">
                                </center>
                            </td>
                        </tr>    ';                
                            }elseif ($tipo=='textoImagen') {
                                $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>   
                            <td width="100%">
                            <center>  
                                <table>
                                    <tr>
                                        <td width="50%" style="text-align:justify;">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td width="50%">
                                            <center>  
                                            <img width="80%" class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.$str[0].'" alt="imagen Acta">
                                            </center>   
                                        </td>
                                    </tr>
                                </table>
                            </center>
                            </td>
                        </tr>    ';                
                            }elseif ($tipo=='imagenTexto') {
                                $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>    
                            <td width="100%">
                            <center>     
                                <table>
                                    <tr>
                                        <td width="50%">
                                            <center>  
                                            <img width="80%" class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.$str[0].'" alt="imagen Acta">
                                            </center>   
                                        </td>
                                        <td width="50%" style="text-align:justify;">
                                            '.nl2br($str[1]).'
                                        </td>
                                    </tr>
                                </table>
                            </center>    
                            </td>
                        </tr>    <tr><td><hr style="border-top:white;"></td></tr>';                
                            }elseif ($tipo=='tableTwo') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack" width="50%">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack" width="50%">
                                            '.nl2br($str[1]).'
                                        </td>
                                    </tr>';
                        if (count($filaTwo[$value->id][$i]>=1) && $filaTwo[$value->id][$i]!=FALSE) {        
                            foreach ($filaTwo[$value->id][$i] as $valueFila) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila->texto2).'   
                                        </td>
                                    </tr>';      
                            } 
                        }          
            $htmlActa.='        </table>
                            </div>
                            </td>';                      
            $htmlActa.='</tr>';
                                }elseif ($tipo=='tableThree') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[2]).'
                                        </td>
                                    </tr>';    
                    if (count($filaThree[$value->id][$i]>=1) && $filaThree[$value->id][$i]!=FALSE) {  
                            foreach ($filaThree[$value->id][$i] as $valueFila3) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila3->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila3->texto2).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila3->texto3).'   
                                        </td>
                                    </tr>';      
                            }  
                        }    
            $htmlActa.='        </table>
                            </div>
                            </td>';                      
            $htmlActa.='</tr>';
                                }elseif ($tipo=='tableFour') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[2]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[3]).'
                                        </td>
                                    </tr>'; 
                        if (count($filaFour[$value->id][$i]>=1) && $filaFour[$value->id][$i]!=FALSE) { 
                            foreach ($filaFour[$value->id][$i] as $valueFila4) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila4->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila4->texto2).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila4->texto3).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila4->texto4).'   
                                        </td>
                                    </tr>'; 
                            }  
            $htmlActa.='        </table>
                            </div>
                            </td>';
                        }                          
            $htmlActa.='</tr>';
                                }elseif ($tipo=='tableFive') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[2]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[3]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[4]).'
                                        </td>
                                    </tr>'; 
                        if (count($filaFive[$value->id][$i]>=1) && $filaFive[$value->id][$i]!=FALSE) { 
                            foreach ($filaFive[$value->id][$i] as $valueFila5) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila5->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila5->texto2).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila5->texto3).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila5->texto4).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila5->texto5).'   
                                        </td>
                                    </tr>';      
                            }  
            $htmlActa.='        </table>
                            </div>
                            </td>';
                        }                          
            $htmlActa.='</tr>';
                                }elseif ($tipo=='tableSix') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[2]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[3]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[4]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[5]).'
                                        </td>
                                    </tr>'; 
                        if (count($filaSix[$value->id][$i]>=1) && $filaSix[$value->id][$i]!=FALSE) { 
                            foreach ($filaSix[$value->id][$i] as $valueFila6) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila6->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila6->texto2).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila6->texto3).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila6->texto4).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila6->texto5).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila6->texto6).'   
                                        </td>
                                    </tr>';      
                            }  
            $htmlActa.='        </table>
                            </div>
                            </td>';
                        }                          
            $htmlActa.='</tr>';
                                }elseif ($tipo=='tableSeven') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.nl2br($str[0]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[1]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[2]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[3]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[4]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[5]).'
                                        </td>
                                        <td class="tableActaBack">
                                            '.nl2br($str[6]).'
                                        </td>
                                    </tr>'; 
                        if (count($filaSeven[$value->id][$i]>=1) && $filaSeven[$value->id][$i]!=FALSE) { 
                            foreach ($filaSeven[$value->id][$i] as $valueFila7) {
            $htmlActa.='            <tr>    
                                        <td class="tableActaBody">
                                           '.nl2br($valueFila7->texto1).' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto2).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto3).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto4).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto5).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto6).'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.nl2br($valueFila7->texto7).'   
                                        </td>
                                    </tr>';      
                            }  
            $htmlActa.='        </table>
                            </div>
                            </td>';
                        }                          
            $htmlActa.='</tr>';
                                }elseif ($tipo=='graphic') {
                            $str=explode(';',@$buildActa[$value->id][$i]);
            $htmlActa.='<tr>
                            <td>';
            //Determinamos el tipo de grafica  
            if ($str[4]==1) {   
            $htmlActa.=' <input type="hidden" id="inputcontainerColumn'.$value->id.'_'.$index.'" value="0">       
                        <input type="hidden" id="index_'.$value->id.'" value="'.$index.'">
                        <div id="containerColumn_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;"> 
                        <script>var json={};
                        $(document).ready(function() { 
                            json.chart={
                                type: "column"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.yAxis={
                                title: {
                                    text: "'.$str[2].'"
                                }
                            }
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
                                            pointStart: '.$str[3].'
                                        }
                            }
                            json.series= [';
                                    foreach ($filaGraphic[$str[5]][$value->id] as $graphic) { 
                $htmlActa.='            {
                                        name: "'.$graphic->tituloColumna.'",
                                        data:['.$graphic->datosColumna.']
                                    },';
                                    }
                $htmlActa.='                ]
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
                    $("#containerColumn_'.$str[5].'").highcharts(json);
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };
                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#inputcontainerColumn'.$value->id.'_'.$index.'").val(url);
                            });
                });
                    </script></div>';$index++;               
                    }else if ($str[4]==2) {
                $htmlActa.=' 
                        <input type="hidden" id="inputcontainerPie'.$value->id.'_'.$indexPie.'" value="0">       
                        <input type="hidden" id="indexPie_'.$value->id.'" value="'.$indexPie.'">
                    <div id="containerPie_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;"> 
                    <script>var json={};$(document).ready(function() { 
                            json.chart={
                                type: "pie"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.plotOptions={
                                pie:
                                {
                                    allowPointSelect: true,
                                    cursor: "pointer",
                                        dataLabels: {
                                            enabled: true,
                                            format: "<b>{point.name}</b>: {point.percentage:.1f} %",
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || "black"
                                            }
                                        }
                                }
                            }
                                json.series= [{
                                    data: [';
                                    foreach ($filaGraphicPie[$str[5]][$value->id] as $graphicPie) {  
                $htmlActa.='            {
                                        name: "'.$graphicPie->tituloColumna.'",
                                        y:'.(float)$graphicPie->datosColumna.'
                                    },';
                                    }
                $htmlActa.='                ]
                                            }]
                    $("#containerPie_'.$str[5].'").highcharts(json);
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };
                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#inputcontainerPie'.$value->id.'_'.$indexPie.'").val(url);
                            });
                });</script>';$indexPie++;  
                    }else if ($str[4]==3) {    
            $htmlActa.='     
                        <input type="hidden" id="inputcontainerLinea'.$value->id.'_'.$indexLinea.'" value="0">       
                        <input type="hidden" id="indexLinea_'.$value->id.'" value="'.$indexLinea.'">   
                        <div id="containerLinea_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">   
                        <script>var json={};
                        $(document).ready(function() { 
                            json.chart={
                                type: "line"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.yAxis={
                                title: {
                                    text: "'.$str[2].'"
                                }
                            }
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
                                            pointStart: '.$str[3].'
                                        }
                            }
                            json.series= [';
                                    foreach ($filaGraphicLinea[$str[5]][$value->id] as $graphicLinea) { 
                $htmlActa.='            {
                                        name: "'.$graphicLinea->tituloColumna.'",
                                        data:['.$graphicLinea->datosColumna.']
                                    },';
                                    }
                $htmlActa.='                ]
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
                    $("#containerLinea_'.$str[5].'").highcharts(json);
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };
                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#inputcontainerLinea'.$value->id.'_'.$indexLinea.'").val(url);
                            });
                });</script></div>';$indexLinea++;        
                    }
            $htmlActa.='        
                            </td>';                        
            $htmlActa.='</tr>';
                                }//fin elseif
                            }//fin foreach buildActa
                        } 
            echo $htmlActa;              
        ?>
                    </table>
                    <br>
                    <br>
                </div>
            </div>
        </div>    
  </div>
  <script src='<?php echo base_url();?>js/autosize.js'></script>
<script type="text/javascript"> 
    autosize(document.querySelectorAll('textarea'));
$(document).ready(function(){
    try{
        for (var i = 1; i <=7; i++) {
            var filas = $('input[id=index_'+i+']');
            $('#index_'+i).val(filas.length);
        }
        for (var i = 1; i <=7; i++) {
            var filas = $('input[id=indexPie_'+i+']');
            $('#indexPie_'+i).val(filas.length);
        }
        for (var i = 1; i <=7; i++) {
            var filas = $('input[id=indexLinea_'+i+']');
            $('#indexLinea_'+i).val(filas.length);
        }
    }catch(err){}
});
</script>