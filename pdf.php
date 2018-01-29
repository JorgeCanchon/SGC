<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
/**
* 
*/ 
class pdf 
{
	private $dompdf;
    private $options;
	function __construct()
	{
        $this->options=new Options();
        $this->options->set('isJavascriptEnabled',TRUE);
		$this->dompdf=new Dompdf($this->options);
		$this->ci =& get_instance();
		$this->ci->load->model('Model_sgc','model',true);
	}
	public function createPdf($id)
	{
		$data=$this->getActa($id);
		$html= $this->createActa($data);
        //echo $html;
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4','portrait');
		$this->dompdf->render();
		$this->dompdf->stream('Acta revisión por la dirección CRM_'.$id.'',array('Attachment=>0'));
	}
	private function createActa($data){
	$html='';
	$currentsite = getcwd();
	$html.='        
    <link href="'.base_url().'vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    .encabezadoTD{
        background-color:#003875;
        font-weight: bold;
        color:#ffdf0f;
        text-align:center;
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
    .tableTop{
        border-right:1px solid black;
    }
    </style>
    <script src="'.base_url().'js/jquery.min.js"></script>
    <script src="'.base_url().'js/highcharts.js"></script>
    <script src="'.base_url().'js/exporting.js"></script>
    <div id="wrapper">
        <div id="page-wrapper">    
            <div class="row">
                <div class="col-lg-12">
                    <table width="100%" style="margin-top:30px;" class="table table-bordered" >
                        <tr>
                            <td class="col-lg-1" rowspan="2">
                                <center>    
                                    <img style="width:80px;" src="'.$currentsite.'/img/LOGO1.jpg">
                                </center>    
                            </td>
                            <td class="col-lg-8">
                                <center>
                                    <h4>CRM CONSULTING SERVICES S.A.S</h4>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <center>
                                    <h5><b>'.$data['title'].'</b></h5>
                                </center>
                            </td>
                        </tr>
                    </table>';

       $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $date=$data['actaHeader']->periodo;
                        $date1=explode("/",$date);
                        $fecha0=explode('-',$date1[0]);
                        $fecha1=explode('-',$date1[1]);
    $html.=         '<br><br>
                    <table class="tableActa">
                        <tr>
                            <td width="30%" class="tableActaHead">PERIODO EVALUADO:</td>
                            <td width="70%" class="tableActaBody">'.$meses[(int)$fecha0[0]].'-'.$fecha0[1].'/'.$meses[(int)$fecha1[0]].'-'.$fecha1[1].'</td>
                        </tr>
                        <tr>    
                            <td width="30%" class="tableActaHead">FECHA DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody">'.$data['actaHeader']->fecha.'</td>
                        </tr>
                        <tr> 
                            <td width="30%" class="tableActaHead">LUGAR DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody">'.$data['actaHeader']->lugar.'</td>
                        </tr>
                        <tr> 
                            <td width="30%" class="tableActaHead">HORA DE REUNIÓN:</td>
                            <td width="70%" class="tableActaBody">'.$data['actaHeader']->hora.'</td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td colspan="3" class="tableActaHead">ASISTENTES</td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck">NOMBRE</td>
                            <td class="tableActaNeck">CARGO</td>
                            <td class="tableActaNeck">PROCESO(S)</td>
                        </tr>';
                            foreach ($data['asistentes'] as $value) {                           
    $html.=             '<tr>
                            <td class="tableActaBody"><center>'.$value->nombre.'</center></td>
                            <td class="tableActaBody"><center>'.$value->cargo.'</center></td>
                            <td class="tableActaBody"><center>'.$value->proceso.'</center></td>
                        </tr>';
                        }
    $html.=         '</table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaHead">AGENDA DE LA REVISIÓN</td>
                        </tr>
                        <tr>
                            <td class="tableActaBody">Preámbulo – Planteamiento estratégico (Misión, visión, política de calidad, objetivos de calidad, si aplica política y objetivos de seguridad y salud en el trabajo).</td>
                        </tr>';
                        foreach ($data['modulo'] as $value) {    
    $html.='            <tr>
                            <td class="tableActaBody">
                                '.$value->titulo.'
                                <br>';
                                if(count($data['encabezado'])>=1 && $data['encabezado']!=FALSE){
                                    $index=1;
                                    foreach ($data['encabezado'] as $en) {
                                        if($value->id==$en->modulo)
                                            {
    $html.='                                    <div class="col-lg-1">&nbsp;</div>'
                                                .$value->id.'.'.$index++.'.'.$en->texto.'<br>';
                                            }
                                        }//fin foreach encabezado
                                }//fin if
    $html.='                </td>
                        </tr>';
                        }//Fin foreach modulo
    $html.='                   
                    </table>
                    <br>
                    <br>
                    <table class="tableActa">
                        <tr>
                            <td class="tableActaHead" >
                                PREAMBULO
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" style="text-align: justify;">
                                '.$data['actaHeader']->preambulo.'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="tableActa" >
                        <tr>
                            <td class="tableActaHead" colspan="2">
                                PLANTEAMIENTO ESTRATÉGICO 
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                MISIÓN
                            </td>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->mision.'
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->vision.'
                            </td>
                            <td class="tableActaNeck" width="50">
                                VISIÓN
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                POLITICA DE CALIDAD
                            </td>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->politica.'
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->objetivoscalidad.'
                            </td>
                            <td class="tableActaNeck" width="50">
                                OBJETIVOS DE CALIDAD
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaNeck" width="50">
                                POLITICA SG-SST
                            </td>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->politicaSG.'
                            </td>
                        </tr>
                        <tr>
                            <td class="tableActaBody" width="50">
                                '.$data['actaHeader']->objetivosSG.'
                            </td>
                            <td class="tableActaNeck" width="50">
                                OBJETIVOS DE SG-SST
                            </td>
                        </tr>
                    </table>';
                    //Parte dinamica 
    $html.='
                    <br>
                    <br>
                    <table class="tableActa">';
                        foreach ($data['modulo'] as $value) {
            $html.='<tr>
                            <td class="tableActaHead" >
                                '.$value->titulo.'
                            </td>
                        </tr>';
                        for ($i=1; $i <=count(@$data['buildActa'][$value->id]) ; $i++) { 
                            $class='';
                            $tipo=@$data['buildTipo'][$value->id][$i];
                            if($tipo=='subtitulo'){
                                $class='tableActaNeck';
                            }elseif ($tipo=='encabezado') {
                                $class='tableActaBack';
                            }elseif ($tipo=='texto') {
                                $class='tableActaBody';
                            }
                            if ($tipo=='subtitulo' || $tipo=='encabezado' || $tipo=='texto') {
            $html.='<tr> 
                            <td class="'.$class.'">
                                '.@$data['buildActa'][$value->id][$i].'
                            </td>
                        </tr>';
                            }elseif ($tipo=='img') {
            $html.='<tr>    
                            <td class="tableActaBody">
                                <center>  
                                <img  src="'.$currentsite.'/img/Acta/acta_'.$data['idActa'].'/modulo_'.$value->id.'/'.@$data['buildActa'][$value->id][$i].'" alt="imagen Acta">
                                </center>
                            </td>
                        </tr>    ';                
                            }elseif ($tipo=='textoImagen') {
                                $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>   
                            <td width="100%">
                                <table>
                                    <tr>
                                        <td width="50%" >
                                            <div>
                                                <div style="float:left;">
                                                    <center>
                                                    '.nl2br($str[1]).'
                                                    </center>
                                                </div>
                                                <div>
                                                    <center>  
                                                    <img style="width:250px;" src="'.$currentsite.'/img/Acta/acta_'.$data['idActa'].'/modulo_'.$value->id.'/'.$str[0].'" alt="imagen Acta">
                                                    </center>
                                                </div>
                                            </div> 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>    ';                
                            }elseif ($tipo=='imagenTexto') {
                                $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>    
                            <td width="100%">
                                <table>
                                    <tr>
                                        <td width="50%">
                                            <div>
                                                <div style="float:left;">
                                                    <center>  
                                                    <img style="width:250px;" src="'.$currentsite.'/img/Acta/acta_'.$data['idActa'].'/modulo_'.$value->id.'/'.$str[0].'" alt="imagen Acta">
                                                    </center>
                                                </div>
                                                <div>    
                                                    <center>
                                                    '.nl2br($str[1]).'
                                                    </center>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>    ';                
                            }elseif ($tipo=='tableTwo') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                    </tr>';
                        if (count($data['filaTwo'][$value->id]>=1) && $data['filaTwo'][$value->id]!=FALSE) {            
                            foreach ($data['filaTwo'][$value->id] as $valueFila) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila->texto2.'   
                                        </td>
                                    </tr>';      
                            } 
                        }          
            $html.='        </table>
                            </div>
                            </td>';                      
            $html.='</tr>';
                                }elseif ($tipo=='tableThree') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[2].'
                                        </td>
                                    </tr>';    
                    if (count($data['filaThree'][$value->id]>=1) && $data['filaThree'][$value->id]!=FALSE) {  
                            foreach ($data['filaThree'][$value->id] as $valueFila3) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila3->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila3->texto2.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila3->texto3.'   
                                        </td>
                                    </tr>';      
                            }  
                        }    
            $html.='        </table>
                            </div>
                            </td>';                      
            $html.='</tr>';
                                }elseif ($tipo=='tableFour') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[2].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[3].'
                                        </td>
                                    </tr>'; 
                        if (count($data['filaFour'][$value->id]>=1) && $data['filaFour'][$value->id]!=FALSE) { 
                            foreach ($data['filaFour'][$value->id] as $valueFila4) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila4->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila4->texto2.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila4->texto3.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila4->texto4.'   
                                        </td>
                                    </tr>';      
                            }  
            $html.='        </table>
                            </div>
                            </td>';
                        }                          
            $html.='</tr>';
                                }elseif ($tipo=='tableFive') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[2].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[3].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[4].'
                                        </td>
                                    </tr>'; 
                        if (count($data['filaFive'][$value->id]>=1) && $data['filaFive'][$value->id]!=FALSE) { 
                            foreach ($data['filaFive'][$value->id] as $valueFila5) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila5->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila5->texto2.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila5->texto3.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila5->texto4.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila5->texto5.'   
                                        </td>
                                    </tr>';      
                            }  
            $html.='        </table>
                            </div>
                            </td>';
                        }                          
            $html.='</tr>';
                                }elseif ($tipo=='tableSix') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[2].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[3].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[4].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[5].'
                                        </td>
                                    </tr>'; 
                        if (count($data['filaSix'][$value->id]>=1) && $data['filaSix'][$value->id]!=FALSE) { 
                            foreach ($data['filaSix'][$value->id] as $valueFila6) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila6->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila6->texto2.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila6->texto3.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila6->texto4.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila6->texto5.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila6->texto6.'   
                                        </td>
                                    </tr>';      
                            }  
            $html.='        </table>
                            </div>
                            </td>';
                        }                          
            $html.='</tr>';
                                }elseif ($tipo=='tableSeven') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>
                            <div style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">
                                <table class="tableActa">
                                    <tr>
                                        <td class="tableActaBack">
                                            '.$str[0].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[1].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[2].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[3].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[4].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[5].'
                                        </td>
                                        <td class="tableActaBack">
                                            '.$str[6].'
                                        </td>
                                    </tr>'; 
                        if (count($data['filaSeven'][$value->id]>=1) && $data['filaSeven'][$value->id]!=FALSE) { 
                            foreach ($data['filaSeven'][$value->id] as $valueFila7) {
            $html.='            <tr>    
                                        <td class="tableActaBody">
                                           '.$valueFila7->texto1.' 
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto2.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto3.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto4.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto5.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto6.'   
                                        </td>
                                        <td class="tableActaBody">
                                            '.$valueFila7->texto7.'   
                                        </td>
                                    </tr>';      
                            }  
            $html.='        </table>
                            </div>
                            </td>';
                        }                          
            $html.='</tr>';
                                }elseif ($tipo=='graphic') {
                            $str=explode(';',@$data['buildActa'][$value->id][$i]);
            $html.='<tr>
                            <td>';
            //Determinamos el tipo de grafica       
            if ($str[4]==1) {    
            $html.='        
                        <div id="containerColumn_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">   
                        <script>$(document).ready(function() { 
                            var json={};
                            json.chart={
                                type: "column"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.yAxis={
                                title: {
                                    text: "'.$str[2].'"
                                }
                            }
                            json.legend={
                                layout: "vertical",
                                align: "right",
                                verticalAlign: "middle"
                            }
                            json.plotOptions={
                                series: {
                                            label: {
                                                connectorAllowed: false
                                            },
                                            pointStart: '.$str[3].'
                                        }
                            }
                            json.series= [';
                                    foreach ($data['filaGraphic'][$str[5]][$value->id] as $graphic) { 
                $html.='            {
                                        name: "'.$graphic->tituloColumna.'",
                                        data:['.$graphic->datosColumna.']
                                    },';
                                    }
                $html.='                ]
                                json.responsive={
                                    rules: [{
                                        condition: {
                                            maxWidth: 500
                                        },
                                        chartOptions: {
                                            legend: {
                                                layout: "horizontal",
                                                align: "center",
                                                verticalAlign: "bottom"
                                            }
                                        }
                                    }]  
                                }
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };

                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#containerColumn_'.$str[5].'").html("<a href="'."+url+".'" target='."_blank".'><img src="'."+url+".'">");
                            });
                    </script></div>';                
                    }else if ($str[4]==2) {
                $html.=' 
                    <div id="containerPie_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;"> 
                    <script>$(document).ready(function() { 
                            var json={};
                            json.chart={
                                type: "pie"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.plotOptions={
                                pie:
                                {
                                    allowPointSelect: true,
                                    cursor: "pointer",
                                        dataLabels: {
                                            enabled: true,
                                            format: "<b>{point.name}</b>: {point.percentage:.1f} %",
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || "black"
                                            }
                                        }
                                }
                            }
                                json.series= [{
                                    data: [';
                                    foreach ($data['filaGraphicPie'][$str[5]][$value->id] as $graphicPie) {  
                $html.='            {
                                        name: "'.$graphicPie->tituloColumna.'",
                                        y:'.(float)$graphicPie->datosColumna.'
                                    },';
                                    }
                $html.='                ]
                                            }]
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };
                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#containerPie_'.$str[5].'").html("<img src="'."+url+".'">");
                            });
                    </script>';
                    }else if ($str[4]==3) {    
            $html.='        
                        <div id="containerLinea_'.$str[5].'" style="margin-top:10px;margin-right:10px;margin-left:10px;margin:10px;">   
                        <script>$(document).ready(function() { 
                            var json={};
                            json.chart={
                                type: "line"
                            }
                            json.title={
                                text:"'.$str[0].'"
                            }
                            json.subtitle={
                                text:"'.$str[1].'"
                            }
                            json.yAxis={
                                title: {
                                    text: "'.$str[2].'"
                                }
                            }
                            json.legend={
                                layout: "vertical",
                                align: "right",
                                verticalAlign: "middle"
                            }
                            json.plotOptions={
                                series: {
                                            label: {
                                                connectorAllowed: false
                                            },
                                            pointStart: '.$str[3].'
                                        }
                            }
                            json.series= [';
                                    foreach ($data['filaGraphicLinea'][$str[5]][$value->id] as $graphicLinea) { 
                $html.='            {
                                        name: "'.$graphicLinea->tituloColumna.'",
                                        data:['.$graphicLinea->datosColumna.']
                                    },';
                                    }
                $html.='                ]
                                json.responsive={
                                    rules: [{
                                        condition: {
                                            maxWidth: 500
                                        },
                                        chartOptions: {
                                            legend: {
                                                layout: "horizontal",
                                                align: "center",
                                                verticalAlign: "bottom"
                                            }
                                        }
                                    }]  
                                }
                            var data = {
                                options: JSON.stringify(json),
                                filename: "cahrts",
                                type: "image/png",
                                async: true
                            };
                            var exportUrl = "http://export.highcharts.com/";
                            $.post(exportUrl, data, function(data) {
                                var url = exportUrl + data;
                                $("#containerLinea_'.$str[5].'").html("<img src="'."+url+".'">");
                            });
                });
                    </script></div>';      
                    }
    $html.='        
                            </td>                       
                        </tr>'; 
                                }//fin elseif
                            }//fin foreach buildActa
                        }             
    $html.='                </table>
                    <br>
                    <br>
                </div>
            </div>
        </div>    
  </div>';
            return $html;
	}
	private function getActa($id){
		$tipo=array();
		$idActa=$id;
		$data['modulo']=$this->ci->model->getModulesActa();
		$subtitulo=$this->ci->model->getSubtituloActa($idActa);
		$texto=$this->ci->model->getTextoActa($idActa);
		$img=$this->ci->model->getImgActa($idActa);
		$textoImg=$this->ci->model->getTextoImgActa($idActa);
		$imgTexto=$this->ci->model->getImgTextoActa($idActa);
		$tableTwo=$this->ci->model->getTableTwoActa($idActa);
		$tableThree=$this->ci->model->getTableThreeActa($idActa);
		$tableFour=$this->ci->model->getTableFourActa($idActa);
		$tableFive=$this->ci->model->getTableFiveActa($idActa);
		$tableSix=$this->ci->model->getTableSixActa($idActa);
		$tableSeven=$this->ci->model->getTableSevenActa($idActa);
		$graphic=$this->ci->model->getGraphicActa($idActa);
		$data['encabezado']=$this->ci->model->getEncabezadoActa($idActa);
		$filaTwo=array();
		$filaThree=array();
		$filaFour=array();
		$filaFive=array();
		$filaSix=array();
		$filaSeven=array();
		$filaGraphic=array();
		$filaGraphicPie=array();
		$filaGraphicLinea=array();
		foreach ($data['modulo'] as $value) {
			if(count($subtitulo)>=1 && $subtitulo!=FALSE){
				foreach ($subtitulo as $sub) {
					if ($sub->modulo==$value->id) {
						$builActa[$value->id][$sub->ordenActa]=$sub->texto;
						$tipo[$value->id][$sub->ordenActa]='subtitulo';
					}
				}//fin foreach
			}
			if(count($data['encabezado'])>=1 && $data['encabezado']!=FALSE){
				foreach ($data['encabezado'] as $enc) {
					if ($enc->modulo==$value->id) {
						$builActa[$value->id][$enc->ordenActa]=$enc->texto;
						$tipo[$value->id][$enc->ordenActa]='encabezado';
					}
				}//fin foreach
			}
			if(count($texto)>=1 && $texto!=FALSE){
				foreach ($texto as $tex) {
					if ($tex->modulo==$value->id) {
						$builActa[$value->id][$tex->ordenActa]=$tex->texto;
						$tipo[$value->id][$tex->ordenActa]='texto';
					}
				}//fin foreach
			}
			if(count($img)>=1 && $img!=FALSE){
				foreach ($img as $imagen) {
					if ($imagen->modulo==$value->id) {
						$builActa[$value->id][$imagen->ordenActa]=$imagen->img;
						$tipo[$value->id][$imagen->ordenActa]='img';
					}
				}//fin foreach
			}
			if(count($textoImg)>=1 && $textoImg!=FALSE){
				foreach ($textoImg as $textoimagen) {
					if ($textoimagen->modulo==$value->id) {
						$builActa[$value->id][$textoimagen->ordenActa]=$textoimagen->img.';'.$textoimagen->texto;
						$tipo[$value->id][$textoimagen->ordenActa]='textoImagen';
					}
				}//fin foreach
			}
			if(count($imgTexto)>=1 && $imgTexto!=FALSE){
				foreach ($imgTexto as $imagentexto) {
					if ($imagentexto->modulo==$value->id) {
						$builActa[$value->id][$imagentexto->ordenActa]=$imagentexto->img.';'.$imagentexto->texto;
						$tipo[$value->id][$imagentexto->ordenActa]='imagenTexto';
					}
				}//fin foreach
			}
			if(count($tableTwo)>=1 && $tableTwo!=FALSE){
				foreach ($tableTwo as $two) {
					if ($two->modulo==$value->id) {
						$builActa[$value->id][$two->ordenActa]=$two->col1.';'.$two->col2;
						$tipo[$value->id][$two->ordenActa]='tableTwo';
						$filaTwo[$value->id]=$this->ci->model->getFilaTwoActa($two->id);
					}
				}//fin foreach
			}
			if(count($tableThree)>=1 && $tableThree!=FALSE){
				foreach ($tableThree as $three) {
					if ($three->modulo==$value->id) {
						$builActa[$value->id][$three->ordenActa]=$three->col1.';'.$three->col2.';'.$three->col3;
						$tipo[$value->id][$three->ordenActa]='tableThree';
						$filaThree[$value->id]=$this->ci->model->getFilaThreeActa($three->id);
					}
				}//fin foreach
			}
			if(count($tableFour)>=1 && $tableFour!=FALSE){
				foreach ($tableFour as $four) {
					if ($four->modulo==$value->id) {
						$builActa[$value->id][$four->ordenActa]=$four->col1.';'.$four->col2.';'.$four->col3.';'.$four->col4;
						$tipo[$value->id][$four->ordenActa]='tableFour';
						$filaFour[$value->id]=$this->ci->model->getFilaFourActa($four->id);
					}
				}//fin foreach
			}
			if(count($tableFive)>=1 && $tableFive!=FALSE){
				foreach ($tableFive as $five) {
					if ($five->modulo==$value->id) {
						$builActa[$value->id][$five->ordenActa]=$five->col1.';'.$five->col2.';'.$five->col3.';'.$five->col4.';'.$five->col5;
						$tipo[$value->id][$five->ordenActa]='tableFive';
						$filaFive[$value->id]=$this->ci->model->getFilaFiveActa($five->id);
					}
				}//fin foreach
			}
			if(count($tableSix)>=1 && $tableSix!=FALSE){
				foreach ($tableSix as $six) {
					if ($six->modulo==$value->id) {
						$builActa[$value->id][$six->ordenActa]=$six->col1.';'.$six->col2.';'.$six->col3.';'.$six->col4.';'.$six->col5.';'.$six->col6;
						$tipo[$value->id][$six->ordenActa]='tableSix';
						$filaSix[$value->id]=$this->ci->model->getFilaSixActa($six->id);
					}
				}//fin foreach
			}
			if(count($tableSeven)>=1 && $tableSeven!=FALSE){
				foreach ($tableSeven as $seven) {
					if ($seven->modulo==$value->id) {
						$builActa[$value->id][$seven->ordenActa]=$seven->col1.';'.$seven->col2.';'.$seven->col3.';'.$seven->col4.';'.$seven->col5.';'.$seven->col6.';'.$seven->col7;
						$tipo[$value->id][$seven->ordenActa]='tableSeven';
						$filaSeven[$value->id]=$this->ci->model->getFilaSevenActa($seven->id);
					}
				}//fin foreach
			}
			if(count($graphic)>=1 && $graphic!=FALSE){
				foreach ($graphic as $g) {
					if ($g->modulo==$value->id) {
						$builActa[$value->id][$g->ordenActa]=$g->tituloG.';'.$g->subtituloG.';'.$g->subtituloY.';'.$g->puntoInicial.';'.$g->tipoG.';'.$g->id;
						if($g->tipoG==1){
							$filaGraphic[$g->id][$value->id]=$this->ci->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==2) {
							$filaGraphicPie[$g->id][$value->id]=$this->ci->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==3) {
							$filaGraphicLinea[$g->id][$value->id]=$this->ci->model->getFilaGraphicActa($g->id);
						}
						$tipo[$value->id][$g->ordenActa]='graphic';
					}
				}//fin foreach
			}
		}//fin foreach modulos
		$data['filaTwo']=$filaTwo;
		$data['filaThree']=$filaThree;
		$data['filaFour']=$filaFour;
		$data['filaFive']=$filaFive;
		$data['filaSix']=$filaSix;
		$data['filaSeven']=$filaSeven;
		$data['filaGraphic']=$filaGraphic;
		$data['filaGraphicPie']=$filaGraphicPie;
		$data['filaGraphicLinea']=$filaGraphicLinea;
		$data['idActa']=$idActa;
		$data['buildActa']=$builActa;
		$data['buildTipo']=$tipo;
		$data['asistentes']=$this->ci->model->getAsistentesActa($idActa);
		$data['actaHeader']=$this->ci->model->getActaHeader($idActa);
		$data['title']='Acta #'.$id.' de Revisión por la Dirección';
		return $data;
                    	}
}

?>