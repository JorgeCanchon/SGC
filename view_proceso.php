    <?php 
		if (isset($barra_superior)) {
			if ($barra_superior) {
					$mostrar_barra=' ';
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
        <div class="row">
            <div class="col-lg-12">
                <table>
                    <tr>
                        <td class="col-sm-2" ><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                        <td>
                        <center><h3><b>CRM CONSULTING SERVICES S.A.S</b></h3></center></td> 
                    </tr>
                </table>
                <div class="col-lg-12">
                    <h3 class="page-header"><center><?php echo $title; ?></center></h3>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <?php 
                        if($proceso!=FALSE){
                            foreach ($proceso as $value ) {
                         ?>
                        <tr>    
                            <td>
                                <li><?php echo  $value->nombre;?></li> 
                            </td>
                            <td class="<?php echo $mostrar_barra;?>">
                                <a href="" id="<?php echo $value->id;?>" class="btn btn-sm btn-warning btn-editar" data-toggle="modal" data-target="#editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <button id="<?php echo $value->id;?>" name="eliminar" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </td>    
                        </tr>
                            <?php
                            }
                        }else{  
                             ?>
                            <tr>
                                <td class="alert alert-danger" colspan="4">
                                    No se encontraron resultados para la búsqueda
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        
                    </tbody>
                </table>               
            </div>    
        </div> 
    </div>
</div>    
    <!-- Modal agregar proceso-->
    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Agregar nuevo proceso</h4>
                </div>
                <?php $url=base_url()."calidad/addProceso";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_agregar_proceso" name="form_agregar_proceso">
                <div class="modal-body">
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <label for="nombre">Nombre Proceso:</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" required/>
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
    <!-- Fin Modal agregar proceso-->
    <!-- Modals modificar-->
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Editar Proceso</h4>
                </div>
                <?php $url=base_url()."calidad/editProceso";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_editar_proceso" name="form_editar_proceso">
                <div class="modal-body">
                    <div class="form-group">
                    <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <label for="nombre">Nombre Proceso:</label>
                            <input class="form-control" type="text" name="nombreP" id="nombreP" required/>
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
        if(validarCampoVacio('nombre','Nombre'))
        {
            return false;
        }
        document.form_agregar_proceso.submit();
    }
        function validarCampoE(){
        if(validarCampoVacio('nombreP','Nombre'))
        {
            return false;
        }
        document.form_editar_proceso.submit();
    }

        $(".btn-danger").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivateProceso/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
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
                url: base+'calidad/loadEditProceso',
                data: { id: id },
              error: function(){
              alert("error al cargar los datos");
              },
                success: function (data) {  //EL JSON QUE ENVIAMOS DESDE BUSCAR_PRODUCTOS_ID SE ALMACENA EN DATA 
                    var valor =JSON.parse(data);  // JSON.parse convierte ese JSON en un objeto
                    $('#id').val(valor["id"]);
                    $('#nombreP').val(valor["nombre"]);
                }, 
            });
        });
    </script>