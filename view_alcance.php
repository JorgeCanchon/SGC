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
                    <a class="btn btn-primary" <?php $site_urll=site_url('calidad/editAlcance/').$alcance->idAlcance ?> href="<?php echo $site_urll; ?>">
                        <i class="fa fa-pencil-square-o"><span class="fa-letra"> Editar</span></i> 
                    </a> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table-bordered" style="margin-top:30px;">
                        <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4>CRM CONSULTING SERVICES S.A.S</center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height: 1px;">
                                </div>
                                <center>
                                  <?php echo $alcance->codigoAlcance; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                  <?php echo $alcance->proceso; ?>
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
                                  <?php echo $alcance->version; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4">
                                <b>Fecha de vigencia:</b>
                                <center>
                                  <?php echo date('d-m-Y', strtotime($alcance->fechaVigencia)); ?>
                                </center>  
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="3">
                                <div class="row">
                                </br>
                                    <div class="cuadro">
                                        <?php echo $alcance->texto; ?>   
                                    </div>
                                </br>               
                                </div>
                            </td>         
                        </tr>
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
                            <td>
                                <center><b>Versión</b></center>
                            </td>
                            <td>
                                <center><b>Descripcion de ajustes</b></center>
                            </td>
                            <td>
                                <center><b>Fecha de Vigencia</b></center>
                            </td>
                        </tr> 
                        <?php foreach ($control as $value ) {
                            ?>
                        <tr>
                            <td>
                                <center><?php echo $value->version; ?></center>
                            </td>
                            <td style="text-align: justify;">
                                &nbsp;<?php echo $value->desc; ?>
                            </td>
                            <td>
                                <center><?php echo $value->fechaVigencia; ?></center>
                            </td>   
                        </tr>
                        <?php  
                            }
                        ?> 
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
                                  <?php echo $elaborado->nombre; ?>
                                  <br>
                                &nbsp; 
                                  <?php echo $elaborado->nombreCargo; ?>
                             </center>     
                             </td>
                             <td class="col-sm-2">
                             <center>
                                &nbsp;                            
                                  <?php echo $revisado->nombre; ?>
                                  <br>
                                &nbsp; 
                                  <?php echo $revisado->nombreCargo; ?>
                            </center>      
                             </td>
                             <td class="col-sm-2">
                             <center>
                                &nbsp;                            
                                  <?php echo $aprobado->nombre; ?>
                                  <br>
                                &nbsp; 
                                  <?php echo $aprobado->nombreCargo; ?>
                            </center>  
                             </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2">
                                <center><b>Fecha:</b>&nbsp; <?php echo $elaborado->fechaRevision; ?></center>
                            </td>
                            <td>
                                <center><b>Fecha:</b>&nbsp; <?php echo $revisado->fechaRevision; ?></center>
                            </td>
                            <td>
                                <center><b>Fecha:</b>&nbsp; <?php echo $aprobado->fechaRevision; ?></center>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  <br><br><br><br><br>
                </div>
            </div>
        </div>    
  </div>