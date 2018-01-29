<div id="wrapper">
	        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- /.navbar-header -->
            <div style="">
            <ul class="nav navbar-top-links navbar-left">
            <a class="navbar-brand" href="<?php echo base_url();?>calidad/index">
            	Quality management systems
            </a>
            </ul>
            <!--<div>&nbsp</div>-->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Hola, <?php echo $this->session->userdata('user'); ?><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url();?>calidad/changePassword"><i class="fa fa-gear fa-fw"></i> Cambiar contraseña</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'sistema/logout';?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            </div>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>calidad/index"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="fa fa-cog"> <span class="fa-letra"> Planteamiento Estratégico</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url();?>calidad/mision" name="p1" class="fa fa-folder f"> <span class="fa-letra"> Misión</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>calidad/vision" name="p2" class="fa fa-folder f"><span class="fa-letra"> Visión</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>calidad/politica" name="p3" class="fa fa-folder f"><span class="fa-letra"> Politica de calidad</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>calidad/proceso" name="p10" class="fa fa-folder f"><span class="fa-letra"> Procesos</span></a>
                                </li> 
                                <li>
                                    <a href="<?php echo base_url();?>calidad/seeMapP" name="p4" class="fa fa-folder f"><span class="fa-letra"> Mapa de Procesos</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>calidad/dofa" name="p5" class="fa fa-folder f"><span class="fa-letra"> DOFA</span></a>
                                </li> 
                                 <li>
                                    <a href="<?php echo base_url();?>calidad/alcance" name="p6" class="fa fa-folder f"><span class="fa-letra"> Alcance</span></a>
                                </li> 
                                 <li>
                                    <a href="<?php echo base_url();?>calidad/despliegueObjetivos" name="p7" class="fa fa-folder f"><span class="fa-letra"> Despliegue de objetivos</span></a>
                                </li> 
                                 <li>
                                    <a href="<?php echo base_url();?>calidad/getObjetivo" name="p8" class="fa fa-folder f"><span class="fa-letra"> Objetivos de calidad</span></a>
                                </li> 
                                 <li>
                                    <a href="<?php echo base_url();?>calidad/viewActa" name="p9" class="fa fa-folder f"><span class="fa-letra"> Actas de la revisión <br>&nbsp; &nbsp; &nbsp;
                                    por la dirección</span></a>
                                </li> 
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Información Documentada <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" id="menus">
                                <li>
                                    <a href="#" name="pr" class="fa fa-caret-down"><span class="fa-letra"> Documentación</span></a>
                                    <ul class="nav nav-third-level" id="men">
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/2" name="pr1" class="fa fa-folder f"><span class="fa-letra"> Administración de <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Riesgos(AR)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/12" name="pr2" class="fa fa-folder f"><span class="fa-letra"> Compras(CO)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/11" name="pr3" class="fa fa-folder f"><span class="fa-letra"> Diseño y Desarrollo(DD)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/16" name="pr4" class="fa fa-folder f"><span class="fa-letra"> Divulgación de procesos</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/4" name="pr5" class="fa fa-folder f"><span class="fa-letra"> Gestión Comercial(GC)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/8" name="pr6" class="fa fa-folder f"><span class="fa-letra"> Gestión Calidad(GQ)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/7" name="pr7" class="fa fa-folder f"><span class="fa-letra"> Gestión Financiera(GF)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/6" name="pr8" class="fa fa-folder f"><span class="fa-letra"> Gestión Humana(GH)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/3" name="pr9" class="fa fa-folder f"><span class="fa-letra"> Infraestructura(IF)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/1" name="pr10" class="fa fa-folder f"><span class="fa-letra"> Planeación<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estratégica(PE)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/13" name="pr11" class="fa fa-folder f"><span class="fa-letra"> Seguridad y Salud <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;en el trabajo(SST)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/10" name="pr12" class="fa fa-folder f"><span class="fa-letra"> Servicio al cliente(SV)</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumental/5" name="pr13" class="fa fa-folder f"><span class="fa-letra"> Siniestros(SI)</span></a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#" name="prD" class="fa fa-caret-down"><span class="fa-letra"> Documentación obsoletos</span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/2" name="prD1" class="fa fa-folder f"><span class="fa-letra"> Administración de <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Riesgos</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/15" name="prD2" class="fa fa-folder f">
                                                <span class="fa-letra"> Asesoría en suscripción</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/12" name="prD3" class="fa fa-folder f">
                                                <span class="fa-letra"> Compras</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/11" name="prD4" class="fa fa-folder f">
                                                <span class="fa-letra"> Diseño y Desarrollo</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/16" name="prD5" class="fa fa-folder f">
                                                <span class="fa-letra"> Divulgación de procesos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/8" name="prD6" class="fa fa-folder f">
                                                <span class="fa-letra"> Gestión de Calidad</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/4" name="prD7" class="fa fa-folder f">
                                                <span class="fa-letra"> Gestión Comercial</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/7" name="prD8" class="fa fa-folder f">
                                                <span class="fa-letra"> Gestión Financiera</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/6" name="prD9" class="fa fa-folder f">
                                                <span class="fa-letra"> Gestión Humana</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/3" name="prD10" class="fa fa-folder f">
                                                <span class="fa-letra"> Infraestructura</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/1" name="prD11" class="fa fa-folder f">
                                                <span class="fa-letra"> Planeación Estratégica</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/10" name="prD12" class="fa fa-folder f">
                                                <span class="fa-letra"> Servicio al Cliente</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/5" name="prD13" class="fa fa-folder f">
                                                <span class="fa-letra"> Siniestros</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>calidad/gestionDocumentalObsoletos/13" name="prD14" class="fa fa-folder f">
                                                <span class="fa-letra"> Seguridad y Salud <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;en el trabajo(SST)</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Indicadores de Gestión<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url(); ?>calidad/indicadorGestionCalidad"><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores calidad</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>calidad/directrizGestionCalidad"><i class="fa fa-bookmark" aria-hidden="true"></i> Directrices calidad</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>calidad/indicadorGestionSST"><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores SST</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>calidad/directrizGestionCalidadSST"><i class="fa fa-bookmark" aria-hidden="true"></i> Directrices SST</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>calidad/medicionCalidad"><i class="fa fa-area-chart" aria-hidden="true"></i> Medición Indicador</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Planes de Acción<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url()?>calidad/planAccion"><i class="fa fa-hand-o-right"></i> Acciones </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>calidad/seguimientoAccion"><i class="fa fa-hand-o-right"></i> Seguimiento de acciones</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Auditorias<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>calidad/solicitudCambio"><i class="fa fa-tasks"></i> Solicitud de Cambio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Comites de calidad<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Riesgos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
</div>
<script type="text/javascript">
/**
 * Funcion para cambiar el tipo de icono de
 * los elementos con el name="folder" 
 */
  $(document).ready(function() {
	var f=document.getElementById('folder').value;
	var p=document.getElementsByName('p'+f);
		$(p).removeClass("fa-folder");
	    $(p).addClass("fa-folder-open");
  });
    $(document).ready(function() {
    var f=document.getElementById('folderD').value;
    var p=document.getElementsByName('pr'+f);
        $(p).removeClass("fa-folder");
        $(p).addClass("fa-folder-open");
        if (!$(p).hasClass("fa-folder-open")) {
            $('#men').removeClass("in");
            $('#men').addClass("out");
            $('#menus').removeClass(" collapse in");
            $('#menus').addClass("collapse out");
        }
        });
        $(document).ready(function() {
    var f=document.getElementById('folderDO').value;
    var p=document.getElementsByName('prD'+f);
        $(p).removeClass("fa-folder");
        $(p).addClass("fa-folder-open");
        });
</script>