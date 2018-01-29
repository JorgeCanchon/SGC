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
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
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
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="encabezadoTD">
                                DIRECTRIZ
                            </td>
                            <td class="encabezadoTD">
                                DESCRIPCIÓN
                            </td>
                            <td class="encabezadoTD">
                                PROCESOS
                            </td>
                            <td width="10%" class="encabezadoTD <?php echo $mostrar_barra; ?>">
                            </td>
                        </tr>
                        <?php 

                        $html='';
                    if($directriz!=FALSE){
                        foreach ($directriz as $value ) {
                        $html.='
                            <tr>
                            	<td>
									'.$value->nombreDirectriz.'
                            	</td>  
                            	<td>
									'.$value->descripcion.'
                            	</td>  
                                <td>';
                                    foreach ($proceso as $pro) {
                                        if ($value->id==$pro->id)
                                        {
                        $html.='       '.$pro->nombreProceso.'.<br>';
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
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Agregar Directriz</h4>
                </div>
                <?php $url=base_url()."calidad/addDirectrizSST";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_agregar_directriz" name="form_agregar_directriz">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="formIndicador">
                            <label for="directriz">Directriz</label>
                            <textarea class="form-control" name="directriz" id="directriz"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="descripcion">Descripcion</label>
                            <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label>Procesos:</label>
                            <select class="form-control" name="proceso[]" id="proceso" multiple="true">
                                <?php foreach ($procesos as $process) {
                                    echo '<option value="'.$process->id.'">'.$process->nombre.'</option>';
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
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Editar Directriz</h4>
                </div>
                <?php $url=base_url()."calidad/editDirectrizSST";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_editar_directriz" name="form_editar_directriz">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>">
                        <input type="hidden" name="id" id="id">
                        <div class="formIndicador">
                            <label for="directriz">Directriz</label>
                            <textarea class="form-control" name="directrizE" id="directrizE"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label for="descripcion">Descripcion</label>
                            <textarea class="form-control" name="descripcionE" id="descripcionE"></textarea>
                        </div>
                        <div class="formIndicador">
                            <label>Procesos:</label>
                            <select class="form-control" name="procesoE[]" id="procesoE" multiple="true">
                                <?php foreach ($procesos as $process) {
                                    echo '<option value="'.$process->id.'">'.$process->nombre.'</option>';
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
    function validarCampo(){
        if(validarCampoVacio('directriz','Directriz'))
        {
            return false;
        }
        if(validarCampoVacio('descripcion','Descripcion'))
        {
            return false;
        }
        if(validarCampoVacio('proceso','Proceso'))
        {
            return false;
        }
        document.form_agregar_directriz.submit();
    }
    function validarCampoE(){
        if(validarCampoVacio('directrizE','Directriz'))
        {
            return false;
        }
        if(validarCampoVacio('descripcionE','Descripcion'))
        {
            return false;
        }
        if(validarCampoVacio('procesoE','Proceso'))
        {
            return false;
        }
        document.form_editar_directriz.submit();
    }

        $(".btn-danger").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivateDirectrizSST/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
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
                url: base+'calidad/loadEditDirectriz',
                data: { id: id },
              error: function(){
              alert("error al cargar los datos");
              },
                success: function (data) {  //EL JSON QUE ENVIAMOS DESDE BUSCAR_PRODUCTOS_ID SE ALMACENA EN DATA 
                    var valor =JSON.parse(data);  // JSON.parse convierte ese JSON en un objeto
                    var arrayId=[];
                    $('#id').val(valor["idD"]);
                    $('#directrizE').val(valor["nombreDirectriz"]);
                    $('#descripcionE').val(valor["descripcion"]);
                    var idG=(Object.keys(valor).length)-3;
                    for (var i = 0; i <idG; i++) {
                       arrayId.push(valor[i]["idProceso"]);
                    }
                    $('#procesoE').val(arrayId);
                }, 
            });
        });
    </script>