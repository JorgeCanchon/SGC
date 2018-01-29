    <?php 
		if (isset($barra_superior)) {
			if ($barra_superior) {
					$mostrar_barra='';
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#agregar"> 
                        <span class="fa-letra"> Agregar</span> <i class="fa fa-arrow-right"></i> 
                    </button>        
                </div>
            </div>  
            <br><br><br><br>
        <div class="table-responsive">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered" id="table-title">
                        <tr>
                            <td class="col-sm-1" rowspan="2"><img class="img-responsive" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-10" ><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                        </tr>
                        <tr>
                            <td  rowspan="2" class="col-sm-10">
                                <center><h4><b><?php echo $title; ?></b></h4></center>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-striped" id="table-1">
                        <tbody>
                            <tr>
                                <td class="encabezadoTD">
                                    PROCESO
                                </td>
                                <td class="encabezadoTD">
                                    TIPO INDICADOR
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
                                    FRECUENCIA DE MEDICIÓN
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
                                
                                <td width="10%" class="encabezadoTD <?php echo $mostrar_barra; ?>">
                                </td>
                            </tr>
                            <?php 

                            $html='';

                        if($indicador!=FALSE){
                            foreach ($indicador as $value ) {
                            $html.='
                                <tr>    
                                    <td>
                                        '.$value->nombreProceso.'
                                    </td>
                                    <td>
                                        '.$value->nombreTipo.'
                                    </td>
                                    <td>
                                        '.$value->nombreIndicador.'
                                    </td>
                                    <td>';
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
                                    <td>
                                        '.$value->meta.'
                                    </td>
                                    <td>
                                        '.$value->nombreMedicion.'
                                    </td>
                                    <td>';
                                        foreach ($recursosInd as $recursoI) {
                                                if ($value->id==$recursoI->codigoIndicador)
                                                {
                            $html.='                -'.$recursoI->nombreRecurso.'<br>';
                                                }
                                            }
                            $html.='
                                    </td>
                                    <td>
                                        '.$value->gestionar.'
                                    </td>
                                    <td>';
                                        foreach ($responsableG as $res) {
                                            if ($value->id==$res->codigoIndicador)
                                            {
                            $html.='       '.$res->nombreCargo.'<br>';
                                            }
                                        }
                            $html.='                    
                                    </td>
                                    <td class="'.$mostrar_barra.'">
                                        <a href="" id="'.$value->id.'" class="btn btn-sm btn-warning btn-editar" data-toggle="modal" data-target="#editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <button id="'.$value->id.'" name="eliminar" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </td>    
                                </tr>
                            ';
                            }
                        }else{  
                        $html.='
                                <tr>
                                    <td class="alert alert-danger" colspan="9">
                                        No se encontraron resultados para la búsqueda
                                    </td>
                                </tr>
                        ';
                        }
                        echo $html;
                                ?>
                        </tbody>
                    </table>     
                    <center><?=$this->pagination->create_links(); ?></center>
                        <br>
                        <br>            
                </div>    
            </div> 
        </div>
    </div>
</div>    
    <!-- Modal agregar indicador-->
    <style type="text/css">
        .formIndicador{
            margin-right:10px;
            margin-left: 10px;
            margin-top: 10px;
        }
    </style>
    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Agregar nuevo indicador calidad</h4>
                </div>
                <?php $url=base_url()."calidad/addIndicador";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_agregar_indicador" name="form_agregar_indicador">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="formIndicador">
                            <label>Proceso:</label>
                            <select class="form-control" name="procesoI" id="procesoI">
                                <?php 
                                    if($procesos==FALSE){
                                        echo '<option value="">Por favor asociar una directriz a un proceso</option>';
                                    }else{
                                        foreach ($procesos as $process) {
                                            echo '<option value="'.$process->id.'">'.$process->nombre.'</option>';
                                        }
                                    }  
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label for="tipoI">Tipo indicador</label>
                            <select class="form-control" name="tipoI" id="tipoI">
                                <?php 
                                    foreach ($tipoIndicador as $tipo) {
                                        echo '<option value="'.$tipo->id.'">'.$tipo->nombreTipo.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label for="nombre">Indicador:</label><textarea class="form-control" type="text" name="nombre" id="nombre"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="formula">Numerador formula:</label>
                            <textarea class="form-control" type="text" name="numerador" id="numerador"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="formula">Denominador formula:</label>
                            <textarea class="form-control" type="text" name="denominador" id="denominador"></textarea>
                        </div>
                        <div class="formIndicador">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="x">X100</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="checkbox" value="1" name="x" id="x">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="formIndicador">
                            <div class="row">
                                <div class="col-lg-12"><label for="simbolo">Meta:</label></div>
                                <div class="col-lg-6">
                                     <select class="form-control" name="simbolo" id="simbolo">
                                    <?php foreach ($simbolo as $sim) {
                                        echo '<option value="'.$sim->id.'">'.$sim->nombre.'</option>';
                                        } 
                                    ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                   <input type="text" name="meta" id="meta" class="form-control" required/> 
                                </div>
                            </div>
                        </div>
                        <div class="formIndicador">
                            <label>Frecuencia de medición</label>
                            <select class="form-control" name="frecuencia" id="frecuencia">
                                <?php foreach ($medicion as $med) {
                                        echo '<option value="'.$med->id.'">'.$med->nombre.'</option>';
                                        } 
                                    ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Recursos</label>
                            <select class="form-control" name="recursos[]" id="recursos" multiple="true">
                                <?php foreach ($recursos as $recurso) {
                                        echo '<option value="'.$recurso->id.'">'.$recurso->nombre.'</option>';
                                        } 
                                    ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Responsable medir:</label>
                            <select class="form-control" name="rMedir" id="rMedir">
                                <?php foreach ($cargo as $carg) {
                                    echo '<option value="'.$carg->id.'">'.$carg->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Responsable Gestionar</label>
                            <select class="form-control" name="rGestionar[]" id="rGestionar" multiple="true">
                                <?php foreach ($cargo as $carg) {
                                    echo '<option value="'.$carg->id.'">'.$carg->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar
                    </button>
                    <button type="button" onclick="validarCampo();" class="btn btn-primary" id="guardar_datos">Guardar 
                    </button>
                </div>
            </form>    
            </div>
        </div>
    </div>    
    <!-- Fin Modal agregar indicador-->
    <!-- Modals modificar-->
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Editar Indicador</h4>
                </div>
                <?php $url=base_url()."calidad/editIndicador";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_editar_indicador" name="form_editar_indicador">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>">
                        <input type="hidden" name="id" id="id">
                        <div class="formIndicador">
                            <label>Proceso:</label>
                            <select class="form-control" name="procesoIE" id="procesoIE">
                                <?php 
                                    if($procesos==FALSE){
                                        echo '<option value="">Por favor asociar una directriz a un proceso</option>';
                                    }else{
                                        foreach ($procesos as $process) {
                                            echo '<option value="'.$process->id.'">'.$process->nombre.'</option>';
                                        }
                                    }  
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label for="tipoI">Tipo indicador</label>
                            <select class="form-control" name="tipoIE" id="tipoIE">
                                <?php foreach ($tipoIndicador as $tipo) {
                                    echo '<option value="'.$tipo->id.'">'.$tipo->nombreTipo.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label for="nombre">Indicador:</label><textarea class="form-control" type="text" name="nombreE" id="nombreE"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="numeradorE">Numerador formula:</label>
                            <textarea class="form-control" type="text" name="numeradorE" id="numeradorE"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="denominadorE">Denominador formula:</label>
                            <textarea class="form-control" type="text" name="denominadorE" id="denominadorE"></textarea>
                        </div>
                        <div class="formIndicador">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="xe">X100</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="checkbox" value="1" name="xe" id="xe">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="formIndicador">
                            <div class="row">
                                <div class="col-lg-12"><label for="simbolo">Meta:</label></div>
                                <div class="col-lg-6">
                                     <select class="form-control" name="simboloE" id="simboloE">
                                    <?php foreach ($simbolo as $sim) {
                                        echo '<option value="'.$sim->id.'">'.$sim->nombre.'</option>';
                                        } 
                                    ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                   <input type="text" name="metaE" id="metaE" class="form-control" required/> 
                                </div>
                            </div>
                        </div>
                        <div class="formIndicador">
                            <label>Frecuencia de medición</label>
                            <select class="form-control" name="frecuenciaE" id="frecuenciaE">
                                <?php foreach ($medicion as $med) {
                                        echo '<option value="'.$med->id.'">'.$med->nombre.'</option>';
                                        } 
                                    ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Recursos</label>
                            <select class="form-control" name="recursosE[]" id="recursosE" multiple="true">
                                <?php foreach ($recursos as $recurso) {
                                        echo '<option value="'.$recurso->id.'">'.$recurso->nombre.'</option>';
                                        } 
                                    ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Responsable medir:</label>
                            <select class="form-control" name="rMedirE" id="rMedirE">
                                <?php foreach ($cargo as $carg) {
                                    echo '<option value="'.$carg->id.'">'.$carg->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                        <div class="formIndicador">
                            <label>Responsable Gestionar</label>
                            <select class="form-control" name="rGestionarE[]" id="rGestionarE" multiple="true">
                                <?php foreach ($cargo as $carg) {
                                    echo '<option value="'.$carg->id.'">'.$carg->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar
                        </button>
                        <button type="button" onclick="validarCampoE();" class="btn btn-primary" id="guardar_datos">Guardar 
                        </button>
                </div>
            </form>    
            </div>
        </div>
    </div>    
    <!-- Fin Modal editar proceso-->
        <script>
        var alturaTable=document.getElementById('table-1').offsetWidth;
            document.getElementById('table-title').style.width=alturaTable+"px";
    function validarCampo(){
        if(validarCampoVacio('procesoI','Proceso'))
        {
            return false;
        }
        if(validarCampoVacio('tipoI','Tipo Indicador'))
        {
            return false;
        }
        if(validarCampoVacio('nombre','Indicador'))
        {
            return false;
        }
        if(validarCampoVacio('numerador','Numerador formula'))
        {
            return false;
        }
        if(validarCampoVacio('denominador','Denominador formula'))
        {
            return false;
        }
        if(validarCampoVacio('simbolo','Simbolo'))
        {
            return false;
        }
        if(validarCampoVacio('meta','Meta'))
        {
            return false;
        } 
        if(validarCampoVacio('frecuencia','Frecuencia'))
        {
            return false;
        }
        if(validarCampoVacio('recursos','Recursos'))
        {
            return false;
        }
        if(validarCampoVacio('rMedir','Responsable Medir'))
        {
            return false;
        }
        if(validarCampoVacio('rGestionar','Responsable Gestionar'))
        {
            return false;
        }
        document.form_agregar_indicador.submit();
    }
    function validarCampoE(){
        if(validarCampoVacio('procesoIE','Proceso'))
        {
            return false;
        }
        if(validarCampoVacio('tipoIE','Tipo Indicador'))
        {
            return false;
        }
        if(validarCampoVacio('nombreE','Indicador'))
        {
            return false;
        }
        if(validarCampoVacio('numeradorE','Numerador formula'))
        {
            return false;
        }
        if(validarCampoVacio('denominadorE','Denominador formula'))
        {
            return false;
        }
        if(validarCampoVacio('simboloE','Simbolo'))
        {
            return false;
        }
        if(validarCampoVacio('metaE','Meta'))
        {
            return false;
        }
        if(validarCampoVacio('recursosE','Recursos'))
        {
            return false;
        }
        if(validarCampoVacio('rMedirE','Responsable Medir'))
        {
            return false;
        }
        if(validarCampoVacio('rGestionarE','Responsable Gestionar'))
        {
            return false;
        }
        if(validarCampoVacio('frecuenciaE','Frecuencia'))
        {
            return false;
        }
        document.form_editar_indicador.submit();
    }

        $(".btn-danger").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivateIndicador/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
             }
        });    
        $(".btn-editar").on("click", function (e) {   //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-editar)

            e.preventDefault();

            var id=this.id;   // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-editar) 
                                     //AL CUAL DIMOS CLIC   

            //AJAX ES UNA ESTRUCTURA PROPIA DE JQUERY Q PERMITE EL ENVIAR Y RECIBIR DATOS POR POST Y GET 
            //TYPE: TIPO DE ENVIO   / URL:  LA URL DONDE ENVIARAS O RECIBIRAS ALGUN DATO / DATA: PARA ENVIAR VARIABLES
            var base=document.getElementById('base').value;
            $.ajax({

                type: "POST",
                url: base+'calidad/loadEditIndicador',
                data: { id: id },
              error: function(){
              alert("error al cargar los datos");
              },
                success: function (data) {  //EL JSON QUE ENVIAMOS DESDE BUSCAR_PRODUCTOS_ID SE ALMACENA EN DATA 
                    var valor =JSON.parse(data);  // JSON.parse convierte ese JSON en un objeto
                    var arrayId=[];
                    var arrayIdR=[];
                    $('#id').val(valor["id"]);
                    $('#procesoIE').val(valor["codigoProceso"]);
                    $('#tipoIE').val(valor["idTipo"]);
                    $('#nombreE').val(valor["nombreIndicador"]);
                    $('#numeradorE').val(valor["numeradorFormula"]);
                    $('#denominadorE').val(valor["denominadorFormula"]);
                    $('#simboloE').val(valor["simbolo"]);
                    $('#metaE').val(valor["meta"]);
                    $('#rMedirE').val(valor["medir"]);
                    $('#frecuenciaE').val(valor["medicion"]);
                    if(valor["x"]==1){
                        $('#xe').prop('checked', true);
                    }else{
                         $('#xe').prop('checked', false);
                    }
                    //14 numero de elementos distintos a los recursos o responsables de gestionar(Cada vez que se adicione algun elemento a la consulta
                    //se debe aumentar este numero )
                    var idR=(Object.keys(valor).length)-15;
                    for (var i = 1; i <idR; i++) {
                       arrayIdR.push(valor[i]["codigoRecurso"]);
                    }
                    $('#recursosE').val(arrayIdR);
                    var idG=(Object.keys(valor).length)-15;
                    for (var i = 0; i <idG; i++) {
                       arrayId.push(valor[i]["idG"]);
                    }
                    $('#rGestionarE').val(arrayId);
                }, 
            });
        });
    </script>