<?php 
/**
* 
*  
*/  
class Model_sgc extends CI_Model
{ 
	function __construct()
	{
		parent::__construct();
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo la misiòn de CRM
	 */
	public function getMision(){
		$data=array();
		$query=$this->db->select("m.idMision,m.codigoMision,m.version,m.fechaVigencia,m.texto,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=m.codigoProceso');
		$query = $this->db->get('mision m');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	
	/**
	 * Este metodo obtiene el nombre de
	 * responsables del dofa segun el idDofa
	 */
	public function getResponsableDOFA($idDOFA){
		$data=array();
		$query=$this->db->select("u.id,u.nombre");
		$query=$this->db->join('responsableDOFA r','r.codigoDOFA=d.idDOFA');
		$query=$this->db->join('usuario u','r.codigoResponsable=u.id');
		$query=$this->db->where('r.codigoDOFA',$idDOFA);
		$query = $this->db->get('dofa d');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo el DOFA de CRM
	 */
	public function getDOFA(){
		$data=array();
		$query=$this->db->select("d.nota,d.idDOFA,d.codigoDOFA,d.version,d.fechaVigencia,d.fechaIdentificacion,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=d.codigoProceso');
		$query=$this->db->join('responsableDOFA r','r.codigoDOFA=d.idDOFA');
		$query = $this->db->get('dofa d');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene el nombre del factor,
	 * fortaleza y debilidades del DOFA
	 * $analisis=>1 si es interno 0 si es externo
	 */
	public function getFactorDOFA($analisis){
		$data=array();
		if (isset($analisis)) {
			$query=$this->db->select("f.nombreFactor factor,f.idFactor,da.idDA,fo.idFO,fa.idFA,do.idDO,fortaleza,debilidad,oportunidades oportunidad,fo.texto ofensivas,do.texto reorientacion,fa.texto defensivas,da.texto supervivencia,f.Amenazas");
			$query=$this->db->join("estrategiasfo fo","f.`codigoOfensivas`=fo.idFO");
			$query=$this->db->join("estrategiasdo do","f.`codigoReorientacion`=do.idDO");
			$query=$this->db->join("estrategiasfa fa","f.`codigoDefensivas`=fa.idFA");
			$query=$this->db->join("estrategiasda da","f.`codigoSupervivencia`=da.idDA");
			$query=$this->db->where("f.analisisInterno",$analisis);
			$query=$this->db->get("factor f");
			if ($query->num_rows()>0) {
				$data= $query->result();
			}else{
				$data=FALSE;
			}
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;

	}
	/**
	 * Este metodo actualiza los datos de 
	 * la tabla DOFA
	 */
	public function editDOFA($data,$id)
	{
		$res=FALSE;
			$this->db->where('idDOFA',$id);
			if ($this->db->update('dofa',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		return $res;
	}
	/**
	 * Este metodo actualiza los responsables 
	 * del DOFA
	 */
	public function editResponsablesDOFA($codigoDOFA,$responsable){
		$res=FALSE;
		if ($this->validateResponsable()) {
			foreach ($responsable as $value) {
				$data=array("codigoDOFA"=>$codigoDOFA,"codigoResponsable"=>$value);
				if ($this->db->insert('responsabledofa',$data)) {
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
		return $res;
	}
	/**
	 * Description
	 * @return type
	 */
	public function validateImg($name,$mod,$nameTable)
	{
		$res=FALSE;
		$query=$this->db->where('nombreImg',$name);
		$query=$this->db->where('modulo',$mod);
		$query=$this->db->select('nombreImg');
		$query=$this->db->get($nameTable);
		if($query->num_rows()>0){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * vacia la tabla responsabledofa
	 * para no repetir los datos ingresados
	 */
	public function validateResponsable(){
		$res=FALSE;
			if ($query=$this->db->empty_table('responsabledofa')) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
			return $res;
	}
	/**
	 * vacia la tabla responsabledofa
	 * para no repetir los datos ingresados
	 */
	public function validateResponsableG($id){
		$res=FALSE;
		$query=$this->db->where('codigoIndicador',$id);
			if ($query=$this->db->delete('relacionindicadorcodigoresponsablegestionar')) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
			return $res;
	}
	/**
	 * Este metodo elimina los procesos asociados a 
	 * una directriz
	 * @param type $id 
	 * @return type
	 */
	public function validateProcesoDirectriz($id)
	{
		$res=FALSE;
		$query=$this->db->where('codigoDirectriz',$id);
			if ($query=$this->db->delete('relacionprocesodirectriz')) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
			return $res;
	}
	/**
	 * Este metodo elimina los recursos asociados a 
	 * un indicador
	 * @param type $id 
	 * @return type
	 */
	public function validateRecursoIndicador($id){
		$res=FALSE;
		$query=$this->db->where('codigoIndicador',$id);
			if ($query=$this->db->delete('relacionIndicadorRecurso')) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
			return $res;
	}
	/**
	 * Este metodo actualiza las estrategias FO
	 * del DOFA
	 * 
	 */
	public function updateFO($text){
		$res=FALSE;
		if(isset($text) ){
			$data=array("texto"=>$text);
			if ($this->db->update('estrategiasfo',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las estrategias DO
	 * del DOFA
	 * 
	 */
	public function updateDO($text){
		$res=FALSE;
		if(isset($text) ){
			$data=array("texto"=>$text);
			if ($this->db->update('estrategiasdo',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las estrategias FA
	 * del DOFA
	 * 
	 */
	public function updateFA($text){
		$res=FALSE;
		if(isset($text) ){
			$data=array("texto"=>$text);
			if ($this->db->update('estrategiasfa',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las estrategias DA
	 * del DOFA
	 * 
	 */
	public function updateDA($text){
		$res=FALSE;
		if(isset($text) ){
			$data=array("texto"=>$text);
			if ($this->db->update('estrategiasda',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las
	 * fortalezas de acuerdo al id del factor 
	 */
	public function updateFactorFortaleza($id,$fortaleza){
		$res=FALSE;
		$index=1;
		if(isset($id) && isset($fortaleza)){
			foreach ($fortaleza as $text){
				$query=$this->db->where('idFactor',$id[$index++]);
				$data=array("Fortaleza"=>$text);
				if ($this->db->update('factor',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las
	 * debilidades de acuerdo al id del factor 
	 */
	public function updateFactorDebilidad($id,$debilidad){
		$res=FALSE;
		$index=1;
		if(isset($id) && isset($debilidad)){
			foreach ($debilidad as $text){
				$query=$this->db->where('idFactor',$id[$index++]);
				$data=array("Debilidad"=>$text);
				if ($this->db->update('factor',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
			return $res;
	}	
	/**
	 * Este metodo actualiza las
	 * oportunidades de acuerdo al id del factor 
	 */
	public function updateFactorOportunidad($id,$oportunidad){
		$res=FALSE;
		$index=11;
		if(isset($id) && isset($oportunidad)){
			foreach ($oportunidad as $text){
				$query=$this->db->where('idFactor',$id[$index++]);
				$data=array("Oportunidades"=>$text);
				if ($this->db->update('factor',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza las
	 * amenazas de acuerdo al id del factor 
	 */
	public function updateFactorAmenaza($id,$amenaza){
		$res=FALSE;
		$index=11;
		if(isset($id) && isset($amenaza)){
			foreach ($amenaza as $text){
				$query=$this->db->where('idFactor',$id[$index++]);
				$data=array("Amenazas"=>$text);
				if ($this->db->update('factor',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
			return $res;
	}			
	/**
	 * Este metodo actualiza el nombre 
	 * del factor de acuerdo al id recibido
	 */
	public function updateNameFactor($id,$name){
		$res=FALSE;
		$index=1;
		if(isset($id)&&isset($name)){
			foreach ($name as $nameFactor){
				$query=$this->db->where('idFactor',$id[$index++]);
				$data=array("nombreFactor"=>$nameFactor);
				if ($this->db->update('factor',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza la mision de CRM en la BD
	 */
	public function editMision($id,$text){
		$res=FALSE;
		if( isset($id) && isset($text) ){
		$this->db->where('idMision',$id);
			if ($this->db->update('mision',$text)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza los objetivos de calidad
	 */
	public function editObjetivo($id,$data){
		$res=FALSE;
		if (isset($id) && isset($data)) {
			$this->db->where('idObjetivoC',$id);
			if ($this->db->update('objetivoCalidad',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza los procesos
	 */
	public function editProceso($id,$data){
		$res=FALSE;
		if (isset($id) && isset($data)) {
			$this->db->where('idProceso',$id);
			if ($this->db->update('proceso',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza el mapa de procesos de CRM en la BD
	 */
	public function editMapa($id,$data){
		$res=FALSE;
		if( isset($id) && isset($data) ){
		$this->db->where('idMapa',$id);
			if ($this->db->update('mapaProcesos',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza el mapa de procesos de CRM en la BD
	 */
	public function editDespliegue($id,$data){
		$res=FALSE;
		if( isset($id) && isset($data) ){
		$this->db->where('idDespliegue',$id);
			if ($this->db->update('despliegueObjetivo',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza la directriz 
	 * del despliegue de objetivos
	 */
	public function editDirectrizSG($id,$nombre,$descripcion,$index){
		$res=FALSE;
		$data=array();
		$j=count($index)+5;
		if( isset($id) && isset($nombre) && isset($descripcion) && isset($index) ){
			for ($i=5; $i<$j; $i++) { 
				$this->db->where('idDirectriz',$id[$index[$i]]);
				$data=array("nombreDirectriz"=>$nombre[$index[$i]],"descripcion"=>$descripcion[$index[$i]]);
				if ($this->db->update('directriz',$data)) {
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}	
           	
		}
			return $res;
	}
	/**
	 * Este metodo inserta los responsables 
	 * de getionar los indicadores en la 
	 * tabla relacionindicadorcodigoresponsablegestionar
	 */
	public function editResponsableGestionar($idIndicador,$idResponsable){
		$res=FALSE;
		if ($this->validateResponsableG()) {
			for ($i=0; $i <count($idIndicador) ; $i++) { 
				for ($j=0; $j <count($idResponsable[$i]) ; $j++) { 
					$data=array("codigoIndicador"=>$idIndicador[$i],"codigoResponsableGestionar"=>$idResponsable[$i][$j]);
					if ($this->db->insert('relacionindicadorcodigoresponsablegestionar',$data)) {
						$res=TRUE;
					}else{
						$res=FALSE;
					}
				}
			}
		}
		return $res;	
	}
	/**
	 * Este metodo obtiene los valores 
	 * iniciales del formato del
	 * acta de revision por la direccion 
	 */
	public function getActaHeader($idActa){
		$data=array();
		if (isset($idActa)) {
			$query=$this->db->where("idActa",$idActa);
			$query=$this->db->where("completa",1);
			$query=$this->db->select("idActa id,DATE_FORMAT(fechaVigencia,'%d/%m/%Y') fechaVigencia,version,codigoActa,periodoEvaluado periodo,fechaReunion  fecha,DATE_FORMAT(fechaVigencia,'%d/%M/%Y') fechaV,DATE_FORMAT(fechaReunion,'%d/%m/%Y') fechaReunion,lugarReunion lugar,horaReunion hora,mision,vision,preambulo,politica,objetivoscalidad,politicaSG,objetivosSG,p.nombreProceso proceso");
			$query=$this->db->join('proceso p','p.idProceso=a.codigoProceso');
			$query=$this->db->get("acta a");
			if ($query->num_rows()>0) {
			$data=$query->row();
				}else{
				$data=FALSE;
			}
		}else{
			$data=FALSE;
		}
		
		$query->free_result();
		return $data;
	}

	/**
	 * Este metodo obtiene las
	 * actas de la revision por la 
	 * revision existentes en la 
	 * BD para su posterior visualizacion 
	 */
	public function getActas($limit,$start)
	{
		$data=array();
		$query=$this->db->select('idActa numeroActa,DATE_FORMAT(fechaReunion,"%d/%m/%y") fecha,periodoEvaluado periodo');
		$query=$this->db->where('completa',1);
			if ($start==0) {
				$query=$this->db->limit($limit);	
			}else{
				$query=$this->db->limit($limit,$start);	
			}		
		$query=$this->db->get('acta');
			if ($query->num_rows()>0) {
				$data=$query->result();
			}else{
				$data=FALSE;
			}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene las
	 * actas incompletas de la revision por la 
	 * revision existentes en la 
	 * BD para su posterior visualizacion 
	 */
	public function getActasIncompleta($limit,$start)
	{
		$data=array();
		$query=$this->db->select('idActa numeroActa,DATE_FORMAT(fechaReunion,"%d/%m/%y") fecha,periodoEvaluado periodo');
		$query=$this->db->where('completa',0);
			if ($start==0) {
				$query=$this->db->limit($limit);	
			}else{
				$query=$this->db->limit($limit,$start);	
			}		
		$query=$this->db->get('acta');
			if ($query->num_rows()>0) {
				$data=$query->result();
			}else{
				$data=FALSE;
			}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene las
	 * actas incompletas de la revision por la 
	 */
	public function validateActaIncompleta($id)
	{
		$data=array();
		$query=$this->db->select('idActa numeroActa');
		$query=$this->db->where('completa',0);
		$query=$this->db->where('idActa',$id);
		$query=$this->db->get('acta');
			if ($query->num_rows()>0) {
				$data=$query->result();
			}else{
				$data=FALSE;
			}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo inserta datos de
	 * la informacion general del acta
	 * de revision por la direccion en 
	 * la tabla acta.
	 */
	public function insertActaInformacionGeneral($periodo,$fechaReunion,$lugar,$hora,$preambulo,$mision,$vision,$politica,$objetivos,$politicaSG,$objetivosSG,$codigoActa,$version,$fechavigencia)
	 {
			$data=array('periodoEvaluado'=>$periodo,'fechaReunion'=>$fechaReunion,'lugarReunion'=>$lugar,'horaReunion'=>$hora,'preambulo'=>$preambulo,'mision'=>$mision,'vision'=>$vision,'politica'=>$politica,'objetivoscalidad'=>$objetivos,'politicaSG'=>$politicaSG,'objetivosSG'=>$objetivosSG,'codigoActa'=>$codigoActa,'version'=>$version,'fechavigencia'=>$fechavigencia);
			if ($this->db->insert('acta',$data)){
				$res=$this->db->insert_id();
			}else{
				$res=FALSE;
			}
		return $res;
	 } 
	 /**
	  * Description
	  * @param type $idActa 
	  * @return type
	  */
	public function updateActaInformacionGeneral($idActa,$periodo,$fechaReunion,$lugar,$hora,$preambulo,$mision,$vision,$politica,$objetivos,$politicaSG,$objetivosSG,$codigoActa,$version,$fechavigencia)
	 {
			$data=array('periodoEvaluado'=>$periodo,'fechaReunion'=>$fechaReunion,'lugarReunion'=>$lugar,'horaReunion'=>$hora,'preambulo'=>$preambulo,'mision'=>$mision,'vision'=>$vision,'politica'=>$politica,'objetivoscalidad'=>$objetivos,'politicaSG'=>$politicaSG,'objetivosSG'=>$objetivosSG,'codigoActa'=>$codigoActa,'version'=>$version,'fechavigencia'=>$fechavigencia);
			$this->db->where('idActa',$idActa);
			if ($this->db->update('acta',$data)){
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		return $res;
	 } 
	 /**
	  * Este metodo cambia el estado del acta 
	  * de 0 a 1
	  */
	 public function completarActa($idActa)
	 {
	 	$res=FALSE;
	 	if (isset($idActa)) {
	 		$this->db->where('idActa',$idActa);
	 		$data=array('completa'=>1);
	 		if($this->db->update('acta', $data)){
	 			$res=TRUE;
	 		}
	 	}
	 	return $res;
	 }
	/**
	 * [deleteActaIncompleta description]
	 * Este metodo elimina el acta incompleta de 
	 * la revision por la direccion segun
	 * el id enviado y los datos relacionados
	 * con este id
  	 */
	public function deleteActaIncompleta($idActa,$nombreTabla)
	{
		$res=FALSE;
		if (isset($idActa)&&isset($nombreTabla)) {
			if($nombreTabla=='acta'){$this->db->where('idActa',$idActa);}else{$this->db->where('codigoActa',$idActa);}
 			if ($this->db->delete($nombreTabla)) {
 				$res=TRUE;
 			}
		}
		return $res;
	}
	/**
	 * Este metodo elimina tablas 
	 * relacionadas al acta de la 
	 * revisión por la dirección
	 * @param type $idActa 
	 * @param type $nombreTable 
	 * @return type
	 */
	public function deleteTable($idActa,$nombreTable)
	{		
		$res=FALSE;
		if (isset($idActa)&&isset($nombreTable)) {
			$codigo='codigoActa';
			if($nombreTable=='acta'){$codigo='idActa';}
			$query=$this->db->where($codigo,$idActa);
			if($query=$this->db->delete($nombreTable)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [deletePlanAccion este metodo elimina 
	 * un plan de accion]
	 * @param  [type] $id [id unico de plan de acción]
	 * @return [type]     [description]
	 */
	public function deletePlanAccion($id)
	{
		$res=false;
		if (isset($id)) {
			$query=$this->db->where('idAccion',$id);
			if($this->db->delete('planaccion')){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function deleteSeguimientoAccion($id)
	{
		$res=false;
		if (isset($id)) {
			$query=$this->db->where('idSeguimiento',$id);
			if($this->db->delete('seguimientoaccion')){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [deleteSolicitud description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteSolicitud($id)
	{
		$res=false;
		if (isset($id)) {
			$query=$this->db->where('idSolicitud',$id);
			if($this->db->delete('solicitudcambio')){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [updateSeguimientoAccion description]
	 * @param  [type] $id_seguimiento         [description]
	 * @param  [type] $fecha_seguimiento      [description]
	 * @param  [type] $descripcionSeguimiento [description]
	 * @param  [type] $eficacia               [description]
	 * @param  [type] $cargoV                 [description]
	 * @return [type]                         [description]
	 */
	public function updateSeguimientoAccion($id_seguimiento,$fecha_seguimiento,$descripcionSeguimiento,$eficacia,$cargoV)
	{
		$res=false;
		for ($i=1; $i <=count($id_seguimiento) ; $i++) { 
			if(isset($eficacia[$i])){
				$_eficacia=$eficacia[$i];
			}else{
				$_eficacia='NO';
			}
			$data=array('fecha'=>$fecha_seguimiento[$i],'descripcion'=>$descripcionSeguimiento[$i],'eficacia'=>$_eficacia,'codigoCargo'=>$cargoV[$i]);
			$this->db->where('idSeguimiento',$id_seguimiento[$i]);
			if($this->db->update('seguimientoaccion',$data)){
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [deleteRelacionContenidoPlanAccion description]
	 * @param  [type] $id_plan [description]
	 * @return [type]          [description]
	 */
	public function deleteRelacionContenidoPlanAccion($id_plan)
	{
		$res=false;
		if (isset($id_plan)) {
			$query=$this->db->where('codigoPlanAccion',$id_plan);
			if($this->db->delete('relacionaccionplan')){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function deleteRelacionAccionSeguimiento($id)
	{
		$res=false;
		if (isset($id)) {
			$query=$this->db->where('codigoSeguimiento',$id);
			if($this->db->delete('relacionaccionseguimiento')){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [deleteTableActa description]
	 * @param  [type] $id        [description]
	 * @param  [type] $nameId    [description]
	 * @param  [type] $nameTable [description]
	 * @param  string $idFila    [description]
	 * @param  string $nameFila  [description]
	 * @return [type]            [description]
	 */
	public function deleteTableActa($id,$nameId,$nameTable,$idFila='',$nameFila='')
	{
		$res=FALSE;
		if (isset($id)&&isset($nameId)&&isset($nameTable)) {
			if(isset($idFila)&&!empty($idFila)&&isset($nameFila)&&!empty($nameFila)){$query=$this->db->where($nameFila,$idFila);}
			$query=$this->db->where($nameId,$id);
			if($query=$this->db->delete($nameTable)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [deleteFilaTable description]
	 * @param  [type] $idFila      [description]
	 * @param  [type] $nombreTable [description]
	 * @param  [type] $codigo      [description]
	 * @param  [type] $id          [description]
	 * @return [type]              [description]
	 */
	public function deleteFilaTable($idFila,$nombreTable,$codigo,$id)
	{		
		$res=FALSE;
		if (isset($idFila)&&isset($nombreTable)&&isset($codigo)) {
			for ($i=0; $i <count($idFila) ; $i++) { 
				if($this->getDataTable($idFila[$i]->$id,$nombreTable,$codigo,$codigo)){
					$query=$this->db->where($codigo,$idFila[$i]->$id);
					if($query=$this->db->delete($nombreTable)){
						$res=TRUE;
					}
				}else{
					$res=TRUE;
				}
			}
		}
		return $res;
	}
	/**
	 * [deleteActa description]
	 * Este metodo elimina el acta de 
	 * la revision por la direccion segun
	 * el id enviado y los datos relacionados
	 * con este id
  	 */
	public function deleteActa($idActa,$nombreTabla)
	{
		$res=FALSE;
		$data=array();
		if (isset($idActa)&&isset($nombreTabla)) {
			if($this->validateDeleteActa($idActa,$nombreTabla)){
				switch ($nombreTabla) {
					case 'graphic':
							$data=$this->getDataTable($idActa,$nombreTabla,'idGraphic','codigoActa');
							if($this->deleteFilaTable($data,'filagraphic','codigoGraphic','idGraphic')){
								if($this->deleteTable($idActa,$nombreTabla)){
									$res=TRUE;
								}else{
									$res=FALSE;
								}
							}
						break;
					case 'tabletwo':
						$data=$this->getDataTable($idActa,$nombreTabla,'idTableTwo','codigoActa');
							if($this->deleteFilaTable($data,'filatwo','codigoTable','idTableTwo')){
								if($this->deleteTable($idActa,$nombreTabla)){
									$res=TRUE;
								}else{
									$res=FALSE;
								}
							}
						break;	
					case 'tablethree':
					$data=$this->getDataTable($idActa,$nombreTabla,'idTableThree','codigoActa');
						if($this->deleteFilaTable($data,'filathree','codigoTable','idTableThree')){
							if($this->deleteTable($idActa,$nombreTabla)){
								$res=TRUE;
							}else{
									$res=FALSE;
								}
						}
					break;	
					case 'tablefour':
					$data=$this->getDataTable($idActa,$nombreTabla,'idTableFour','codigoActa');
						if($this->deleteFilaTable($data,'filafour','codigoTable','idTableFour')){
							if($this->deleteTable($idActa,$nombreTabla)){
								$res=TRUE;
							}else{
									$res=FALSE;
								}
						}
					break;
					case 'tablefive':
					$data=$this->getDataTable($idActa,$nombreTabla,'idTableFive','codigoActa');
						if($this->deleteFilaTable($data,'filafive','codigoTable','idTableFive')){
							if($this->deleteTable($idActa,$nombreTabla)){
								$res=TRUE;
							}else{
									$res=FALSE;
								}
						}
					break;
					case 'tablesix':
					$data=$this->getDataTable($idActa,$nombreTabla,'idTableSix','codigoActa');
						if($this->deleteFilaTable($data,'filasix','codigoTable','idTableSix')){
							if($this->deleteTable($idActa,$nombreTabla)){
								$res=TRUE;
							}else{
									$res=FALSE;
								}
						}
					break;
					case 'tableseven':
					$data=$this->getDataTable($idActa,$nombreTabla,'idTableSeven','codigoActa');
						if($this->deleteFilaTable($data,'filaseven','codigoTable','idTableSeven')){
							if($this->deleteTable($idActa,$nombreTabla)){
								$res=TRUE;
							}else{
									$res=FALSE;
								}
						}
					break;	
					default:
						if($this->deleteTable($idActa,$nombreTabla)){
							$res=TRUE;
						}else{
							$res=FALSE;
							}
						break;
				}
 			}else{
 				$res=TRUE;
 			}
		}
		return $res;
	}
	/**
	 * Este metodo obtiene los datos 
	 * relacionados con el nombre de 
	 * la tabla recibida
	 */
	public function getDataTable($idActa,$nombreTabla,$id,$codigo)
	{
		$data=FALSE;
		if (isset($idActa)&&isset($nombreTabla)) {
			$query=$this->db->where($codigo,$idActa);
			$query=$this->db->select($id);
			$query=$this->db->get($nombreTabla);
			if($query->num_rows()>0){
				$data=$query->result();
			}
		}
		$query->free_result();
		return $data;
	}
	/**
	 * metodo complemento de getDataTable
	 */
	public function getFilaTable($idActa,$nombreTabla)
	{
		$data=FALSE;
		if (isset($idActa)&&isset($nombreTabla)) {
			$query=$this->db->where('codigoActa',$idActa);
			if($nombreTabla=='graphic'){$query=$this->db->select('codigoGraphic');}else{$query=$this->db->select('codigoTable');}
			$query=$this->db->get($nombreTabla);
			if($query->num_rows()>0){
				$data=$query->result();
			}
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo verifica 
	 * que el id del acta de la 
	 * revision por la direccion
	 * este asociada en la tabla
	 * que se va a eliminar
	 */
	public function validateDeleteActa($idActa,$nombreTabla)
	{
		$res=FALSE;
		if (isset($idActa)&&isset($nombreTabla)) {
			if($nombreTabla=='acta'){return TRUE;}else{$query=$this->db->where('codigoActa',$idActa);}
			$query=$this->db->select('codigoActa');
			$query=$this->db->get($nombreTabla);
 			if ($query->num_rows()>0) {
 				$res=TRUE;
 			}
		}
		return $res;
	}
	/**
	 * Este metodo inserta los asistentes
	 * del acta de la revision por la 
	 * direccion en la tabla asistentesActa
	 */
	public function insertAsistentes($name,$cargo,$proceso,$idActa)
	{
		$data=array();
		for ($i=1; $i <=count($name) ; $i++) { 
			$data=array('nombre'=>$name[$i],'cargo'=>$cargo[$i],'proceso'=>$proceso[$i],'codigoActa'=>$idActa);
			if ($this->db->insert('asistentesActa',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * [deleteAsistente description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
		/**
	 * Este metodo inserta los asistentes
	 * del acta de la revision por la 
	 * direccion en la tabla asistentesActa
	 */
	public function insertNewAsistentes($id,$name,$cargo,$proceso,$idActa)
	{
		$data=array();
		$res=TRUE;
		$index=count($id)+1;
		for ($i=$index; $i <=count($name) ; $i++) { 
			$data=array('nombre'=>$name[$i],'cargo'=>$cargo[$i],'proceso'=>$proceso[$i],'codigoActa'=>$idActa);
			if ($this->db->insert('asistentesActa',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	public function deleteAsistente($id)
	{
		$res=FALSE;
		if (isset($id)) {
			$this->db->where('idAsistente',$id);
 			if ($this->db->delete('asistentesacta')) {
 				$res=TRUE;
 			}
		}
		return $res;
	}
	/**
	 * Este metodo obtiene los 
	 * asistentes del acta de la
	 * revision por la direccion
	 */
	public function getAsistentesActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idAsistente id,nombre,cargo,proceso');	
		$query=$this->db->get('asistentesacta');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @return type
	 */
	public function updateAsistentesActa($id,$nombre,$cargo,$proceso)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($nombre) && isset($cargo) && isset($proceso)){
			for ($i=1; $i <=count($id) ; $i++) { 
				$this->db->where('idAsistente',$id[$i]);
				$data=array("nombre"=>$nombre[$i],"cargo"=>$cargo[$i],"proceso"=>$proceso[$i]);
				if ($this->db->update('asistentesacta',$data)) {
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}			
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $idSub 
	 * @param type $arraySubtitulo 
	 * @return type
	 */
	public function updateSubtituloActa($idSub,$arraySubtitulo)
	{
		$res=FALSE;
		$data=array();
		if( isset($idSub) && isset($arraySubtitulo)){
			$this->db->where('idSubtituloActa',$idSub);
			if ($this->db->update('subtitulo',$arraySubtitulo)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id
	 * @param type $array
	 * @return type
	 */
	public function updateEncabezadoActa($id,$array)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($array)){
			$this->db->where('idEncabezadoActa',$id);
			if ($this->db->update('encabezado',$array)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $nombre_Doc 
	 * @param type $imgTexto 
	 * @return type
	 */
	public function updateImgTextoActa($nombreImg,$id,$texto){
		$res=FALSE;
		$data=array();
		if($nombreImg==''){
			$this->db->where('idImagenTextoActa',$id);
			$data=array('texto'=>$texto);
			if ($this->db->update('imagentexto',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		else if(isset($id) && isset($nombreImg)){
			$this->db->where('idImagenTextoActa',$id);
			$data=array('nombreImg'=>$nombreImg);
			if ($this->db->update('imagentexto',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $nombre_Doc 
	 * @param type $imgTexto 
	 * @return type
	 */
	public function updateTextoImgActa($nombreImg,$id,$texto){
		$res=FALSE;
		$data=array();
		if($nombreImg==''){
			$this->db->where('idTextoImagenActa',$id);
			$data=array('texto'=>$texto);
			if ($this->db->update('textoimagen',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		else if(isset($id) && isset($nombreImg)){
			$this->db->where('idTextoImagenActa',$id);
			$data=array('nombreImg'=>$nombreImg);
			if ($this->db->update('textoimagen',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $array 
	 * @return type
	 */
	public function updateImgActa($nombreImg,$id)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($nombreImg)){
			$this->db->where('idImgActa',$id);
			$data=array('nombreImg'=>$nombreImg);
			if ($this->db->update('imgacta',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id
	 * @param type $array
	 * @return type
	 */
	public function updateTextoActa($id,$array)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($array)){
			$this->db->where('idTextoActa',$id);
			if ($this->db->update('texto',$array)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * [updateTableTwo description]
	 * @param  [type] $id   [description]
	 * @param  [type] $tex1 [description]
	 * @param  [type] $tex2 [description]
	 * @return [type]       [description]
	 */
	public function updateTableTwo($id,$tex1,$tex2)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)){
			$this->db->where('idTableTwo',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2);
			if ($this->db->update('tabletwo',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * [updateTableThree description]
	 * @param  [type] $id    [description]
	 * @param  [type] $name1 [description]
	 * @param  [type] $name2 [description]
	 * @param  [type] $name3 [description]
	 * @return [type]        [description]
	 */
	public function updateTableThree($id,$tex1,$tex2,$tex3)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)){
			$this->db->where('idTableThree',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2,"nombreColumna3"=>$tex3);
			if ($this->db->update('tablethree',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $tex1 
	 * @param type $tex2 
	 * @param type $tex3 
	 * @param type $tex4 
	 * @return type
	 */
	public function updateTableFour($id,$tex1,$tex2,$tex3,$tex4)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)&& isset($tex4)){
			$this->db->where('idTableFour',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2,"nombreColumna3"=>$tex3,"nombreColumna4"=>$tex4);
			if ($this->db->update('tablefour',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $tex1 
	 * @param type $tex2 
	 * @param type $tex3 
	 * @param type $tex4 
	 * @param type $tex5 
	 * @return type
	 */
	public function updateTableFive($id,$tex1,$tex2,$tex3,$tex4,$tex5)
	{
		$res=FALSE;
		$data=array();
		if(isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)&& isset($tex4)&&isset($tex5)){
			$this->db->where('idTableFive',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2,"nombreColumna3"=>$tex3,"nombreColumna4"=>$tex4,"nombreColumna5"=>$tex5);
			if ($this->db->update('tablefive',$data)) {
				$res=TRUE;
			}	
		}
		return $res;
	}
	/**
	 * [updateTableSix description]
	 * @param  [type] $id   [description]
	 * @param  [type] $tex1 [description]
	 * @param  [type] $tex2 [description]
	 * @param  [type] $tex3 [description]
	 * @param  [type] $tex4 [description]
	 * @param  [type] $tex5 [description]
	 * @param  [type] $tex6 [description]
	 * @return [type]       [description]
	 */
	public function updateTableSix($id,$tex1,$tex2,$tex3,$tex4,$tex5,$tex6)
	{
		$res=FALSE;
		$data=array();
		if(isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)&& isset($tex4)&&isset($tex5)&&isset($tex6)){
			$this->db->where('idTableSix',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2,"nombreColumna3"=>$tex3,"nombreColumna4"=>$tex4,"nombreColumna5"=>$tex5,"nombreColumna6"=>$tex6);
			if ($this->db->update('tablesix',$data)) {
				$res=TRUE;
			}	
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $tex1 
	 * @param type $tex2 
	 * @param type $tex3 
	 * @param type $tex4 
	 * @param type $tex5 
	 * @param type $tex6 
	 * @param type $tex7 
	 * @return type
	 */
	public function updateTableSeven($id,$tex1,$tex2,$tex3,$tex4,$tex5,$tex6,$tex7)
	{
		$res=FALSE;
		$data=array();
		if(isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)&& isset($tex4)&&isset($tex5)&&isset($tex6)&&isset($tex7)){
			$this->db->where('idTableSeven',$id);
			$data=array("nombreColumna1"=>$tex1,"nombreColumna2"=>$tex2,"nombreColumna3"=>$tex3,"nombreColumna4"=>$tex4,"nombreColumna5"=>$tex5,"nombreColumna6"=>$tex6,"nombreColumna7"=>$tex7);
			if ($this->db->update('tableseven',$data)) {
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [updateGraphic description]
	 * @param  [type] $id         [description]
	 * @param  [type] $titulo     [description]
	 * @param  [type] $subtitulo  [description]
	 * @param  [type] $subtituloY [description]
	 * @param  [type] $punto      [description]
	 * @return [type]             [description]
	 */
	public function updateGraphic($id,$titulo,$subtitulo,$subtituloY,$punto)
	{
		$res=FALSE;
		$data=array();
		if(isset($id) && isset($titulo)&& isset($subtitulo)&& isset($subtituloY)&& isset($punto)){
			$this->db->where('idGraphic',$id);
			$data=array("tituloG"=>$titulo,"subtituloG"=>$subtitulo,"subtituloY"=>$subtituloY,"puntoInicial"=>$punto);
			if ($this->db->update('graphic',$data)) {
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [updateTableTwo description]
	 * @param  [type] $id   [description]
	 * @param  [type] $tex1 [description]
	 * @param  [type] $tex2 [description]
	 * @return [type]       [description]
	 */
	public function updateFilaTwo($id,$tex1,$tex2)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)){
			$this->db->where('idFila',$id);
			$data=array("texto1"=>$tex1,"texto2"=>$tex2);
			if ($this->db->update('filatwo',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $tex1 
	 * @param type $tex2 
	 * @param type $tex3 
	 * @return type
	 */
	public function updateFilaThree($id,$tex1,$tex2,$tex3)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)){
			$this->db->where('idFilaThree',$id);
			$data=array("texto1"=>$tex1,"texto2"=>$tex2,"texto3"=>$tex3);
			if ($this->db->update('filathree',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * [updateFilaFour description]
	 * @param  [type] $id   [description]
	 * @param  [type] $tex1 [description]
	 * @param  [type] $tex2 [description]
	 * @param  [type] $tex3 [description]
	 * @param  [type] $tex4 [description]
	 * @return [type]       [description]
	 */
	public function updateFilaFour($id,$tex1,$tex2,$tex3,$tex4)
	{
		$res=FALSE;
		$data=array();
		if( isset($id) && isset($tex1)&& isset($tex2)&& isset($tex3)&& isset($tex4)){
			$this->db->where('idFilaFour',$id);
			$data=array("texto1"=>$tex1,"texto2"=>$tex2,"texto3"=>$tex3,"texto4"=>$tex4);
			if ($this->db->update('filafour',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}		
		}
		return $res;
	}
	/**
	 * Este metodo obtiene los modulos 
	 * del acta de la revision por la direccion
	 */
	public function getModulesActa()
	{
		$data=array();
		$query=$this->db->select('idModulo id,titulo');	
		$query=$this->db->get('moduloacta');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los subtitulos 
	 */
	 public function getSubtituloActa($idActa)
	 {
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idSubtituloActa id,texto,modulo,ordenActa');	
		$query=$this->db->get('subtitulo');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	 }
	/**
	 * Description
	 */
	public function getTextoActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTextoActa id,texto,modulo,ordenActa');	
		$query=$this->db->get('texto');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getImgActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idImgActa id,nombreImg img,modulo,ordenActa');	
		$query=$this->db->get('imgActa');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTextoImgActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTextoImagenActa id,texto,nombreImg img,modulo,ordenActa');
		$query=$this->db->get('textoimagen');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getImgTextoActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idImagenTextoActa id,texto,nombreImg img,modulo,ordenActa');
		$query=$this->db->get('imagentexto');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTableTwoActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableTwo id,nombreColumna1 col1,nombreColumna2 col2,modulo,ordenActa');
		$query=$this->db->get('tabletwo');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTableThreeActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableThree id,nombreColumna1 col1,nombreColumna2 col2,nombreColumna3 col3,modulo,ordenActa');
		$query=$this->db->get('tablethree');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}	
	/**
	 * Description
	 */
	public function getTableFourActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableFour id,nombreColumna1 col1,nombreColumna2 col2,nombreColumna3 col3,nombreColumna4 col4,modulo,ordenActa');
		$query=$this->db->get('tablefour');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTableFiveActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableFive id,nombreColumna1 col1,nombreColumna2 col2,nombreColumna3 col3,nombreColumna4 col4,nombreColumna5 col5,modulo,ordenActa');
		$query=$this->db->get('tablefive');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTableSixActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableSix id,nombreColumna1 col1,nombreColumna2 col2,nombreColumna3 col3,nombreColumna4 col4,nombreColumna5 col5,nombreColumna6 col6,modulo,ordenActa');
		$query=$this->db->get('tablesix');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getTableSevenActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idTableSeven id,nombreColumna1 col1,nombreColumna2 col2,nombreColumna3 col3,nombreColumna4 col4,nombreColumna5 col5,nombreColumna6 col6,nombreColumna7 col7,modulo,ordenActa');
		$query=$this->db->get('tableseven');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getGraphicActa($idActa)
	{
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idGraphic id,tituloG,subtituloG,subtituloY,puntoInicial,modulo,ordenActa,codigoTipoG tipoG');
		$query=$this->db->get('graphic');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaTwoActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFila id,texto1,texto2');
		$query=$this->db->get('filatwo');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaThreeActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFilaThree id,texto1,texto2,texto3');
		$query=$this->db->get('filathree');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaFourActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFilaFour id,texto1,texto2,texto3,texto4');
		$query=$this->db->get('filafour');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaFiveActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFilaFive id,texto1,texto2,texto3,texto4,texto5');
		$query=$this->db->get('filafive');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaSixActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFilaSix id,texto1,texto2,texto3,texto4,texto5,texto6');
		$query=$this->db->get('filasix');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaSevenActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoTable',$id);
		$query=$this->db->select('idFilaSeven id,texto1,texto2,texto3,texto4,texto5,texto6,texto7');
		$query=$this->db->get('filaseven');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 */
	public function getFilaGraphicActa($id)
	{
		$data=array();
		$query=$this->db->where('codigoGraphic',$id);
		$query=$this->db->select('idFilaBarra id,tituloColumna,datosColumna');
		$query=$this->db->get('filagraphic');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
 	/**
	 * Este metodo obtiene los encabezados
	 */
	 public function getEncabezadoActa($idActa)
	 {
		$data=array();
		$query=$this->db->where('codigoActa',$idActa);
		$query=$this->db->select('idEncabezadoActa id,texto,modulo,ordenActa');	
		$query=$this->db->get('encabezado');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	 }
	/**
	 * Este metodo obtiene el total de filas 
	 * de la tabla acta
	 */
	public function numberRowsActas()
	{
		$data=array();
		$query=$this->db->where('completa',1);
		$query=$this->db->select('idActa');	
		$query=$this->db->get('acta');
		return $query->num_rows();
	}
	/**
	 * [numberRowsIndicador description]
	 * @param  [type] $nivel [description]
	 * @return [type]        [description]
	 */
	public function numberRowsIndicador($nivel)
	{
		$data=array();
		$query=$this->db->where("visibilidad",1);
		$query=$this->db->where("nivel",$nivel);
		$query=$this->db->select('idIndicador');	
		$query=$this->db->get('indicador');
		return $query->num_rows();
	}
	/**
	 * [numberRowsMedicionId este metodo obtiene 
	 * el numero total de mediciones que tiene un
	 * indicador ]
	 * @param  [type] $id [description]
	 * @return [type]        [description]
	 */
	public function numberRowsMedicionId($id)
	{
		$data=array();
		$query=$this->db->where("codigoFichaIndicador",$id);
		$query=$this->db->select('codigoFichaIndicador');
		$query=$this->db->get('relacionindicadorcomportamiento');
		return $query->num_rows();
	}
	/**
	 * Description
	 * @param type $nivel 
	 * @return type
	 */
	public function numberRowsDirectriz($nivel)
	{
		$data=array();
		$query=$this->db->where("visibilidad",1);
		$query=$this->db->where("nivel",$nivel);
		$query=$this->db->select('idDirectriz');	
		$query=$this->db->get('directriz');
		return $query->num_rows();
	}
	/**
	 * Este metodo obtiene el total de filas 
	 * de la tabla acta incompletas
	 */
	public function numberRowsActasIncompleta()
	{
		$data=array();
		$query=$this->db->where('completa',0);
		$query=$this->db->select('idActa');	
		$query=$this->db->get('acta');
		return $query->num_rows();

	}
	public function numberRowsContenidoAccion($cadena=NULL)
	{
		$data=array();
		$query=$this->db->select('idContenidoAccion id');	
		$query=$this->db->join('relacionaccionfuente rf','rf.codigoAccion=c.idContenidoAccion');
		$query=$this->db->join('filtro f','f.idFiltro=c.codigoFiltro');
		if (isset($cadena) && $cadena != FALSE) {
			if(strpos($cadena,'eficacia')){
				$query=$this->db->join('controlseguimiento co','co.codigoContenidoAccion=c.idContenidoAccion ');
			}
		$this->db->where($cadena);
		}
		$query=$this->db->group_by('c.idContenidoAccion');
		$query=$this->db->get('contenidoAccion c');
		return $query->num_rows();

	}
	/**
	 * Este metodo obtiene el total de filas 
	 * de la tabla acta
	 */
	public function getIdActa()
	{
		$data=array();
		$query=$this->db->where('TABLE_SCHEMA','sistema_calidad');
		$query=$this->db->where('TABLE_NAME','acta');
		$query=$this->db->select('AUTO_INCREMENT idActa');	
		$query=$this->db->get('INFORMATION_SCHEMA.TABLES');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los modulos del contenido
	 * del acta de la revision por la direccion
	 */
	public function getModulosActa()
	{
		$data=array();
		$query=$this->db->select('titulo');
		$query=$this->db->get('moduloActa');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo inserta los responsables 
	 * de getionar los indicadores en la 
	 * tabla relacionindicadorcodigoresponsablegestionar
	 */
	public function editResponsableGestionarSG($idIndicador,$idResponsable){
		$res=FALSE;
			for ($i=0; $i <count($idIndicador) ; $i++) { 
					$data=array("codigoIndicador"=>$idIndicador[$i],"codigoResponsableGestionar"=>$idResponsable[$i]);
					if ($this->db->insert('relacionindicadorcodigoresponsablegestionar',$data)) {
						$res=TRUE;
					}else{
						$res=FALSE;
					}
			}
		return $res;	
	}
	/**
	 *  Este metodo actualiza la relacion entre
	 *  el proceso y la directriz.
	 */
	public function editRelacionProceso($idProceso,$idDirectriz,$nivel,$idDirectrizEditar){
		$res=FALSE;
		$data=array();
		if( isset($idProceso) && isset($idDirectriz) && isset($nivel) && isset($idDirectrizEditar)){
			for ($i=0; $i <count($idProceso) ; $i++) { 
				$this->db->where('idRelacion',$idDirectriz[$i]);
				$this->db->where('nivel',$nivel);
				$data=array("codigoProceso"=>$idProceso[$i],"codigoDirectriz"=>$idDirectrizEditar[$i]);
				if ($this->db->update('relacionprocesodirectriz',$data)) {
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}			
		}
			return $res;
	}
	/**
	 * Este metodo inserta los datos en la tabla control de cambios 
	 */
	public function insertCambio($version,$desc,$fecha,$tabla){
		$res=FALSE;
		if (isset($version) && isset($desc) && isset($fecha) && isset($tabla)) {
			$data=array(
				"version"=>$version,"descripcionAjuste"=>$desc,"fechaVigencia"=>$fecha,"codigoTabla"=>$tabla
			);
			$this->db->insert('controlCambio',$data);
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * Este metodo actualiza la revision de la mision de CRM en la BD
	 */
	public function editRevision($codigoE,$fecha,$codigoRelacion,$tabla){
		$res=FALSE;
		if( isset($codigoE) && isset($fecha)&& isset($codigoRelacion)&& isset($tabla)){
			$data=array(
				"codigoEmpleado"=>$codigoE,
				"fechaRevision"=>$fecha,
				"codigoTabla"=>$tabla
			);	
		$this->db->where('codigoRelacion',$codigoRelacion);
		$this->db->where('codigoTabla',$tabla);
			if ($this->db->update('revision',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
			return $res;
	}
	/**
	 * Este metodo actualiza la vision de CRM en la BD
	 */
	public function editVision($id,$text){
		$res=FALSE;
		if( isset($id) && isset($text) ){
		$this->db->where('idVision',$id);
			if ($this->db->update('vision',$text)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * Este metodo actualiza la politica de CRM en la BD
	 */
	public function editPolitica($id,$text){
		$res=FALSE;
		if( isset($id) && isset($text) ){
		$this->db->where('idPolitica',$id);
			if ($this->db->update('politicaCalidad',$text)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * Este metodo actualiza la politica del SST en la BD
	 */
	public function editPoliticaSG($id,$text){
		$res=FALSE;
		if( isset($id) && isset($text) ){
			$this->db->where('idPolitica_SG',$id);
			$data=array("texto"=>$text);
			if ($this->db->update('politica_sg_sst',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * Este metodo actualiza el alcance de CRM en la BD
	 */
	public function editAlcance($id,$text){
		$res=FALSE;
		if( isset($id) && isset($text) ){
		$this->db->where('idAlcance',$id);
			if ($this->db->update('alcance',$text)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo la visiòn de CRM
	 */
	public function getVision(){
		$data=array();
		$query=$this->db->select("v.idVision,v.codigoVision,DATE_FORMAT(v.fechaVigencia,'%d/%m/%Y')AS fechaVigencia,v.version,v.texto,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=v.codigoProceso');
		$query = $this->db->get('vision v');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo 
	 * el control de cambios de la tabla de CRM
	 * $tabla->codigo de tabla de la que se van a obtenr los cambios
	 */
	public function getControlCambio($tabla){
		$data=array();
		$query=$this->db->select("version,descripcionAjuste desc,fechaVigencia");
		$query=$this->db->where("codigoTabla",$tabla);
		$query = $this->db->get('controlCambio');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo el alcance de CRM
	 */
	public function getAlcance(){
		$data=array();
		$query=$this->db->select("a.idAlcance,a.codigoAlcance,a.fechaVigencia,a.version,a.texto,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=a.codigoProceso');
		$query = $this->db->get('alcance a');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo la politica de calidad de CRM
	 */
	public function getPolitica(){
		$data=array();
		$query=$this->db->select("pc.idPolitica,pc.codigoPolitica,pc.fechaVigencia,pc.version,pc.texto,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=pc.codigoProceso');
		$query = $this->db->get('politicaCalidad pc');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene la
	 * politica del SG-SST
	 */
	public function getPoliticaSG()
	{
		$data=array();
		$query=$this->db->select('texto');
		$query=$this->db->get('politica_sg_sst');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo el nombre y id de los usuarios de * CRM
	 */
	public function getUsers(){
		$data=array();
		$this->db->where('visibilidad',1);
		$this->db->select("id,nombre,codigoCargo,email");
		$this->db->order_by('nombre');
		$query=$this->db->get("usuario");
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else
		{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los procesos asociados a un usuario
	 * @param type $id 
	 * @return type
	 */
	public function getProcesoUser($id)
	{
		$data=array();
		$query=$this->db->where('r.codigoUsuario',$id);
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->join('proceso p ','p.idProceso=r.codigoProceso');
		$query=$this->db->join('usuario u ','u.id=r.codigoUsuario');
		$query=$this->db->select("p.nombreProceso,p.idProceso id");
		$query=$this->db->get("relacionprocesousuario  r");
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else
		{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getUserProceso este metodo obtiene los usuarios relacionados a 
	 * un proceso]
	 * @param  [type] $id [id unico del proceso]
	 * @return [type]     [description]
	 */
	public function getUserProceso($id)
	{
		$data=false;
		if(isset($id)){
			$query=$this->db->query('SELECT u.`nombre`,u.`email`,p.`nombreProceso`
			FROM proceso p
			INNER JOIN relacionprocesousuario r
			ON p.`idProceso`=r.`codigoProceso`
			INNER JOIN usuario u
			ON u.`id`=r.`codigoUsuario`
			WHERE p.`visibilidad`=1 && p.`idProceso`='.$id.' 
			&& primario=1 && (codigoTipoUsuario=1 OR codigoTipoUsuario=3 )');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * [getCargoUser este metodo obtiene los usuarios asociados a un cargo]
	 * @param  [type] $id [id de usuario]
	 * @return [type]     [description]
	 */
	public function getUserCargo()
	{
		$data=array();
		$query=$this->db->join('cargo c','c.idCargo=r.codigoCargo');
		$query=$this->db->join('usuario u ','u.id=r.codigoUsuario');
		$query=$this->db->select("u.nombre,c.idCargo");
		$query=$this->db->get("relacioncargousuario r");
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else
		{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo los datos de la tabla revision
	 * segun el id de la tabla que se consulte.
	 * $tabla->id de la tabla (Ej:mision)
	 */
	public function getRevision($tabla){
		$data=array();
		$this->db->select("DATE_FORMAT(r.fechaRevision,'%d/%m/%y') AS fechaRevision,u.nombre,c.nombreCargo");
		$this->db->join("usuario u","u.id=r.codigoEmpleado");
		$this->db->join("cargo c","c.idCargo=r.codigoCargo");
		$this->db->where("codigoTabla",$tabla);
		$query=$this->db->get("revision r");
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else
		{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este método realiza una consulta a la BD obteniendo los
	 * datos de la tabla despliegueObjetivo

	 */
	public function getDespliegueObjetivos(){
		$data=array();
		$query=$this->db->select("po.texto politica,poSG.texto politica_SG,d.idDespliegue,d.codigoDespliegue,d.version,d.fechaVigencia,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=d.codigoProceso');
		$query=$this->db->join('politicaCalidad po','po.idPolitica=d.codigoPolitica');
		$query=$this->db->join('politica_SG_SST poSG','poSG.idPolitica_SG=d.codigoPolitica_SG');
		$query = $this->db->get('despliegueObjetivo d');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;	
	}
	/**
	 * [getAjusteTablaSST Consulta para saber si hay una relación
	 * entre la tabla relacionprocesodirectriz e indicador]
	 * nivel(1/2)
	 * 		nivel-1 hace referencia a la tabla calidad 
	 * 		nivel-2 hace referencia a la tabla SST
	 * @param  [type] $codigoProceso   [description]
	 * @param  [type] $codigoDirectriz [description]
	 */
	public function getAjusteTablaSST($codigoProceso,$codigoDirectriz)
	{	
		$data=FALSE;
		if(isset($codigoProceso)&&isset($codigoDirectriz)){
			$query=$this->db->select('i.orden');
			$query=$this->db->join('indicador i','r.codigoProceso=i.codigoProceso');
			$query=$this->db->where('i.nivel','2');
			$query=$this->db->where('i.visibilidad','1');
			$query=$this->db->where('i.codigoProceso',$codigoProceso);
			$query=$this->db->where('i.codigoDirectriz',$codigoDirectriz);
			$query=$this->db->get('relacionprocesodirectriz r');
			if($query->num_rows()>0){
				$data=$query->row();
			}
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getMaxAjusteSST description]
	 * @return [type] [description]
	 */
	public function getMaxAjusteSST()
	{
		$data=FALSE;
		$query=$this->db->select_max('orden','orden');
		$query=$this->db->get('indicador');
		if($query->num_rows()>0){
			$data=$query->row();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [updateOrdenIndicador description]
	 * @param  [type] $codigoIndicador [description]
	 * @param  [type] $orden           [description]
	 * @return [type]                  [description]
	 */
	public function updateOrdenIndicador($id,$orden)
	{
		$res=FALSE;
		if(isset($id)&&isset($orden)){ 
			$data=array('orden'=>$orden);
			$this->db->where('idIndicador',$id);
			if ($this->db->update('indicador',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * Este metodo se encarga de obtener
	 * los tipo de indicador del despliegue de
	 * objetivos en la BD(tabla tipoIndicador)
	 */
	public function getTipoIndicador(){
		$data=array();
		$query=$this->db->select('idTipo id,nombreTipo');
		$query=$this->db->get('tipoIndicador');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
 	}
	/**
	 * Este metodo obtiene los responsables
	 * de gestionar los indicadores del 
	 * despliegue de objetivos
	 */
	public function getResponsableGestionar($nivel='',$id=''){
		$data=array();
		$query=$this->db->select("i.idIndicador ,i.nombreIndicador,c.idCargo idC,c.nombreCargo,rg.codigoIndicador");
		$query=$this->db->join('indicador i','i.idIndicador=rg.codigoIndicador');
		$query=$this->db->join('cargo c','c.idCargo=rg.codigoResponsableGestionar');
		if(isset($nivel) &&!empty($nivel)){
			$query=$this->db->where("nivel",$nivel);
		}
		if(isset($id) &&!empty($id)){
			$query=$this->db->where("i.idIndicador",$id);
		}
		
		$query=$this->db->order_by("i.idIndicador",'asc');
		$query = $this->db->get('relacionindicadorcodigoresponsablegestionar rg');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;	
	}
	public function getResponsableGestionarId($id){
		$data=array();
		$query=$this->db->select("codigoResponsableGestionar idG");
		$query=$this->db->where('codigoIndicador',$id);
		$query = $this->db->get('relacionindicadorcodigoresponsablegestionar rg');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;	
	}
	/**
	 * Este metodo obtiene los simbolos 
	 * de la meta del despliegue de objetivos
	 */
    public function getSimbolo(){
    	$data=array();
    	$query=$this->db->select('idSimbolo id,codigoSimbolo nombre');
    	$query=$this->db->get('simbolo');
    	if ($query->num_rows()>0) {
    		$data=$query->result();
    	}else{
    		$data=FALSE;
    	}
    	$query->free_result();
    	return $data;
    }
	/**
	 * Este metodo obtiene la directriz
	 * del despliegue de objetivos
	 * $nivel->1=componentes de calidad
	 * $nivel->2=componentes de SST
	 */
	public function getDirectriz($nivel){
		$data=array();
		$query=$this->db->select("r.idRelacion,r.codigoProceso,p.nombreProceso proceso,p.idProceso,d.nombreDirectriz nombreDirectriz,d.idDirectriz,d.descripcion descripcion");
		$query=$this->db->join("directriz d","d.idDirectriz=r.codigoDirectriz");
		$query=$this->db->join("proceso p","p.idProceso=r.codigoProceso");
		$query=$this->db->where("r.nivel",$nivel);
		$query=$this->db->where("d.visibilidad",1);
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->order_by("r.codigoProceso",'asc');
		$query = $this->db->get('relacionprocesodirectriz r');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;	
	}
	/**
	 * Este metodo obtiene las directrices 
	 * para mostrarlas en lal paginacion
	 * @param type $nivel 
	 * @param type|string $limit 
	 * @param type|string $start 
	 * @return type
	 */
	public function getDirectriz1($nivel,$limit='',$start='')
	{
		$data=array();
		$query=$this->db->select("idDirectriz id,nombreDirectriz,descripcion");
		$query=$this->db->where("nivel",$nivel);
		$query=$this->db->where("visibilidad",1);
			if ($start==0) {
				$query=$this->db->limit($limit);	
			}else{
				$query=$this->db->limit($limit,$start);
			}
		$query = $this->db->get('directriz');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;	
	}
	/**
	 * [getProcesoDirectriz description]
	 * @param  [type] $nivel [description]
	 * @return [type]        [description]
	 */
	public function getProcesoDirectriz($nivel,$id='')
	{
		$data=array();
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->select("d.idDirectriz id,d.nombreDirectriz,d.descripcion,p.nombreProceso,p.idProceso");
		$query=$this->db->join('relacionprocesodirectriz r','r.codigoDirectriz=d.idDirectriz');
		$query=$this->db->join('proceso p','p.idProceso=r.codigoProceso');
		$query=$this->db->where("r.nivel",$nivel);
		//$query=$this->db->where("i.visibilidad",1);
		$query = $this->db->get('directriz d');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getProcesoDirectrizId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getProcesoDirectrizId($id)
	{
		$data=array();
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->select("p.idProceso,p.nombreProceso");
		$query=$this->db->join('relacionprocesodirectriz r','r.codigoDirectriz=d.idDirectriz');
		$query=$this->db->join('proceso p','p.idProceso=r.codigoProceso');
		$query=$this->db->where("r.codigoDirectriz",$id);
		//$query=$this->db->where("i.visibilidad",1);
		$query = $this->db->get('directriz d');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los datos de la tabla
	 * indicador para ser visualizados en el 
	 * despliegue de objetivos 
	 */
	public function getIndicador($nivel=''){
		$data=array();
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->select("i.orden,i.codigoProceso,c.nombreCargo gestionar,ti.nombreTipo,ti.idTipo,i.nombreIndicador,i.idIndicador,i.numeradorFormula,i.denominadorFormula,i.x100 x,s.codigoSimbolo,i.meta metaE,CONCAT(s.codigoSimbolo,i.meta) meta,s.idSimbolo,m.nombreMedicion");
		$query=$this->db->join('tipoindicador ti','ti.idTipo=i.codigoTipoIndicador');
		$query=$this->db->join('medicion m','m.idMedicion=i.codigoMedicion');	
		$query=$this->db->join('simbolo s','s.idSimbolo=i.simbolo');
		$query=$this->db->join('cargo c','c.idCargo=i.codigoResponsableMedir');
		$query=$this->db->join('relacionprocesodirectriz r','r.codigoProceso=i.codigoProceso');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		if(isset($nivel) && !empty($nivel)){
			$query=$this->db->where("i.nivel",$nivel);
		}
		$query=$this->db->where("i.visibilidad",1);
		$query=$this->db->where("r.visibilidad",1);
		$query=$this->db->order_by('i.codigoProceso','asc');
		$query=$this->db->group_by('i.nombreIndicador');
		$query = $this->db->get('indicador i');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @return type
	 */
	public function getContenidoAccion($cadena = NULL)
	{
		$data=FALSE;
		$query=$this->db->where("c.visibilidad",1);
		$query=$this->db->select('idContenidoAccion id,pi.nombreProceso procesoInf,pi.idProceso idProcesoInf,p.nombreProceso proceso,p.idProceso idProceso,fechaHallazgo,t.nombre nombreTipo,c.codigoAccion,version,fechaVigencia,f.idFiltro,f.nombreFiltro estado,pq.descripcionHallazgo');
		$query=$this->db->join('proceso pi','pi.idProceso=c.codigoProcesoInf');
		$query=$this->db->join('proceso p','p.idProceso=c.codigoProceso');
		$query=$this->db->join('porqueaccion pq','pq.idPorqueAccion=c.codigoPorque');
		$query=$this->db->join('tipoAccion t','t.idTipoAccion=c.codigoTipoAccion');
		$query=$this->db->join('relacionaccionfuente rf','rf.codigoAccion=c.idContenidoAccion');
		$query=$this->db->join('filtro f','f.idFiltro=c.codigoFiltro');
		if (isset($cadena) && $cadena != FALSE) {
			if(strpos($cadena,'eficacia')){
				$query=$this->db->join('controlseguimiento co','co.codigoContenidoAccion=c.idContenidoAccion ');
			}
		$this->db->where($cadena);
		}
		$query=$this->db->group_by('c.idContenidoAccion');
		$query=$this->db->get('contenidoAccion c');
		
		if ($query->num_rows()>0) {
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getContenidoAccionId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getContenidoAccionId($id)
	{
		$data=FALSE;
		if (isset($id)) {
		$query=$this->db->where('idContenidoAccion',$id);
		$query=$this->db->where('c.visibilidad',1);
		$query=$this->db->select('c.codigoPorque,c.codigoCargoResponsable,idContenidoAccion id,pi.nombreProceso procesoInf,pi.idProceso idProcesoInf,p.nombreProceso proceso,p.idProceso idProceso,fechaHallazgo,t.nombre nombreTipo,c.codigoAccion,version,fechaVigencia,
			pq.descripcionHallazgo,pq.causaRaizHallazgo,pq.descripcionPrimer primer,pq.descripcionSegundo segundo,pq.descripcionTercer tercera,
			pq.frecuenciaPrimer,pq.frecuenciaSegunda,pq.frecuenciaTercera,c.beneficio_consecuencia,c.descripcion,c_r.nombreCargo cargo_responsable,c_r.idCargo id_cargo_responsable,t.idTipoAccion');
		$query=$this->db->join('proceso pi','pi.idProceso=c.codigoProcesoInf');
		$query=$this->db->join('proceso p','p.idProceso=c.codigoProceso');
		$query=$this->db->join('tipoAccion t','t.idTipoAccion=c.codigoTipoAccion');
		$query=$this->db->join('porqueaccion pq','pq.idPorqueAccion=c.codigoPorque');
		$query=$this->db->join('cargo c_r','c_r.idCargo=c.codigoCargoResponsable');
		$query=$this->db->get('contenidoAccion c');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}
		$query->free_result();
		}
		return $data;
	}
	/**
	 * [getFechaRevisionPlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getFechaRevisionPlanAccion()
	{
		$data=false;
		$query=$this->db->select('codigoPlanAccion id,fecha_1,fecha_2,fecha_3');
		$query=$this->db->get('fecharevisionplanaccion');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo elimina las fechas de revisión
	 * del plan de acción segun el id recibido
	 * @param type $id => id unico de plan de acción
	 * @return type
	 */
	public function emptyFechaRevision($id)
	{
		$res=false;
		if (isset($id)) {
			$query=$this->db->where('codigoPlanAccion',$id);
			if($query=$this->db->empty_table('fecharevisionplanaccion')){
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [emptyFuenteAccion este metodo elimina los datos 
	 * de la tabla relacionaccionfuente para que no se repitan datos al 
	 * editar el plan de accion]
	 * @param  [type] $idAccion [description]
	 * @return [type]           [description]
	 */
	public function emptyFuenteAccion($idAccion)
	{
		$res=false;
		if(isset($idAccion)){
			$query=$this->db->where('codigoAccion',$idAccion);
			if ($query=$this->db->empty_table('relacionaccionfuente')) {
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [emptyRecursoAccion description]
	 * @param  [type] $idAccion [description]
	 * @return [type]           [description]
	 */
	public function emptyRecursoAccion($idAccion)
	{
		$res=false;
		if(isset($idAccion)){
			if(is_array($idAccion)){
				for ($i=1; $i <=count($idAccion) ; $i++) { 
					$query=$this->db->where('codigoPlanAccion',$idAccion[$i]);
					if ($query=$this->db->empty_table('relacionaccionrecurso')) {
						$res=TRUE;
					}
				}
			}else{
				$query=$this->db->where('codigoPlanAccion',$idAccion);
				if ($query=$this->db->empty_table('relacionaccionrecurso')) {
					$res=TRUE;
				}
			}
		}
		return $res;
	}
	/**
	 * [emptyMetodologiaAccion description]
	 * @param  [type] $idAccion [description]
	 * @return [type]           [description]
	 */
	public function emptyMetodologiaAccion($idAccion)
	{
		$res=false;
		if(isset($idAccion)){
			$query=$this->db->where('codigoContenidoAccion',$idAccion);
			if ($query=$this->db->empty_table('relacionaccionmetodologia')) {
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [emptyCorreccionAccion description]
	 * @param  [type] $idAccion [description]
	 * @return [type]           [description]
	 */
	public function emptyCorreccionAccion($idAccion)
	{
		$res=false;
		if(isset($idAccion)){
			$query=$this->db->where('codigoContenidoAccion',$idAccion);
			if ($query=$this->db->empty_table('relacionaccioncorrecion')) {
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [addContenidoAccion description]
	 * @param [type] $data [description]
	 */
	public function addContenidoAccion($data)
	{
		$res=FALSE;
		if ($this->db->insert('contenidoaccion',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function addSolicitudCambio($data)
	{
		$res=FALSE;
		if ($this->db->insert('solicitudcambio',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * [editSolicitudCambio description]
	 * @param  [type] $data [description]
	 * @param  [type] $id   [description]
	 * @return [type]       [description]
	 */
	public function editSolicitudCambio($data,$id)
	{
		$res=FALSE;
		$this->db->where('idSolicitud',$id);
		if ($this->db->update('solicitudcambio',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function addPorque($data)
	{
		$res=FALSE;
		if ($this->db->insert('porqueaccion',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	/**
	 * [InsertRelacionAccionFuente description]
	 * @param [type] $data [description]
	 */
	public function InsertRelacionAccionFuente($idAccion,$fuenteDeteccion)
	{
		$res=FALSE;
		for ($i=0; $i <count($fuenteDeteccion) ; $i++) { 
			$data=array('codigoFuente'=>$fuenteDeteccion[$i],'codigoAccion'=>$idAccion);
			if ($this->db->insert('relacionaccionfuente',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [InsertCorrecionAccion description]
	 * @param [type] $correccion [description]
	 * @param [type] $idAccion   [description]
	 */
	public function InsertCorreccionAccion($correccion,$idAccion)
	{
		$res=FALSE;
		for ($i=0; $i <count($correccion) ; $i++) { 
			$data=array('codigoCorreccion'=>$correccion[$i],'codigoContenidoAccion'=>$idAccion);
			if ($this->db->insert('relacionaccioncorrecion',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [addPlanAccion description]
	 * @param [type] $actividad_desarrollar   [description]
	 * @param [type] $fecha_ejecucion         [description]
	 * @param [type] $responsable_seguimiento [description]
	 */
	public function addPlanAccion($actividad_desarrollar,$fecha_ejecucion,$responsable_seguimiento)
	{
		$res=false;
		for ($i=1; $i <=count($actividad_desarrollar) ; $i++) { 
			$data=array('actividad'=>$actividad_desarrollar[$i],'fechaEjecucion'=>$fecha_ejecucion[$i],' codigoCargoResponsable'=>$responsable_seguimiento[$i]);
			if ($this->db->insert('planaccion',$data)){
				$res[$i]=$this->db->insert_id();
			}		
		}
		return $res;
	}
	/**
	 * [addPlanAccionNew description]
	 * @param [type] $actividad_desarrollar   [description]
	 * @param [type] $fecha_ejecucion         [description]
	 * @param [type] $responsable_seguimiento [description]
	 */
	public function addPlanAccionNew($actividad_desarrollar,$fecha_ejecucion,$responsable_seguimiento)
	{
		$res=false;
		for ($i=2; $i <=(count($actividad_desarrollar)+1) ; $i++) { 
			$data=array('actividad'=>$actividad_desarrollar[$i],'fechaEjecucion'=>$fecha_ejecucion[$i],' codigoCargoResponsable'=>$responsable_seguimiento[$i]);
			if ($this->db->insert('planaccion',$data)){
				$res[$i]=$this->db->insert_id();
			}		
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $id 
	 * @param type $actividad_desarrollar 
	 * @param type $fecha_ejecucion 
	 * @param type $responsable_seguimiento 
	 * @return type
	 */
	public function updatePlanAccion($id,$actividad_desarrollar,$fecha_ejecucion,$responsable_seguimiento)
	{
		$res=false;
		for ($i=1; $i <=count($actividad_desarrollar) ; $i++) { 
			$data=array('actividad'=>$actividad_desarrollar[$i],'fechaEjecucion'=>$fecha_ejecucion[$i],' codigoCargoResponsable'=>$responsable_seguimiento[$i]);
			$this->db->where('idAccion',$id[$i]);
			if ($this->db->update('planaccion',$data)){
				$res=true;
			}		
		}
		return $res;
	}
	/**
	 * [addSeguimientoAccion description]
	 * @param [type] $fecha_seguimiento       [description]
	 * @param [type] $descripcion_seguimiento [description]
	 * @param [type] $cargo_verifica          [description]
	 */
	public function addSeguimientoAccion($indexSeguimiento,$fecha_seguimiento,$descripcion_seguimiento,$cargo_verifica,$eficacia)
	{
		$res=false;
		$index=1;
		for ($i=$indexSeguimiento; $i <(count($fecha_seguimiento)+$indexSeguimiento); $i++) { 
			if(isset($eficacia[$i])){
				$_eficacia=$eficacia[$i];
			}else{
				$_eficacia='NO';
			}
			$data=array('fecha'=>$fecha_seguimiento[$i],'descripcion'=>$descripcion_seguimiento[$i],'eficacia'=>$_eficacia,'codigoCargo'=>$cargo_verifica[$i]);
			if($this->db->insert('seguimientoaccion',$data)){
				$res[$index++]=$this->db->insert_id();
			}
		}
		return $res;
	}
	/**
	 * [InsertRelacionAccionSeguimiento description]
	 * @param [type] $idSeguimiento [description]
	 * @param [type] $idAccion      [description]
	 */
	public function InsertRelacionAccionSeguimiento($idSeguimiento,$idAccion)
	{
		$res=false;
		for ($i=1; $i <=count($idSeguimiento) ; $i++) { 
			$data=array('codigoAccion'=>$idAccion,'codigoSeguimiento'=>$idSeguimiento[$i]);
			if ($this->db->insert('relacionaccionseguimiento',$data)) {
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [addControlSeguimientoAccion description]
	 * @param [type] $idAccion           [description]
	 * @param [type] $conclusion         [description]
	 * @param [type] $norma              [description]
	 * @param [type] $fechaCierre        [description]
	 * @param [type] $responsable_cierre [description]
	 * @param [type] $eficacia_accion    [description]
	 */
	public function addControlSeguimientoAccion($idAccion,$conclusion,$norma,$fechaCierre
					,$responsable_cierre,$eficacia_accion)
	{
		$res=false;
		$data=array('conclusion'=>$conclusion,'numeralNorma'=>$norma,'fechaCierre'=>$fechaCierre,'codigoCargoCierre'=>$responsable_cierre,'eficacia'=>$eficacia_accion,'codigoContenidoAccion'=>$idAccion);
		if($this->db->insert('controlseguimiento',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * [InsertRelacionPlanAccion description]
	 * @param [type] $idAccion     [description]
	 * @param [type] $idPlanAccion [description]
	 */
	public function InsertRelacionPlanAccion($idAccion,$idPlanAccion)
	{
		$res=false;
		for ($i=1; $i <=count($idPlanAccion) ; $i++) { 
			$data=array('codigoContenidoAccion'=>$idAccion,'codigoPlanAccion'=>$idPlanAccion[$i]);
			if ($this->db->insert('relacionaccionplan',$data)) {
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $idAccion 
	 * @param type $idPlanAccion 
	 * @return type
	 */
	public function InsertRelacionPlanAccionNew($idAccion,$idPlanAccion)
	{
		$res=false;
		for ($i=2; $i <=(count($idPlanAccion)+1) ; $i++) { 
			$data=array('codigoContenidoAccion'=>$idAccion,'codigoPlanAccion'=>$idPlanAccion[$i]);
			if ($this->db->insert('relacionaccionplan',$data)) {
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [InsertRelacionMetodologiaAccion description]
	 * @param [type] $idAccion [description]
	 * @param [type] $causa    [description]
	 */
	public function InsertRelacionMetodologiaAccion($idAccion,$causa)
	{
		$res=false;
		for ($i=0; $i <count($causa) ; $i++) { 
			$data=array('codigoContenidoAccion'=>$idAccion,'codigoMetodologia'=>$causa[$i]);
			if ($this->db->insert('relacionaccionmetodologia',$data)) {
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [updatePorqueAccion description]
	 * @param  [type] $id   [description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function updatePorqueAccion($id,$data)
	{
		$res=false;
		if (isset($id) && isset($data)) {
			$this->db->where('idPorqueAccion',$id);
			if($this->db->update('porqueaccion',$data)){
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * [InsertRelacionRecursoPlan description]
	 * @param [type] $idPlanAccion [description]
	 * @param [type] $recurso      [description]
	 */
	public function InsertRelacionRecursoPlan($idPlanAccion,$recurso)
	{
		$res=false;
		for ($i=0; $i <count($recurso) ; $i++) { 
			$data=array('codigoPlanAccion'=>$idPlanAccion,'codigoRecurso'=>$recurso[$i]);
			if ($this->db->insert('relacionaccionrecurso',$data)){
				$res=true;
			}
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertFechaRevisionAccion($data)
	{
		$res=false;
		if ($this->db->insert('fecharevisionplanaccion',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * Este metodo obtiene todas las fuentes
	 * de deteccion asociadas a los planes
	 * de accion
	 * @return type
	 */
	public function getAccionFuenteDeteccion()
	{
		$data=false;
		$query=$this->db->select('f.nombreDeteccion,rf.codigoAccion');
		$query=$this->db->join('fuentedeteccion f','f.idFuente=rf.codigoFuente');
		$query=$this->db->get('relacionaccionfuente rf');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		return $data;
	}
	/**
	 * [getMetodologiaAccion description]
	 * @return [type] [description]
	 */
	public function getMetodologiaAccion()
	{
		$data=FALSE;
		$query=$this->db->select('idMetodologia id,nombreMetodologia nombre');
		$query=$this->db->get('metodologia6M');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getMetodologiaAccionId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getMetodologiaAccionId($id)
	{
		$data=FALSE;
		if (isset($id)) {
			$query=$this->db->where('r.codigoContenidoAccion',$id);
			$query=$this->db->select('idMetodologia id,nombreMetodologia nombre');
			$query=$this->db->join('metodologia6M m','m.idMetodologia=r.codigoMetodologia');
			$query=$this->db->get('relacionaccionmetodologia r');
			if ($query->num_rows()>0) {
				$data=$query->result();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * [getComportamientoIndicador description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getComportamientoIndicador($id='')
	{
		$data=array();
		if (isset($id)&&$id!='') {
			$query=$this->db->where('r.codigoFichaIndicador',$id);
		}
		$query=$this->db->select('c.*,r.estado,a.*,t.nombre,r.codigoFichaIndicador');
		$query=$this->db->join('comportamientoindicador c','r.codigoComportamiento=c.idComportamiento');
		$query=$this->db->join('analisisindicador a','a.idAnalisis=r.codigoAnalisis');
		$query=$this->db->join('tipoAccion t','t.idTipoAccion=a.codigoTipoAccion');
		$query=$this->db->order_by('r.codigoComportamiento','asc');
		$query=$this->db->get('relacionindicadorcomportamiento r');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getMaxIdIndicador description]
	 * @return [type] [description]
	 */
	public function getMaxIdIndicador($id)
	{
		$data=false;
		if(isset($id)){
			$query=$this->db->where('codigoProcesoInf',$id);
			$query=$this->db->select_max('idFichaIndicador','id');
			$query=$this->db->get('fichatecnicaindicador');
			if($query->num_rows()>0){
				$data=$query->row();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * Description
	 * @param type $table 
	 * @param type $id 
	 * @param type $nombreColumna 
	 * @return type
	 */
	public function eliminarTabla($table,$id,$nombreColumna)
	{
		$res=FALSE;
		$query=$this->db->where($nombreColumna,$id);
		if ($query=$this->db->delete($table)) {
			$res=TRUE;
		}else{
			$res=FALSE;
		}
		return $res;
	}
	/**
	 * [getRecursos este metodo obtiene los recursos]
	 * @return [type] [description]
	 */
	public function getRecursos()
	{
		$data=array();
		$query=$this->db->select('idRecurso id,nombreRecurso nombre');
		$query=$this->db->get('recursos');
		if($query->num_rows()>0){
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		return $data;
	}
	/**
	 * [getRecursosIndicador Esta funcion obtiene los recursos asociados a los indicadores]
	 * @return [type] [description]
	 */
	public function getRecursosIndicador()
	{
		$data=array();
		$query=$this->db->select('ri.codigoIndicador,r.nombreRecurso');
		$query=$this->db->join('recursos r','r.idRecurso=ri.codigoRecurso');
		$query=$this->db->get('relacionIndicadorRecurso ri');
		if($query->num_rows()>0){
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		return $data;
	}
	/**
	 * [getIndicadorNew description]
	 * @param  [type] $nivel [description]
	 * @return [type]        [description]
	 */
	/*public function getIndicadorNew($nivel)
	{
		$data=array();
		$query=$this->db->where('i.nivel',$nivel);
		$query=$this->db->query("SELECT d.`nombreDirectriz`,p.`nombreProceso`,ti.`nombreTipo`,i.`nombreIndicador`,i.`formula`,CONCAT(s.codigoSimbolo,i.meta) meta
								,c.nombreCargo gestionar,m.`nombreMedicion`
								FROM indicador i
								INNER JOIN `relacionprocesodirectriz` r
								ON r.`codigoProceso`=i.`codigoProceso`
								INNER JOIN directriz d
								ON d.`idDirectriz`=r.`codigoDirectriz`
								INNER JOIN proceso p
								ON p.`idProceso`=r.`codigoProceso`
								INNER JOIN tipoindicador ti
								ON ti.`idTipo`=i.`codigoTipoIndicador`
								INNER JOIN simbolo s
								ON s.`idSimbolo`=i.`simbolo`
								INNER JOIN cargo c
								ON i.`codigoResponsableMedir`=c.idCargo
								INNER JOIN medicion m 
								ON m.idMedicion=i.codigoMedicion
								WHERE i.`visibilidad`=1 && d.`visibilidad`=1 
								ORDER BY d.`idDirectriz` ASC");
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}*/
	/**
	 * [addIndicador description]
	 * @param [type] $nombre     [description]
	 * @param [type] $idTipo     [description]
	 * @param [type] $formula    [description]
	 * @param [type] $idSimbolo  [description]
	 * @param [type] $meta       [description]
	 * @param [type] $idMedicion [description]
	 * @param [type] $rMedir     [description]
	 * @param [type] $rGestionar [description]
	 * @param [type] $idProceso  [description]
	 */
	public function addIndicador($recursos,$directriz,$nombre,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$idMedicion,$rMedir,$rGestionar,$idProceso,$nivel,$x)
	{
		$res=FALSE;
		if(empty($x)){$x=0;}
		$data=array('nombreIndicador'=>$nombre,'codigoTipoIndicador'=>$idTipo,'numeradorFormula'=>$numerador,'denominadorFormula'=>$denominador,'simbolo'=>$idSimbolo,'meta'=>$meta
			,'codigoMedicion'=>$idMedicion,'codigoResponsableMedir'=>$rMedir,'nivel'=>$nivel,'codigoProceso'=>$idProceso,'codigoDirectriz'=>$directriz,'x100'=>$x);
		if ($this->db->insert('indicador',$data)){
			$idIndicador=$this->db->insert_id();
			for ($i=0; $i <count($rGestionar) ; $i++) { 
				$data=array('codigoIndicador'=>$idIndicador,'codigoResponsableGestionar'=>$rGestionar[$i]);
				if($this->db->insert('relacionindicadorcodigoresponsablegestionar',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
			for ($i=0; $i <count($recursos) ; $i++) { 
				$data=array('codigoIndicador'=>$idIndicador,'codigoRecurso'=>$recursos[$i]);
				if($this->db->insert('relacionIndicadorRecurso',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
			if($nivel==2 && isset($directriz)){
				$ajuste=$this->getAjusteTablaSST($idProceso,$directriz);
				if($ajuste==FALSE || $ajuste->orden==0){
					$max=$this->getMaxAjusteSST();
					$max=$max->orden+1;
					if($this->updateOrdenIndicador($idIndicador,$max)){
						$res=TRUE;
					}else{
						$res=FALSE;
					}
				}else{
					if($this->updateOrdenIndicador($idIndicador,$ajuste->orden)){
						$res=TRUE;
					}else{
						$res=FALSE;
					}
				}
			}
			if($nivel==1){
				$codigo=$this->getIdDirectrizProceso($idProceso);
				$this->updateCodigoDirectrizIndicador($idProceso,$codigo);
			}
		}
		return $res;
	}
	/**
	 * Este metodo actualiza el codigoDirectriz del indicador
	 * del nivel 1
	 * @param  [type] $codigo [codigoDirectriz]
	 * @return [type]         [description]
	 */
	public function updateCodigoDirectrizIndicador($idProceso,$codigo)
	{
		if($codigo!=FALSE){
			$data=array('codigoDirectriz'=>$codigo->codigoDirectriz);
			$this->db->where('nivel',1);
			$this->db->where('codigoProceso',$idProceso);
			$this->db->update('indicador',$data);
		}
			return ;
	}
	/**
	 * Este metodo obtiene el codigo de la directriz asociado
	 * a un proceso
	 * @param  [type] $id [id del proceso]
	 * @return [type]     [description]
	 */
	public function getIdDirectrizProceso($id)
	{
		$data=array();
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->where('codigoProceso',$id);
		$query=$this->db->where('nivel',1);
		$query=$this->db->select('codigoDirectriz');
		$query=$this->db->get('relacionprocesodirectriz');
		if($query->num_rows()>0){
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [addDirectriz description]
	 * @param [type] $directriz   [description]
	 * @param [type] $descripcion [description]
	 * @param [type] $proceso     [description]
	 * @param [type] $nivel       [description]
	 */
	public function addDirectriz($directriz,$descripcion,$proceso,$nivel)
	{
		$res=FALSE;
		$data=array('nombreDirectriz'=>$directriz,'descripcion'=>$descripcion,'nivel'=>$nivel);
		if ($this->db->insert('directriz',$data)){
			$idDirectriz=$this->db->insert_id();
			for ($i=0; $i <count($proceso) ; $i++) { 
				$data=array('codigoProceso'=>$proceso[$i],'codigoDirectriz'=>$idDirectriz,'nivel'=>$nivel);
				if($this->db->insert('relacionprocesodirectriz',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
		return $res;
	}
	/**
	 * [editIndicador description]
	 * @param  [type] $id         [description]
	 * @param  [type] $nombre     [description]
	 * @param  [type] $idTipo     [description]
	 * @param  [type] $formula    [description]
	 * @param  [type] $idSimbolo  [description]
	 * @param  [type] $meta       [description]
	 * @param  [type] $idMedicion [description]
	 * @param  [type] $rMedir     [description]
	 * @param  [type] $rGestionar [description]
	 * @param  [type] $idProceso  [description]
	 * @param  [type] $nivel      [description]
	 * @return [type]             [description]
	 */
	public function editIndicador($recursos,$id,$nombre,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$idMedicion,$rMedir,$rGestionar,$idProceso,$nivel,$x)
	{
		$res=FALSE;
		if(empty($x)){$x=0;}
		$data=array('nombreIndicador'=>$nombre,'codigoTipoIndicador'=>$idTipo,'numeradorFormula'=>$numerador,'denominadorFormula'=>$denominador,'simbolo'=>$idSimbolo,'meta'=>$meta
			,'codigoMedicion'=>$idMedicion,'codigoResponsableMedir'=>$rMedir,'nivel'=>$nivel,'codigoProceso'=>$idProceso,'x100'=>$x);
		$this->db->where('idIndicador',$id);
		if ($this->db->update('indicador',$data)){
			if($this->validateResponsableG($id)){
				for ($i=0; $i <count($rGestionar) ; $i++) { 
				$data=array('codigoIndicador'=>$id,'codigoResponsableGestionar'=>$rGestionar[$i]);
					if($this->db->insert('relacionindicadorcodigoresponsablegestionar',$data)){
						$res=TRUE;
					}else{
						$res=FALSE;
					}
				}
				if($this->validateRecursoIndicador($id)){
					for ($i=0; $i <count($recursos) ; $i++) { 
						$data=array('codigoIndicador'=>$id,'codigoRecurso'=>$recursos[$i]);
						if($this->db->insert('relacionIndicadorRecurso',$data)){
							$res=TRUE;
						}else{
							$res=FALSE;
						}
					}
				}
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * [editDirectriz description]
	 * @param  [type] $id          [description]
	 * @param  [type] $directriz   [description]
	 * @param  [type] $descripcion [description]
	 * @param  [type] $nivel       [description]
	 * @return [type]              [description]
	 */
	public function editDirectriz($id,$directriz,$descripcion,$proceso,$procesoDis,$nivel)
	{
		$res=FALSE;
		$data=array('nombreDirectriz'=>$directriz,'descripcion'=>$descripcion);	
		$this->db->where('idDirectriz',$id);
		if ($this->db->update('directriz',$data)){
			if($this->validateProcesoDirectriz($id)){
				if($nivel==1){
				$this->updateDisponibilidadProceso($proceso,0);
				$this->updateDisponibilidadProceso($procesoDis,1);
				}
				for ($i=0; $i <count($proceso) ; $i++) { 
				$data=array('codigoProceso'=>$proceso[$i],'codigoDirectriz'=>$id,'nivel'=>$nivel);
					if($this->db->insert('relacionprocesodirectriz',$data)){
						$res=TRUE;
					}else{
						$res=FALSE;
					}
				}
			}else{
				$res=FALSE;
			}
		}
		return $res;
	}
	/**
	 * [updateDisponibilidadProceso description]
	 * @param  [type] $proceso [description]
	 * @return [type]          [description]
	 */
	public function updateDisponibilidadProceso($proceso,$dis){
		$res=FALSE;
		if(empty($proceso) || $proceso==0){
			$res=TRUE;
		}else{
			for ($i=0; $i <count($proceso) ; $i++) {
			$query=$this->db->where('idProceso',$proceso[$i]); 
				$data=array('disponible'=>$dis);
				if($this->db->update('proceso',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
		return $res;
	}
	/**
	 * Este metodo obtiene los datos de la tabla
	 * indicador para ser visualizados en la paginacion
	 */
	public function getIndicadorCalidad($nivel,$limit,$start){
		$data=array();
		$query=$this->db->select("p.nombreProceso,i.codigoProceso,c.nombreCargo gestionar,ti.nombreTipo,ti.idTipo,i.nombreIndicador,i.idIndicador id,i.numeradorFormula,i.x100 x,i.denominadorFormula,s.codigoSimbolo,i.meta metaE,CONCAT(s.codigoSimbolo,i.meta) meta,s.idSimbolo,m.nombreMedicion");
		$query=$this->db->join('tipoindicador ti','ti.idTipo=i.codigoTipoIndicador');
		$query=$this->db->join('medicion m','m.idMedicion=i.codigoMedicion');	
		$query=$this->db->join('simbolo s','s.idSimbolo=i.simbolo');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->join('cargo c','c.idCargo=i.codigoResponsableMedir');
		$query=$this->db->where("i.nivel",$nivel);
		$query=$this->db->where("i.visibilidad",1);
		$query=$this->db->where("p.visibilidad",1);
		$query=$this->db->order_by('i.idIndicador','asc');
		if ($start==0) {
				$query=$this->db->limit($limit);	
			}else{
				$query=$this->db->limit($limit,$start);	
			}	
		$query = $this->db->get('indicador i');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los cargos
	 * de la BD 
	 */
	public function getCargo(){ 
		$data=array();
		$query=$this->db->select('idCargo id, nombreCargo nombre');
		$query=$this->db->order_by('nombre');
		$query=$this->db->get('cargo');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene el cargo 
	 * segun el idUsuario que se le envie 
	 */
	public function getIdCargo($idUsuario)
	{
		$data=array();
		if (isset($idUsuario)) {
			$query=$this->db->where('id',$idUsuario);
			$query=$this->db->select('codigoCargo');
			$query=$this->db->get('usuario');
			if ($query->num_rows()>0) {
				$data=$query->row();
			}else{
				$data=FALSE;
			}
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los tiempos 
	 * de medicion de los indicadores 
	 * en la BD 
	 */
	public function getMedicion(){ 
		$data=array();
		$query=$this->db->select('idMedicion id, nombreMedicion nombre');
		$query=$this->db->get('medicion');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/*
	 * Este método realiza una consulta a la BD obteniendo los datos de la tabla revision
	 * segun el id de la tabla que se consulte.
	 * $tabla->id de la tabla (Ej:mision)
	 * $idRelacion->id de la tabla relacionRevision(Ej:ElaboradoPor)
	 */
	public function getRevisionId($idRelacion,$tabla){
		$data=array();
		$this->db->select("r.fechaRevision,u.nombre,c.nombreCargo,u.id");
		$this->db->join("usuario u","u.id=r.codigoEmpleado");
		$this->db->join("cargo c","c.idCargo=u.codigoCargo");
		$this->db->where("codigoTabla",$tabla);
		$this->db->where("codigoRelacion",$idRelacion);
		$query=$this->db->get("revision r");
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else
		{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo retorna el password segun el id que reciba
	 */
	public function getPass($id){
		$data=array();
		$this->db->select('password');
		$this->db->where('id',$id);
		$query=$this->db->get('usuario');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  savePass()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método recibe como parametros: 
	|  $id 	--> id único de usuario
	|  $pass    --> Contraseña única de usuario
	|  Este método se encarga de actualizar la contraseña 
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function savePass($id,$pass){
		$data=array('password'=>$pass);
		$this->db->where('id',$id);
		$this->db->update('usuario',$data);
	}
	/**
	 * Este metodo cambia el estado del objetivo de 1 a 0
	 */
	public function inactivateObjetivo($id,$data){
		$option = FALSE;
		$this->db->where('idObjetivoC', $id);
		if($this->db->update('objetivoCalidad',$data))
		{$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * [inactivateIndicador description]
	 * @param  [type] $id   [description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inactivateIndicador($id,$data){
		$option = FALSE;
		$this->db->where('idIndicador', $id);
		if($this->db->update('indicador',$data))
		{$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * [inactivatePlanAccion description]
	 * @param  [type] $id   [description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inactivatePlanAccion($id,$data)
	{
		$option = FALSE;
		$this->db->where('idContenidoAccion', $id);
		if($this->db->update('contenidoAccion',$data))
		{$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * [inactivateDirectriz description]
	 * @param  [type] $id   [description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inactivateDirectriz($id,$data,$nivel){
		$option = FALSE;
		$this->db->where('idDirectriz', $id);
		if($this->db->update('directriz',$data)&&$this->inactivateDirectrizIndicador($id,$nivel,$data))
		{$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * [inactivateDirectrizIndicador pone la visibilidad en 0 de los
	 * indicadores relacionados a una directriz]
	 * @param  [type] $id    [id de la directriz]
	 * @param  [type] $nivel [tipo de tabla a consultar 1/calidad 2/sst]
	 * @return [type]        [description]
	 */
	public function inactivateDirectrizIndicador($id,$nivel,$data)
	{
		$idIndicador=$this->getDirectrizIndicadorId($id,$nivel);
		$res=FALSE;
		if($idIndicador!=FALSE){
			foreach ($idIndicador as $value) {
				$this->db->where('idIndicador',$value->idIndicador);
				if($this->db->update('indicador',$data)){
					$res=TRUE;
				}else{
					$res=FALSE;
				}
			}
		}
		return $res;
	}
	/**
	 * [getDirectrizIndicadorId Este metodo obtiene los id de indicadores
	 * relacionados con la directriz ]
	 * Cuando el nivel es 1 se consulta por id de proceso
	 * Cuando el nivel es 2 se consulta por id de directriz
	 * @param  [type] $id    [id de la directriz o id de proceso]
	 * @param  [type] $nivel [tipo de tabla a consultar 1/calidad 2/sst]
	 * @return [type] array  [id indicadores]
	 */
	public function getDirectrizIndicadorId($id,$nivel)
	{
		$data=FALSE;
		if($nivel==1){
			$query=$this->db->query('
								SELECT idIndicador
								FROM indicador
								WHERE visibilidad=1 && nivel='.$nivel.' && codigoProceso ='.$id.' ');
		}else{
			$query=$this->db->query('  SELECT idIndicador
								FROM indicador
								WHERE visibilidad=1 && nivel='.$nivel.' && codigoProceso IN
								(
								SELECT i.codigoProceso
								FROM indicador i
								INNER JOIN relacionprocesodirectriz  r
								ON r.codigoProceso=i.codigoProceso
								INNER JOIN proceso p
								ON p.idProceso=r.codigoProceso
								WHERE p.visibilidad=1 && r.codigodirectriz='.$id.' && i.nivel='.$nivel.'
								GROUP BY(i.`codigoProceso`)
								)');
		}
		if($query){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo cambia el estado del proceso de 1 a 0
	 */
	public function inactivateProceso($id,$data){
		$option = FALSE;
		$this->db->where('idProceso', $id);
		if($this->db->update('proceso',$data))
		{$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * Este metodo agrega un nuevo objetivo
	 */
	public function addObjetivo($tipo,$text){ 
		$data=array("tipo"=>$tipo,"texto"=>$text);
		$this->db->insert('objetivoCalidad',$data);
	}
	/**
	 * Este metodo agrega un nuevo proceso
	 */
	public function addProceso($name){ 
		$data=array("nombreProceso"=>$name);
		$this->db->insert('proceso',$data);
	}
	/**
	 * Este metodo carga los objetivos de calidad sgc(1), sst(2)
	 */
	Public function getObjetivo($tipo){
		$data=array();
		if (isset($tipo)) {
			$this->db->select('idObjetivoC id,texto');
			$this->db->where('tipo',$tipo);
			$this->db->where('visibilidad',1);
			$query=$this->db->get('objetivoCalidad');
			if ($query->num_rows()>0) {
				$data=$query->result();
			}else{
				$data=FALSE;
			}
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}

	/**
	 * Este metodo carga los objetivos de calidad sgc(1), sst(2)
	 * segun el id 
	 */
	Public function getObjetivoId($id){
		$data=array();
		$this->db->select('idObjetivoC id,texto,tipo');
		$this->db->where('visibilidad',1);
		$this->db->where('idObjetivoC',$id);
		$query=$this->db->get('objetivoCalidad');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo carga el proceso
	 * segun el id 
	 */
	Public function getProcesoId($id){
		$data=array();
		$this->db->select('idProceso id,nombreProceso nombre');
		//$this->db->where('visibilidad',1);
		$this->db->where('idProceso',$id);
		$query=$this->db->get('proceso');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los datos del indicador
	 * @param type $id id del indicador
	 * @return type object class
	 */
	public function getIndicadorId($id)
	{
		$data=array();
		$query=$this->db->where('i.idIndicador',$id);
		$query=$this->db->select("i.codigoProceso,p.nombreProceso,i.codigoResponsableMedir medir,
								i.codigoTipoIndicador idTipo,i.nombreIndicador,
								i.idIndicador id,
								i.numeradorFormula,i.denominadorFormula,i.simbolo,i.meta,
								i.codigoMedicion medicion,m.nombreMedicion,
								c.nombreCargo,d.nombreDirectriz,i.x100 x
								");
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->join('medicion m','m.idMedicion=i.codigoMedicion');
		$query=$this->db->join('cargo c','c.idCargo=i.codigoResponsableMedir');
		$query=$this->db->join('directriz d','d.idDirectriz=i.codigoDirectriz');
		$query=$this->db->get('indicador i');
		if ($query->num_rows()>0){
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getEncabezadoMedicion Este metodo obtiene los datos
	 * sobre la identificacion de la documentacion de la 
	 * ficha medicion ]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getEncabezadoMedicion()
	{
		$data=array();
		$query=$this->db->query("SELECT f.*,p.nombreProceso
								FROM fichatecnicaindicador f
								INNER JOIN proceso p 
								ON p.idProceso=codigoProceso
								WHERE idFichaIndicador=(
								SELECT MAX(idFichaIndicador)
								FROM fichatecnicaindicador
								)");
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [tipoAccionMedicion Este metodo obtiene los tipo de accion 
	 * que puede tener el analisis de la medicion]
	 * @return [type] [description]
	 */
	public function tipoAccionMedicion()
	{
		$data=FALSE;
		$query=$this->db->select('idTipoAccion id,nombre');
		$query=$this->db->get('tipoaccion');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getTipoSolicitud description]
	 * @return [type] [description]
	 */
	public function getTipoSolicitud()
	{
		$data=FALSE;
		$query=$this->db->select('idTipo id,nombre');
		$query=$this->db->get('tiposolicitud');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getFuenteDeteccion description]
	 * @return [type] [description]
	 */
	public function getFuenteDeteccion()
	{
		$data=FALSE;
		$query=$this->db->select('idFuente id,nombreDeteccion nombre');
		$query=$this->db->get('fuenteDeteccion');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getFuenteDeteccionId description]
	 * @param  [type] $id [$iContenidoAccion]
	 * @return [type]     [description]
	 */
	public function getFuenteDeteccionId($id)
	{
		$data=FALSE;
		$query=$this->db->where('codigoAccion',$id);
		$query=$this->db->select('idFuente id,nombreDeteccion nombre');
		$query=$this->db->join('fuenteDeteccion f','f.idFuente=r.codigoFuente');
		$query=$this->db->get('relacionaccionfuente r');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getCorreccionAccion description]
	 * @return [type] [description]
	 */
	public function getCorreccionAccion()
	{
		$data=FALSE;
		$query=$this->db->select('idCorreccion id,nombreCorreccion nombre');
		$query=$this->db->get('correccionaccion');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getCorreccionAccionId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getCorreccionAccionId($id)
	{
		$data=false;
		if (isset($id)) {
			$query=$this->db->where('r.codigoContenidoAccion',$id);
			$query=$this->db->select('c.idCorreccion id,nombreCorreccion nombre');
			$query=$this->db->join('correccionaccion c','c.idCorreccion=r.codigoCorreccion');
			$query=$this->db->get('relacionaccioncorrecion r');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * [getPlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getPlanAccionId($id)
	{
		$data=false;
		if (isset($id)) {
			$query=$this->db->where('codigoContenidoAccion',$id);
			$query=$this->db->select('idAccion,actividad,fechaEjecucion,codigoCargoResponsable ,c.nombreCargo cargo');
			$query=$this->db->join('planaccion p','p.idAccion=r.codigoPlanAccion');
			$query=$this->db->join('cargo c','c.idCargo=codigoCargoResponsable');
			$query=$this->db->get('relacionaccionplan r');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();

		}
		return $data;
	}
	/**
	 * [getPlanAccion description]
	 * @return [type] [description]
	 */
	public function getPlanAccion()
	{
		$data=false;
			$query=$this->db->query('SELECT p.*,pr.`nombreProceso`,ca.`idContenidoAccion` idC
									FROM planAccion p
									INNER JOIN `relacionaccionplan` r
									ON r.`codigoPlanAccion`=p.`idAccion`
									INNER JOIN contenidoaccion ca
									ON ca.`idContenidoAccion`=r.`codigoContenidoAccion`
									INNER JOIN proceso pr 
									ON pr.`idProceso`=ca.`codigoProceso`
									WHERE ca.`visibilidad`=1 ');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();
		return $data;
	}
	/**
	 * [getPlanAccionDashboard este metodo obtiene los plaanes de 
	 * accion para mostrarlos en el select de medicion indicador]
	 * @return [type] [description]
	 */
	public function getPlanAccionDashboard($idTipo=null,$id_proceso=null)
	{	
		$data=false;
		if(isset($idTipo) && isset($id_proceso)){
			$query=$this->db->query('
        	SELECT c.`idContenidoAccion` id,c.`descripcion`, t.`nombre`,p.`nombreProceso`
			FROM contenidoaccion c
			INNER JOIN `tipoaccion` t
			ON t.`idTipoAccion`=c.`codigoTipoAccion`
			INNER JOIN proceso p
			ON p.`idProceso`=c.`codigoProceso`
			WHERE c.`visibilidad`=1 && c.`codigoTipoAccion`='.$idTipo.' && c.`codigoProceso`='.$id_proceso.'
			ORDER BY id
        	');
			if($query->num_rows()>0){
				$data=$query->result();
			}
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getEstadoPlanAccion description]
	 * @return [type] [description]
	 */
	public function getEstadoPlanAccion()
	{
		$data=false;
		$query=$this->db->select('idFiltro id,nombreFiltro nombre');
		$query=$this->db->get('filtro');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @return type
	 */
	public function getNormas()
	{
		$data=false;
		$query=$this->db->select('idNorma id,nombreNorma nombre');
		$query=$this->db->get('numeralNorma');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @param type $idAccion 
	 * @param type $data 
	 * @return type
	 */
	public function updateContenidoAccion($idAccion,$data){
		$res=FALSE;
			$this->db->where('idContenidoAccion',$idAccion);
			if ($this->db->update('contenidoaccion',$data)) {
				$res=TRUE;
			}else{
				$res=FALSE;
			}
		return $res;
	}
	/**
	 * [getRecursosAccion description]
	 * @return [type] [description]
	 */
	public function getRecursosAccion()
	{
		$data=false;
		$query=$this->db->select('r.idRecurso,r.nombreRecurso,rr.codigoPlanAccion codigo');
		$query=$this->db->join('recursos r','rr.codigoRecurso=r.idRecurso');
		$query=$this->db->get('relacionaccionrecurso rr');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getSeguimientoAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getSeguimientoAccion($id)
	{
		$data=false;
		if (isset($id)) {
			$query=$this->db->where('r.codigoAccion',$id);
			$query=$this->db->select('s.*,c.nombreCargo cargo,c.idCargo');
			$query=$this->db->join('seguimientoaccion s','r.codigoSeguimiento=s.idSeguimiento');
			$query=$this->db->join('cargo c','s.codigoCargo=c.idCargo');
			$query=$this->db->get('relacionaccionseguimiento r');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getConclusionAccionId($id)
	{
		$data=false;
		if (isset($id)) {
			$query=$this->db->where('codigoContenidoAccion',$id);
			$query=$this->db->select('cs.*,c.nombreCargo cargo');
			$query=$this->db->join('cargo c','cs.codigoCargoCierre=c.idCargo');
			$query=$this->db->get('controlseguimiento cs');
			if($query->num_rows()>0){
				$data=$query->row();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * [getConclusionAccion description]
	 * @return [type] [description]
	 */
	public function getConclusionAccion()
	{
		$data=false;
			$query=$this->db->select('idControlSeguimiento idC,conclusion,numeralNorma idN,
				fechaCierre,eficacia,codigoContenidoAccion idA');
			$query=$this->db->get('controlseguimiento');
			if($query->num_rows()>0){
				$data=$query->result();
			}
			$query->free_result();
		return $data;
	}
	/**
	 * [getInformacionSeguimientoAccion Este metodo obtiene
	 * la informacion sobre la documentacion del seguimiento de las acciones]
	 * @return [type] [description]
	 */
	public function getInformacionSeguimientoAccion()
	{
		$data=false;
		$query=$this->db->select('i.codigo,i.version,i.fechaVigencia,p.nombreProceso,p.idProceso');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->get('informacionseguimientoaccion i');
		if($query->num_rows()>0){
			$data=$query->row(); 
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getInformacionSolicitud Este metodo obtiene
	 * la informacion sobre la documentacion de la solicitud de cambio]
	 * @return [type] [description]
	 */
	public function getInformacionSolicitud()
	{
		$data=false;
		$query=$this->db->select('i.codigo,i.version,i.fechaVigencia,p.nombreProceso,p.idProceso');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->get('informacionsolicitudcambio i');
		if($query->num_rows()>0){
			$data=$query->row(); 
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getInformacionPlanAccion description]
	 * @return [type] [description]
	 */
	public function getInformacionPlanAccion()
	{
		$data=false;
		$query=$this->db->select('i.codigo,i.version,i.fechaVigencia,p.nombreProceso,p.idProceso');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->get('informacionplanaccion i');
		if($query->num_rows()>0){
			$data=$query->row(); 
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getInformacionMedicion description]
	 * @return [type] [description]
	 */
	public function getInformacionMedicion()
	{
		$data=false;
		$query=$this->db->select('i.codigo,i.version,i.fechaVigencia,p.nombreProceso,p.idProceso');
		$query=$this->db->join('proceso p','p.idProceso=i.codigoProceso');
		$query=$this->db->get('informacionmedicionindicador i');
		if($query->num_rows()>0){
			$data=$query->row(); 
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getSolicitud description]
	 * @return [type] [description]
	 */
	public function getSolicitudCambio()
	{
		$data=false;
		$query=$this->db->select('s.idSolicitud id,s.fechaSolicitud,s.codigoProceso,s.nombreDocumento,t.nombre tipo_documento,ts.nombre tipo_solicitud,e.nombreEstado estado');
		$query=$this->db->join('tipoDocumentoSolicitud t','t.idTipo=s.codigoTipoDocumento');
		$query=$this->db->join('tiposolicitud ts','ts.idTipo=s.codigoTipoSolicitud');
		$query=$this->db->join('estadoSolicitud e','e.idEstado=s.codigoEstado');
		$query=$this->db->get('solicitudCambio s');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @return type
	 */
	public function getTipoDivulgacion()
	{
		$data=false;
		$query=$this->db->select('id,nombre');
		$query=$this->db->get('tipoDivulgacion');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function getSolicitudCambioId($id)
	{
		$data=false;
		if(isset($id)){
			$query=$this->db->where('idSolicitud',$id);
			$query=$this->db->select('s.idSolicitud id,s.fechaSolicitud,s.codigoProceso,ts.idTipo id_tipo_solicitud,s.nombreDocumento,t.nombre tipo_documento,t.idTipo id_tipo_documento,c.nombreCargo cargo ,p.nombreProceso,ts.nombre tipo_solicitud,s.fechaSolicitud,ts.idTipo,u.nombre,u.id id_usuario,s.codigoDocumento,
				s.version,s.fechaVigencia,s.descripcion,s.justificacion,
				s.codigoSolicitudInf,s.versionInf,fechaVigenciaInf,p_i.nombreProceso procesoInf,e.nombreEstado estado

					');
			$query=$this->db->join('tipoDocumentoSolicitud t','t.idTipo=s.codigoTipoDocumento');
			$query=$this->db->join('tiposolicitud ts','ts.idTipo=s.codigoTipoSolicitud');
			$query=$this->db->join('proceso p','p.idProceso=s.codigoProceso');
			$query=$this->db->join('proceso p_i','p_i.idProceso=s.codigoProcesoInf');
			$query=$this->db->join('usuario u','u.id=s.codigoSolicitante');
			$query=$this->db->join('cargo c','c.idCargo=u.codigoCargo');
			$query=$this->db->join('estadoSolicitud e','e.idEstado=s.codigoEstado');
			$query=$this->db->get('solicitudCambio s');
			if($query->num_rows()>0){
				$data=$query->row();
			}
			$query->free_result();
		}
		return $data;
	}
	/**
	 * Este metodo obtiene los tipo de documentos disponibles
	 * en una solicitud de cambio
	 * @return type
	 */
	public function getTipoDocumentoSolicitud()
	{
		$data=false;
		$query=$this->db->select('idTipo id, nombre');
		$query=$this->db->get('tipoDocumentoSolicitud');
		if($query->num_rows()>0){
			$data=$query->result();
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [editInfSeguimientoAccion description]
	 * @return [type] [description]
	 */
	public function editInfSeguimientoAccion($data)
	{
		$res=false;
		if($this->db->update('informacionseguimientoaccion',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * [editInfMedicionIndicador description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function editInfMedicionIndicador($data)
	{
		$res=false;
		if($this->db->update('informacionmedicionindicador',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function editInfPlanAccion($data)
	{
		$res=false;
		if($this->db->update('informacionplanaccion',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * [editInfSolicitudCambio description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function editInfSolicitudCambio($data)
	{
		$res=false;
		if($this->db->update('informacionsolicitudcambio',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * [getFichaIndicador Este metodo obtiene la identificación de la documentación]
	 * @return [type] [description]
	 */
	public function getFichaIndicadorId($id)
	{
		$data=array();
		$query=$this->db->where('idFichaIndicador',$id);
		$query=$this->db->select("idFichaIndicador id,codigoIndicador,idIndicador,p.nombreProceso proceso,pr.nombreProceso procesoInf,pr.idProceso idPR,version,DATE_FORMAT(fechaVigencia,'%d/%m/%Y')  fechaVigencia,nombreIndicador,frecuencia,objetivo,nombreCargoMedicion medir,nombreCargoGestion gestionar,numeradorFormula,denominadorFormula
			");
		$query=$this->db->join('proceso p','f.codigoProceso=p.idProceso');
		$query=$this->db->join('proceso pr','f.codigoProcesoInf=pr.idProceso');
		$query=$this->db->get('fichaTecnicaIndicador f');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getFichaIndicador Este metodo obtiene todas las mediciones asociadas a un indicador]
	 * @return [type] [description]
	 */
	public function getListFichaIndicador($id)
	{
		$data=array();
		$query=$this->db->where('idIndicador',$id);
		$query=$this->db->select("idFichaIndicador id,codigoIndicador,idIndicador,p.nombreProceso proceso,pr.nombreProceso procesoInf,pr.idProceso idPF,version,DATE_FORMAT(fechaVigencia,'%d/%m/%y')  fechaVigencia,nombreIndicador,frecuencia,objetivo,nombreCargoMedicion medir,nombreCargoGestion gestionar,numeradorFormula,denominadorFormula
			");
		$query=$this->db->join('proceso p','f.codigoProceso=p.idProceso');
		$query=$this->db->join('proceso pr','f.codigoProcesoInf=pr.idProceso');
		$query=$this->db->get('fichaTecnicaIndicador f');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo actualiza el estado de la medicion 
	 * de indicador 
	 * @param type $data 
	 * @param type $id 
	 * @return type
	 */
	public function updateEstadoMedicion($data,$id)
	{
		$res=false;
		$this->db->where('codigoComportamiento',$id);
		if($this->db->update('relacionindicadorcomportamiento',$data)){
			$res=true;
		}
		return $res;
	}
	/**
	 * Este metodo complementa al metodo medicion calidad
	 * @return type
	 */
	public function getFichaIndicador()
	{
		$data=array();
		$query=$this->db->select("idFichaIndicador id,codigoIndicador,idIndicador,p.nombreProceso proceso,pr.nombreProceso procesoInf,version,DATE_FORMAT(fechaVigencia,'%d/%m/%y')  fechaVigencia,nombreIndicador,frecuencia,objetivo,nombreCargoMedicion medir,nombreCargoGestion gestionar,numeradorFormula,denominadorFormula
			");
		$query=$this->db->join('proceso p','f.codigoProceso=p.idProceso');
		$query=$this->db->join('proceso pr','f.codigoProcesoInf=pr.idProceso');
		$query=$this->db->get('fichaTecnicaIndicador f');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * [getDirectrizId Este metodo obtiene los datos de una directriz]
	 * @param  [type] $id [id directriz]
	 * @return [type]  object class
	 */
	public function getDirectrizId($id)
	{
		$data=array();
		$query=$this->db->select("idDirectriz idD,nombreDirectriz,descripcion");
		$query=$this->db->where('idDirectriz',$id);
		$query=$this->db->get('directriz');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @param type $id id del indicador
	 * @return type
	 */
	public function getRecursosId($id)
	{
		$data=array();
		$query=$this->db->select("r.nombreRecurso,ri.codigoRecurso");
		$query=$this->db->join('recursos r','r.idRecurso=ri.codigoRecurso');
		$query=$this->db->where('codigoIndicador',$id);
		$query=$this->db->get('relacionIndicadorRecurso ri ');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo carga los datos de la tabla mapa de procesos
	 */
	public function getMapaProcesos(){
		$data=array();
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->select("m.idMapa,m.codigoMapa,DATE_FORMAT(m.fechaVigencia,'%d/%m/%Y')AS fechaVigencia,m.version,m.urlImage imagen,p.nombreProceso proceso");
		$query=$this->db->join('proceso p','p.idProceso=m.codigoProceso');
		$query = $this->db->get('mapaProcesos m');
		if ($query->num_rows()>0) {
			$data= $query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo carga las coordenadas de los botones del mapa de procesos
	 */
	public function getCoordenadas(){
		$data=array();
		$query=$this->db->select("coordenadas,rc.codigoProceso");
		$query=$this->db->join('proceso p','p.idProceso=rc.codigoProceso');
		$query=$this->db->where('p.visibilidad',1);
		$query = $this->db->get('relacionprocesocoordenada rc');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene el id del proceso segun el nombre
	 * del proceso que reciba
	 */
	public function getProcessNameId($nombre){
		$data='';
		$query=$this->db->select('idProceso');
		$query=$this->db->where('nombreProceso',$nombre);
		$query=$this->db->where('visibilidad',1);
		$query=$this->db->get('proceso');
		if ($query->num_rows()>0) {
			$data=$query->row();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo revisa si el id del proceso ya existe en
	 *  la tabla relacionprocesocordenada en la bd
	 */
	public function getProcessId($id){
		$data='';
		$query=$this->db->select('codigoProceso');
		$query=$this->db->join('proceso p','p.idProceso=rc.codigoProceso');
		$query=$this->db->where('p.visibilidad',1);
		$query=$this->db->where('codigoProceso',$id);
		$query=$this->db->get('relacionprocesocoordenada rc');
		if ($query->num_rows()>0) {
			$data=FALSE;
		}else{
			$data=TRUE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * 
	 */
	public function getProceso(){
		$data=array();
		$query=$this->db->select("idProceso id,nombreProceso nombre");
		$query=$this->db->where('visibilidad',1);
		$query = $this->db->get('proceso');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Description
	 * @return type
	 */
	public function getProcesoDis($dis){
		$data=array();
		$query=$this->db->select("idProceso id,nombreProceso nombre");
		$query=$this->db->where('visibilidad',1);
		$query=$this->db->where('disponible',$dis);
		$query = $this->db->get('proceso');
		if ($query->num_rows()>0) {
			$data= $query->result();
		}else{
			$data=FALSE;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * 
	 */
	public function setUploadImage($datos) {
		$option = FALSE;
		if($this->db->update('mapaprocesos',$datos)){$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * Este metodo guarda las coordenadas con 
	 * su respectivo proceso
	 */
	public function saveCoordenadas($id,$coordenadas,$idMapa){
		$query=false;
		if (isset($id) && isset($coordenadas)&& isset($idMapa)) {
			$data=array(
				"codigoProceso"=>$id,"coordenadas"=>$coordenadas,"codigoMapa"=>$idMapa
			);
			
			if ($this->getProcessId($id)) {
				$query=$this->db->insert('relacionprocesocoordenada',$data);
			}else{
				$query=$this->db->where('codigoProceso',$id);
				$query=$this->db->update('relacionprocesocoordenada',$data);
			}
		}
		return $query;
	}
	/**
	 * Este  metodo obtiene las carpetas de 
	 * gestion documental segun 
	 */
	public function getFolder($id){
		$data=array();
		$query=$this->db->select('s.nombreCarpeta,c.orden');
		$query=$this->db->join('subCarpeta s','c.codigoSubCarpeta=idSubCarpeta');
		$query=$this->db->where('c.codigoProceso',$id);
		$query=$this->db->order_by('orden','asc');
		$query=$this->db->get('carpeta c');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
		$data=false;
		}
		$query->free_result();
		return $data;
	}
	//-----Estos metodos son esenciales para el acta de la revision por la direccion-----//
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertSubtituloActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('subtitulo',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [addFichaIndicador Este metodo inserta datos en la tabla fichatecnicaindicador]
	 * @param [type] $data [description]
	 */
	public function addFichaIndicador($data)
	{
		$res=FALSE;
		if ($this->db->insert('fichatecnicaindicador',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	/**
	 * [updateFichaIndicador description]
	 * @param  [type] $data [description]
	 * @param  [type] $id   [description]
	 * @return [type]       [description]
	 */
	public function updateFichaIndicador($data,$id)
	{
		$option = FALSE;
		$this->db->where('idFichaIndicador',$id);
		if($this->db->update('fichatecnicaindicador',$data)){$option = TRUE;} else {$option = FALSE;}			
		return $option;
	}
	/**
	 * [addComportamientoIndicador description]
	 * @param [type] $fechaMedicion [description]
	 * @param [type] $per1          [description]
	 * @param [type] $per2          [description]
	 * @param [type] $meta          [description]
	 * @param [type] $numerador     [description]
	 * @param [type] $denominador   [description]
	 * @param [type] $resultado     [description]
	 */
	public function addComportamientoIndicador($fechaMedicion,$per1,$per2,$meta,$numerador,$denominador,$resultado)
	{
		$res=FALSE;
		for ($i=1; $i <=count($meta) ; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			$data=array('fechaMedicion'=>$fechaMedicion[$i],'fechaPEvaluado'=>$periodo,'meta'=>$meta[$i],'valorN'=>$numerador[$i],'valorD'=>$denominador[$i],'resultado'=>$resultado[$i]);
			if ($this->db->insert('comportamientoindicador',$data)){
			$res[$i]=$this->db->insert_id();
			}
		}
		return $res;
	}
	/**
	 * [addComportamientoIndicadorNew description]
	 * @param [type] $i             [description]
	 * @param [type] $j             [description]
	 * @param [type] $fechaMedicion [description]
	 * @param [type] $per1          [description]
	 * @param [type] $per2          [description]
	 * @param [type] $meta          [description]
	 * @param [type] $numerador     [description]
	 * @param [type] $denominador   [description]
	 * @param [type] $resultado     [description]
	 */
	public function addComportamientoIndicadorNew($inicio,$fin,$fechaMedicion,$per1,$per2,$meta,$numerador,$denominador,$resultado)
	{
		$res=FALSE;
		for ($i=$inicio; $i <=$fin; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			$data=array('fechaMedicion'=>$fechaMedicion[$i],'fechaPEvaluado'=>$periodo,'meta'=>$meta[$i],'valorN'=>$numerador[$i],'valorD'=>$denominador[$i],'resultado'=>$resultado[$i]);
			if ($this->db->insert('comportamientoindicador',$data)){
			$res[$i]=$this->db->insert_id();
			}
		}
		return $res;
	}
	/**
	 * [updateComportamientoIndicador description]
	 * @param  [type] $id            [description]
	 * @param  [type] $fechaMedicion [description]
	 * @param  [type] $per1          [description]
	 * @param  [type] $per2          [description]
	 * @param  [type] $meta          [description]
	 * @param  [type] $numerador     [description]
	 * @param  [type] $denominador   [description]
	 * @param  [type] $resultado     [description]
	 * @return [type]                [description]
	 */
	public function updateComportamientoIndicador($id,$fechaMedicion,$per1,$per2,$numerador,$denominador,$resultado)
	{
		$res=FALSE;

		for ($i=1; $i <=count($id) ; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			$data=array('fechaMedicion'=>$fechaMedicion[$i],'fechaPEvaluado'=>$periodo,'valorN'=>$numerador[$i],'valorD'=>$denominador[$i],'resultado'=>$resultado[$i]);
			$this->db->where('idComportamiento',$id[$i]);
			if ($this->db->update('comportamientoindicador',$data)){
			$res=true;
			/**
					$data=array('estado'=>2);
					$this->updateEstadoMedicion($data,$id[$i]);*/
			}
		}
		return $res;
	}
	/**
	 * [addAnalisisIndicador description]
	 * @param [type] $periodo1 [description]
	 * @param [type] $periodo2 [description]
	 * @param [type] $analisis [description]
	 * @param [type] $accion   [description]
	 */
	public function addAnalisisIndicador($per1,$per2,$analisis,$accion,$idAccion)
	{
		$res=FALSE;
		for ($i=1; $i <=count($analisis) ; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			if(isset($idAccion[$i])){
				$_idAccion=$idAccion[$i];
			}else{
				$_idAccion=0;
			}
			$data=array('periodo'=>$periodo,'analisis'=>$analisis[$i],'codigoTipoAccion'=>$accion[$i],'codigoAccion'=>$_idAccion);
			if ($this->db->insert('analisisindicador',$data)){
				$res[$i]=$this->db->insert_id();
			}
		}
		return $res;
	}
	/**
	 * [addAnalisisIndicadorNew description]
	 * @param [type] $inicio   [description]
	 * @param [type] $fin      [description]
	 * @param [type] $per1     [description]
	 * @param [type] $per2     [description]
	 * @param [type] $analisis [description]
	 * @param [type] $accion   [description]
	 */
	public function addAnalisisIndicadorNew($inicio,$fin,$per1,$per2,$analisis,$accion,$idAccion)
	{
		$res=FALSE;
		for ($i=$inicio; $i <=$fin ; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			if(isset($idAccion[$i])){
				$_idAccion=$idAccion[$i];
			}else{
				$_idAccion=0;
			}
			$data=array('periodo'=>$periodo,'analisis'=>$analisis[$i],'codigoTipoAccion'=>$accion[$i],'codigoAccion'=>$_idAccion);
			if ($this->db->insert('analisisindicador',$data)){
			$res[$i]=$this->db->insert_id();
			}
		}
		return $res;
	}
	/**
	 * [updateAnalisisIndicador description]
	 * @param  [type] $id       [description]
	 * @param  [type] $per1     [description]
	 * @param  [type] $per2     [description]
	 * @param  [type] $analisis [description]
	 * @param  [type] $accion   [description]
	 * @return [type]           [description]
	 */
	public function updateAnalisisIndicador($id,$per1,$per2,$analisis,$accion,$idAccion)
	{
		$res=FALSE;
		for ($i=1; $i <=count($id) ; $i++) { 
			$periodo=$per1[$i].'/'.$per2[$i];
			if(isset($idAccion[$i])){
				$_idAccion=$idAccion[$i];
			}else{
				$_idAccion=0;
			}
			$data=array('periodo'=>$periodo,'analisis'=>$analisis[$i],'codigoTipoAccion'=>$accion[$i],'codigoAccion'=>$_idAccion);
			$this->db->where('idAnalisis',$id[$i]);
			if ($this->db->update('analisisindicador',$data)){
			$res=true;
			}
		}

		return $res;
	}
	/**
	 * Este metodo inserta los id en la tabla relacionindicadorcomportamiento
	 * @param type $idFichaIndicador 
	 * @param type $idComportamiento 
	 * @param type $idAnalisis 
	 * @return type
	 */
	public function addIndicadorComportamiento($idFichaIndicador,$idComportamiento,$idAnalisis)
	{
		$res=FALSE;
		for ($i=1; $i <=count($idComportamiento) ; $i++) { 
			$data=array('codigoFichaIndicador'=>$idFichaIndicador,'codigoComportamiento'=>$idComportamiento[$i],'codigoAnalisis'=>$idAnalisis[$i]);
			if ($this->db->insert('relacionindicadorcomportamiento',$data)){
			$res=true;
			}
		}
		return $res;
	}
	/**
	 * [addIndicadorComportamientoNew description]
	 * @param [type] $inicio           [description]
	 * @param [type] $fin              [description]
	 * @param [type] $idFichaIndicador [description]
	 * @param [type] $idComportamiento [description]
	 * @param [type] $idAnalisis       [description]
	 */
	public function addIndicadorComportamientoNew($inicio,$fin,$idFichaIndicador,$idComportamiento,$idAnalisis)
	{
		$res=FALSE;
		for ($i=$inicio; $i <=$fin ; $i++) { 
			$data=array('codigoFichaIndicador'=>$idFichaIndicador,'codigoComportamiento'=>$idComportamiento[$i],'codigoAnalisis'=>$idAnalisis[$i]);
			if ($this->db->insert('relacionindicadorcomportamiento',$data)){
			$res=true;
			}
		}
		return $res;
	}
	/**
	 * [InsertEncabezadoActa description]
	 * @param [type] $data [description]
	 */
	public function InsertEncabezadoActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('encabezado',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [InsertTextoActa description]
	 * @param [type] $data [description]
	 */
	public function InsertTextoActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('texto',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertImgActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('imgacta',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [InsertTextoImgActa description]
	 * @param [type] $data [description]
	 */
	public function InsertTextoImgActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('textoimagen',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [InsertImgTextoActa description]
	 * @param [type] $data [description]
	 */
	public function InsertImgTextoActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('imagentexto',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertTableTwoActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tabletwo',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	/**
	 * [InsertFilaTwoActa description]
	 * @param [type] $texto1      [description]
	 * @param [type] $texto2      [description]
	 * @param [type] $codigoTable [description]
	 */
	public function InsertFilaTwoActa($texto1,$texto2,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filatwo',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [insertFilaTwo description]
	 * @param  [type] $texto1      [description]
	 * @param  [type] $texto2      [description]
	 * @param  [type] $codigoTable [description]
	 * @return [type]              [description]
	 */
	public function insertFilaTwo($texto1,$texto2,$codigoTable)
	{
		$res=FALSE;
			$data=array("texto1"=>$texto1,"texto2"=>$texto2,"codigoTable"=>$codigoTable);
			if ($this->db->insert('filatwo',$data)){
				$res=TRUE;
			}
		return $res;
	}
	/**
	 * Description
	 * @param type $texto1 
	 * @param type $texto2 
	 * @param type $texto3 
	 * @param type $codigoTable 
	 * @return type
	 */
	public function insertFilaThree($texto1,$texto2,$texto3,$codigoTable)
	{
		$res=FALSE;
			$data=array("texto1"=>$texto1,"texto2"=>$texto2,"texto3"=>$texto3,"codigoTable"=>$codigoTable);
			if ($this->db->insert('filathree',$data)){
				$res=TRUE;
			}
		return $res;
	}
	public function insertFilaFour($texto1,$texto2,$texto3,$texto4,$codigoTable)
	{
		$res=FALSE;
			$data=array("texto1"=>$texto1,"texto2"=>$texto2,"texto3"=>$texto3,"texto4"=>$texto4,"codigoTable"=>$codigoTable);
			if ($this->db->insert('filafour',$data)){
				$res=TRUE;
			}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertTableThreeActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tablethree',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaThreeActa($texto1,$texto2,$texto3,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"texto3"=>$texto3[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filathree',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	public function InsertTableFourActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tablefour',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaFourActa($texto1,$texto2,$texto3,$texto4,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"texto3"=>$texto3[$i],"texto4"=>$texto4[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filafour',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	public function InsertTableFiveActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tablefive',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaFiveActa($texto1,$texto2,$texto3,$texto4,$texto5,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"texto3"=>$texto3[$i],"texto4"=>$texto4[$i],"texto5"=>$texto5[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filafive',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	/**
	 * [updateFilaFive description]
	 * @param  [type] $texto1      [description]
	 * @param  [type] $texto2      [description]
	 * @param  [type] $texto3      [description]
	 * @param  [type] $texto4      [description]
	 * @param  [type] $texto5      [description]
	 * @param  [type] $codigoTable [description]
	 * @return [type]              [description]
	 */
	public function updateFilaFive($texto1,$texto2,$texto3,$texto4,$texto5,$codigoTable)
	{
		$res=FALSE;
		$data=array("texto1"=>$texto1,"texto2"=>$texto2,"texto3"=>$texto3,"texto4"=>$texto4,"texto5"=>$texto5);
		$this->db->where('idFilaFive',$codigoTable);
		if ($this->db->update('filafive',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [updateFilaSix description]
	 * @param  [type] $texto1      [description]
	 * @param  [type] $texto2      [description]
	 * @param  [type] $texto3      [description]
	 * @param  [type] $texto4      [description]
	 * @param  [type] $texto5      [description]
	 * @param  [type] $codigoTable [description]
	 * @return [type]              [description]
	 */
	public function updateFilaSix($texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$codigoTable)
	{
		$res=FALSE;
		$data=array("texto1"=>$texto1,"texto2"=>$texto2,"texto3"=>$texto3,"texto4"=>$texto4,"texto5"=>$texto5,"texto6"=>$texto6);
		$this->db->where('idFilaSix',$codigoTable);
		if ($this->db->update('filasix',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [updateFilaSeven description]
	 * @param  [type] $texto1      [description]
	 * @param  [type] $texto2      [description]
	 * @param  [type] $texto3      [description]
	 * @param  [type] $texto4      [description]
	 * @param  [type] $texto5      [description]
	 * @param  [type] $texto6      [description]
	 * @param  [type] $texto7      [description]
	 * @param  [type] $codigoTable [description]
	 * @return [type]              [description]
	 */
	public function updateFilaSeven($texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$texto7,$codigoTable)
	{
		$res=FALSE;
		$data=array("texto1"=>$texto1,"texto2"=>$texto2,"texto3"=>$texto3,"texto4"=>$texto4,"texto5"=>$texto5,"texto6"=>$texto6,"texto7"=>$texto7);
		$this->db->where('idFilaSeven',$codigoTable);
		if ($this->db->update('filaseven',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * [updateFilaGraphic description]
	 * @param  [type] $tituloColumna [description]
	 * @param  [type] $datosColumna  [description]
	 * @param  [type] $idFila        [description]
	 * @return [type]                [description]
	 */
	public function updateFilaGraphic($tituloColumna,$datosColumna,$idFila)
	{
		$res=FALSE;
		$data=array("tituloColumna"=>$tituloColumna,"datosColumna"=>$datosColumna);
		$this->db->where('idFilaBarra',$idFila);
		if ($this->db->update('filagraphic',$data)){
			$res=TRUE;
		}
		return $res;
	}
	/**
	 * Description
	 * @param type $data 
	 * @return type
	 */
	public function InsertTableSixActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tablesix',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaSixActa($texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"texto3"=>$texto3[$i],"texto4"=>$texto4[$i],"texto5"=>$texto5[$i],"texto6"=>$texto6[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filasix',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	public function InsertTableSevenActa($data)
	{
		$res=FALSE;
		if ($this->db->insert('tableseven',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaSevenActa($texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$texto7,$codigoTable)
	{
		$res=FALSE;
		for ($i=0; $i <count($texto1) ; $i++) { 
			$data=array("texto1"=>$texto1[$i],"texto2"=>$texto2[$i],"texto3"=>$texto3[$i],"texto4"=>$texto4[$i],"texto5"=>$texto5[$i],"texto6"=>$texto6[$i],"texto7"=>$texto7[$i],"codigoTable"=>$codigoTable);
			if ($this->db->insert('filaseven',$data)){
				$res=TRUE;
			}
		}
		return $res;
	}
	public function InsertGraphic($data)
	{
		$res=FALSE;
		if ($this->db->insert('graphic',$data)){
			$res=$this->db->insert_id();
		}
		return $res;
	}
	public function InsertFilaGraphic($tituloCol,$datosCol,$codigoGraphic)
	{
		$res=FALSE;
		if (isset($tituloCol) && isset($datosCol) && isset($codigoGraphic)) {
			$data=array("tituloColumna"=>$tituloCol,"datosColumna"=>$datosCol,"codigoGraphic"=>$codigoGraphic);
				if ($this->db->insert('filaGraphic',$data)){
					$res=TRUE;
				}
		}
		return $res;
	}
}
?>