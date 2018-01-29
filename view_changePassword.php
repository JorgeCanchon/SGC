    <?php 
    if (isset($mensaje)) {
        echo '<script>mensaje("changePassword","'.$mensaje.'");</script>';
    }
    ?>
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
                <div class="col-lg-8" style="margin-top:50px;">
                    <div class="panel panel-default panel-center">
                        <div class="panel panel-heading"><b>Por favor, rellene los siguientes campos para cambiar la contraseña</b>
                        </div>
                        <center>
                            <form name="change" id="change" class="form-inline" method="POST" action="<?php echo base_url();?>calidad/updatePass">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                                <label for="old"> <h4><b>
                                    Contraseña anterior</b></h4></label>
                               <br>
                                <input type="password" name="old" id="old" placeholder="Old Password" class="form-control" required>
                            </div>  
                            <br>
                            <div class="form-group">
                                <label for="new"><h4><b>Nueva Contraseña </b></h4></label>
                                <br>
                                <input minlength="5" type="password" name="new" id="new" placeholder="New Password" class="form-control" onkeyup=" validarC();" required/>
                            </div>  
                            <br>
                            <div class="form-group">
                                <label for="repeat"><h4><b>Repita la Contraseña</b></h4></label>
                                <br> 
                                <input type="password" name="repeat" id="repeat" placeholder="Repeat New Password" class="form-control" onkeyup=" validarC();" required/>
                            </div> 
                            <br><br>
                            
                            <p class="text-center" id="error" style="color:red;"><p>
                             
                            <div >&nbsp;</div>
                            <button type="button" onclick="envio();" class="btn btn-primary">Enviar</button> 
                            </form>
                        </center>   
                            <br>   
                    </div>    
                </div>
            </div>
        </div>
    </div>      
   <script type="text/javascript">
       
   </script>
