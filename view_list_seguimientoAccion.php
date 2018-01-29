<?php 
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
                    <form action="<?php echo base_url() ?>calidad/editInfSeguimientoAccion" method="POST" name="form_inf" id="form_inf">
                        <table class="table-bordered" style="margin-top:30px;">
                            <tr>
                                <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                                <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</center></h4></td>
                                <td class="col-sm-4" ><b>Código:</b>
                                    <div style="width: 220px; height: 1px;">
                                    </div>
                                    <center>
                                      <?php 
                                        if ($barra_superior) {
                                        echo '<input type="text" name="codigoAccion" id="codigoAccion" class="form-control" value="'.@$inf->codigo.'">';
                                        }else{
                                            if(empty($inf->codigo)){
                                                echo 'CRM-GQ-F-11'; 
                                            }else{
                                                echo $inf->codigo;
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
                                        if ($barra_superior) {
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
                                                echo 'Gestión de calidad'; 
                                            }else{
                                                echo $inf->nombreProceso;
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
                                        if ($barra_superior) {
                                        echo '<input type="text" name="version" id="version" class="form-control" value="'.@$inf->version.'">';
                                        }else{
                                            if(empty($inf->version)){
                                                echo '1'; 
                                            }else{
                                                echo $inf->version;
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
                                        if ($barra_superior) {
                                        echo '<input type="date" name="fechaV" id="fechaV" class="form-control" value="'.@$inf->fechaVigencia.'">';
                                        echo '<input type="submit" class="btn btn-default btn-xs dropdown-toggle" value="enviar">';
                                        }else{
                                            if(empty($inf->fechaVigencia)){
                                                echo strftime( "%d-%m-%Y", time() ); 
                                            }else{
                                                echo date('d-m-Y', strtotime($inf->fechaVigencia));
                                            }
                                        }
                                      ?>
                                    </center>  
                                </td>
                            </tr> 
                        </table>
                    </form>
                    <br>
                    <div class="table table-responsive">
                        <div id="Contenedor1">
                            <table style="vertical-align: center;" id="table-1" class="table table-bordered">
                                <tr id="tr-1">
                                    <td class="encabezadoTD" width="15%">Nº NC</td>
                                    <td class="encabezadoTD">NO CONFORMIDAD</td>
                                    <td class="encabezadoTD">CAUSALIDAD</td>
                                </tr>
                                <?php 
            $html_encabezado='';
            $accion='';
                                if($contenidoaccion==false){
            $html_encabezado.=' <tr>
                                    <td class="alert alert-danger" colspan="3">
                                    No hay resultados disponibles
                                    </td>
                                </tr>';                        
                                }else{
                                $indexEncabezado=0;
                                foreach ($contenidoaccion as $value) {
            $html_encabezado.='<tr>';
            $html_encabezado.='     
                                    <td class="tableActaBody" id="rowsEncabezado['.$indexEncabezado.']">
                                        <center>'.$value->id.'</center>
                                    </td>
                                    <td class="tableActaBody">
                                        '.$value->descripcionHallazgo.'
                                    </td>
                                    <td class="tableActaBody">';
                                        $pendiente=true;
                                        if($norma!=false && $conclusion!=false){
                                        foreach ($norma as $value_n) {
                                            foreach ($conclusion as $_conclusion) {
                                                if($value_n->id==$_conclusion->idN && $_conclusion->idA==$value->id){
            $html_encabezado.=                      $value_n->nombre;
                                                    $pendiente=false;
                                                }
                                            }
                                        }
                                        }
                                        if($pendiente){
            $html_encabezado.=                  'Pendiente';                                
                                        }
            $html_encabezado.='
                                    </td>
            ';
            $html_encabezado.='</tr>';
                                $accion[$indexEncabezado]=(int)$value->id;
                                $indexEncabezado++;
                                }
            $html_encabezado.='<input type="hidden" id="rows" value="'.json_encode($accion).'"> ';
                                }
                                echo $html_encabezado;
                                 ?>
                            </table>
                        </div> 
                        <div id="Contenedor2">
                            <table class="table table-bordered" id="table-2"> 
                                <tr id="tr-2">
                                    <td class="encabezadoTD">Nº ACCIÓN</td>
                                    <td class="encabezadoTD">TIPO DE ACCIÓN</td>
                                    <td class="encabezadoTD">PROCESO</td>
                                    <td class="encabezadoTD">ACCIÓN</td>
                                    <td class="encabezadoTD">FECHA DE HALLAZGO</td>
                                    <td class="encabezadoTD">FECHA DE EJECUCIÓN</td>
                                    <td class="encabezadoTD">FECHA DE CIERRE</td>
                                    <td class="encabezadoTD">EFICACIA</td>
                                    <td class="encabezadoTD">ESTADO</td>
                                </tr>
                                <?php 
            $html_cuerpo='';
                                if($contenidoaccion==false){
            $html_cuerpo.='     <tr>
                                    <td class="alert alert-danger" colspan="9">
                                        No hay resultados disponibles
                                    </td>
                                </tr>';                        
                                }else{
                             $index=0;     
                        foreach ($plan as $value_p) {
                            foreach ($contenidoaccion as $value) {
                                if($value_p->idC==$value->id){

            $html_cuerpo.='
                                <td class="tableActaBody" id="rowsCuerpo_'.$value->id.'['.$index.']"><center>'.$value->id.'</center></td>
                                <td class="tableActaBody">'.$value->nombreTipo.'</td>
                                <td class="tableActaBody">'.$value->proceso.'</td>
                                <td class="tableActaBody" id="accion">'.$value_p->actividad.'</td>
                                <td class="tableActaBody">'.$value->fechaHallazgo.'</td>
                                <td class="tableActaBody">'.$value_p->fechaEjecucion.'</td>';
                            if($conclusion!=false){
                                foreach ($conclusion as $_conclusion) {
                                    $pendiente=true;
                                    if($_conclusion->idA==$value->id){
            $html_cuerpo.='                   
                                <td class="tableActaBody">'.$_conclusion->fechaCierre.'</td>';
                                if($_conclusion->eficacia=='NO'){
            $html_cuerpo.='                     
                                <td class="tableActaBody" style="color:red;"><center>'.$_conclusion->eficacia.'</center></td>
                                <td class="tableActaBody" style="color:red;">CERRADA</td>';
                                }else{
            $html_cuerpo.='                     
                                <td class="tableActaBody"><center>'.$_conclusion->eficacia.'</center></td>
                                <td class="tableActaBody">CERRADA</td>';
                                }
                                $pendiente=false;
                                    }
                                    if($pendiente){
            $html_cuerpo.='                   
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>';                             
                                    }
                                } 
                            }else{
            $html_cuerpo.='                   
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>
                                <td class="tableActaBody" style="background-color:yellow;">Pendiente</td>';                           
                            }   
            $html_cuerpo.=' </tr>';
                                }
                            } 
                            $index++;
                        } 
                             echo'   
                                <input type="hidden" id="rowsFirst" value="'.$index.'">
                                <input type="hidden" id="rowsAccion" value="'.count($contenidoaccion).'">';
                            }
                            echo $html_cuerpo; 
                                 ?>
                            </table>
                        </div>
                    </div>  
                    <br>
                    <br>  
                </div>
            </div>
        </div>    
	</div>
    <script>
        $('#form_inf').submit(function(e){
           if (!validarTodosCampos('form_inf', 'Todos los campos deben estar llenos')) {
               e.preventDefault();
            }
        });
        $(document).ready(function() {
                try{
                var rowsFirst=document.getElementById('rowsFirst').value;
                var rowsAccion=parseInt(document.getElementById('rowsAccion').value);
                var alturaAccion=0;
                var alturaPlan=0;
                var index=[];
                var count=0;
                var rows=JSON.parse(document.getElementById('rows').value);
                var tr_1=document.getElementById('tr-1').offsetHeight; 
                var tr_2=document.getElementById('tr-2').offsetHeight;
                if(tr_1 > tr_2){
                    document.getElementById('tr-2').style.height=tr_1+"px";
                }else{
                    document.getElementById('tr-1').style.height=tr_2+"px";
                }
                for (var j =0; j <rows.length; j++) {
                    for (var  k= 0; k<parseInt(rowsFirst);k++) {
                        try{
                            alturaAccion=document.getElementById('rowsEncabezado['+j+']').offsetHeight;
                            alturaPlan+=document.getElementById('rowsCuerpo_'+rows[j]+'['+k+']').offsetHeight;
                            index[count++]=k;
                        }catch(err){}
                    }
                    setHeightAccion(alturaAccion,alturaPlan,rows[j],index,j);
                    index=[];
                    count=0;
                    alturaPlan=0;
                }
            }catch(err){

            }
        });    
    </script>