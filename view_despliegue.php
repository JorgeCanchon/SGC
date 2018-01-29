<?php 
    $html='';
        if (isset($barra_superior)) {
            if ($barra_superior) {
                $mostrar_barra='show';
            }else{
                $mostrar_barra='hidden';
            } 
        }
            if (isset($mensaje) && $mensaje!='') {
    $html.='    <script type="text/javascript">
                   alert("'.$mensaje.'");
                </script>';
                $mensaje='';
            }
    $html.='
    <div id="wrapper">
        <div id="page-wrapper">   
            <br><br>
            <div style="padding: 2px;" class="'.$mostrar_barra.'">
                <div class="pull-right">
                    <a class="btn btn-primary" href="'.site_url('calidad/editDespliegue/').$despliegue->idDespliegue.'">
                        <i class="ace-icon fa fa-arrow-right icon-on-right"><span class="fa-letra"> Editar</span></i> 
                    </a> 
                </div>
            </div>';
    $html.='        
            <br>
            <div class="row" >
                <div class="table table-responsive" id="row">
                    <table class="table-bordered button-editar" id="table-title">
                        <tr>
                            <td class="col-sm-1" rowspan="4"><img class="img-responsive img-rounded" src="'.base_url().'img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                  '.$despliegue->codigoDespliegue.'
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                   '.$despliegue->proceso.'
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td  rowspan="2" class="col-sm-10">
                                <center><h5><b>'.$title.'</b></h5></center>
                            </td>
                            <td class="col-sm-4">
                                <b>Versión:</b>
                                <center>
                                   '.$despliegue->version.'
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4">
                                <b>Fecha de vigencia:</b>
                                <center>
                                   '.date('d-m-Y', strtotime($despliegue->fechaVigencia)).'
                                </center>  
                            </td>
                        </tr> 
                    </table>';
    $html.='       <div class="table table-responsive">             
                        <div id="Contenedor1">
                            <table style="vertical-align: center;" class="table table-bordered" id="table-1"> 
                                <thead>
                                    <tr>
                                        <td class="encabezadoTD">
                                           POLITICA DE CALIDAD
                                        </td>
                                        <td class="encabezadoTD">
                                            DIRECTRIZ
                                        </td>
                                        <td class="encabezadoTD">
                                            DESCRIPCION DEL OBJETIVO    
                                        </td>
                                        <td class="encabezadoTD">
                                            PROCESOS QUE INTERVIENEN
                                        </td>
                                    </tr>  
                                </thead>
                                <tbody>';
                                    $index=0; 
                                    $proces='';
                                    if($directriz!=FALSE){
                                    foreach ($directriz as $value) {
    $html.='                        <tr'; 
                                    if($index%2==0){ 
    $html.='                             style="background-color:#E0ECF8;"';
                                    }
    $html.='                        >';
                                        if ($index==0) {  
    $html.='                             <td style="background-color:#D8D8D8;text-align:justify;" rowspan="'.(count($indicador)+1).'">
                                                '.$despliegue->politica.'
                                            <div class="divTD">&nbsp;</div>
                                                '.$despliegue->politica.'
                                        </td>';
                                        }   
    $html.='                                    
                                        <td style="text-align:justify;">
                                            '.$value->nombreDirectriz.'
                                        </td>      
                                        <td style="text-align:justify;">
                                            '.$value->descripcion.'
                                        </td> 
                                        <td style="text-align:justify;" id="rowsTD['.$index.']">
                                            '.$value->proceso.'
                                        </td>
                                    </tr>';
                                        $proces[$index]=(int)$value->idProceso;
                                        $index++;
                                           }  
                                    }else{
    $html.='                                    
                                        <tr>
                                            <td class="alert alert-danger" colspan="9">
                                                No se encontraron resultados para la búsqueda
                                            </td>
                                        </tr>';
                                    }
    $html.='                                        
                                    <input type="hidden" id="rows" value="'.json_encode($proces).'">  
                                </tbody>
                            </table>
                        </div>
                        <div id="Contenedor2">
                            <table class="table table-bordered" id="table-2">
                                <thead>
                                    <td class="encabezadoTD">
                                        TIPO DE INDICADOR
                                    </td>
                                    <td class="encabezadoTD">
                                        INDICADOR
                                    </td>
                                    <td class="encabezadoTD">
                                        FORMULA
                                    </td>
                                    <td class="encabezadoTD">
                                        META
                                    </td>
                                    <td class="encabezadoTD">
                                        FRECUENCIA DE  MEDICION
                                    </td>
                                    <td class="encabezadoTD">
                                        RECURSOS
                                    </td>
                                    <td class="encabezadoTD">
                                        RESPONSABLE DE MEDIR
                                    </td>
                                    <td class="encabezadoTD">
                                        RESPONSABLE DE GESTIONAR                     
                                    </td>
                                </thead>
                                <tbody>';
                                    $index=0; 
                                    $responsable='';
                                    $cont=0;
                                    $contArray=$responsableG; 
                                    if($indicador!=FALSE){                                    
                                    foreach ($indicador as $value) {
    $html.='                                     
                                    <tr>
                                        <td style="text-align:justify;" id="rowsIndicador_'.$value->codigoProceso.'['.$index.']">
                                            '.$value->nombreTipo.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicador1_'.$value->codigoProceso.'['.$index.']">
                                            '.$value->nombreIndicador.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicador2_'.$value->codigoProceso.'['.$index.']">';    
                                    if($value->denominadorFormula=='N/A'){
    $html.='                                       
                                        ('.$value->numeradorFormula.')';
                                        if($value->x==1){$html.='*100';};
                                    }else{
    $html.='                                       
                                    ('.$value->numeradorFormula.'/'.$value->denominadorFormula.')';
                                    if($value->x==1){$html.='*100';};  
                                    }
    $html.='                                        
                                        </td>
                                        <td id="rowsIndicador3_'.$value->codigoProceso.'['.$index.']">    
                                            '.$value->meta.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicador6_'.$value->codigoProceso.'['.$index.']">    
                                            '.$value->nombreMedicion.'
                                        </td> 
                                        <td style="text-align:justify;" id="rowsIndicador7_'.$value->codigoProceso.'['.$index.']">';
                                            foreach ($recursos as $recurso) {
                                                if ($value->idIndicador==$recurso->codigoIndicador)
                                                {
    $html.='                                         -'.$recurso->nombreRecurso.'<br>';
                                                }
                                            }
    $html.='
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicador4_'.$value->codigoProceso.'['.$index.']">    
                                            '.$value->gestionar.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicador5_'.$value->codigoProceso.'['.$index.']">';
                                            foreach ($responsableG as $key => $valuer) {
                                                if ($value->idIndicador==$valuer->codigoIndicador)
                                                {
    $html.='                                         '.$valuer->nombreCargo.'<br>';
                                                }
                                            }
    $html.='                                        
                                        </td>                               
                                    </tr>';  
                                $index++;
                                    }
                                    }else{
    $html.='       
                                        <tr>
                                            <td class="alert alert-danger" colspan="9">
                                                No se encontraron resultados para la búsqueda
                                            </td>
                                        </tr>';
                                    }
    $html.='
                                    <input type="hidden" id="rowsFirst" value="'.$index.'">
                                    <input type="hidden" id="rowsProceso" value="'.count($directriz).'">
                                </tbody>
                            </table>  
                        </div>
                    </div>    ';
    $html.='        <div class="table table-responsive">            
                        <div id="Contenedor1">
                            <table class="table table-bordered" id="tableSG-1"> 
                                <thead>
                                    <tr>
                                        <td class="encabezadoTD">
                                           POLITICA DE SG-SST
                                        </td>
                                        <td class="encabezadoTD">
                                            DIRECTRIZ
                                        </td>
                                        <td class="encabezadoTD">
                                            DESCRIPCION DEL OBJETIVO    
                                        </td>
                                        <td class="encabezadoTD">
                                            PROCESOS QUE INTERVIENEN
                                        </td>
                                    </tr>  
                                </thead>
                                <tbody>';
                                    $index=0; 
                                    $procesg=[];
                                    $ordeng=[];
                                    foreach ($directrizSG as $value) {
    $html.='
                                    <tr';
                                    if($index%2==0){
    $html.='                           style="background-color:#E0ECF8;"';
                                    }
    $html.='                        >';
                                        if ($index==0) {  
    $html.='                            <td style="background-color:#D8D8D8;text-align:justify;" rowspan="'.(count($indicadorSG)+1).'">
                                            '.nl2br($despliegue->politica_SG).'
                                        </td>';
                                        }
    $html.='
                                        <td style="text-align:justify;">
                                            '.$value->nombreDirectriz.'
                                        </td>      
                                        <td style="text-align:justify;">
                                            '.$value->descripcion.'
                                        </td> 
                                        <td style="text-align:justify;" id="rowsTDSG['.$index.']">
                                            '.$value->proceso.'
                                        </td>
                                    </tr>';
                                           $index++;
                                       } 
    $html.='                    </tbody>
                            </table>
                        </div>
                        <div id="Contenedor2">
                            <table class="table table-bordered" id="tableSG-2">
                                <thead>
                                    <td class="encabezadoTD">
                                        TIPO DE INDICADOR
                                    </td>
                                    <td class="encabezadoTD">
                                        INDICADOR
                                    </td>
                                    <td class="encabezadoTD">
                                        FORMULA
                                    </td>
                                    <td class="encabezadoTD">
                                        META
                                    </td>
                                    <td class="encabezadoTD">
                                        FRECUENCIA DE  MEDICION
                                    </td>
                                    <td class="encabezadoTD">
                                        RECURSOS
                                    </td>
                                    <td class="encabezadoTD">
                                        RESPONSABLE DE MEDIR
                                    </td>
                                    <td class="encabezadoTD">
                                        RESPONSABLE DE GESTIONAR                     
                                    </td>
                                </thead>
                                <tbody>';
                                    $index=0; 
                                    foreach ($indicadorSG as $value) {
    $html.='
                                    <tr>
                                        <td style="text-align:justify;" id="rowsIndicadorSG_'.$value->orden.'['.$index.']">
                                            '.$value->nombreTipo.' 
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG1_'.$value->orden.'['.$index.']">
                                            '.$value->nombreIndicador.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG2_'.$value->orden.'['.$index.']">';
                                    if($value->denominadorFormula=='N/A'){
    $html.='                                       
                                        ('.$value->numeradorFormula.')';
                                        if($value->x==1){$html.='*100';};
                                    }else{
    $html.='                                       
                                    ('.$value->numeradorFormula.'/'.$value->denominadorFormula.')';
                                    if($value->x==1){$html.='*100';};  
                                    }
    $html.='  
                                        </td>
                                        <td id="rowsIndicadorSG3_'.$value->orden.'['.$index.']">    
                                            '.$value->meta.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG6_'.$value->orden.'['.$index.']">    
                                            '.$value->nombreMedicion;
                                               $ordeng[$index]=(int)$value->orden; 
    $html.='                            </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG7_'.$value->orden.'['.$index.']">';
                                            foreach ($recursos as $recurso) {
                                                if ($value->idIndicador==$recurso->codigoIndicador)
                                                {
    $html.='                                         -'.$recurso->nombreRecurso.'<br>';
                                                }
                                            }
    $html.='
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG4_'.$value->orden.'['.$index.']">    
                                            '.$value->gestionar.'
                                        </td>
                                        <td style="text-align:justify;" id="rowsIndicadorSG5_'.$value->orden.'['.$index.']">    
                                            '.$responsableG_SG[$index]->nombreCargo.'
                                        </td>                          
                                    </tr>';  
                                $index++;
                                    }
    $html.='                                
                                    <input type="hidden" id="rowsg" value="'.json_encode($ordeng).'">
                                    <input type="hidden" id="rowsFirstSG" value="'.$index.'">
                                    <input type="hidden" id="rowsProcesoSG" value="'.count($directrizSG).'"> 
                                </tbody>
                            </table>  
                        </div>
                </div>   
            </div>
        </div>    ';
    $html.='                
            <div class="row">
                <div class="col-lg-12">         
                    <table class="table-bordered">                 
                        <tr>
                            <td style="height:40px;" colspan="3">
                               &nbsp; 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <center><h4><b>Control de cambios</b></h4></center>        
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2">
                                <center><b>Versión</b></center>
                            </td>
                            <td>
                                <center><b>Descripcion de ajustes</b></center>
                            </td>
                            <td class="col-sm-2">
                                <center><b>Fecha de Vigencia</b></center>
                            </td>
                        </tr>';
                        foreach ($control as $value ) {
    $html.='                    
                        <tr>
                            <td>
                                <center>'.$value->version.'</center>
                            </td>
                            <td>
                               &nbsp;'.$value->desc.'
                            </td>
                            <td>
                                <center>'.$value->fechaVigencia.'</center>
                            </td>   
                        </tr>'; 
                        }
    $html.=' 
                         <tr>
                             <td colspan="3">&nbsp;</td>
                         </tr>
                    </table>
                    <table class="table-bordered">
                    <tbody>
                        <tr>
                            <td>
                            <center><b>Elaborado por:</b></center>     
                            </td>
                            <td>
                                <center><b>Revisado por:</b></center>
                            </td>
                            <td>
                                <center><b>Aprobado por:</b></center>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2">
                            <center>
                                &nbsp;                            
                                   '.$elaborado->nombre.'
                                  <br>
                                &nbsp; 
                                  '.$elaborado->nombreCargo.'
                            </center>     
                            </td>
                            <td class="col-sm-2">
                            <center>
                                &nbsp;                            
                                   '.$revisado->nombre.'
                                   <br>
                                &nbsp; 
                                   '.$revisado->nombreCargo.'
                            </center>      
                            </td>
                            <td class="col-sm-2">
                                <center>
                                &nbsp;                            
                                   '.$aprobado->nombre.'
                                  <br>
                                &nbsp; 
                                   '.$aprobado->nombreCargo.'
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2">
                                <center><b>Fecha:</b>&nbsp; '.$elaborado->fechaRevision.'</center>
                            </td>
                            <td>
                                <center><b>Fecha:</b>&nbsp; '.$revisado->fechaRevision.'</center>
                            </td>
                            <td>
                                <center><b>Fecha:</b>&nbsp; '.$aprobado->fechaRevision.'</center>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  <br><br><br><br><br>
                </div>
            </div>
        </div>    
    </div>';
    echo $html;
    var_dump($verificarDirectrizSST);
    ?>
    <script>
        $(document).ready(function() {
            /*var alturaTable=document.getElementById('table-1').offsetWidth+document.getElementById('table-2').offsetWidth;
            document.getElementById('table-title').style.width=alturaTable+"px";*/
                try{
                var rowsFirst=document.getElementById('rowsFirst').value;
                var rowsProceso=parseInt(document.getElementById('rowsProceso').value);
                var alturaProceso=0;
                var alturaIndicador=0;
                var index=[];
                var count=0;
                var rows=JSON.parse(document.getElementById('rows').value);
                for (var j =0; j <rows.length; j++) {
                    for (var  k= 0; k<parseInt(rowsFirst);k++) {
                        try{
                            alturaProceso=document.getElementById('rowsTD['+j+']').offsetHeight;
                            alturaIndicador+=document.getElementById('rowsIndicador_'+rows[j]+'['+k+']').offsetHeight;
                            index[count++]=k;
                        }catch(err){}
                    }
                    setHeight(alturaProceso,alturaIndicador,rows[j],index,j);
                    index=[];
                    count=0;
                    alturaIndicador=0;
                }
            }catch(err){

            }
            
            //-----SST-------------//
            var rowsFirstSG=document.getElementById('rowsFirstSG').value;
            var rowsProcesoSG=parseInt(document.getElementById('rowsProcesoSG').value);
            var alturaProceso=0;
            var alturaIndicador=0;
            var indexSG=[];
            var countSG=0;
            var rowsg=JSON.parse(document.getElementById('rowsg').value);
            rowsg=rowsg.unique();
            for (var j =0; j <rowsProcesoSG; j++) {
                for (var  k= 0; k<parseInt(rowsFirstSG);k++) {
                    try{
                        alturaProceso=document.getElementById('rowsTDSG['+j+']').offsetHeight;
                        alturaIndicador+=document.getElementById('rowsIndicadorSG_'+rowsg[j]+'['+k+']').offsetHeight; 
                        indexSG[countSG++]=k; 
                    }catch(err){}
                }
                setHeightSG(alturaProceso,alturaIndicador,rowsg[j],indexSG,j);
                indexSG=[];
                countSG=0;
                alturaIndicador=0;
            }
        });
        Array.prototype.unique=function(a){
          return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });
    </script>
