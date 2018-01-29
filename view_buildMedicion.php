<?php 
    if (isset($barra_superior)) {
      if ($barra_superior) {
          $mostrar_barra=' ';
      }else{
        $mostrar_barra='hidden';
        }
    }
    $base_url=base_url(); 
?>
    <div id="wrapper">
        <div id="page-wrapper">   
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <form action="<?php echo base_url() ?>calidad/editInfMedicion" method="POST" name="form_inf" id="form_inf">
                        <table class="table-bordered" style="margin-top:30px;">
                            <tr>
                                <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                                <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</center></h4></td>
                                <td class="col-sm-4" ><b>Código:</b>
                                    <div style="width: 220px; height: 1px;">
                                    </div>
                                    <center>
                                      <?php 
                                        if ($option==1) {
                                        echo '<input type="text" name="codigoIndicador" id="codigoIndicador" class="form-control" value="'.@$inf->codigo.'">';
                                        }else{
                                            if(empty($inf->codigo)){
                                                echo 'CRM-PE-02'; 
                                            echo '<input type="hidden" name="codigoIndicador" id="codigoIndicador" class="form-control" value="CRM-PE-02">';
                                            }else{
                                                echo $inf->codigo;
                                                echo '<input type="hidden" name="codigoIndicador" id="codigoIndicador" class="form-control" value="'.$inf->codigo.'">';
                                            }
                                        }
                                      ?>
                                    </center>  
                                </td>
                            </tr>
                            <tr> 
                                <td class="col-sm-4">
                                    <b>Proceso:</b>
                                    <center>
                                    <?php 
                                        if ($option==1) {
                                        echo '
                                        <select name="idProceso" id="idProceso" class="form-control">';
                                            foreach ($procesos as $p) {
                                                if($p->id==$inf->idProceso){
                                        echo   '<option value="'.$p->id.'" selected>'.$p->nombre.'</option>';
                                                }else{
                                        echo   '<option value="'.$p->id.'">'.$p->nombre.'</option>';
                                                }
                                       
                                           }       
                                        echo '</select>';
                                        }else{
                                            if(empty($inf->nombreProceso)){
                                                echo 'Planeación Estratégica'; 
                                                echo '<input type="hidden" name="idProceso" id="idProceso" value="1">';
                                            }else{
                                                echo $inf->nombreProceso;
                                                echo '<input type="hidden" name="idProceso" id="idProceso" value="'.$inf->idProceso.'">';
                                            }
                                        }
                                      ?>
                                    </center>  
                                </td>
                            </tr>
                            <tr>
                                <td  rowspan="2">
                                    <center><h5><b><?php echo $title; ?></b></h5></center>
                                </td>
                                <td class="col-sm-4">
                                    <b>Versión:</b>
                                    <center>
                                        <?php 
                                        if ($option==1) {
                                        echo '<input type="text" name="version" id="version" class="form-control" value="'.@$inf->version.'">';
                                        }else{
                                            if(empty($inf->version)){
                                                echo '1'; 
                                                echo '<input type="hidden" name="version" id="version" value="1">';
                                            }else{
                                                echo $inf->version;
                                                echo '<input type="hidden" name="version" id="version" value="'.$inf->version.'">';
                                            }
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
                                        if ($option==1) {
                                        echo '<input type="date" name="fechaVigencia" id="fechaVigencia" class="form-control" value="'.@$inf->fechaVigencia.'">';
                                        echo '<input type="submit" class="btn btn-default btn-xs dropdown-toggle" value="enviar">';
                                        }else{
                                            if(empty($inf->fechaVigencia)){
                                                echo strftime( "%d-%m-%Y", time() ); 
                                               echo '<input type="hidden" name="fechaVigencia" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
                                            }else{
                                                echo date('d-m-Y', strtotime($inf->fechaVigencia));
                                                echo '<input type="hidden" name="fechaVigencia" value="'.$inf->fechaVigencia.'" class="form-control">';
                                            }
                                        }
                                      ?>
                                    </center>  
                                </td>
                            </tr> 
                        </table>
                    </form>
                    <form method="POST" action="<?php echo base_url();?>calidad/addMedicion" id="form_medicion" name="form_medicion">
                        <input type="hidden" name="idIndicador" value="<?php echo $idIndicador; ?>">
                      <?php 
                      //------------------------------------------------
                            if(empty($inf->codigo)){; 
                            echo '<input type="hidden" name="codigoIndicador" id="codigoIndicador" class="form-control" value="CRM-PE-02">';
                            }else{
                                echo '<input type="hidden" name="codigoIndicador" id="codigoIndicador" class="form-control" value="'.$inf->codigo.'">';
                            }
                        //-------------------------------------
                        if(empty($inf->nombreProceso)){
                            echo '<input type="hidden" name="idProceso" id="idProceso" value="1">';
                        }else{
                            echo '<input type="hidden" name="idProceso" id="idProceso" value="'.$inf->idProceso.'">';
                        }
                        //-------------------------------------------------
                        if(empty($inf->version)){
                            echo '<input type="hidden" name="version" id="version" value="1">';
                        }else{
                            echo '<input type="hidden" name="version" id="version" value="'.$inf->version.'">';
                        }
                        //--------------------------------------------------------
                        if(empty($inf->fechaVigencia)){
                           echo '<input type="hidden" name="fechaVigencia" value="'.strftime( "%d-%m-%Y", time() ).'" class="form-control">';
                        }else{
                            echo '<input type="hidden" name="fechaVigencia" value="'.$inf->fechaVigencia.'" class="form-control">';
                        }
                        //----------------------------------------------------------------
                       ?>

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
                                    <?php 
                                        echo $indicador->nombreProceso; 
                                        echo '<input type="hidden" name="idProcesoInf" value="'.$indicador->codigoProceso.'">';
                                        echo '<input type="hidden" name="nombreProceso" value="'.$indicador->nombreProceso.'">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                   Nombre del Indicador:
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                        echo $indicador->nombreIndicador; 
                                        echo '<input type="hidden" name="nombreIndicador" value="'.$indicador->nombreIndicador.'">'
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                   Frecuencia de Medición: 
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                        echo $indicador->nombreMedicion; 
                                        echo '<input type="hidden" name="frecuencia" value="'.$indicador->nombreMedicion.'">'
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                   Objetivo de la medición: 
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                        echo $indicador->nombreDirectriz; 
                                         echo '<input type="hidden" name="objetivo" value="'.$indicador->nombreDirectriz.'">'
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                   Nombre y Cargo responsable de la Medición: 
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                    $index=0;
                                    $nombre='';
                                        foreach ($userCargo as $valueC) {
                                            if($indicador->medir==$valueC->idCargo){
                                                if($index>0){ 
                                                    echo $valueC->nombre.'-';
                                                    $nombre.=$valueC->nombre.'-';
                                                }else{
                                                    echo $valueC->nombre;
                                                    $nombre.=$valueC->nombre;
                                                }
                                                $index++;
                                                
                                            }
                                        }
                                        echo '/'.$indicador->nombreCargo;
                                        $nombre.='/'.$indicador->nombreCargo;
                                        echo '<input type="hidden" name="medir" value="'.$nombre.'">'
                                     ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                   Nombre y Cargo responsable de la Gestión: 
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                    $nombre='';
                                    foreach ($responsableG as $valuer) {
                                        if ($indicador->id==$valuer->codigoIndicador)
                                        {
                                            $index=0;
                                            foreach ($userCargo as $valueC) {
                                                if($valuer->idC==$valueC->idCargo){
                                                    if($index>0){ 
                                                        echo $valueC->nombre.'-';
                                                        $nombre.=$valueC->nombre.'-';
                                                    }else{
                                                        echo $valueC->nombre;
                                                        $nombre.=$valueC->nombre;
                                                    }
                                                    $index++;
                                                }
                                            }
                                        echo '/'.$valuer->nombreCargo.'<br>';
                                        $nombre.='/'.$valuer->nombreCargo;
                                        echo '<input type="hidden" name="gestionar" value="'.$nombre.'">';
                                        }
                                    }
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
                                    <?php 
                                        echo $indicador->numeradorFormula;
                                        echo '<input type="hidden" name="numeradorF" value="'.$indicador->numeradorFormula.'">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableActaBody">
                                    <b>Denominador</b>
                                </td>
                                <td class="tableActaBody">
                                    <?php 
                                        echo $indicador->denominadorFormula; 
                                        echo '<input type="hidden" name="denominadorF" value="'.$indicador->denominadorFormula.'">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead" width="30%">
                                    Escala/unidad
                                </td>
                                <td class="tableActaBody" colspan="2">
                                   <select id="unidad" name="unidad" class="form-control" onchange="calculateResult();">
                                    <?php if($indicador->denominadorFormula=='N/A'){
                                        echo '
                                        <option value="Decimal">Decimal</option>
                                        ';
                                    }else{
                                        echo '
                                        <option value="Porcentaje">Porcentaje</option>
                                        ';
                                    } ?>
                                       
                                   </select>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="tableActa" id="tableComportamiento">
                            <tr>
                                <td class="tableActaBack" colspan="7">COMPORTAMIENTO DE INDICADOR</td>
                            </tr>
                            <tr>
                                <td class="tableIndicadorHead">FECHA MEDICIÓN</td>
                                <td class="tableIndicadorHead">FECHA DE PERIODO EVALUADO</td>
                                <td class="tableIndicadorHead">META</td>
                                <td class="tableIndicadorHead">VALOR NUMERADOR</td>
                                <td class="tableIndicadorHead">VALOR DENOMINADOR</td>
                                <td class="tableIndicadorHead">RESULTADOS</td>
                            </tr>
                            <tr class="fila" id="fila_1">
                                <td class="tableActaBody">
                                    <input type="date"  class="form-control" name="fechaM[1]" id="fechaM_1">
                                </td>
                                <td class="tableActaBody">
                                    <input type="date"  class="form-control" onchange="sincronizarFechas();" name="periodo1[1]" id="periodo1_1"><center>-</center><input type="date"  class="form-control" onchange="sincronizarFechas();" name="periodo2[1]" id="periodo2_1">
                                </td>
                                <td class="tableActaBody">
                                    <input type="text"  class="form-control" name="meta[1]" id="meta_1" value="<?php echo $indicador->meta; ?>" readonly>
                                </td>
                                <td class="tableActaBody">
                                    <input type="number"  class="form-control" min="1" name="numerador[1]" onkeyup="calculateResult();" id="numerador_1">
                                </td>
                                <td class="tableActaBody">
                                    <input type="number" class="form-control"  min="1" name="denominador[1]" onkeyup="calculateResult();" id="denominador_1" <?php if($indicador->denominadorFormula=='N/A') echo 'readonly value="0"' ?>>
                                </td>
                                <td class="tableActaBody">
                                    <input type="number" value="1" class="form-control" name="resultado[1]" id="resultado_1" readonly/>
                                </td>
                            </tr>
                            <tr>
                                <td class="tableActaBack" colspan="2">PERIODO</td>
                                <td class="tableActaBack" colspan="2">ANALISIS Y PLAN DE MEJORA</td>
                                <td class="tableActaBack" colspan="2">N°ACCIÓN</td>
                            </tr>
                            <tr class="filaM" id="filaM_1">
                                <td class="tableActaBody" colspan="2">
                                    <input type="date"  class="form-control" name="periodoA1[1]" id="periodoA1_1" readonly><center>-</center><input type="date"  class="form-control" name="periodoA2[1]" id="periodoA2_1" readonly="">
                                </td>
                                <td colspan="2" class="tableActaBody">
                                    <textarea class="form-control" name="analisis[1]" id="analisis_1"></textarea>
                                </td>
                                <td colspan="2" class="tableActaBody">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-8">
                                                <select name="accion[1]" id="accion_1" class="form-control" onchange="agregarAccion(this.id,'<?php echo $base_url; ?>','<?php echo $indicador->codigoProceso; ?>');">
                                                    <?php 
                                                        foreach ($tipoaccion as $value) {
                                                            echo '<option value="'.$value->id.'" data-id="'.$value->id.'">'.$value->nombre.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 hidden" id="btn-crear_1">
                                                <a href="<?php echo base_url() ?>calidad/buildPlanAccion" class="btn btn-default"  target="_blank">Crear</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="margin-top:5px;">
                                            <div id="contenedorAccion_1"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <!--
                        <div class="row hidden">
                            <div class="col-lg-12" id="contenedor_botones">
                                <div class="row">
                                    <div class="col-md-5">&nbsp;</div>
                                    <div class="col-md-1"><input type="button" id="agregarC" class="btn btn-default" value="+" title="Agregar" onClick="agregarComportamiento(this.id,'<?php echo $base_url ?>','<?php echo $indicador->denominadorFormula; ?>','<?php echo $indicador->meta; ?>');"></div>
                                    <div class="col-md-1"><input type="button" id="removerC" class="btn btn-default" value="-" title="Remover" onClick="agregarComportamiento(this.id,'<?php echo $base_url ?>','<?php echo $indicador->denominadorFormula; ?>','<?php echo $indicador->meta; ?>');"></div>
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
                        </div>-->
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
    <script type="text/javascript">
        $('#form_inf').submit(function(e){
           if (!validarTodosCampos('form_inf', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        });

        function validar(event){
            event.preventDefault();
            var fila=document.getElementsByClassName("fila").length;
            var res=true;
            if (validarTodosCampos('form_medicion', 'Todos los campos deben estar llenos')) {
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
                    document.form_medicion.submit();
                }   
            }
        }
        function calculateResult(){
            var fila=document.getElementsByClassName("fila").length;
            var unidad;
            for (var i = 1; i <=fila; i++) {
                try{
                    var numerador=document.getElementById('numerador_'+i).value;
                    var denominador=document.getElementById('denominador_'+i);
                    if(denominador.readOnly){
                        document.getElementById('resultado_'+i).value=numerador;
                    }
                    else if(isEmpty(numerador)&&isEmpty(denominador.value)){
                            unidad=document.getElementById('unidad').value
                            if (unidad=='Porcentaje') {
                                if(denominador.value!=0){
                                    document.getElementById('resultado_'+i).value=(numerador/denominador.value)*100;
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
    </script>