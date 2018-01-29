<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SGC</title>
    <!-- MetisMenu CSS -->
    <!-- Bootstrap Core CSS -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>img/favicon.ico">
    <link href="<?php echo base_url();?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/fileinput.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lightbox.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <style type="text/css">
        .cuadro{
            margin-left: 40px;
            margin-right: 45px;
            text-align: justify;
            font-size: 15px;
        }
        .panel-h{
            background:#f5f5f5;
            border-color: #ddd;
        }
        .f{
            font-size:16px;
            }
        .fa-letra{
                font-size:15px;
                font-family:sans-serif ;
            }
            .panel-toggle {
                  display: block;
                  cursor: pointer;
                }
    @media screen and (min-width:1000px) {
        .panel-center{
            margin-left:200px;
            margin-right:-80px;
        }     
    }    
    @media screen and (max-width:1200px) { 
/*este es para el responsive del despliegue*/
    }
        .div-response{
            height:75px;
        }
    @media screen and (max-width:800px) {
        .response{
            margin-top:26px;
        }
        .div-response{
            height:0px;
        }
    }
    .divTD{
            margin-top:500px;
    }
    .button-editar{
        margin-top:30px;
    }
    .descarga{
        text-decoration: none;
        color:black;
        font-size:14px;
    }
    .verticalText {
        color:#000;
        white-space: pre;
        font-size: 16px;
        font-weight: bold;

    }
    .encabezadoTD{
        background-color:#003875;
        font-weight: bold;
        color:#ffdf0f;
        text-align:center;
        font-size: 15px;
    }
    #Contenedor1{
    float: left;
    width: 49%;
    }
    #Contenedor2{
        float: left;
        width: 49%;
      }
    .tableActa{
        border:1px solid black;
        width: 100%;
        max-width: 100%;
    }    
    .tableActaHead{
        background-color:#DF7401;
        padding:1px;
        float: none;
        border-top:1px solid black;
        color:#fff;
        font-weight:bold;
        text-align: center;
    }
    .tableIndicadorHead{
        background-color:rgb(197,217,241);
        padding:1px;
        float: none;
        border:1px solid black;
        color:#000;
        font-weight:bold;
    }
    .tableActaBody{
        padding:1px;
        float: none;
        border:1px solid black;
        color:#000;
        font-weight:normal;
       text-align:justify;
    }
    .tableActaNeck{
        border:1px solid black;
        color:#000;
        font-weight:bold;
        text-align: center;
        background-color:rgb(251,212,180);
    }
    .tableActaBack{
        border:1px solid black;
        color:#000;
        font-weight:bold;
        text-align: center;
        background-color:rgb(191,191,191);
    }
    .tableImg{
        margin:20px;
    }
    .dropdown-submenu {
        position: relative;
    }
    .dropdown-submenu .dropdown-menu {
        top: 0;
        left:-100%;
        margin-top: -1px;
    }
    .seleccionada{
        background-color:#0585C0;
        color:white;
    }
    .tableTop{
        border-right:1px solid black;
    }
    </style>
            <!-- Javascript -->
    <script src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/funciones.js"></script> 
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>js/highcharts.js"></script>
    <script src="<?php echo base_url();?>js/exporting.js"></script>
    <script src="<?php echo base_url();?>js/lightbox.js"></script>  
    <script src="<?php echo base_url();?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>
    <script src="<?php echo base_url();?>vendor/metisMenu/metisMenu.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/fileinput.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.rwdImageMaps.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.rwdImageMaps.js"></script>
   <!-- <script src="<?php echo base_url();?>push.js-master/bin/push.min.js"></script>-->
     
    <script>    
    $(document).ready(function(){
        localStorage.setItem("x",1);
        var refreshId = setInterval(log,4000);
     });
    var valores='';
    $(document).ready(function(e) {
        //Libreria de Jquery para hacer 
        //responsive la etiqueta area de map
        $('img[usemap]').rwdImageMaps();
    });
    $(document).ready(function(){
        var value="";
        // set a coordinate point
        $('.lb-nav').click(function(e) {
            setCoordinates(e, 1);
            e.preventDefault();
        });
        function setCoordinates(e, status) {
            var proceso=document.getElementById('proceso').value;
            numeroProcesos=$('#numeroProceso').val();
            //Proceso 0=Seleccione...
            if (proceso==0){
                alert('Seleccione un proceso');
            }else{
                //Coordenadas de la etiqueta map
                var x = e.pageX;
                var y = e.pageY;
                var offset = $('.lb-image').offset();
                x -= parseInt(offset.left);
                y -= parseInt(offset.top);
                //valores en x ,y
                value +=(x + "," + y+",");
                //numero de valores que contiene value 
                var n = value.length;
                //Quita la ultima coma del string
                var res = value.substr(0,n-1);
                //Pasa los valores al input
                $('#coordsText').val(res);
                //Obtiene los valores del input 
                var respuesta=res.split(",");
                if (respuesta.length==4) {
                    //vacia el input y la variable value 
                    validateProceso(proceso,res);
                    value='';
                    $('#coordsText').val('');
                }
            }
        }
     });
        //Envia los arrays de nombre de proceso y sus coordenadas 
        function submitItemText(str,respuesta){
            url=document.getElementById('url').value;
            id=document.getElementById('id').value;
            ubicacion=url+'calidad/saveCoordenadas';
            $.ajax({
              type: "POST",
              url: ubicacion,
              data: { str:str,respuesta:respuesta,id:id},
              success: function(data){
                    alert(data);
                    window.reload();
              },
              error: function(data) {
                 alert(data);
              }
            });
        }
        //valida que no exista el nombre del proceso
        function validateProceso(proceso,value){
            //Declaracion de variables locales
            var respuesta='';
            var bool=false;
            var text='';
            var str=Array();
            if (valores=='') {
                //coloca los valores en el textarea
                valores+=proceso +':'+ value +'\n';
                $('#areaText').val(valores);
                //toma los valores del textarea
                text=$('#areaText').val();
                //separa el texto del textarea por salto de linea
                respuesta = text.split(/\n/);
                //declara un array con tamaño del array respuesta
                var str=new Array(respuesta.length-1);
                //asigna los nombres a la variable str
                for (i=0;i<respuesta.length-1;i++) {
                        str[i]=respuesta[i].split(':',1);
                }
                //si la variable bool es true 
                //no existe un nombre de proceso igual
                bool=true;
                for (var i = 0; i<str.length; i++) {
                    if(str[i].includes(proceso)){
                        //si la variable bool es false
                        //existe un nombre de proceso igual
                        bool=false;
                    }
                }
                //vacia la variable global valores
                valores='';
                //actualiza la variable global
                valores=text;
                if(bool){
                    //coloca los valores en el textarea
                    valores+=proceso +':'+ value +'\n';
                    //toma los valores del textarea
                    $('#areaText').val(valores);
                }
            }else{
                //toma los valores del textarea
                text=$('#areaText').val();
                //separa el texto del textarea por salto de linea
                respuesta = text.split(/\n/);
                //declara un array con tamaño del array respuesta
                var str=new Array(respuesta.length-1);
                //asigna los nombres a la variable str
                for (i=0;i<respuesta.length-1;i++) {
                    //separa el array obteniendo los nombres
                        str[i]=respuesta[i].split(':',1);
                }
                //si la variable bool es true 
                //no existe un nombre de proceso igual
                bool=true;
                for (var i = 0; i<str.length; i++) {
                    //comprueba si existe un nombre igual 
                    if(str[i].includes(proceso)){
                        //si la variable bool es false
                        //existe un nombre de proceso igual
                        bool=false;
                    }
                }
                //vacia la variable global valores
                valores='';
                //actualiza la variable global
                valores=text;
                if(bool){
                    //coloca los valores en el textarea
                    valores+=proceso +':'+ value +'\n';
                    //toma los valores del textarea
                    $('#areaText').val(valores);
                }
            } 
             //toma los valores del textarea
                text=$('#areaText').val();
                //separa el texto del textarea por salto de linea
                respuesta = text.split(/\n/);
                 //declara un array con tamaño del array respuesta
                var str=new Array(respuesta.length-1);
                //asigna los nombres a la variable str
                for (i=0;i<respuesta.length-1;i++) {
                    //separa el array obteniendo los nombres
                        str[i]=respuesta[i].split(':',1);
                }
                //comprueba si el array que contiene los nombres de 
                //los procesos es igual al total de los nombres 
                //consultadosen la base de datos
            if(str.length==numeroProcesos){
                submitItemText(str,respuesta);
            }
        }
        //Metodo para ajustar el textarea
        function ajustarText(el){
        var textarea = document.querySelector('textarea');
            if (textarea) {
                  setTimeout(function(){
                    el.style.cssText = 'height:auto; padding:0';
                    // for box-sizing other than "content-box" use:
                    // el.style.cssText = '-moz-box-sizing:content-box';
                    el.style.cssText = 'height:' + el.scrollHeight + 'px';
                  },0);  
            }
        }
        //funcion para impedir escritura
        function KeyPress(e){
            //alert (e.keyCode);
            var key = e.charCode || e.keyCode || 0;
            if (key==8 || key==13) {
                return true;
            }else{
                return false;
            }
        }
        function descargar(ruta){
            window.location=ruta;
        }
</script>
</head>
<body> <!--oncontextmenu="return false"-->
<input type="hidden" name="folder" id="folder" value="<?php echo $folder;?>">
<input type="hidden" name="folderD" id="folderD" value="<?php echo $folderD;?>">
<input type="hidden" name="folderD" id="folderDO" value="<?php echo $folderDO;?>">