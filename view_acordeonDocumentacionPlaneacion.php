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
          <input type="hidden" id="option" value="<?php echo $option; ?>">
        <div class="row">
            <div class="col-lg-12">
                <table>
                    <tr>
                        <td class="col-sm-2" ><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                        <td>
                        <center><h3><b>CRM CONSULTING SERVICES S.A.S</b></h3></center></td> 
                    </tr>
                </table>
            </div>
        </div>
        <div style="height:50px;">
            
        </div>
        <?php 
            echo $acordeon;
         ?>
    </div>
</div>        
<script type="text/javascript">
       $(".file").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)
        
        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC  
        localStorage.setItem("id",id);
        });  
        $(".btn-danger").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)
        var option=document.getElementById('option').value;
        var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC 
        p = confirm("¿Estas seguro que desea eliminar?");
        if (option==1) {
            ubicacion='<?php echo base_url();?>'+"calidad/deleteFile";
        }else if(option==0){
            ubicacion='<?php echo base_url();?>'+"calidad/moveFile";
        }
       
            if(p){ 
                jQuery.ajax({
                        url: ubicacion,
                        data: {oldname:id},
                        type: 'POST',
                        success: function(data){
                            alert(data);
                        }
                    }); 
            }
        });
    function EnviarI(){
        var id=localStorage.getItem("id");
        if (id==null || id=='' || id==' ') {
            return false;
        }
        ubicacion1='<?php echo base_url();?>'+"calidad/getPackage";
        var carpeta=document.getElementById('targetPath-'+id.substr(5,2)).value;
            $.ajax({
                type: "POST",
                url: ubicacion1,
                data: { carpeta: carpeta },
                error: function(){
                 alert("error al cargar los datos");
                },success: function(data){
                    ubicacion='<?php echo base_url();?>'+"calidad/uploadC";
                    var idBase=document.getElementById('id').value;
                    var files=document.getElementById(id).value;
                    var base='<?php echo base_url();?>'+"calidad/gestionDocumental/"+idBase;
                    var data = new FormData();
                    jQuery.each($('#'+id)[0].files, function(i, file) {
                        data.append('file-'+i, file);
                    });
                    var other_data = $('file-1').serializeArray();
                    $.each(other_data,function(key,input){
                        data.append(input.name,input.value);
                    });
                    jQuery.ajax({
                        url: ubicacion,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(data){
                                alert(data);
                            localStorage.removeItem("id");
                            window.location=base;
                        }
                    }); 
                }
           });
    }
</script>