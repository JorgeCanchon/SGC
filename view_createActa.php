    <?php 
        if (isset($barra_superior)) {
          if ($barra_superior) {
              $mostrar_barra='show';
          }else{
            $mostrar_barra='hidden'; 
            }
        }
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
                            <label>Acta # <?php if(empty($idActa))echo $numActa->idActa;else echo $idActa;?></label>
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
                                            <form  method="POST" action="<?php echo base_url();?>calidad/insertActa" id="form_informacion_general" name="form_informacion_general">
                                            <input type="hidden" name="idActa" id="idActa" value="<?php if(empty($idActa))echo 0;else echo $idActa;?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    CodigoActa:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="codigoActa" placeholder="codigo del acta" class="form-control" value="" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Versión:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="version" placeholder="Versión del acta" class="form-control" value="" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Fecha vigencia:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="fVigencia"  id="datepickervigencia" placeholder="Fecha vigencia del acta" class="form-control" value="" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Periodo Evaluado:
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" id="datepickermonth" placeholder="Inicio Periodo" name="periodo" class=" form-control" id="periodo1" required/>  
                                                </div>
                                                <div class="col-lg-1">
                                                   Hasta   
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" id="datepickermonth1" placeholder="Fin periodo" name="periodo1" class="form-control" id="periodo2" required/>    
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Fecha Reunión:
                                                </div>
                                                <div class="col-lg-9">                                                    
                                                    <input type="text" id="datepicker" name="fechaR" placeholder="Fecha de la reunión" class="form-control" required/> 
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Lugar Reunión:
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" name="lugarR" placeholder="Lugar de la reunión" class="form-control" required/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    Hora Reunión:
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="time"  placeholder="Hora de la reunión" title="Ingrese hora de inicio de la reunión" name="hora" class=" form-control" id="hora" required/>  
                                                </div>
                                                <div class="col-lg-1">
                                                   Hasta   
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="time"  name="hora1" class="form-control" title="Ingrese hora de fin de la reunión" id="hora1" required/>    
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
                                                        <div class="row fila" id="fila_1">
                                                            <div class="col-lg-3">
                                                                <center>Nombre:</center>
                                                                <br>
                                                                <input style="height:50px;" type="text" placeholder="Nombre" title="Ingrese nombre completo de la persona asistente" name="nameA[1]" id="nameA_1" class="form-control" required/>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <center>Cargo:</center>
                                                                <br>
                                                                <textarea class="form-control" placeholder="Cargo" title="Ingrese cargo o cargos de la persona" name="cargoA[1]" id="cargoA_1" required/></textarea>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <center>Proceso(s):</center>
                                                                <br>
                                                                <textarea class="form-control" placeholder="Proceso(s)" title="Ingrese nombre del proceso" name="procesoA[1]" id="procesoA_1" required/></textarea>
                                                            </div>              
                                                        </div>
                                                    </div>
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
                                                            <textarea class="form-control" name="preambulo" required/></textarea>
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
                                                        <textarea class="form-control" name="mision" title="Mision"><?php echo nl2br($mision->texto); ?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="vision" title="Vision"><?php echo nl2br($vision->texto); ?></textarea>
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
                                                        <textarea class="form-control" name="politica" title="Politica de calidad"><?php echo nl2br($politica->texto); ?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="objetivos" title="Objetivos de calidad"><?php 
                                                        foreach ($objetivosCalidad as  $value) {
                                                             echo str_replace("<br />", " ",nl2br('-'.$value->texto));
                                                        }
                                                        ?></textarea>
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
                                                        <textarea class="form-control" name="politicaSG" title="Politica SG-SST"><?php echo str_replace("<br />", " ",nl2br($politicaSG->texto));?></textarea>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-lg-6" align="center">
                                                        <textarea class="form-control" name="objetivosSG" title="Objetivos de SG-SST"><?php 
                                                        foreach ($objetivosCalidadSG as  $value) {
                                                            echo str_replace("<br />", " ",nl2br('-'.$value->texto));
                                                        }
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
                                                            <button type="button" onclick="validarCampo();"  <?php if(!empty($idActa))echo 'disabled="TRUE"';?> name="enviar" id="enviar" value="enviar" class="btn btn-default">Guardar</button>
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
                                                <?php 
                                                $index=1;
                                                    foreach ($modulos as $value) {
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
    <?php 
        if ($this->session->userdata('retorno')==1) {
            echo '<input type="text" id="retorno" value="'.base_url().'">';
        }
     ?>
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
            if($('#idActa').val().length <= 0 || $('#idActa').val()==0){
                alert('Primero debe diligenciar la informacion general');
                return false;
            }
            p=confirm('Para completar el proceso de crear de click al botón Ok');
            if(p){
                 $.ajax({
                url: '<?php echo base_url();?>'+"calidad/insertActaContenido",
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
        $(function ($){
            var res=localStorage.getItem("res");
            if(res){
                $('#info').removeClass('in');
                $('#content').addClass('out');
                $('#content').addClass('in');
                alert('Informacion general agregada con exito.\nPor favor continue con el contenido.');
                $('#form_informacion_general :input').each(function() {
                    $(this).attr('disabled', true);          
                });
            }
            localStorage.setItem("res",'');
        });
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
    var loadFileT = function(event,index_id,index) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('outputT_'+index_id+'['+index+']');
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
</script>