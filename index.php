    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $title; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        <input type="button" id="btn_busqueda" class="btn btn-default" onclick="ver();" value="Busqueda Avanzada">
                    </div>
                </div>
                <div class="row hidden" id="busqueda" >
                    <form accept-charset="utf-8" id="form_busqueda" class="form-horizontal" name="form_busqueda" method="POST" action="<?php echo base_url().'calidad/index' ?>">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                            <label>Tipo acción</label>
                                <select class="form-control" name="filtro[tipo_accion]" id="tipo_accion">
                                <?php 
                                foreach ($tipoAccion as $value) {
                                    if($value->id==1){
                                    echo  '<option value="">Seleccione...</option>';
                                    }else{
                                    echo  '<option value="'.$value->id.'">'.$value->nombre.'</option>';
                                    }
                                }
                                 ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Proceso</label>
                                <select name="filtro[id_proceso]" id="proceso" class="form-control">
                                <?php 
                                    echo  '<option value="">Seleccione...</option>';
                                    foreach ($procesos as $value) {
                                    echo   '<option value="'.$value->id.'">'.$value->nombre.'</option>';
                                    }
                                 ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Estado:</label>
                                <select name="filtro[estado]" id="estado" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php 
                                    foreach ($tipo_accion as $value_t) {
                                        echo '<option value="'.$value_t->id.'">'.$value_t->nombre.'</option>';
                                    }
                                     ?>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                &nbsp;
                            </div>
                            <div class="col-lg-4">
                                <label>Desde:</label>
                                <input type="date" name="filtro[fecha_inicial]" id="fechaI" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Hasta:</label>
                                <input type="date" name="filtro[fecha_final]" id="fechaF" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Eficacia:</label>
                                <select name="filtro[eficacia]" id="fechaF" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                &nbsp;
                            </div>
                            <div class="col-lg-12">
                                <center>
                                    <a href="<?php echo base_url().'calidad/index' ?>" class="btn btn-default">Ver todas</a>
                                    <input type="submit" name="Buscar" class="btn btn-default" value="Filtrar">
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12" style="margin-top:15px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Planes de acción
                            <div class="pull-right">
                                Total Filas:
                                <?php 
                                if($planaccion!=false){
                                    echo count($planaccion);
                                }else{
                                    echo '0';
                                } ?>
                            </div>
                        </div>
                        <?php 
                        if($planaccion==false){
                        ?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="alert alert-danger">
                                    No hay resultados para la busqueda
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                        <?php  
                        }else{?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <?php 
                                $html='';
                                foreach ($planaccion as $value) {
                                    $porcentaje=0;
                                     $tipo='';
                                    switch ($value->idFiltro) {
                                        case 1:
                                            $porcentaje=40;
                                            $tipo='warning';
                                            break;
                                        case 2:
                                            $porcentaje=80;
                                            $tipo='info';
                                            break;
                                        case 3:
                                            $porcentaje=20;
                                            $tipo='danger';
                                            break;
                                        case 4:
                                            $porcentaje=100;
                                            $tipo='success';
                                            break;
                                    }
                                $html.='
                                <div>
                                    <p>
                                        <strong>#'.$value->id.'-'.$value->proceso.'-'.$value->estado.'</strong>
                                        <span class="pull-right text-muted">'.$porcentaje.'% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-'.$tipo.'" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$porcentaje.'%">
                                            <span class="sr-only">'.$porcentaje.'% Complete</span>
                                        </div>
                                    </div>
                                </div>';
                                }
                                echo $html;
                                ?>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                        <?php 
                        } ?>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <center><?=$this->pagination->create_links(); ?></center>
            <br>
            <br>  
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
