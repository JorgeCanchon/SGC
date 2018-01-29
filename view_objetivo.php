    <?php 
        if (isset($barra_superior)) {
            if ($barra_superior) {
                    $mostrar_barra='show';
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
            <div class="row ">
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
                            <tr>
                                <th colspan="2"><h4>SGC</h4></th>
                            </tr>
                            <?php foreach ($sgc as $value ) {
                             ?>
                            <tr>    
                                <td>
                                    <li><?php echo  $value->texto;?></li></td>
                                <td class="<?php echo $mostrar_barra;?>">
                                    <a href="" id="<?php echo $value->id;?>" class="btn btn-sm btn-warning btn-editar" data-toggle="modal" data-target="#editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <button id="<?php echo $value->id;?>" name="eliminar" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>    
                            </tr>
                                <?php
                            }
                                ?>
                            <tr>
                                <th colspan="2"><h4>SST</h4></th>
                            </tr>        
                            <?php foreach ($sst as $value ) {
                            ?>
                            <tr >    
                                <td><li><?php echo $value->texto;?></li></td>
                                <td class="<?php echo $mostrar_barra;?>">
                                    <a href="" id="<?php echo $value->id;?>" class="btn btn-sm btn-warning btn-editar" data-toggle="modal" data-target="#editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <button id="<?php echo $value->id;?>" name="eliminar" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
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

    <!-- Modal agregar objetivo-->
    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Agregar nuevo Objetivo</h4>
                </div>
                <?php $url=base_url()."calidad/addObjetivo";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_agregar_objetivo" name="form_agregar_objetivo">
                <div class="modal-body">
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <select class="form-control" name="tipo" id="tipo" required>
                                <option value="1">SGC</option>
                                <option value="2">SST</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <label class="col-sm-3" for="objetivo">Objetivo:</label>
                            <textarea class="form-control" id="objetivo" name="objetivo" required></textarea>
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
    <!-- Fin Modal agregar objetivo-->

    <!-- Modals modificar-->
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Editar Objetivo</h4>
                </div>
                <?php $url=base_url()."calidad/editObjetivo";  ?>
            <form class="form-horizontal" method="POST" action="<?php echo $url;?>" id="form_editar_objetivo" name="form_editar_objetivo">
                <div class="modal-body">
                    <div class="form-group">
                    <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <select class="form-control" name="tipoE" id="tipoE" required>
                                <option value="1">SGC</option>
                                <option value="2">SST</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="margin-right:10px;margin-left: 10px;">
                            <label class="col-sm-3" for="objetivoE">Objetivo:</label>
                            <textarea class="form-control" id="objetivoE" name="objetivoE" required>
                            </textarea>
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
    <!-- Fin Modal editar objetivo-->
    <script>
    function validarCampo(){
        if(validarCampoVacio('tipo','Tipo de objetivo'))
        {
            return false;
        }
        if(validarCampoVacio('objetivo','Texto'))
        {
            return false;
        }
        document.form_agregar_objetivo.submit();
    }
        function validarCampoE(){
        if(validarCampoVacio('tipoE','Tipo de objetivo'))
        {
            return false;
        }
        if(validarCampoVacio('objetivoE','Texto'))
        {
            return false;
        }
        document.form_editar_objetivo.submit();
    }

        $(".btn-danger").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  

        p = confirm("¿Estas seguro que desea eliminar?");

            if(p){ 

                 window.location="<?php echo base_url()."calidad/inactivateObjetivo/"?>"+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN EL CONTROLADOR
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
                url: base+'calidad/loadEditObjetivo',
                data: { id: id },
              error: function(){
              alert("error al cargar los datos");
              },
                success: function (data) {  //EL JSON QUE ENVIAMOS DESDE BUSCAR_PRODUCTOS_ID SE ALMACENA EN DATA 
                    var valor =JSON.parse(data);  // JSON.parse convierte ese JSON en un objeto
                    $('#id').val(valor["id"]);
                    $('#objetivoE').val(valor["texto"]);
                    $('#tipoE').val(valor["tipo"]);
                }, 
            });
        });
    </script>