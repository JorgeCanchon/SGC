    <div id="wrapper">
        <div id="page-wrapper">   
            <div class="row">
                <div class="col-lg-12">
                    <form action="<?php echo base_url();?>calidad/updateDOFA" method="POST" id="form_editar_dofa" name="form_editar_dofa">
                        <input type="hidden" name="id" value="<?php echo $idDOFA; ?>">
                    <table class="table-bordered" id="table" style="margin-top:30px;">
                    <tbody>
                        <tr>
                            <td class="col-sm-2" rowspan="4"><img class="img-responsive img-rounded" src="<?php echo base_url();?>img/LOGO1.png"></td>
                            <td class="col-sm-8" rowspan="2"><center><h4><b>CRM CONSULTING SERVICES S.A.S</b></center></h4></td>
                            <td class="col-sm-4" ><b>Código:</b>
                                <div style="width: 220px; height:1px;">
                                </div>
                                <center>
                                <input class="form-control" type="text" name="codigo" value="<?php echo $dofa->codigoDOFA; ?>" id="codigo" required/>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Proceso:</b>
                                <center>
                                  <?php echo $dofa->proceso; ?>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td  rowspan="2" class="col-sm-10">
                                <center><h4><b><?php echo $title; ?></b></h4></center>
                            </td>
                            <td class="col-sm-4" >
                                <b>Versión:</b>
                                <center>
                                <input type="number" min="1" id="version" name="version" value="<?php echo $dofa->version; ?>" class="form-control" required/>
                                </center>  
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" >
                                <b>Fecha de vigencia:</b>
                                <center>
                                  <input type="date" name="fvigencia" id="fvigencia" value="<?php echo $dofa->fechaVigencia; ?>" class="form-control" required>
                                </center>  
                            </td>
                        </tr>
                  </table>
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <b>FECHA DE IDENTIFICACIÓN:</b>
                                <input type="date" name="fidentificacion" id="fidentificacion" value="<?php echo $dofa->fechaIdentificacion; ?>" class="form-control" required>
                            </td>
                            <td colspan="2">
                            <?php  $inde=0; ?>
                                <b>RESPONSABLE(S):</b>
                                <select title="Para seleccionar ctrl+click izquierdo" class="form-control" name="responsable[]" id="responsable" required multiple>
                                    <?php 
                                   
                                    foreach ($users as $value) {
                                        if ($value->id==$responsable[$inde]->id) {
                                        $inde=$inde+1;
                                    ?>
                                                <option value="<?php echo $value->id; ?>" selected><?php echo $value->nombre;?>
                                                </option>
                                        <?php }else{?>
                                                <option value="<?php echo $value->id;?>"><?php echo $value->nombre; ?>
                                                </option>
                                        <?php  }//fin else 
                                    }//fin foreach
                                        ?>
                                </select>
                            </td>
                        </tr> 
                        <tr> <!--Esta oración se colocó de esta manera
        por que tiene el estilo white-space: pre;-->
                            <td rowspan="<?php echo count($factorI)+1;?>">
        <div class="verticalText" id="textV">  
            A
            N
            Á
            L
            I
            S
            I
            S

            I
            N
            T
            E
            R
            N
            O
        </div> 
<div class="verticalText" id="textVe">              
A    
N
Á
L
I
S
I
S

