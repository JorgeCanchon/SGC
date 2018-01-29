<div id="wrapper">
    <div id="page-wrapper">   
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="<?php echo base_url() ?>calidad/updateMedicion" id="form_edit_medicion" name="form_edit_medicion">
                    <input type="hidden" name="idFichaIndicador" value="<?php echo $id; ?>">
                    <table class="table-bordered button-editar" style="margin-top:30px;">
                        <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                  <?php
                                  if($barra_superior){
                                    echo '<input type="text" name="codigoIndicador" class="form-control" value="'.$fichaIndicador->codigoIndicador.'">';
                                  }else{
                                     echo $fichaIndicador->codigoIndicador; 
                                  }
                                  ?>
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
                                  <?php 
                                  if($barra_superior){
                                    echo '<input type="text" name="version" class="form-control" value="'.$fichaIndicador->version.'">';
                                  }else{
                                    echo $fichaIndicador->version;
                                  }
                                  ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4">
                                <b>Fecha de vigencia:</b>
                                <center>
                                    <?php 
                                    if($barra_superior){
                                        echo '<input name="fechaVigencia" class="form-control" value="'.$fichaIndicador->fechaVigencia.'">'; 
                                    }else{
                                        echo $fichaIndicador->fechaVigencia; 
                                    }
                                    ?>
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
                                <?php echo $fichaIndicador->procesoInf; 
                                 echo '<input type="hidden" name="nombreProceso" value="'.$fichaIndicador->procesoInf.'">';
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableIndicadorHead" width="30%">
                               Nombre del Indicador:
                            </td>
                            <td class="tableActaBody">
                                <?php 
                                echo $fichaIndicador->nombreIndicador; 
                                echo '<input type="hidden" name="nombreIndicador" value="'.$fichaIndicador->nombreIndicador.'">';
                                echo '<input type="hidden" id="id_proceso" value="'.$fichaIndicador->idPR.'">';
                                ?>
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
                                        echo 'Porcentaje
                                        <input type="hidden" id="unidad" value="Porcentaje">';
                                        $porcentaje=TRUE;
                                    }else{
                                        echo 'Decimal
                                        <input type="hidden" id="unidad" value="Decimal">';
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
                            $index=1;
                                foreach ($comportamiento as $value) {
                                    if($value->codigoFichaIndicador==$fichaIndicador->id){
                                        if($value->estado==1 || $value->estado==2){
                                    echo '<tr class="fila">';
                                   echo '<td class="tableActaBody">'.$p++.'
                                            <input type="hidden" name="idIndicador" id="idIndicador" value="'.$indicador->id.'">
                                            <input type="hidden" name="idComportamiento['.$index.']" id="idComportamiento_'.$index.'" value="'.$value->idComportamiento.'">
                                        </td>';
                                   echo '<td class="tableActaBody">
                                            <input type="date" class="form-control" name="fechaM['.$index.']" id="fechaM_'.$index.'" value="'.$value->fechaMedicion.'" readonly>
                                        </td>';
                                   echo '<td class="tableActaBody">';
                                            $periodo = explode("/", $value->fechaPEvaluado);
                                    echo    '<input type="date" name="periodo1['.$index.']" id="periodo1_'.$index.'" class="form-control" onchange="sincronizarFechas();" value="'.$periodo[0].'" readonly>'; 
                                    echo    '<center>-</center>';
                                    echo    '<input type="date" name="periodo2['.$index.']" id="periodo2_'.$index.'" class="form-control" onchange="sincronizarFechas();" value="'.trim($periodo[1]).'" readonly>';
                                echo    '</td>';
                                   echo '<td class="tableActaBody">'
                                            .$value->meta.
                                        '</td>';
                                   echo '<td class="tableActaBody">
                                            <input type="number" onchange="calculateResult();" min="1" name="numerador['.$index.']" id="numerador_'.$index.'" class="form-control" value="'.$value->valorN.'" readonly>
                                        </td>';
                                   echo '<td class="tableActaBody">';
                                            if($porcentaje){
                                    echo'    <input type="number" onchange="calculateResult();" class="form-control" min="1" name="denominador['.$index.']" id="denominador_'.$index.'" value="'.$value->valorD.'" readonly>';        
                                            }else{
                                    echo'    <input type="text" onchange="calculateResult();" class="form-control" min="1" name="denominador['.$index.']" id="denominador_'.$index.'" value="'.$value->valorD.'" readonly>';
                                            }
                                    echo'     
                                        </td>';
                                   echo '<td class="tableActaBody">
                                            <input type="number" class="form-control" name="resultado['.$index.']" id="resultado_'.$index.'" value="'.$value->resultado.'" readonly>
                                        </td>';
                                    echo '<td class="tableActaBody">';
                                        if($value->estado==1){
                                echo'Aprobado';
                                        }else{
                                echo'En revisión';
                                        }
                               echo'     </td>';
                                echo ' </tr>'; 
                                        }else{
                                echo '<tr class="fila">';
                                   echo '<td class="tableActaBody">'.$p++.'
                                            <input type="hidden" name="idIndicador" id="idIndicador" value="'.$indicador->id.'">
                                            <input type="hidden" name="idComportamiento['.$index.']" id="idComportamiento_'.$index.'" value="'.$value->idComportamiento.'">
                                        </td>';
                                   echo '<td class="tableActaBody">
                                            <input type="date" class="form-control" name="fechaM['.$index.']" id="fechaM_'.$index.'" value="'.$value->fechaMedicion.'">
                                        </td>';
                                   echo '<td class="tableActaBody">';
                                            $periodo = explode("/", $value->fechaPEvaluado);
                                    echo    '<input type="date" name="periodo1['.$index.']" id="periodo1_'.$index.'" class="form-control" onchange="sincronizarFechas();" value="'.$periodo[0].'">'; 
                                    echo    '<center>-</center>';
                                    echo    '<input type="date" name="periodo2['.$index.']" id="periodo2_'.$index.'" class="form-control" onchange="sincronizarFechas();" value="'.trim($periodo[1]).'">';
                                echo    '</td>';
                                   echo '<td class="tableActaBody">'
                                            .$value->meta.
                                        '</td>';
                                   echo '<td class="tableActaBody">
                                            <input type="number" onchange="calculateResult();" min="1" name="numerador['.$index.']" id="numerador_'.$index.'" class="form-control" value="'.$value->valorN.'">
                                        </td>';
                                   echo '<td class="tableActaBody">';
                                            if($porcentaje){
                                    echo'    <input type="number" class="form-control" min="1" name="denominador['.$index.']" id="denominador_'.$index.'" onchange="calculateResult();" value="'.$value->valorD.'">';        
                                            }else{
                                    echo'    <input type="text" class="form-control" min="1" name="denominador['.$index.']" id="denominador_'.$index.'" onchange="calculateResult();" value="'.$value->valorD.'" readonly>';
                                            }
                                    echo'     
                                        </td>';
                                    echo '<td class="tableActaBody">
                                            <input type="number" class="form-control" name="resultado['.$index.']" id="resultado_'.$index.'" value="'.$value->resultado.'" readonly>
                                        </td>';
                                    echo '<td class="tableActaBody">
                                            No aprobado
                                        </td>';
                                echo ' </tr>'; 
                                }
                                    $index++;
                                    }
                                }
                            }else{
                                echo '
                                <tr>
                                        <td colspan="8">No hay resultados para la busqueda</td>
                                </tr>';
                            }
                             ?>
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
                            $index=1;
                            $estado=true;
                            foreach ($comportamiento as $value) {
                                if($value->codigoFichaIndicador==$fichaIndicador->id){
                                    if($value->estado==1 || $value->estado==2){
                                    echo'<tr class="filaM"> 
                                            <td class="tableActaBody" width="20%">
                                                <input type="hidden" name="idAnalisis['.$index.']" value="'.$value->idAnalisis.'">       
                                            ';
                                                $periodo = explode("/", $value->fechaPEvaluado);
                                    echo'            
                                                <input type="date" name="periodoA1['.$index.']" id="periodoA1_'.$index.'" class="form-control" value="'.$periodo[0].'" readonly/>
                                                <center>-</center>
                                                <input type="date" name="periodoA2['.$index.']" id="periodoA2_'.$index.'" class="form-control" value="'.trim($periodo[1]).'" readonly/>
                                            </td>
                                            <td class="tableActaBody" width="60%" style="align-text:justify;"> 
                                                <textarea class="form-control" name="analisis['.$index.']" readonly>'.$value->analisis.'</textarea>
                                            </td>
                                            <td class="tableActaBody" width="20%">
                                                <select class="form-control hidden" name="accion['.$index.']" id="accion_'.$index.'">
                                            ';
                                            foreach ($tipoaccion as $valueA) {
                                                if($valueA->id==$value->codigoTipoAccion){
                                                        echo '<option value="'.$valueA->id.'" selected>'.$valueA->nombre.'</option>';
                                                        $nombreAccion=$valueA->nombre;
                                                }else{
                                                        echo '<option value="'.$valueA->id.'">'.$valueA->nombre.'</option>';
                                                }
                                            }
                                    echo    '   </select>
                                        <select name="idAccion['.$index.']" id="idAccion_'.$index.'" class="form-control hidden">
                                            <option value="'.$value->codigoAccion.'">...</option>
                                        </select>
                                    <center>';
                                    if($nombreAccion=='N/A'){
                                        echo $nombreAccion;
                                    }else{
                                        echo 'Acción de '.$nombreAccion.' # '.$value->codigoAccion;
                                    }
                                    echo '</center>
                                            </td>';
                                    echo '</tr>';
                                        if($value->estado==2){
                                            $estado=false;
                                        }
                                    }else{
                                        $estado=false;
                                    echo'<tr class="filaM"> 
                                            <td class="tableActaBody" width="20%">
                                                <input type="hidden" name="idAnalisis['.$index.']" value="'.$value->idAnalisis.'">       
                                            ';
                                                $periodo = explode("/", $value->fechaPEvaluado);
                                    echo'            
                                                <input type="date" name="periodoA1['.$index.']" id="periodoA1_'.$index.'" class="form-control" value="'.$periodo[0].'" readonly/>
                                                <center>-</center>
                                                <input type="date" name="periodoA2['.$index.']" id="periodoA2_'.$index.'" class="form-control" value="'.trim($periodo[1]).'" readonly/>
                                            </td>
                                            <td class="tableActaBody" width="60%" style="align-text:justify;"> 
                                                <textarea class="form-control" name="analisis['.$index.']">'.$value->analisis.'</textarea>
                                            </td>
                                            <td class="tableActaBody">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-8">';
                                            foreach ($tipoaccion as $valueA) {
                                                if($valueA->id==$value->codigoTipoAccion){
                                                        $nombreAccion=$valueA->nombre;
                                                }
                                            }
                                             if($nombreAccion=='N/A'){
                                               echo'        <select class="form-control" onchange="agregarAccion('."this.id,"."'".base_url()."'".','.$fichaIndicador->idPR.')" 
                                                    name="accion['.$index.']" id="accion_'.$index.'">
                                            ';
                                            foreach ($tipoaccion as $valueA) {
                                                if($valueA->id==$value->codigoTipoAccion){
                                                        echo '<option value="'.$valueA->id.'" selected>'.$valueA->nombre.'</option>';
                                                }else{
                                                        echo '<option value="'.$valueA->id.'">'.$valueA->nombre.'</option>';
                                                }
                                            }
                                    echo    '   </select>
                                            </div>
                                            <div class="col-lg-4 hidden" id="btn-crear_'.$index.'">
                                                <a href="'.base_url().'calidad/buildPlanAccion" class="btn btn-default"  target="_blank">Crear</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="margin-top:5px;">
                                            <div id="contenedorAccion_'.$index.'"></div>
                                        </div>
                                    </div>';
                                            }else{
                                                //---------------
                                   echo'        <select data-id="editar_select_'.$index.'" class="form-control" onchange="agregarAccion('."this.id,"."'".base_url()."'".','.$fichaIndicador->idPR.')" 
                                                    name="accion['.$index.']" id="accion_'.$index.'">
                                            ';
                                            foreach ($tipoaccion as $valueA) {
                                                if($valueA->id==$value->codigoTipoAccion){
                                                        echo '<option value="'.$valueA->id.'" selected>'.$valueA->nombre.'</option>';
                                                }else{
                                                        echo '<option value="'.$valueA->id.'">'.$valueA->nombre.'</option>';
                                                }
                                            }
                                    echo    '   </select>
                                            </div>
                                            <div class="col-lg-4 " id="btn-crear_'.$index.'">
                                                <a href="'.base_url().'calidad/buildPlanAccion" class="btn btn-default"  target="_blank">Crear</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="margin-top:5px;">
                                            <div id="contenedorAccion_'.$index.'">
                                                
                                            </div>
                                        </div>
                                    </div>';
                                                //-----------
                                            }
                                echo '  </td>
                                    </tr>';
                                    } 
                                     $index++;
                                }
                            }
                        }else{
                                    echo '
                                    <tr>
                                            <td colspan="8">No hay resultados para la busqueda</td>
                                    </tr>';
                                }
                         ?>
                    </table>
                    <?php 
                    if($estado){
                    ?>
                    <br>
                    <table id="tableNew">
                    </table>
                    <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-12" id="contenedor_botones">
                                <div class="row">
                                    <div class="col-md-5">&nbsp;</div>
                                    <div class="col-md-1"><input type="button" id="agregarC" class="btn btn-default" value="+" title="Agregar" onClick="agregarComportamientoNew(this.id,'<?php echo base_url(); ?>','<?php echo $indicador->denominadorFormula; ?>','<?php echo $indicador->meta; ?>',<?php echo $index; ?>);"></div>
                                    <div class="col-md-1"><input type="button" id="removerC" class="btn btn-default" value="-" title="Remover" onClick="agregarComportamientoNew(this.id,'<?php echo base_url(); ?>','<?php echo $indicador->denominadorFormula; ?>','<?php echo $indicador->meta; ?>',<?php echo $index; ?>);"></div>
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
                        <br>
                    <?php
                    }
                    ?>
                    <br>
                    <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <center>
                                    <input class="btn btn-default" type="reset" value="Limpiar">
                                    <button type="submit" onclick="validar(event);" name="enviar" id="enviar" value="enviar" class="btn btn-default">Guardar</button>
                                </center>
                            </div>
                        </div>
                </form>
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
<script src='<?php echo base_url();?>js/autosize.js'></script>
<script type="text/javascript">
    var fila=document.getElementsByClassName("fila").length;
    $('#editar_select_'+fila).ready(function(){
        var id_proceso=document.getElementById('id_proceso').value;
        agregarAccion('accion_'+fila,'<?php echo base_url(); ?>',id_proceso);
    });
    function validar(event){
        event.preventDefault();
        var fila=document.getElementsByClassName("fila").length;
        var res=true;
        if (validarTodosCampos('form_edit_medicion', 'Todos los campos deben estar llenos')) {
            for (var i=1;i<=fila;i++) {
                var fecha1=document.getElementById('periodo1_'+i).value;
                var fecha2=document.getElementById('periodo2_'+i).value;
                if(res){
                    res=validarFecha(fecha1,fecha2);
                }
                var numerador=document.getElementById('numerador_'+i).value;
                var denominador=document.getElementById('denominador_'+i).value;
                var unidad=document.getElementById('unidad').value;
                if(numerador>denominador && unidad=='Porcentaje'){
                    res=false;
                    alert('Ningun numerador puede ser mayor al denominador');
                }
            }
            if(res){
                document.form_edit_medicion.submit();
            }   
        }
    }
    function calculateResult(){
        var fila=document.getElementsByClassName("fila").length;
        var unidad;
        for (var i = 1; i <=fila; i++) {
            try{
                unidad=document.getElementById('unidad').value
                var numerador=document.getElementById('numerador_'+i).value;
                var denominador=document.getElementById('denominador_'+i);
                if(denominador.readOnly && unidad=='Decimal'){
                    document.getElementById('resultado_'+i).value=numerador;
                }
                else if(isEmpty(numerador)&&isEmpty(denominador.value)){
                        
                        if (unidad=='Porcentaje') {
                            if(denominador.value!=0){
                                document.getElementById('resultado_'+i).value=parseInt((numerador/denominador.value)*100);
                            }else{
                                document.getElementById('resultado_'+i).value=0;
                            } 
                        }else{
                            if(denominador.value!=0){
                                document.getElementById('resultado_'+i).value=(numerador/denominador.value);
                            }else{
                                document.getElementById('resultado_'+i).value=0;
                            } 
                        }
                }
            }catch(err){}
        }
    }
    autosize(document.querySelectorAll('textarea'));
</script>
