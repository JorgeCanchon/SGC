    <?php  
        if (isset($barra_superior)) {
          if ($barra_superior) {
              $mostrar_barra='show';
          }else{
            $mostrar_barra='hidden'; 
            }
        }
        if (isset($mensaje) && !empty($mensaje)) echo '<script>alert("'.$mensaje.'")</script>';
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
                            <td colspan="2"><center><h5><b><?php echo $title; ?></b></h5></center></td>
                        </tr>
                    </table> 
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-lg-12">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Acta #<?php echo $idActa;?></label>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="panel-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#info"><label>Informacion General</label></a>
                                        </h4>
                                    </div>
                                    <div id="info" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <form  method="POST" action="<?php echo base_url();?>calidad/updateActa" id="form_informacion_general" name="form_informacion_general">
                                             <input type="hidden" name="idActa" id="idActa" value="<?php echo $idActa;?>">
                                             <div class="row">
                                                <div class="col-lg-3">
                                                    CodigoActa:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="codigoActa" placeholder="codigo del acta" class="form-control" value="<?php echo $actaHeader->codigoActa; ?>" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Versión:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="version" placeholder="Versión del acta" class="form-control" value="<?php echo $actaHeader->version; ?>" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Fecha vigencia:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="fVigencia"  id="datepickervigencia" placeholder="Fecha vigencia del acta" class="form-control" value="<?php echo $actaHeader->fechaVigencia; ?>" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Periodo Evaluado:
                                                </div>
                                                <div class="col-lg-4">
                                                    <?php $date=explode("/",$actaHeader->periodo); ?>
                                                    <input type="text" id="datepickermonth" placeholder="Inicio Periodo" name="periodo" class=" form-control" id="periodo1" value="<?php echo $date[0]; ?>" required/>  
                                                </div>
                                                <div class="col-lg-1">
                                                   Hasta   
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" id="datepickermonth1" placeholder="Fin periodo" name="periodo1" class="form-control" id="periodo2" value="<?php echo $date[1]; ?>" required/>    
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Fecha Reunión:
                                                </div>
                                                <div class="col-lg-9">                   
                                                    <input type="text" id="datepicker" name="fechaR" placeholder="Fecha de la reunión" class="form-control" value="<?php echo $actaHeader->fechaReunion; ?>" required/> 
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Lugar Reunión:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="lugarR" placeholder="Lugar de la reunión" class="form-control" value="<?php echo $actaHeader->lugar; ?>" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Hora Reunión:
                                                </div>
                                                <div class="col-lg-4">
                                                    <?php 
                                                        $hora=explode('-',$actaHeader->hora);
                                                        $resHora=substr($hora[0],0,-4);
                                                        $horaMilitar = strtotime($hora[0]);
                                                        $horaMilitar = date("H:i", $horaMilitar);
                                                        $horaMilitar1 = strtotime($hora[1]);
                                                        $horaMilitar1 = date("H:i", $horaMilitar1);
                                                    ?>   
                                                    <input type="time"  placeholder="Hora de la reunión" title="Ingrese hora de inicio de la reunión" name="hora" class=" form-control" id="hora" value="<?php echo $horaMilitar; ?>" required/>  
                                                </div>
                                                <div class="col-lg-1">
                                                   Hasta   
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="time"  name="hora1" class="form-control" title="Ingrese hora de fin de la reunión" id="hora1" value="<?php echo $horaMilitar1; ?>" required/>    
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <center><b><h4>Asistentes</h4></b></center>
                                                </div>
                                                <br><br>
                                                <div class="col-lg-12">
                                                    <div id="contenedor_inputs">
                                                        <?php
                                                            $index=1;
                                                            foreach ($asistentes as $value) { 
                                                        ?> 
                                                        <div class="row fila" id="fila_<?php echo $index;?>">
                                                            <div class="col-lg-3">
                                                                <input type="hidden" name="idAsistente[<?php echo $index;?>]" id="idAsistente[<?php echo $index;?>]" value="<?php echo $value->id; ?>">
                                                                <center>Nombre:</center>
                                                                <br>
                                                                <input style="height:50px;" type="text" placeholder="Nombre" title="Ingrese nombre completo de la persona asistente" name="nameA[<?php echo $index;?>]" id="nameA_<?php echo $index;?>" class="form-control" value="<?php echo $value->nombre; ?>" required/>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <center>Cargo:</center>
                                                                <br>
                                                                <textarea class="form-control" placeholder="Cargo" title="Ingrese cargo o cargos de la persona" name="cargoA[<?php echo $index;?>]" id="cargoA_<?php echo $index;?>" required/><?php echo $value->cargo; ?></textarea>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <center>Proceso(s):</center>
                                                                <br>
                                                                <textarea class="form-control" placeholder="Proceso(s)" title="Ingrese nombre del proceso" name="procesoA[<?php echo $index;?>]" id="procesoA_<?php echo $index;?>" required/><?php echo $value->proceso; ?></textarea>
                                                            </div>              
                                                        </div>
                                                        <?php
                                                        $index++;
                                                        }
                                                        ?>
                                                    </div>
                                                    <br>
                                                </div>
                                                <br><br><br><br><br><br>
                                                <div class="row">
                                                    <div class="col-lg-12" id="contenedor_botones">
                                                        <div class="row">
                                                            <div class="col-md-5">&nbsp;</div>
                                                            <div class="col-md-1"><input type="button" id="agregarA" class="btn btn-default" value="+" title="Agregar" onClick="agregarAsistente(this.id,'<?php echo $base_url ?>');"></div>
                                                            <div class="col-md-1"><input type="button" id="removerA" class="btn btn-default" value="-" title="Remover" onClick="agregarAsistente(this.id,'<?php echo $base_url ?>');"></div>
                                                            <div class="col-md-5">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div id="loading" class="hidden">
                                                    <div class="row">
                                                        <div class="col-md-5">&nbsp;</div>
                                                        <div class="col-md-2 ">
                                                            <div class="row">
                                                                <div class="col-md-4">&nbsp;</div>
                                                                <div class="col-md-4"><img src="<?php echo base_url(); ?>img/progress.gif" alt="" /><h1></h1></div>
                                                                <div class="col-md-4">&nbsp;</div>
                                                            </div>
                                                        </div>          
                                                        <div class="col-md-5">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <center><b><h4>Preambulo</h4></b></center>
                                                        <br>
                                                        <div class="col-lg-12">
                                                            <textarea class="form-control" name="preambulo" required/><?php echo $actaHeader->preambulo; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <center><b><h4>Planteamiento estratégico </h4></b></center>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        Mision
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="mision" title="Mision"><?php echo nl2br($actaHeader->mision); ?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="vision" title="Vision"><?php echo nl2br($actaHeader->vision); ?></textarea>
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        Vision
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        Politica de calidad
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="politica" title="Politica de calidad"><?php echo str_replace("<br />", " ",nl2br($actaHeader->politica)); ?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="objetivos" title="Objetivos de calidad"><?php echo str_replace("<br />", " ",nl2br($actaHeader->objetivoscalidad));?></textarea>
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        Objetivos de calidad
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        Politica SG-SST
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="politicaSG" title="Politica SG-SST"><?php echo str_replace("<br />", " ",nl2br($actaHeader->politicaSG));?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="objetivosSG" title="Objetivos de SG-SST"><?php 
                                                        echo str_replace("<br />", " ",nl2br($actaHeader->objetivosSG));
                                                        ?></textarea>
                                                    </div>
                                                    <div class="col-lg-6" align="center">
                                                        Objetivos de SG-SST
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <center>
                                                            <input class="btn btn-default" type="reset" value="Limpiar">
                                                            <button type="button" onclick="validarCampo();"  name="enviar" id="enviar" value="enviar" class="btn btn-default">Guardar</button>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div><!-- row-->
                                            </form><!--form informacion general-->
                                        </div><!-- panel body-->
                                    </div><!-- panel collapse-->
                                </div><!-- panel default-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="panel-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#content"><label>Contenido</label></a>
                                        </h4>
                                    </div>
                                    <div id="content" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form  method="POST" name="form_contenido" id="form_contenido" enctype="multipart/form-data">
                                                    <input type="hidden" value="<?php echo base_url(); ?>" name="base" id="base">
                                                    <input type="hidden" name="idActa" id="idActa" value="<?php echo $idActa;?>">
                                                <?php 
                                                $index=1;
                                                    foreach ($modulo as $value) {
                                                ?>
                                                <div class="col-lg-1">&nbsp;</div>
                                                <div class="col-lg-9" style="background-color:#ddd;color:#000;border-radius:15px;">
                                                    <center><?php echo $value->titulo; ?></center>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="pull-right">
                                                        <div class="dropdown" style="margin-right:20px;">
                                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="Agregar">Agregar
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" id="acciones_<?php echo $index; ?>" onclick="envioObject(event,this.id,'<?php echo $base_url ?>');">
                                                                    <li><a id="Subtitulo">Subtitulo</a></li>
                                                                    <li><a id="Encabezado">Encabezado</a></li>
                                                                    <li><a id="Texto">Texto</a></li>
                                                                    <li><a id="Imagen">Imagen</a></li>
                                                                    <li><a id="Texto-Imagen">Texto-Imagen</a></li> 
                                                                    <li><a id="Imagen-Texto">Imagen-Texto</a></li>
                                                                <li class="dropdown-submenu">
                                                                    <a class="test" tabindex="-1" href="#">Tabla<span class="caret"></span></a>
                                                                    <ul class="dropdown-menu" >
                                                                      <li><a tabindex="-1" id="Table2">2 columnas</a></li>
                                                                      <li><a tabindex="-1" id="Table3">3 columnas</a></li>
                                                                      <li><a tabindex="-1" id="Table4">4 columnas</a></li>
                                                                      <li><a tabindex="-1" id="TableOtro">Otro</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="dropdown-submenu">
                                                                    <a class="test" tabindex="-1" href="#">Grafico<span class="caret"></span></a>
                                                                    <ul class="dropdown-menu">
                                                                      <li><a tabindex="-1" id="Grafico1">Barra</a></li>
                                                                      <li><a tabindex="-1" id="Grafico2">Pie</a></li>
                                                                      <li><a tabindex="-1" id="Grafico3">Lineal</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div><!--dropdown-->
                                                    </div><!--Pull right-->
                                                </div><!--col-lg-3-->
                                                <br> <br> 
                                                <div class="row">
                                                    <div class="col-lg-12" id="contenedor_content_<?php echo $index; ?>">
                                                        <?php 
                                                        $htmlActa='';
                                                        $indexSubtitulo=1;
                                                        $indexEncabezado=1;
                                                        $indexTexto=1;
                                                        $indexImagen=1;
                                                        $indexTextoImagen=1;
                                                        $indexImagenTexto=1;
                                                        $indexTableTwo=1;
                                                        $indexTableThree=1;
                                                        $indexTableFour=1;
                                                        $indexTableFive=1;
                                                        $indexTableSix=1;
                                                        $indexTableSeven=1;
                                                        $indexGraphicBarra=1;
                                                        $indexGraphicPie=1;
                                                        $indexGraphicLinea=1;
                                                        for($i=1; $i <=count(@$buildActa[$value->id]) ; $i++) {
                                                            $tipo=@$buildTipo[$value->id][$i];
                                                            if($tipo=='subtitulo'){
                                                        $htmlActa.='
                                                        <div class="row fila_content" id="content_'.$i.'">
                                                            <div class="col-lg-12">
                                                            <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="subtitulo">
                                                            <input type="hidden" name="idSubtitulo_'.$indexSubtitulo.'['.$value->id.']" id="idSubtitulo_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">                
                                                            <input type="hidden" name="numeroOrden_'.$value->id.'['."subtitulo".']" value="'.$indexSubtitulo.'">        
                                                                    <center>Subtitulo</center>
                                                                </div>
                                                            <div class="col-lg-2">&nbsp;</div>
                                                                <div class="col-lg-8">
                                                                    <input type="text" placeholder="Ingrese Subtitulo" class="form-control" title="Ingrese subtitulo" value="'.@$buildActa[$value->id][$i].'" name="subtituloActaE_'.$indexSubtitulo.'['.$value->id.']">
                                                                </div> 
                                                            <div class="col-lg-12">            
                                                            <hr>
                                                            </div>
                                                        </div>
                                                        ';$indexSubtitulo++;
                                                            }//fin if subtitulo
                                                            elseif($tipo=='encabezado'){
                                                                $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">             
                                                                    <input type="hidden" name="numeroOrden_'.$value->id.'['."encabezado".']" value="'.$indexEncabezado.'"> 
                                                                    <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="encabezado">
                                                                    <input type="hidden"  name="idEncabezado_'.$indexEncabezado.'['.$value->id.']" id="idEncabezado_'.$i.'['.$value->id.']" value="'.@$buildTipoId[$value->id][$i].'">                
                                                                            <center>Encabezado</center>
                                                                        </div>
                                                                    <div class="col-lg-2">&nbsp;</div>
                                                                        <div class="col-lg-8">
                                                                            <input type="text" placeholder="Ingrese encabezado" class="form-control" title="Ingrese encabezado" value="'.@$buildActa[$value->id][$i].'" name="encabezadoActaE_'.$indexEncabezado.'['.$value->id.']">
                                                                        </div> 
                                                                    <div class="col-lg-12">            
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                                ';$indexEncabezado++;
                                                            }//fin if encabezado
                                                            elseif($tipo=='texto'){
                                                                $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">
                                                                    <input type="hidden" name="numeroOrden_'.$value->id.'['."texto".']" value="'.$indexTexto.'"> 
                                                                    <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="texto">
                                                                    <input type="hidden"  name="idTexto_'.$indexTexto.'['.$value->id.']" id="idTexto_'.$i.'['.$value->id.']" value="'.@$buildTipoId[$value->id][$i].'">     
                                                                            <center>Texto</center>
                                                                        </div>
                                                                    <div class="col-lg-2">&nbsp;</div>
                                                                        <div class="col-lg-8">
                                                                            <textarea placeholder="Ingrese texto" class="form-control" title="Ingrese texto" name="textoE_'.$indexTexto.'['.$value->id.']">'.@$buildActa[$value->id][$i].'</textarea>
                                                                        </div> 
                                                                    <div class="col-lg-12">            
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                                ';$indexTexto++;
                                                                }//fin if texto
                                                            elseif($tipo=='img'){
                                                                $htmlActa.='
                                                                        <div class="row fila_content" id="content_'.$i.'">
                                                                            <div class="col-lg-12">                                                                          
                                                                                <center>Imagen</center>
                                                                                <br>
                                                                                <center>
                                                                                <div style="margin-right:40px;margin-left:40px;">
                                                                                <input type="hidden" value="'.$i.'" name="img_index_id['.$value->id.']">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="imagen">
                                                                                <input type="hidden"  id="idImg_'.$value->id.'['.$i.']" name="idImg_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="nameImg_'.$value->id.'['.$i.']" value="'.@$buildActa[$value->id][$i].'">    
                                                                                    <img class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.@$buildActa[$value->id][$i].'"  id="outputE_'.$i.'['.$value->id.']"/>
                                                                                </div>
                                                                                </center>
                                                                            </div>
                                                                            <div class="col-lg-12"> 
                                                                            &nbsp;
                                                                            </div> 
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                                <br>
                                                                                <div id="img'.$i.'_'.$value->id.'">
                                                                                    <div class="col-lg-10">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <div class="col-md-2"></div>
                                                                                                    <div class="col-md-8 text-center">
                                                                                                        <div class="input-group">
                                                                                                            <span class="input-group-btn">
                                                                                                               <button value="0" onclick="bringPicture(event,'.$i.','.$value->id.','."'".($base_url.'calidad/getObjectImgEdit')."'".','.@$buildTipoId[$value->id][$i].');" class="btn btn-primary">Cambiar imagen</button>         
                                                                                                            </span>
                                                                                                            <input type="text" class="form-control" value="'.@$buildActa[$value->id][$i].'" readonly>
                                                                                                        </div>                              
                                                                                                    </div>
                                                                                                    <div class="col-md-2"></div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> 
                                                                                </div>
                                                                            <div class="col-lg-12">                                                                                    
                                                                            <hr>
                                                                            </div>
                                                                            </div>
                                                                ';$indexImagen++;
                                                                }//fin if imagen
                                                            elseif($tipo=='textoImagen'){
                                                                $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">       
                                                                        <center>Texto-Imagen</center>
                                                                        <br>
                                                                        <center>
                                                                        <div style="margin-right:40px;margin-left:40px;">
                                                                        <input type="hidden" value="'.$i.'" name="textoImg_index_id['.$value->id.']">
                                                                        <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="textoImagen">
                                                                        <input type="hidden"  id="idTextoImg_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'" name="idTextoImg_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                        <input type="hidden"  id="nameTextoImg_'.$value->id.'['.$i.']" value="'.$str[0].'">    
                                                                            <img class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.$str[0].'"  id="outputTE_'.$i.'['.$value->id.']"/>
                                                                        </div>
                                                                        </center>
                                                                    </div>
                                                                    <div class="col-lg-12"> 
                                                                    &nbsp;
                                                                    </div> 
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-11">
                                                                                <div class="col-lg-4">
                                                                                    <textarea class="form-control" title="Ingrese texto" name="textoIE_'.$i.'['.$value->id.']"  placeholder="Ingrese texto">'.$str[1].'</textarea>
                                                                                </div>
                                                                            <div id="img'.$i.'_'.$value->id.'">
                                                                                <div class="col-lg-8">
                                                                                    <div class="row">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-8 text-center">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-btn">
                                                                                                       <button value="0" onclick="bringPicture(event,'.$i.','.$value->id.','."'".($base_url.'calidad/getObjectTextoImgEdit')."'".','.@$buildTipoId[$value->id][$i].');" class="btn btn-primary">Cambiar imagen</button>         
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" value="'.$str[0].'" readonly>
                                                                                                </div>                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>    
                                                                        </div> 
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                            ';$indexTextoImagen++;
                                                            }//fin if texto imagen
                                                            elseif ($tipo=='imagenTexto') {
                                                                $str=explode(';',@$buildActa[$value->id][$i]);
                                                                $htmlActa.='
                                                                    <div class="row fila_content" id="content_'.$i.'">
                                                                        <div class="col-lg-12">                                                                                    
                                                                            <center>Imagen-Texto</center>
                                                                            <br>
                                                                            <center>
                                                                            <div style="margin-right:40px;margin-left:40px;">
                                                                                <input type="hidden" value="'.$i.'" name="imgTexto_index_id['.$value->id.']">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="imagenTexto">
                                                                                <input type="hidden"  name="idImgTexto_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'"  id="idImgTexto_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="nameImgTexto_'.$value->id.'['.$i.']" value="'.$str[0].'">  
                                                                                <img class="img-responsive" src="'.base_url().'img/Acta/acta_'.$idActa.'/modulo_'.$value->id.'/'.$str[0].'" id="outputIE_'.$i.'['.$value->id.']"/>
                                                                            </div>
                                                                            </center>
                                                                        </div>
                                                                        <div class="col-lg-12"> 
                                                                        &nbsp;
                                                                        </div> 
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                            <div class="col-lg-11">
                                                                            <div id="img'.$i.'_'.$value->id.'">
                                                                                <div class="col-lg-6">
                                                                                    <div class="row">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 text-center">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-btn">
                                                                                                       <button value="0" onclick="bringPicture(event,'.$i.','.$value->id.','."'".($base_url.'calidad/getObjectImgTextoEdit')."'".','.@$buildTipoId[$value->id][$i].');" class="btn btn-primary">Cambiar imagen</button>         
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" value="'.$str[0].'" readonly>
                                                                                                </div>                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>    
                                                                                <div class="col-lg-4"><textarea class="form-control" title="Ingrese texto" name="textoTE_'.$i.'['.$value->id.']"  placeholder="Ingrese texto">'.$str[1].'</textarea>
                                                                                </div>
                                                                            </div> 
                                                                        <div class="col-lg-12">                                                                                   
                                                                        <hr>
                                                                        </div>
                                                                    </div>
                                                                ';$indexImagenTexto++;
                                                            }//fin if imagen texto 
                                                            elseif ($tipo=='tableTwo') {
                                                            $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Tabla dos columnas</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                    <div class="col-lg-10">
                                                                        <table class="table table-bordered" id="tableTwoE_'.$value->id.'_'.$i.'">
                                                                            <tr>    
                                                                                <td colspan="2" align="center">
                                                                                    <button id="'.$value->id.'_'.$i.'" class="btn btn-default" onclick="agregarTDT(event,'.$value->id.','.$i.','.$indexTableTwo.');" value="agregar">Agregar Fila</button>
                                                                                    <button id="bt_del" class="btn btn-default" onclick="eliminarT(event,'.$value->id.','.$i.','."'".$base_url."'".','.$indexTableTwo.');" value="eliminar">Eliminar Fila</button>
                                                                                    <input type="hidden" id="posTableTwoE_'.$i.'['.$value->id.']" name="posTableTwoE_'.$i.'['.$value->id.']" value="0">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableTwo">
                                                                                <input type="hidden"  id="idTableTwo_'.$value->id.'['.$i.']" name="idTableTwo_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idTableTwoE_'.$value->id.'['.$indexTableTwo.']" name="idTableTwoE_'.$value->id.'['.$indexTableTwo.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" value="'.$str[0].'" name="tituloITDE2_'.$indexTableTwo.'['.$value->id.']"></td>
                                                                                <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" value="'.$str[1].'" name="tituloDTDE2_'.$indexTableTwo.'['.$value->id.']"></td>
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$indexTableTwo.'['."two".']['.$value->id.']">
                                                                                <input type="hidden" value="'.$indexTableTwo.'" id="tableTwoE_index_id['.$value->id.']" name="tableTwoE_index_id['.$value->id.']">
                                                                            </tr>';
                                                                            if (count($filaTwo[$value->id][$i]>=1) && $filaTwo[$value->id][$i]!=FALSE) { 
                                                                                $con=1;           
                                                                                foreach ($filaTwo[$value->id][$i] as $valueFila) {
                                                            $htmlActa.='                <tr class="filaTwoE" id="filaTE_'.$indexTableTwo.'_'.$con.'_'.$value->id.'"  onclick="seleccionar(this.id);">    
                                                                                            <td class="tableActaBody"><input type="hidden" id="idFilaTwoE'.$indexTableTwo.'_'.$con.'['.$value->id.']" value="'.$valueFila->id.'" name="idFilaTwoE'.$indexTableTwo.'_'.$con.'['.$value->id.']" value="'.$valueFila->id.'"><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITDE'.$indexTableTwo.'_'.$con.'['.$value->id.']">'.$valueFila->texto1.'</textarea>
                                                                                            </td>
                                                                                            <td class="tableActaBody"><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTDE'.$indexTableTwo.'_'.$con.'['.$value->id.']">'.$valueFila->texto2.'</textarea> 
                                                                                            </td>
                                                                                        </tr>';    
                                                                                        $con++;  
                                                                                } 
                                                            $htmlActa.='                    <input type="hidden" id="filaTwoE_index_id'.$indexTableTwo.'['.$value->id.']" value="'.($con-1).'" name="filaTwoE_index_id'.$indexTableTwo.'['.$value->id.']">';
                                                                            }
                                                            $htmlActa.='    <input type="hidden" value="0" id="con_'.$indexTableTwo.'['.$value->id.']" name="con_'.$indexTableTwo.'['.$value->id.']">';                
                                                            $htmlActa.='</table>
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                    </div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>';$indexTableTwo++;  
                                                            }//fin if filatwo
                                                            else if($tipo=='tableThree'){
                                                            $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                            <div class="row fila_content" id="content_'.$i.'">
                                                                <div class="col-lg-12">                                                                                    
                                                                    <center>Tabla tres columnas</center>
                                                                </div>
                                                                <div class="col-lg-1">&nbsp;</div>
                                                                <div class="col-lg-10">
                                                                    <table class="table table-bordered" id="tableThreeE_'.$value->id.'_'.$i.'">
                                                                        <tr>    
                                                                            <td colspan="3" align="center">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableThree">
                                                                                <button id="'.$value->id.'_'.$i.'" class="btn btn-default" onclick="agregarTDT3(event,'.$value->id.','.$i.','.$indexTableThree.');" value="Agregar">Agregar Fila</button>
                                                                                <button id="bt_del" class="btn btn-default" onclick="eliminarT(event,'.$value->id.','.$i.','."'".$base_url."'".','.$indexTableThree.');" value="Eliminar">Eliminar Fila</button>
                                                                                <input type="hidden" id="posTableThreeE_'.$i.'['.$value->id.']" name="posTableThreeE_'.$i.'['.$value->id.']" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <input type="hidden"  id="idTableThreeE_'.$value->id.'['.$indexTableThree.']" name="idTableThreeE_'.$value->id.'['.$indexTableThree.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                            <input type="hidden"  id="idTableThree_'.$value->id.'['.$i.']" name="idTableThree_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                            <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloITDE3_'.$indexTableThree.'['.$value->id.']" value="'.$str[0].'"></td>
                                                                            <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCTDE3_'.$indexTableThree.'['.$value->id.']" value="'.$str[1].'"></td>
                                                                            <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloDTDE3_'.$indexTableThree.'['.$value->id.']" value="'.$str[2].'"></td>
                                                                            <input type="hidden" value="'.$i.'" name="ordenActa_'.$value->id.'['."three".']['.$i.']">
                                                                            <input type="hidden" value="'.$indexTableThree.'" name="tableThreeE_index_id['.$value->id.']" id="tableThreeE_index_id['.$value->id.']">
                                                                        </tr>';
                                                                        if (count($filaThree[$value->id][$i]>=1) && $filaThree[$value->id][$i]!=FALSE) {  
                                                                            $con=1; 
                                                                            foreach ($filaThree[$value->id][$i] as $valueFila3) {
                                                            $htmlActa.='            <tr class="filaThreeE" id="filaTE3_'.$indexTableThree.'_'.$con.'_'.$value->id.'" onclick="seleccionar3(this.id);">
                                                                                        <td><input type="hidden" id="idFilaThreeE'.$indexTableThree.'_'.$con.'['.$value->id.']" value="'.$valueFila3->id.'" name="idFilaThreeE'.$indexTableThree.'_'.$con.'['.$value->id.']" value="'.$valueFila3->id.'"><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD3E_'.$indexTableThree.'_'.$con.'['.$value->id.']">'.$valueFila3->texto1.'</textarea>
                                                                                        </td>
                                                                                        <td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCTD3E_'.$indexTableThree.'_'.$con.'['.$value->id.']">'.$valueFila3->texto2.'</textarea>
                                                                                        </td>
                                                                                        <td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD3E_'.$indexTableThree.'_'.$con.'['.$value->id.']">'.$valueFila3->texto3.'</textarea>
                                                                                        </td>
                                                                                    </tr>';    
                                                                                    $con++;  
                                                                            }
                                                                        }
                                                        $htmlActa.='    <input type="hidden" id="filaThreeE_index_id'.$indexTableThree.'['.$value->id.']" value="'.($con-1).'" name="filaThreeE_index_id'.$indexTableThree.'['.$value->id.']">
                                                                        <input type="hidden" value="0" id="con3_'.$indexTableThree.'['.$value->id.']" name="con3_'.$indexTableThree.'['.$value->id.']">';      
                                                        $htmlActa.='</table>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                </div>
                                                                <div class="col-lg-12">                                                                                    
                                                                <hr>
                                                                </div>
                                                            </div>  
                                                            ';$indexTableThree++;
                                                            }//fin if filathree
                                                            elseif($tipo=='tableFour'){
                                                            $str=explode(';',@$buildActa[$value->id][$i]);
                                                        $htmlActa.='<div class="row fila_content" id="content_'.$i.'">
                                                                        <div class="col-lg-12">                                                                                    
                                                                            <center>Tabla cuatro columnas</center>
                                                                        </div>
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-10">
                                                                            <table class="table table-bordered" id="tableFourE_'.$value->id.'_'.$i.'">
                                                                                <tr>    
                                                                                    <td colspan="4" align="center">
                                                                                    <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableFour">
                                                                                        <button id="bt_add" class="btn btn-default" value="Agregar" onclick="agregarTDT4(event,'.$value->id.','.$i.','.$indexTableFour.');">Agregar Fila</button>
                                                                                        <button id="bt_del" class="btn btn-default" value="Eliminar" onclick="eliminarT(event,'.$value->id.','.$i.','."'".$base_url."'".','.$indexTableFour.');">Eliminar Fila</button>
                                                                                        <input type="hidden" id="posTableFourE_'.$i.'['.$value->id.']" name="posTableFourE_'.$i.'['.$value->id.']" value="0">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                <input type="hidden"  id="idTableFourE_'.$value->id.'['.$indexTableFour.']" name="idTableFourE_'.$value->id.'['.$indexTableFour.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idTableFour_'.$value->id.'['.$i.']" name="idTableFour_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                    <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloITDE4_'.$indexTableFour.'['.$value->id.']" value="'.$str[0].'"></td>
                                                                                    <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCITDE4_'.$indexTableFour.'['.$value->id.']" value="'.$str[1].'"></td>
                                                                                    <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCDTDE4_'.$indexTableFour.'['.$value->id.']" value="'.$str[2].'"></td>
                                                                                    <td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloDTDE4_'.$indexTableFour.'['.$value->id.']" value="'.$str[3].'"></td>
                                                                                    <input type="hidden" value="'.$i.'" name="ordenActa_'.$value->id.'['."four".']['.$i.']">
                                                                                    <input type="hidden" value="'.$indexTableFour.'" name="tableFourE_index_id['.$value->id.']" id="tableFourE_index_id['.$value->id.']">
                                                                                </tr>';
                                                            $htmlActa.='    <input type="hidden" value="0" id="con4_'.$indexTableFour.'['.$value->id.']" name="con4_'.$indexTableFour.'['.$value->id.']">';  
                                                                            if (count($filaFour[$value->id][$i])>=1 && $filaFour[$value->id][$i]!=FALSE) {
                                                                                $con=1; 
                                                                                foreach ($filaFour[$value->id][$i] as $valueFila4) {
                                                                                $htmlActa.='
                                                                                    <tr class="filaFourE" id="filaTE4_'.$indexTableFour.'_'.$con.'_'.$value->id.'" onclick="seleccionar4(this.id);">
                                                                                        <td><input type="hidden" id="filaFourE_index_id'.$indexTableFour.'['.$value->id.']" value="'.$con.'" name="filaFourE_index_id'.$indexTableFour.'['.$value->id.']"><input type="hidden" id="idFilaFourE'.$indexTableFour.'_'.$con.'['.$value->id.']" name="idFilaFourE'.$indexTableFour.'_'.$con.'['.$value->id.']" value="'.$valueFila4->id.'"><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoITD4E_'.$indexTableFour.'_'.$con.'['.$value->id.']">'.$valueFila4->texto1.'</textarea></td>
                                                                                        <td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCITD4E_'.$indexTableFour.'_'.$con.'['.$value->id.']">'.$valueFila4->texto2.'</textarea></td>
                                                                                        <td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoCDTD4E_'.$indexTableFour.'_'.$con.'['.$value->id.']">'.$valueFila4->texto3.'</textarea></td>
                                                                                        <td><textarea type="text" title="Ingrese Texto" class="form-control" placeholder="Ingrese texto" name="textoDTD4E_'.$indexTableFour.'_'.$con.'['.$value->id.']">'.$valueFila4->texto4.'</textarea></td>
                                                                                    </tr>
                                                                                    ';
                                                                                    $con++;
                                                                                }              
                                                                            }  
                                                            $htmlActa.='                       
                                                                            </table>
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                        </div>
                                                                        <div class="col-lg-12">                                                                                    
                                                                        <hr>
                                                                        </div>
                                                                    </div>';
                                                                    $indexTableFour++;
                                                            }//fin if table four
                                                            elseif($tipo=='tableFive'){
                                                                $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Tabla Columna-'.count($str).' Fila-'.count($filaFive[$value->id][$i]).'</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-10">
                                                                            <table class="table table-bordered" id="tableOtro_'.$i.'_'.$value->id.'">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableFive">
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$value->id.'['."otro".']['.$i.']">
                                                                                <input type="hidden" value="'.$indexTableFive.'" name="tableFiveE_index_id['.$value->id.']">
                                                                                <input type="hidden"  id="idTableFive_'.$value->id.'['.$i.']"  name="idTableFive_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idTableFiveE_'.$value->id.'['.$i.']"  name="idTableFiveE_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <tr>';
                                                                                $pos=1;
                                                                                for ($k=0; $k <count($str) ; $k++) { 
                                                            $htmlActa.='            <td><input value="'.$str[$k].'" type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloN_'.$pos++.'TD_'.$value->id.'['.$i.']"></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                    $pos=1;
                                                                                    $conPos=1;
                                                                                for ($j=0; $j <count($filaFive[$value->id][$i]); $j++) {
                                                            $htmlActa.='        <tr>
                                                                                    <input type="hidden" id="filaFiveE_index_id'.$indexTableFive.'['.$value->id.']" value="'.$conPos.'" name="filaFiveE_index_id'.$indexTableFive.'['.$value->id.']"><input type="hidden" id="idFilaFiveE'.$indexTableFive.'_'.$conPos.'['.$value->id.']" name="idFilaFiveE'.$indexTableFive.'_'.$conPos.'['.$value->id.']" value="'.$filaFive[$value->id][$i][$j]->id.'">';
                                                                                $text='texto'; 
                                                                                $conPos++;  
                                                                                for ($k=0; $k <count($str); $k++) { 
                                                                                    $$text='texto'.($k+1);          
                                                            $htmlActa.='            <td><textarea type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="textoOtroN'.$pos++.'TD_'.$value->id.'['.$i.']">'.$filaFive[$value->id][$i][$j]->${$text}.'</textarea></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                }
                                                            $htmlActa.='
                                                                            </table>
                                                                            <input type="hidden" id="posTableFiveE_'.$indexTableFive.'['.$value->id.']" name="posTableFiveE_'.$indexTableFive.'['.$value->id.']" value="'.$pos.'">    
                                                                            <input type="hidden" id="columnaFiveE_'.$indexTableFive.'['.$value->id.']" name="columnaFiveE_'.$indexTableFive.'['.$value->id.']" value="'.$i.'">  
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                        </div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                            ';$indexTableFive++;
                                                            }//fin if table five
                                                            elseif($tipo=='tableSix'){
                                                                $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Tabla Columna-'.count($str).' Fila-'.count($filaSix[$value->id][$i]).'</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-10">
                                                                            <table class="table table-bordered" id="tableOtro_'.$i.'_'.$value->id.'">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableSix">
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$value->id.'['."otro".']['.$i.']">
                                                                                <input type="hidden" value="'.$indexTableSix.'" name="tableSixE_index_id['.$value->id.']">
                                                                                <input type="hidden"  id="idTableSix_'.$value->id.'['.$i.']" name="idTableSix_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idTableSixE_'.$value->id.'['.$i.']" name="idTableSixE_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <tr>';
                                                                                $pos=1;
                                                                                $conPos=1;
                                                                                for ($k=0; $k <count($str) ; $k++) { 
                                                            $htmlActa.='            <td><input value="'.$str[$k].'" type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloN_'.$pos++.'TD_'.$value->id.'['.$i.']"></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                    $pos=1;
                                                                                for ($j=0; $j <count($filaSix[$value->id][$i]); $j++) {
                                                            $htmlActa.='        <tr>
                                                                                    <input type="hidden" id="filaSixE_index_id'.$indexTableSix.'['.$value->id.']" value="'.$conPos.'" name="filaSixE_index_id'.$indexTableSix.'['.$value->id.']"><input type="hidden" id="idFilaSixE'.$indexTableSix.'_'.$conPos.'['.$value->id.']" name="idFilaSixE'.$indexTableSix.'_'.$conPos.'['.$value->id.']" value="'.$filaSix[$value->id][$i][$j]->id.'">';
                                                                                $text='texto';   
                                                                                $conPos++;
                                                                                for ($k=0; $k <count($str); $k++) { 
                                                                                    $$text='texto'.($k+1);
                                                            $htmlActa.='            <td><textarea type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="textoOtroN'.$pos++.'TD_'.$value->id.'['.$i.']">'.$filaSix[$value->id][$i][$j]->${$text}.'</textarea></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                }
                                                            $htmlActa.='
                                                                            </table>
                                                                            <input type="hidden" id="posTableSixE_'.$indexTableSix.'['.$value->id.']" name="posTableSixE_'.$indexTableSix.'['.$value->id.']" value="'.$pos.'">    
                                                                            <input type="hidden" id="columnaSixE_'.$indexTableSix.'['.$value->id.']" name="columnaSixE_'.$indexTableSix.'['.$value->id.']" value="'.$i.'">  
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                        </div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                            ';$indexTableSix++;
                                                            }//fin if table six
                                                            elseif ($tipo=='tableSeven') {
                                                            $str=explode(';',@$buildActa[$value->id][$i]);
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Tabla Columna-'.count($str).' Fila-'.count($filaSeven[$value->id][$i]).'</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-10">
                                                                            <table class="table table-bordered" id="tableOtro_'.$i.'_'.$value->id.'">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="tableSeven">
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$value->id.'['."otro".']['.$i.']">
                                                                                <input type="hidden" value="'.$indexTableSeven.'" name="tableSevenE_index_id['.$value->id.']">
                                                                                <input type="hidden"  id="idTableSeven_'.$value->id.'['.$i.']" name="idTableSeven_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idTableSevenE_'.$value->id.'['.$i.']" name="idTableSevenE_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <tr>';
                                                                                $pos=1;
                                                                                $conPos=1;
                                                                                for ($k=0; $k <count($str) ; $k++) { 
                                                            $htmlActa.='            <td><input value="'.$str[$k].'" type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloN_'.$pos++.'TD_'.$value->id.'['.$i.']"></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                    $pos=1;
                                                                                for ($j=0; $j <count($filaSeven[$value->id][$i]); $j++) {
                                                            $htmlActa.='        <tr>
                                                                                    <input type="hidden" id="filaSevenE_index_id'.$indexTableSeven.'['.$value->id.']" value="'.$conPos.'" name="filaSevenE_index_id'.$indexTableSeven.'['.$value->id.']">
                                                                                    <input type="hidden" id="idFilaSevenE'.$indexTableSeven.'_'.$conPos.'['.$value->id.']" name="idFilaSevenE'.$indexTableSeven.'_'.$conPos.'['.$value->id.']" value="'.$filaSeven[$value->id][$i][$j]->id.'">';
                                                                                $text='texto';  
                                                                                $conPos++; 
                                                                                for ($k=0; $k <count($str); $k++) { 
                                                                                    $$text='texto'.($k+1);
                                                            $htmlActa.='            <td><textarea type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="textoSevenN'.$pos++.'TD_'.$value->id.'['.$i.']">'.$filaSeven[$value->id][$i][$j]->${$text}.'</textarea></td>';
                                                                                }
                                                            $htmlActa.='        </tr>';
                                                                                }
                                                            $htmlActa.='
                                                                            </table>
                                                                            <input type="hidden" id="posTableSevenE_'.$value->id.'['.$i.']" name="posTableSevenE_'.$value->id.'['.$i.']" value="'.$pos.'">    
                                                                            <input type="hidden" id="columnaSevenE_'.$value->id.'['.$i.']" name="columnaSevenE_'.$value->id.'['.$i.']" value="'.$i.'">  
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                        </div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>';$indexTableSeven++;    
                                                            }//fin if table seven
                                                            elseif ($tipo=='graphic') {
                                                                $str=explode(';',@$buildActa[$value->id][$i]);
                                                                $id=$str[4];
                                                                $url=base_url();
                                                                if ($id==1) {
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Grafico de barras</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                    <div class="col-lg-10">
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td><center>Titulo Grafico</center></td>
                                                                                <td><center>Subtitulo Grafico</center></td>
                                                                                <td><center>Subtitulo Lateral del grafico</center></td>
                                                                                <td><center>Punto inicial eje X</center></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="text" value="'.$str[0].'" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGraficoE_'.$indexGraphicBarra.'['.$value->id.']" id="tituloGraficoE_'.$indexGraphicBarra.'['.$value->id.']"></td>
                                                                                <td><input type="text" value="'.$str[1].'" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGraficoE_'.$indexGraphicBarra.'['.$value->id.']" id="subtituloGraficoE_'.$indexGraphicBarra.'['.$value->id.']"></td>
                                                                                <td><input type="text" value="'.$str[2].'" title="Ingrese subtitulo lateral" class="form-control" placeholder="Ingrese Subtitulo Grafico (Y)" name="tituloGraficoYE_'.$indexGraphicBarra.'['.$value->id.']" id="tituloGraficoYE_'.$indexGraphicBarra.'['.$value->id.']"></td>
                                                                                <td><input type="number" value="'.$str[3].'" title="Ingrese punto de inicio" class="form-control" placeholder="Ingrese punto de inicio" name="startE_'.$indexGraphicBarra.'['.$value->id.']" id="startE_'.$indexGraphicBarra.'['.$value->id.']"></td>
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="graphic">
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$i.'['."gBarra".']['.$value->id.']">
                                                                                <input type="hidden" value="'.$indexGraphicBarra.'" min="0" name="graficoBarraE_index_id['.$value->id.']">
                                                                                <input type="hidden"  id="idGraphicE_'.$value->id.'['.$i.']" name="idGraphicE_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idGraphicEd_'.$value->id.'['.$indexGraphicBarra.']" name="idGraphicEd_'.$value->id.'['.$indexGraphicBarra.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                            </tr>
                                                                        </table>
                                                                        </br>
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td><center>Titulo columna</center></td>
                                                                                <td><center>Datos columna</center></td>
                                                                            </tr>';
                                                                            $cont=1;

                                                                            foreach ($filaGraphic[$str[5]][$value->id] as $graphic) {
                                                            $htmlActa.='        <tr>
                                                                                    <input type="hidden" id="filaGraphicBarraE_index_id'.$indexGraphicBarra.'['.$value->id.']" value="'.$cont.'" name="filaGraphicBarraE_index_id'.$indexGraphicBarra.'['.$value->id.']">
                                                                                    <input type="hidden" id="idFilaGraphicBarraE'.$indexGraphicBarra.'_'.$cont.'['.$value->id.']" name="idFilaGraphicBarraE'.$indexGraphicBarra.'_'.$cont.'['.$value->id.']" value="'.$graphic->id.'">
                                                                                <td>
                                                                                    <input value="'.$graphic->tituloColumna.'" type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTBarraE'.$cont.'_'.$indexGraphicBarra.'['.$value->id.']" id="dataTBarraE'.$cont.'_'.$indexGraphicBarra.'['.$value->id.']">
                                                                                </td>
                                                                                <td>
                                                                                    <input value="'.$graphic->datosColumna.'" type="text" title="Ingrese Datos separados por ," class="form-control" placeholder="Ejem: 1,2,3,4,5" onkeyup="validarData(event);" name="dataBarraE'.$cont.'_'.$indexGraphicBarra.'['.$value->id.']" id="dataBarraE'.$cont.'_'.$indexGraphicBarra.'['.$value->id.']">                
                                                                                </td>   
                                                                            </tr>';
                                                                            $cont++;
                                                                            }
                                                            $htmlActa.='            
                                                                        <tr>
                                                                            <td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGraficaE(event,'.$cont.','.$indexGraphicBarra.','.$value->id.','.$id.','."'".$base_url."'".')">ver</button></center></td>
                                                                        </tr>
                                                                            <input type="hidden" id="posBarraE_'.$indexGraphicBarra.'['.$value->id.']" name="posBarraE_'.$indexGraphicBarra.'['.$value->id.']" value="'.$cont.'">   
                                                                        </table>
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                    </div>
                                                                    <div id="containerE_'.$indexGraphicBarra.'_'.$value->id.'" class="col-lg-12"></div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>
                                                                        ';$indexGraphicBarra++;
                                                            }else if($id==2){
                                                            $htmlActa.='
                                                                <div class="row fila_content" id="content_'.$i.'">
                                                                    <div class="col-lg-12">                                                                                    
                                                                        <center>Grafico de Pie</center>
                                                                    </div>
                                                                    <div class="col-lg-1">&nbsp;</div>
                                                                    <div class="col-lg-10">
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td><center>Titulo Grafico</center></td>
                                                                                <td><center>Subtitulo Grafico</center></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="text" value="'.$str[0].'" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGraficoPE_'.$indexGraphicPie.'['.$value->id.']" id="tituloGraficoPE_'.$indexGraphicPie.'['.$value->id.']"></td>
                                                                                <td><input type="text" value="'.$str[1].'" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGraficoPE_'.$indexGraphicPie.'['.$value->id.']" id="subtituloGraficoPE_'.$indexGraphicPie.'['.$value->id.']"></td>
                                                                                <input type="hidden" value="'.$i.'" name="ordenActa_'.$i.'['."gPie".']['.$value->id.']">
                                                                                <input type="hidden" value="'.$indexGraphicPie.'" min="0" name="graficoPieE_index_id['.$value->id.']">
                                                                                <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="graphic">
                                                                                <input type="hidden"  id="idGraphicPE_'.$value->id.'['.$i.']" name="idGraphicPE_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idGraphicE_'.$value->id.'['.$i.']" name="idGraphicE_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                <input type="hidden"  id="idGraphicPeE_'.$value->id.'['.$indexGraphicPie.']" name="idGraphicPeE_'.$value->id.'['.$indexGraphicPie.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                            </tr>
                                                                        </table>
                                                                        </br>
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td><center>Titulo columna</center></td>
                                                                                <td><center>Datos columna</center></td>
                                                                            </tr>';
                                                                            $cont=1;
                                                                            foreach ($filaGraphicPie[$str[5]][$value->id] as $graphicPie) { 
                                                                            
                                                            $htmlActa.='        <tr>
                                                                                <td>
                                                                                <input type="hidden" id="filaGraphicPieE_index_id'.$indexGraphicPie.'['.$value->id.']" value="'.$cont.'" name="filaGraphicPieE_index_id'.$indexGraphicPie.'['.$value->id.']">
                                                                                    <input type="hidden" id="idFilaGraphicPieE'.$indexGraphicPie.'_'.$cont.'['.$value->id.']" name="idFilaGraphicPieE'.$indexGraphicPie.'_'.$cont.'['.$value->id.']" value="'.$graphicPie->id.'">
                                                                                    <input value="'.$graphicPie->tituloColumna.'" type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTPieE'.$cont.'_'.$indexGraphicPie.'['.$value->id.']" id="dataTPieE'.$cont.'_'.$indexGraphicPie.'['.$value->id.']">
                                                                                </td>
                                                                                <td>
                                                                                    <input value="'.$graphicPie->datosColumna.'" type="number"  min="0" step="0.10" title="Ingrese Dato numerico" class="form-control" placeholder="Ejem: 0.5" name="dataPieE'.$cont.'_'.$indexGraphicPie.'['.$value->id.']" id="dataPieE'.$cont.'_'.$indexGraphicPie.'['.$value->id.']">             
                                                                                </td>   
                                                                            </tr>';
                                                                            $cont++;
                                                                            }
                                                            $htmlActa.='            
                                                                        <tr>
                                                                            <td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGraficaE(event,'.$cont.','.$indexGraphicPie.','.$value->id.','.$id.','."'".$base_url."'".')">ver</button></center></td>
                                                                        </tr>
                                                                            <input type="hidden" name="posPieE_'.$indexGraphicPie.'['.$value->id.']" id="posPieE_'.$indexGraphicPie.'['.$value->id.']" value="'.$cont.'">
                                                                            
                                                                        </table>
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                    </div>
                                                                    <div id="containerPE_'.$indexGraphicPie.'_'.$value->id.'" class="col-lg-12"></div>
                                                                    <div class="col-lg-12">                                                                                    
                                                                    <hr>
                                                                    </div>
                                                                </div>';$indexGraphicPie++;
                                                            }elseif($id==3){
                                                                $htmlActa.='
                                                                    <div class="row fila_content" id="content_'.$i.'">
                                                                        <div class="col-lg-12">                                                                                    
                                                                            <center>Grafico de lineas</center>
                                                                        </div>
                                                                        <div class="col-lg-1">&nbsp;</div>
                                                                        <div class="col-lg-10">
                                                                            <table class="table table-bordered">
                                                                                <tr>
                                                                                    <td><center>Titulo Grafico</center></td>
                                                                                    <td><center>Subtitulo Grafico</center></td>
                                                                                    <td><center>Subtitulo Lateral del grafico</center></td>
                                                                                    <td><center>Punto inicial eje X</center></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><input value="'.$str[0].'" type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGraficoLE_'.$indexGraphicLinea.'['.$value->id.']" id="tituloGraficoLE_'.$indexGraphicLinea.'['.$value->id.']"></td>
                                                                                    <td><input value="'.$str[1].'" type="text" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGraficoLE_'.$indexGraphicLinea.'['.$value->id.']" id="subtituloGraficoLE_'.$indexGraphicLinea.'['.$value->id.']"></td>
                                                                                    <td><input value="'.$str[2].'" type="text" title="Ingrese subtitulo lateral" class="form-control" placeholder="Ingrese Subtitulo Grafico (Y)" name="tituloGraficoYLE_'.$indexGraphicLinea.'['.$value->id.']" id="tituloGraficoYLE_'.$indexGraphicLinea.'['.$value->id.']"></td>
                                                                                    <td><input value="'.$str[3].'" type="number" title="Ingrese punto de inicio" class="form-control" placeholder="Ingrese punto de inicio" name="startLE_'.$indexGraphicLinea.'['.$value->id.']" id="startLE_'.$indexGraphicLinea.'['.$value->id.']"></td>
                                                                                    <input type="hidden" value="'.$i.'" name="ordenActa_'.$i.'['."gLinea".']['.$value->id.']">
                                                                                    <input type="hidden" value="'.$indexGraphicLinea.'" min="0" name="graficoLineaE_index_id['.$value->id.']">
                                                                                    <input type="hidden" id="accion_'.$value->id.'['.$i.']" value="graphic">
                                                                                    <input type="hidden"  id="idGraphicE_'.$value->id.'['.$i.']" name="idGraphicE_'.$value->id.'['.$i.']" value="'.@$buildTipoId[$value->id][$i].'">
                                                                                    <input type="hidden"  id="idGraphicEd_'.$value->id.'['.$i.']"  name="idGraphicEd_'.$value->id.'['.$i.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                     <input type="hidden"  id="idGraphicLE_'.$value->id.'['.$indexGraphicLinea.']"  name="idGraphicLE_'.$value->id.'['.$indexGraphicLinea.']"  value="'.@$buildTipoId[$value->id][$i].'">
                                                                                </tr>
                                                                            </table>
                                                                            </br>
                                                                            <table class="table table-bordered">
                                                                                <tr>
                                                                                    <td><center>Titulo columna</center></td>
                                                                                    <td><center>Datos columna</center></td>
                                                                                </tr>';
                                                                                $cont=1;
                                                                                 foreach ($filaGraphicLinea[$str[5]][$value->id] as $graphicLinea) { 
                                                                                
                                                                $htmlActa.='        <tr>
                                                                                    <td>
                                                                                    <input type="hidden" id="filaGraphicLineaE_index_id'.$indexGraphicLinea.'['.$value->id.']" value="'.$cont.'" name="filaGraphicLineaE_index_id'.$indexGraphicLinea.'['.$value->id.']">
                                                                                        <input type="hidden" id="idFilaGraphicLineaE'.$indexGraphicLinea.'_'.$cont.'['.$value->id.']" name="idFilaGraphicLineaE'.$indexGraphicLinea.'_'.$cont.'['.$value->id.']" value="'.$graphicLinea->id.'">
                                                                                        <input value ="'.$graphicLinea->tituloColumna.'" type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTLineaE'.$cont.'_'.$indexGraphicLinea.'['.$value->id.']" id="dataTLineaE'.$cont.'_'.$indexGraphicLinea.'['.$value->id.']">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input value="'.$graphicLinea->datosColumna.'" type="text" title="Ingrese Datos separados por ," class="form-control" placeholder="Serie 1,Serie 2,Serie 3" onkeyup="validarData(event);" name="dataLineaE'.$cont.'_'.$indexGraphicLinea.'['.$value->id.']" id="dataLineaE'.$cont.'_'.$indexGraphicLinea.'['.$value->id.']">                
                                                                                    </td>   
                                                                                </tr>';
                                                                                $cont++; 
                                                                                }
                                                                $htmlActa.='            
                                                                            <tr>
                                                                                <td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGraficaE(event,'.$cont.','.$indexGraphicLinea.','.$value->id.','.$id.','."'".$base_url."'".')">ver</button></center></td>
                                                                            </tr>
                                                                                <input type="hidden" id="posLineaE_'.$indexGraphicLinea.'['.$value->id.']" name="posLineaE_'.$indexGraphicLinea.'['.$value->id.']" value="'.$cont.'">   
                                                                            </table>
                                                                            <div class="col-lg-1">&nbsp;</div>
                                                                        </div>
                                                                        <div id="containerLE_'.$indexGraphicLinea.'_'.$value->id.'" class="col-lg-12"></div>
                                                                        <div class="col-lg-12">                                                                                    
                                                                        <hr>
                                                                        </div>
                                                                    </div>
                                                                            ';$indexGraphicLinea++;
                                                            }//fin id 3 graphic
                                                        }//fin if graphic
                                                    }
                                                        echo $htmlActa;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12" id="contenedor_botones_<?php echo $index; ?>">
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col-md-5">&nbsp;</div>
                                                                <div class="col-md-1"><input type="button" id="removerA_<?php echo $index; ?>" class="btn btn-default" value="-" title="Remover" onClick="envioObject(event,this.id,'<?php echo $base_url ?>');"></div>
                                                                <div class="col-md-5">&nbsp;</div>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="loading_<?php echo $index; ?>" class="hidden">
                                                    <div class="row">
                                                        <div class="col-md-5">&nbsp;</div>
                                                        <div class="col-md-2 ">
                                                            <div class="row">
                                                                <div class="col-md-4">&nbsp;</div>
                                                                <div class="col-md-4"><img src="<?php echo base_url(); ?>img/progress.gif" alt="" /><h1></h1></div>
                                                                <div class="col-md-4">&nbsp;</div>
                                                            </div>
                                                        </div>          
                                                        <div class="col-md-5">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <?php 
                                                $index++;      
                                                    }
                                                ?>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <center>
                                                            <input class="btn btn-default" type="reset" value="Limpiar">
                                                            <button type="submit" name="enviar" id="enviar" value="enviar" class="btn btn-default">Guardar</button>
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="hidden" id="LoadingEnviar">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label>Enviando...</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <center><a <?php $site_urll=site_url('calidad/viewActa/');?>  href="<?php echo $site_urll; ?>" class="btn btn-default" style="margin-top:40px;">Volver</a></center>
            <br>
            <br>
        </div>    
    </div>
    <script type="text/javascript">
        $( function() {
            $('#datepicker').datepicker({
                    autoclose: true,
                    format: 'mm/dd/yyyy'
            });
            $('#datepickervigencia').datepicker({
                    autoclose: true,
                    format: 'mm/dd/yyyy'
            });
            $('#datepickermonth').datepicker({
                autoclose: true,
                   format: "mm-yyyy",
                    viewMode: "months", 
                    minViewMode: "months"
            });
            $('#datepickermonth1').datepicker({
                autoclose: true,
                   format: "mm-yyyy",
                    viewMode: "months", 
                    minViewMode: "months"
            });
        });
    </script>
    <script type="text/javascript">
        function validarCampo(){
            var fechaI=document.getElementById('datepickermonth').value;
            var fechaF=document.getElementById('datepickermonth1').value;
            var horaI=document.getElementById('hora').value;
            var horaF=document.getElementById('hora1').value;
            if (!validarTodosCampos('form_informacion_general', 'Todos los campos deben estar llenos')) {
                return false;;
            }
            if (fechaF<=fechaI) {
                alert('La fecha de inicio no puede ser menor o igual a la fecha final');
                return false;
            }
            if (horaF<=horaI) {
                alert('La hora de inicio no puede ser menor o igual a la hora final');
                return false;
            }
            p=confirm('Para completar el proceso de crear de click al botón Ok');
            if(p){
                document.form_informacion_general.submit();
                var res=$('#info').hasClass('in');
                localStorage.setItem("res", res);
            }

        }
        $("#form_contenido").on('submit',(function(e) {
            e.preventDefault();
            if (!validarTodosCampos('form_contenido', 'Todos los campos deben estar llenos')) {
                return false;
            }
            if($('.fila_content').length <= 0 ){
                alert('Contenido vacio');
                return false;
            }
            p=confirm('Para completar el proceso de crear de click al botón Ok');
            if(p){
                 $.ajax({
                url: '<?php echo base_url();?>'+"calidad/insertEditActaContenido",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false
                ,
                beforeSend: function() {
                    $('#LoadingEnviar').removeClass('hidden');
                },
                success: function(data)
                {
                alert(data);
                $('#LoadingEnviar').addClass('hidden');
                    window.location='viewActa';
                },
                error: function() 
                {
                    alert('Upsss ocurrio algo :(');
                }           
                });
            }
        }));
    </script>
    <script src='<?php echo base_url();?>js/autosize.js'></script>
    <script>
        autosize(document.querySelectorAll('textarea'));
        $(document).ready(function(){
          $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
          });
        });
    </script>
<script>
  var loadFile = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
  var loadFileE = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputE_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
    var loadFileT = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputT_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
  var loadFileTE = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputTE_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
    var loadFileIT = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputI_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
  var loadFileITE = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputIE_'+index_id+'['+index+']');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>