E
X
T
E
R
N
O 
</div>                           
                            </td>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;width:15%;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                FORTALEZAS(F)
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                DEBILIDADES(D)
                            </td>
                        </tr>   
                        
                        <?php 
                            $index=1;
                            foreach ($factorI  as $value) {

                        ?>
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;">
                            </br></br></br>
                                <input type="hidden" name="idFactor[<?php echo $value->idFactor; ?>]" value ="<?php echo $value->idFactor; ?>"><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="nombreFactor[<?php echo $index;?>]" id="factor-<?php echo $index;?>" class="form-control" required><?php echo $value->factor; ?></textarea>
                            </td>
                            <td style="text-align:justify;"><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="fortaleza[<?php echo $index;?>]" id="fortaleza-<?php echo $index;?>" class="form-control" rows="7" required><?php $str=array('<br />','</br>','<br />','<br>'); echo nl2br(str_replace($str,' ',$value->fortaleza));?></textarea>  
                            </td>
                            <td style="text-align:justify;"><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="debilidad[<?php echo $index;?>]" id="debilidad-<?php echo $index;?>" class="form-control" rows="7" required><?php echo $value->debilidad;?> 
                                </textarea>
                            </td>
                        </tr> 
                        <?php  
                            $index++;   
                            }
                         ?> 
                        </tbody>
                        </table>
                        <table class="table table-bordered"> 
                        <tr>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                OPORTUNIDADES (O)
                            </td>
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS FO(OFENSIVAS)
                            </td> 
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS DO(REORIENTACIÓN)
                            </td>   
                        </tr> 
                        <?php 
                        $ofensivas=null;
                        $reorientacion=null;
                        $index=1;
                            foreach ($factorE  as $value) {
                        ?>
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;width:20%">
                                </br></br></br>
                                <input type="hidden" name="idFactor[<?php echo $value->idFactor; ?>]" value ="<?php echo $value->idFactor; ?>"><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="nombreFactor[<?php echo $value->idFactor;?>]" id="factor-<?php echo $value->idFactor;?>" class="form-control" required><?php echo $value->factor; ?></textarea>
                            </td>
                            <td style="text-align:justify;width:30%; "> <textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="oportunidad[<?php echo $index;?>]" id="oportunidad-<?php echo $index;?>" class="form-control" rows="7" required><?php echo $value->oportunidad;?></textarea>
                            </td>
                            <?php if (isset($ofensivas) && isset($reorientacion)){
                            }else{
                                $ofensivas=$value->ofensivas;
                                $reorientacion=$value->reorientacion;
                            ?>
                            <td style="text-align:justify;margin-top:50px;width:25%; " name="fo" id="fo"><textarea onmousemove="ajustarText(this);" title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="ofensivas" id="ofensivas" class="form-control" required><?php echo $value->ofensivas;?></textarea>
                            </td>
                            <td style="text-align:justify;width:25%"  name="do" id="do"><textarea onmousemove="ajustarText(this);" title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="reorientacion" id="reorientacion" class="form-control" required><?php echo $value->reorientacion;?></textarea>
                            </td>
                            <?php
                                }
                                $index++; 
                            }
                             ?>
                        </tr>
                        </table>
                        <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="background-color:#688A08;font-weight: bold;color:#fff;text-align:center;">
                                FACTOR
                            </td>
                            <td style="background-color:#00337f;font-weight: bold;color:#fff;text-align:center;">
                                AMENAZA (A)
                            </td>
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;text-align:center;">
                                ESTRATÉGIAS FA(DEFENSIVAS)
                            </td> 
                            <td style="background-color:#FF8000;font-weight: bold;color:#fff;">
                                ESTRATÉGIAS DA(SUPERVIVENCIA)
                            </td>   
                        </tr> 
                        <?php 
                        $defensivas=null;
                        $supervivencia=null;
                        $index=1;
                            foreach ($factorE  as $value) {
                        ?>                        
                        <tr>
                            <td style="text-align:center;background-color:#F2F2F2;width:20%">
                             </br></br></br>
                                <input type="hidden" name="idFactor[<?php echo $value->idFactor; ?>]" value ="<?php echo $value->idFactor; ?>"><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="nombreFactor[<?php echo $value->idFactor;?>]" id="factorI-<?php echo $value->idFactor;?>" class="form-control" required><?php echo $value->factor; ?></textarea>
                            </td>
                            <td style="text-align:justify;width:30%; "> <textarea rows="7" title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="amenaza[<?php echo $index;?>]" id="amenaza-<?php echo $index;?>" class="form-control" required><?php echo $value->Amenazas;?></textarea>
                            </td>
                            <?php if (isset($defensivas) && isset($supervivencia)){
                            }else{
                                $defensivas=$value->defensivas;
                                $supervivencia=$value->supervivencia;
                            ?>
                            <td style="text-align:justify;margin-top:50px;width:25%; " name="fa" id="fa"><textarea onmousemove="ajustarText(this);" title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="defensivas" id="defensivas" class="form-control" required><?php echo $value->defensivas;?></textarea>
                            </td>
                            <td style="text-align:justify;width:25%" name="da" id="da"><textarea onmousemove="ajustarText(this);" title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="supervivencia" id="supervivencia" class="form-control" required><?php echo $value->supervivencia;?></textarea>                            </td>
                            </td>
                            <?php
                                }
                                $index++;    
                                $indexF=$value->idFactor;  
                            }
                             ?>
                            <input type="hidden" name="indexF" id="indexF" value="<?php echo $indexF;?>">
                        <input type="hidden" id="index" value="<?php echo $index-1;?>">
                        </tr>
                        <tr>
                            <td colspan="4">
                                <center><textarea title="Para colocar texto en Negrita <b>texto</b>, salto de linea </br>" name="nota" id="nota" class="form-control" rows="3" required><?php echo $dofa->nota;?></textarea>
                                </center>  
                            </td>
                        </tr>                    
                    </tbody> 
                </table>
                    <br>
                        <center>
                        <a href="<?php echo base_url();?>calidad/dofa" class="btn btn-default">Cancelar</a>
                        <button type="button" onclick="validarCampo();" name="enviar" id="enviar" class="btn btn-primary">Editar</button>
                        </center>
                  </form>
                  <br>
                  <br>
                </div>
            </div>
        </div>    
	</div>
    <script type="text/javascript">
    var index=0;
        $(document).ready(function(){
        var elmnt=document.getElementById("table");
            index=document.getElementById("index").value;
            document.getElementById("textV").style.marginTop=(elmnt.offsetHeight/6)+"em";
            document.getElementById("textVe").style.marginTop=(elmnt.offsetHeight/4)+"em";
            document.getElementById("fo").rowSpan=index;
            document.getElementById("do").rowSpan=index;
            document.getElementById("fa").rowSpan=index;
            document.getElementById("da").rowSpan=index;
        });
        function validarCampo(){
            if(validarCampoVacio('codigo','Código'))
            {
                return false;
            }
            if(validarCampoVacio('version','Versión'))
            {
                return false;
            }
            if(validarCampoVacio('fvigencia','Fecha de vigencia'))
            {
                return false;
            }
            if(validarCampoVacio('fidentificacion','Fecha de identificación'))
            {
                return false;
            }
            if(validarCampoVacio('responsable','Responsable(s)'))
            {
                return false;
            }
            if(validarCampoVacio('ofensivas','ESTRATÉGIAS FO(OFENSIVAS)'))
            {
                return false;
            }            
            if(validarCampoVacio('reorientacion','ESTRATÉGIAS DO(REORIENTACIÓN)'))
            {
                return false;
            } 
            if(validarCampoVacio('defensivas','ESTRATÉGIAS FA(DEFENSIVAS)'))
            {
                return false;
            } 
            if(validarCampoVacio('supervivencia','ESTRATÉGIAS DA(SUPERVIVENCIA)'))
            {
                return false;
            } 
            if(validarCampoVacio('nota','Nota'))
            {
                return false;
            }    
            var factor=document.getElementById("indexF").value;
            var res=true;
            for (var i = 1; i <=factor; i++) {
                if(validarCampoVacio('factor-'+i,'Factor'))
                    {
                        res=false;
                    }
                if (i>=11) {
                    if(validarCampoVacio('factorI-'+i,'Factor'))
                    {
                        res=false;
                    }
                }     
            }  
            for (var i = 1; i <=index; i++) {
                if(validarCampoVacio('amenaza-'+i,'AMENAZA(A)'))
                    {
                        res=false;
                    }  
                
                if(validarCampoVacio('oportunidad-'+i,'Fortalezas'))
                    {
                        res=false;
                    }
            }
            var indexF=document.getElementById("indexF").value;
            for (var i = 1; i <=(indexF-index); i++) {
                if(validarCampoVacio('fortaleza-'+i,'Fortalezas'))
                    {
                        res=false;
                    } 
                if(validarCampoVacio('debilidad-'+i,'Debilidades'))
                    {
                        res=false;
                    } 

            }    
            if (!res) {
                return res;
            }
            document.form_editar_dofa.submit();
        }
    </script>