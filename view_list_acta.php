    <?php 
    if ($this->session->userdata('retorno')==1) {
        $this->session->set_userdata('retorno','');
    }
    if($this->session->userdata('delete')){
        if ($this->session->userdata('delete')==1) 
            {
                $this->session->set_userdata('delete','');
                echo '<script>alert("Acta eliminada con exito");</script>';
            }else if($this->session->userdata('delete')==0){
                $this->session->set_userdata('delete','');
                echo '<script>alert("No se pudo eliminar el acta, por favor contacte al administrador ");</script>';
            }
    }
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
                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/buildActa');?> href="<?php echo $site_urll; ?>">
                        <span class="fa-letra"> Agregar</span> <i class="fa fa-plus-circle"></i> 
                    </a> 
                </div>
            </div>
            <br>
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
                        <tr >
                            <td colspan="2">
                                <div style="padding: 2px;" class="row <?php echo $mostrar_barra;?>">
                                    <div class="col-lg-12">
                                    <div class="col-lg-11">&nbsp;</div>
                                    <div class="col-lg-1">
                                       <a href="<?php echo base_url(); ?>calidad/viewActaIncompleta" title="Actas Incompletas"><img src="<?php echo base_url(); ?>img/ico_completar.png" style="width:35px; height:32px;"></a> 
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table" style="margin-top:30px;">
                        <thead style="background-color:rgb(51,122,183);color:#FFF;text-align: center;">
                            <tr>
                                <th width="20%">
                                    Acta #
                                </th>
                                <th width="35%">
                                    Periodo Evaluado
                                </th>
                                <th width="30%">
                                    Fecha Revisión
                                </th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <?php 
                            $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                         ?>
                        <tbody style="background-color: rgb(217,217,217);">
                            <?php 
                            if ($actas!=FALSE) {
                                foreach ($actas as $value) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $value->numeroActa; ?>
                                </td>
                                <td>
                                    <?php 
                                            $date=$value->periodo;
                                            $date1=explode("/",$date);
                                            $fecha0=explode('-',$date1[0]);
                                            $fecha1=explode('-',$date1[1]);

                                        echo $meses[(int)$fecha0[0]].'-'.$fecha0[1].'/'.$meses[(int)$fecha1[0]].'-'.$fecha1[1]; 
                                    ?>
                                </td>
                                <td>
                                    <?php echo $value->fecha; ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Accion
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                          <li><?php     $site_urll = site_url('calidad/ActaRevisionDireccion/').$value->numeroActa; ?><a href="<?php echo $site_urll; ?>">Ver</a></li>
                                          <li class="<?php echo $mostrar_barra;?>"><?php     $site_urll = site_url('calidad/editActa/').$value->numeroActa; ?><a href="<?php echo $site_urll; ?>">Editar</a></li>
                                          <li class="<?php echo $mostrar_barra;?>">
                                            <a href="#addBookDialog" data-toggle="modal" data-id="<?php echo $value->numeroActa; ?>" data-toggle="modal" class="open-AddBookDialog" >Eliminar</a></li>
                                        </ul>
                                    </div>
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
                            } ?>
                        </tbody>
                    </table>
                    <center><?=$this->pagination->create_links(); ?></center>
                    <br>
                    <br>  
                </div>
            </div>
        </div>    
  </div>
    <!-- MODAL ELIMINAR ACTA -->
    <div class="modal fade" id="addBookDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Acta de revisión por la dirección</h4>
                </div>
                <div class="modal-body">
                    Está seguro de eliminar esta acta de revisión por la dirección
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-default" style="width:100%;" data-dismiss="modal">No</button>
                        </div>
                        <div class="col-md-2 text-center">
                            <?php   $site_url =site_url('calidad/deleteActa') ?>
                            <form action="<?php echo $site_url; ?>" name="form_eliminar" id="form_eliminar" method="POST" accept-charset="utf-8">               
                                <input type="hidden" name="id_acta" id="id_acta" value="<?php echo $value->numeroActa; ?>">
                                <button type="submit" class="btn btn-primary" style="width:100%;">Si</button>  
                            </form>
                        </div>
                        <div class="col-md-4">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>