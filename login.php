  <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>img/favicon.ico">
     <link href="<?php echo base_url();?>vendor/bootstrap/CSS/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/supersized.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">

    <script src="<?php echo base_url();?>js/jquery-1.8.2.min.js"></script>
    <script src="<?php echo base_url();?>js/supersized.3.2.7.min.js"></script>
    <script src="<?php echo base_url();?>js/supersized-init.js"></script>
    <script src="<?php echo base_url();?>js/scripts.js"></script>
    <script src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/funciones.js"></script>
   </head>
   <body >

       <?php $site_url=site_url('sistema/validateUser'); ?>
       <input type="hidden" name="base" id="base" value="<?php echo $base; ?>">
        <div class="page-container">
            <h1 style="color:#fff;">SGC</h1>
            <form action="<?php echo $site_url;?>" method="post">
                <input type="text" name="login[username]" class="username" placeholder="Username">
                <input type="password" name="login[password]" class="password" placeholder="Password">
                <button class="button" type="submit">Sign me in</button>
                <div class="error"><span>+</span></div>
            </form>
                <?php if (isset($message)) {
                    $base_url=base_url().'calidad';
                    echo '<script>';
                    echo 'mensaje("'.$base_url.'","'.$message.'");';
                    echo '</script>';
                } 
            ?>
            <div class="connect">
                <a  data-toggle="modal" data-target="#forgot" style="text-decoration: none;color:white;" href="">Forgot your username or password?</a>
                <div>&nbsp;</div>   
             <?php if ($mensaje != '') { ?>              
            <div class="alert alert-danger" style="padding: 0px; margin-bottom: 5px;"><h5 class="text-center"><?php echo $mensaje; ?></h5></div>
            <?php } ?>
            </div>
        </div>
         <!-- Modal -->
  <div class="modal fade" id="forgot" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title"><b>Remember password CRM</b></h2>
        </div>
        <form class="form-horizontal" method="POST" action="<?php echo base_url();?>sistema/restorePassword">
            <div class="modal-body">
            <label for="correo">Please enter the email address associated with your User account.</label>
            <input type="email" name="email" id="correo" class="form form-control">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>    
      </div>
    </div>
  </div>
</div>
   </body>
   </html> 