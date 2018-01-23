<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * 
 * 
 */
class Calidad extends CI_Controller 
{
	/**
	 * [$tipoUsuario description]
	 * @var [type]
	 */
	public $tipoUsuario;
	/**
	 * [$idUsuario description]
	 * @var [type]
	 */
	public $idUsuario; 
	/**
	 * [$folderD description]
	 * @var [type]
	 */
	public $folderD;
	/**
	 * [$folderDO description]
	 * @var [type]
	 */
	public $folderDO; 
	/**
	 * [$proceso description]
	 * @var [type]
	 */
	public $proceso;
	/**
	 * [$nombre description]
	 * @var [type]
	 */
	private $nombre;
	/**
	 * [$email description]
	 * @var [type]
	 */
	private $email;
	/**
	 * [__construct description]
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_sgc','model',true);
		$this->load->library('image_lib');
		$this->load->library('My_PHPMailer');
		$this->load->library('pagination');
		$this->load->library('pdfm');
		$this->tipoUsuario=$this->session->userdata('codigoTipoUsuario');
		$this->email=$this->session->userdata('email');
		$this->nombre=$this->session->userdata('name');
		$this->idUsuario=$this->session->userdata('idUsuario');
		$this->folderD=0;
		$this->folderDO=0;
		$this->proceso=$this->session->userdata('proceso');
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  FUNCIONES PRINCIPALES
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Estos métodos son de vital importancia para la ejecución del sistema
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	/* -------------------------------------------------------------------------------------------------------------------------------------
	|  index()
	|  -------------------------------------------------------------------------------------------------------------------------------------
	|  El metodo index() es el que carga por defecto al llamar al controlador.
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function index(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */			
		if (($this->input->post('filtro')!=NULL)){
			$filtro=$this->input->post('filtro');
			$this->getCadena($filtro);
		}
		$consulta_sesion=$this->session->userdata('cadena');
		$config['base_url'] = base_url().'calidad/planAccion/';		
        $config['total_rows'] = $this->model->numberRowsContenidoAccion($consulta_sesion);  
        $config['per_page'] =$limit;
       	$config['uri_segment'] = 3;
        $config['num_links'] = 5; 
        $config['first_link'] ='Primero';
        $config['last_link'] = 'Ultimo';
        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';
        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
        $config['full_tag_close'] = '</li></ul></div>'; 

		/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */

		$this->pagination->initialize($config);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=0;
		$data['procesos']=$this->model->getProceso();
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['tipo_accion']=$this->model->getEstadoPlanAccion();
		$data['tipoAccion']=$this->model->tipoAccionMedicion();
		$data['title']='Tablero';
		$data['planaccion']=$this->model->getContenidoAccion($consulta_sesion);
		$this->session->set_userdata('cadena', '');	
		$data['content']='index';
		$this->load->vars($data);
		$this->load->view('template');
		/* ----------- FIN ENVIO DE DATOS A LA VISTA ----------- */
	}
	/**
	 * [dofa Este metodo crea el DOFA de CRM
	 * con los datos de la BD]
	 * @return [type] [description]
	 */
	public function dofa(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		
		$this->validateSession();

		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=5;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['dofa']=$this->model->getDOFA();
		$data['factorI']=$this->model->getFactorDOFA(1);
		$data['factorE']=$this->model->getFactorDOFA(0);
		$data['responsable']=$this->model->getResponsableDOFA(1);
		$data['title']='DOFA';
		$data['content']='view_DOFA';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editDOFA Este metodo carga el DOFA de la base de datos
	 * y envia los datos a la vista para ser editados. ]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editDOFA($id){

		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=5;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['idDOFA']=$id;
		$data['dofa']=$this->model->getDOFA();
		$data['factorI']=$this->model->getFactorDOFA(1);
		$data['factorE']=$this->model->getFactorDOFA(0);
		$data['responsable']=$this->model->getResponsableDOFA($id);
		$data['users']=$this->model->getUsers();
		$data['title']='EDITAR DOFA';
		$data['content']='view_editarDOFA';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [indicadorGestionCalidad description]
	 * @return [type] [description]
	 */
	public function indicadorGestionCalidad(){

		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/indicadorGestionCalidad/';		
		        $config['total_rows'] =$this->model->numberRowsIndicador(1);           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);

		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['cargo']=$this->model->getCargo();
		$data['simbolo']=$this->model->getSimbolo();
		$data['medicion']=$this->model->getMedicion();
		$data['tipoIndicador']=$this->model->getTipoIndicador();
		$data['responsableG']=$this->model->getResponsableGestionar(1);
		$data['indicador']=$this->model->getIndicadorCalidad(1,$limit,$start);
		$data['procesos']=$this->model->getProcesoDis(0);
		//$data['procesos']=$this->model->getProcesoUser($this->idUsuario);
		$data['recursos']=$this->model->getRecursos();
		$data['recursosInd']=$this->model->getRecursosIndicador();
		$data['title']='Indicadores de gestión';
		$data['content']='view_indicador';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [medicionCalidad description]
	 * @return [type] [description]
	 */
	public function medicionCalidad()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['indicador']=$this->model->getIndicador();
		$data['procesos']=$this->model->getProceso();
		//VALIDA QUE EL INDICADOR TENGA ASOCIADA UNA MEDICION
		$data['fichaIndicador']=$this->model->getFichaIndicador();
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();
		//------------------------------------------------//
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['title']='Indicadores de gestión CRM';
		$data['content']='view_list_medicionCalidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [planAccion description]
	 * @return [type] [description]
	 */
	public function planAccion()
	{
		$data=array();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */			
		if (($this->input->post('filtro')!=NULL)){
			$filtro=$this->input->post('filtro');
			$this->getCadena($filtro);
		}
		$consulta_sesion=$this->session->userdata('cadena');
		$config['base_url'] = base_url().'calidad/planAccion/';		
        $config['total_rows'] = $this->model->numberRowsContenidoAccion($consulta_sesion);  
        $config['per_page'] =$limit;
       	$config['uri_segment'] = 3;
        $config['num_links'] = 5; 
        $config['first_link'] ='Primero';
        $config['last_link'] = 'Ultimo';
        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';
        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
        $config['full_tag_close'] = '</li></ul></div>'; 
		/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */

		$this->pagination->initialize($config);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */

		//$data['actas']=$this->model->getActas($limit,$start);
		
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['contenidoaccion']=$this->model->getContenidoAccion($consulta_sesion);
		$data['seguimiento']=$this->validateDelete();
		$data['procesos']=$this->model->getProceso();
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['tipoAccion']=$this->model->tipoAccionMedicion();
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['relacionFuente']=$this->model->getAccionFuenteDeteccion();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$this->session->set_userdata('cadena', '');	
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_list_accion';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [solicitudCambio description]
	 * @return [type] [description]
	 */
	public function solicitudCambio()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['tipo_solicitud']=$this->model->getTipoSolicitud();
		$data['procesos']=$this->model->getProceso();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['solicitud']=$this->model->getSolicitudCambio();
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();
		//------------------------------------------------//
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Solicitud de elaboración, modificación o eliminación de documentos';
		$data['content']='view_list_solicitud_cambio';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [comiteCalidad description]
	 * @return [type] [description]
	 */
	public function comiteCalidad()
	{
		$data=array();
		$limit=10;
		$start=$this->uri->segment(3);

		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		if (($this->input->post('filtro')!=NULL)){
			$filtro=$this->input->post('filtro');
			$this->getCadenaCalidad($filtro);
		}
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$cadena=$this->session->userdata('cadenaCalidad');
		$config['base_url'] = base_url().'calidad/comiteCalidad/';		
        $config['total_rows'] = $this->model->numberRowsComiteCalidad($cadena);  
        $config['per_page'] =$limit;
       	$config['uri_segment'] = 3;
        $config['num_links'] = 5; 
        $config['first_link'] ='Primero';
        $config['last_link'] = 'Ultimo';
        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';
        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
        $config['full_tag_close'] = '</li></ul></div>'; 
		/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */

		$this->pagination->initialize($config);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data['option']=$this->validateDelete();
		$data['mensaje']=$this->session->userdata('mensaje');
		$data['comite']=$this->model->getComiteCalidad($cadena);
		$this->session->set_userdata('mensaje','');
		$this->session->set_userdata('cadenaCalidad', '');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Acta comité de calidad';
		$data['content']='view_list_comite_calidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * 	
	 * @return [type] [description]
	 */
	public function changeEstadoComite()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$valor=$this->input->post('val');
		$id_c=$this->input->post('id_comite');
		$id_a=$this->input->post('id_a');
		if(isset($valor) && isset($id_a) && isset($id_c)){
			if($this->model->updateAprobacionComite($id_a,$valor)){
				if($valor==0){
					echo 'No aprobó';
				}elseif($valor==1){
					echo 'Aprobó';
				}
			}
		}
	}
	/**
	 * [buildComiteCalidad description]
	 * @return [type] [description]
	 */
	public function buildComiteCalidad()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data['option']=$this->validateDelete();
		if($data['option']!=1) redirect('calidad');
		$data['_idComite']=$this->model->getIdComiteCalidad();
		$data['inf']=$this->model->getInformacionComite();
		$data['procesos']=$this->model->getProceso();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/comiteCalidad';
		$data['users']=$this->model->getUsers();
		$data['elaboro']=$this->idUsuario;
		//-------------------------------------------------------//
		$max_id=$this->model->getMaxIdComite();
		if($max_id==false){
			$data['compromisos_pasados']=0;
		}else{
			$data['compromisos_pasados']=$this->model->getCompromisosPasadosComite($max_id->id);
			if($data['compromisos_pasados']==false)$data['compromisos_pasados']=0;
		}
		//------------------------------------------------------//
		$data['base_url']=base_url();
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Acta comité de calidad';
		$data['content']='view_build_comite_calidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editInfComiteCalidad description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editComiteCalidad($id)
	{
		$this->validateGet($id);

		$data['option']=$this->validateDelete();
		if($data['option']!=1) redirect('calidad');
		$data['comite']=$this->model->getComiteCalidadId($id);
		if($data['comite']==false) redirect('calidad/');

		$data['id_usuario']=$this->idUsuario;
		$data['asistentes']=$this->model->getAsistentesComite($id);
		$data['agenda']=$this->model->getAgendaComite($id);
		$data['temas_tratados']=$this->model->getTemasTratadosComite($id);
		$data['acuerdos']=$this->model->getAcuerdosComite($id);
		$data['base_url']=base_url();
		$data['option']=$this->validateDelete();
		$data['retorno']=base_url().'calidad/comiteCalidad';

		$data['users']=$this->model->getUsers();
		$data['elaboro']=$this->idUsuario;

		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Acta comité de calidad';
		$data['content']='view_edit_comite_calidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function viewComiteCalidad($id)
	{

		$this->validateGet($id);

		$data['comite']=$this->model->getComiteCalidadId($id);
		if($data['comite']==false) redirect('calidad/');
		$data['id_usuario']=$this->idUsuario;
		$data['asistentes']=$this->model->getAsistentesComite($id);
		$data['agenda']=$this->model->getAgendaComite($id);
		$data['temas_tratados']=$this->model->getTemasTratadosComite($id);
		$data['acuerdos']=$this->model->getAcuerdosComite($id);
		$data['base_url']=base_url();
		$data['option']=$this->validateDelete();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/comiteCalidad';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Acta comité de calidad';
		$data['content']='view_comite_calidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [addComiteCalidad description]
	 */
	public function addComiteCalidad()
	{
		if($this->validateDelete()!=1) redirect('calidad');
		//-------------------------------------------------------//
		$tipo_reunion=$this->input->post('tipo_reunion');
		$objetivo_comite=$this->input->post('objetivo_comite');
		$fecha_comite=$this->input->post('fecha_comite');
		$lugar_comite=$this->input->post('lugar_comite');
		$observacion_comite=$this->input->post('observacion_comite');
		$elaboro=$this->input->post('elaboro');
		$aprobo_elaboro=$this->input->post('aprobo_elaboro');
		$compromisos_pasados=$this->input->post('compromisos_pasados');
		//---
		$codigo=$this->input->post('codigoAccionInf');
		$idProceso=$this->input->post('codigoProcesoInf');
		$version=$this->input->post('versionInf');
		$fechaV=$this->input->post('fechaVigenciaInf');
		//------------------------------------------------------//
		$nombre_asistente=$this->input->post('nameA');
		$cargo_asistente=$this->input->post('cargoA');
		//------------------------------------------------------//
		$agenda=$this->input->post('agenda');
		//------------------------------------------------------//
		$tema_tratado=$this->input->post('tema_tratado');
		$cumple=$this->input->post('cumple');
		//------------------------------------------------------//
		$acuerdos=$this->input->post('acuerdos');
		//------------------------------------------------------//
		if(isset($tipo_reunion) && isset($objetivo_comite) && isset($fecha_comite) && isset($lugar_comite) 
			&& isset($observacion_comite) && isset($elaboro) && isset($compromisos_pasados)){
			if(!isset($aprobo_elaboro)) $aprobo_elaboro=0;
			$data=array('tipo_reunion'=>$tipo_reunion,'objetivo'=>$objetivo_comite,'fecha'=>$fecha_comite,
						'lugar'=>$lugar_comite,'observacion'=>$observacion_comite,'codigo_elaboro'=>$elaboro,
						'aprobo'=>$aprobo_elaboro,'compromisos_pasados'=>$compromisos_pasados,
						'codigo_inf'=>$codigo,'codigoProceso_inf'=>$idProceso,'version_inf'=>$version,'fechaVigencia'=>$fechaV);
			$idComite=$this->model->addComiteCalidad($data); 
			if($idComite!=false){
				$res=$this->model->addAsistenteComite($idComite,$nombre_asistente,$cargo_asistente);
				$res1=$this->model->addAgendaComite($agenda,$idComite);
				$res2=$this->model->addTemasComite($tema_tratado,$cumple,$idComite);
				$res3=$this->model->addAcuerdosComite($acuerdos,$idComite);
				if($res && $res1 && $res2 && $res3){
					$this->session->set_userdata('mensaje','Comite agregado con éxito');
					//-------------------------------------------------------------//
					try{
						$sujeto='Comite de calidad fue agregado';
						$cuerpo='Comite de calidad #'.$idComite.' fue agregado, favor dar aprobación';
						for($i=1;$i<=count($nombre_asistente);$i++){
							$_user=$this->model->getUserId($nombre_asistente[$i]);
							if($_user!=false){
								$nombre=$_user->nombre;
								$email=$_user->email;
								$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
							}
						}		
					}catch(Exception $e){

					}
					//-------------------------------------------------------------//
				}else{
					$this->session->set_userdata('mensaje','No se pudo agregar el comite');
				}
			}else{
					$this->session->set_userdata('mensaje','No se pudo agregar el comite');
			}
		}
		redirect('calidad/comiteCalidad');
	}
	/**
	 * Description
	 * @return type
	 */
	public function updateComiteCalidad()
	{
		if($this->validateDelete()!=1) redirect('calidad');
		//-------------------------------------------------------//
		$idComite=$this->input->post('id_comite');
		$tipo_reunion=$this->input->post('tipo_reunion');
		$objetivo_comite=$this->input->post('objetivo_comite');
		$fecha_comite=$this->input->post('fecha_comite');
		$lugar_comite=$this->input->post('lugar_comite');
		$observacion_comite=$this->input->post('observacion_comite');
		$elaboro=$this->input->post('elaboro');
		$aprobo_elaboro=$this->input->post('aprobo_elaboro');
		$compromisos_pasados=$this->input->post('compromisos_pasados');
		//------------------------------------------------------//
		$nombre_asistente=$this->input->post('nameA');
		$cargo_asistente=$this->input->post('cargoA');
		//------------------------------------------------------//
		$agenda=$this->input->post('agenda');
		//------------------------------------------------------//
		$tema_tratado=$this->input->post('tema_tratado');
		$cumple=$this->input->post('cumple');
		//------------------------------------------------------//
		$acuerdos=$this->input->post('acuerdos');
		//-------;-----------------------------------------------//
		if(isset($idComite) && isset($tipo_reunion) && isset($objetivo_comite) && isset($fecha_comite) && isset($lugar_comite) 
			&& isset($observacion_comite) && isset($elaboro)){
			if(!isset($aprobo_elaboro)) $aprobo_elaboro=0;
			$data=array('tipo_reunion'=>$tipo_reunion,'objetivo'=>$objetivo_comite,'fecha'=>$fecha_comite,
						'lugar'=>$lugar_comite,'observacion'=>$observacion_comite,'codigo_elaboro'=>$elaboro,
						'aprobo'=>$aprobo_elaboro);
			if($this->model->editComiteCalidad($idComite,$data)){
				if($this->model->emptyTableComiteCalidad($idComite,'asistentes_comite')){
					$res=$this->model->addAsistenteComite($idComite,$nombre_asistente,$cargo_asistente);
				}
				if($this->model->emptyTableComiteCalidad($idComite,'agenda_reunion_comitecalidad')){
					$res1=$this->model->addAgendaComite($agenda,$idComite);
				}
				if($this->model->emptyTableComiteCalidad($idComite,'temastratados_comitecalidad')){
					$res2=$this->model->addTemasComite($tema_tratado,$cumple,$idComite);
				}				
				if($this->model->emptyTableComiteCalidad($idComite,'acuerdo_comite')){
					$res3=$this->model->addAcuerdosComite($acuerdos,$idComite);	
				}
				if($res && $res1 && $res2 && $res3){
					$this->session->set_userdata('mensaje','Comite editado con éxito');
					//-------------------------------------------------------------//
					try{
						$sujeto='Comite de calidad fue editado';
						$cuerpo='Comite de calidad #'.$idComite.' fue editado, favor revisar';
						for($i=1;$i<=count($nombre_asistente);$i++){
							$_user=$this->model->getUserId($nombre_asistente[$i]);
							if($_user!=false){
								$nombre=$_user->nombre;
								$email=$_user->email;
								$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
							}
						}		
					}catch(Exception $e){

					}
					//-------------------------------------------------------------//
				}else{
					$this->session->set_userdata('mensaje','No se pudo editar el comite');
				}
			}else{
					$this->session->set_userdata('mensaje','No se pudo editar el comite');
			}
		}
		redirect('calidad/viewComiteCalidad/'.$idComite);
	}
	/**
	 * [verSolicitud description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function verSolicitud($id)
	{
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		//-----Valida que el us<u></u>ario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();

		$data['solicitud']=$this->model->getSolicitudCambioId($id);
		if($data['solicitud']==false){
			redirect('calidad');
		}
		$data['option']=$this->validateDelete();
		$data['divulgacion']=$this->model->getDivulgacionSolicitud($id);
		$data['revision']=$this->model->getRevisionSolicitud($id);
		$data['aprobacion']=$this->model->getAprobacionSolicitud($id);
		$data['tipo_solicitud']=$this->model->getTipoSolicitud();
		$data['id_usuario']=$this->idUsuario;
		$data['procesos']=$this->model->getProceso();
		$data['inf']=$this->model->getInformacionSolicitud();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/solicitudCambio';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Solicitud de elaboración, modificación o eliminación de documentos';
		$data['content']='view_solicitud_cambio';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [buildSeguimientoSolicitudCambio description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function buildSeguimientoSolicitudCambio($id)
	{
		$this->validateGet($id);

		$data['solicitud']=$this->model->getSolicitudCambioId($id);
		if($data['solicitud']==false){
			redirect('calidad');
		}
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();
		$data['representante']=$this->getRepresentanteDireccion();
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['idSolicitud']=$id;
		$data['revision']=$this->model->getRevisionSolicitud($id);
		$data['aprobacion']=$this->model->getAprobacionSolicitud($id);
		$data['base_url']=base_url();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['seguimiento']=false;
		$data['id_usuario']=$this->idUsuario;
		$data['tipoDivulgacion']=$this->model->getTipoDivulgacion();
		$data['inf']=$this->model->getInformacionSolicitud();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['tipo_solicitud']=$this->model->getTipoSolicitud();
		$data['procesos']=$this->model->getProceso();
		$data['id_usuario']=$this->idUsuario;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/solicitudCambio';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Solicitud de elaboración, modificación o eliminación de documentos';
		$data['content']='view_seguimiento_solicitud_cambio';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * 	Este metodo obtiene el cargo principal del
	 *  id de usuario recibido 
	 * @return [type] [description]
	 */
	public function getCargoUsuario()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$data=false;
		$id=$this->input->post('id_usuario');
		if(isset($id)){
			$data=($this->model->getIdCargo($id));
			if($data!=false)
				echo $data->codigoCargo;
		}
	}
	/**
	 * [deleteSolicitud description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteSolicitud($id)
	{
		if($this->validateDelete()!=1)
			redirect('calidad');

		$this->validateGet($id);

		if($this->model->deleteSolicitud($id) ){
			$this->session->set_userdata('mensaje','Solicitud #'.$id.' eliminada con éxito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar la solicitud #'.$id.'');
		}
		redirect('calidad/solicitudCambio');
	}
	/**
	 * [seguimientoCambio description]
	 * @return [type] [description]
	 */
	public function buildSolicitudCambio()
	{
		$this->validateUsuarioProceso();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();
		$data['tipo_solicitud']=$this->model->getTipoSolicitud();
		$data['id_usuario']=$this->idUsuario;
		$data['inf']=$this->model->getInformacionSolicitud();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['procesos']=$this->model->getProceso();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['documento']=$this->model->getTipoDocumentoSolicitud();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/solicitudCambio';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Solicitud de elaboración, modificación o eliminación de documentos';
		$data['content']='view_buildSolicitud_cambio';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editSolicitudCambio description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editSolicitudCambio($id)
	{
		$this->validateGet($id);

		$this->validateUsuarioProceso();

		$data['solicitud']=$this->model->getSolicitudCambioId($id);
		if($data['solicitud']==false){
			redirect('calidad');
		}
		$data['tipo_solicitud']=$this->model->getTipoSolicitud();
		$data['id_usuario']=$this->idUsuario;
		$data['inf']=$this->model->getInformacionSolicitud();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['procesos']=$this->model->getProceso();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['documento']=$this->model->getTipoDocumentoSolicitud();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['retorno']=base_url().'calidad/verSolicitud/'.$id;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['title']='Solicitud de elaboración, modificación o eliminación de documentos';
		$data['content']='view_editSolicitud_cambio';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [getCadena description]
	 * @param  [type] $filtro [description]
	 * @return [type]         [description]
	 */
	public function getCadena($filtro){

		$cadena='';
		$and=false;
		$temp=FALSE;
		foreach ($filtro as $varPost => $value) {
			$query='';
			if ($value=='' || !isset($value) || empty($value)) {
				# code...
			}else{
				if ($varPost=='id_proceso') {
					if($and){
						$query .=' AND ';
					}
					$query .='(codigoProceso)='.$value;
					$and=TRUE;
				}
				if($varPost=='tipo_accion'){
					if($and){
						$query .=' AND ';
					}
					$query .='(codigoTipoAccion)='.$value;
					$and=TRUE;
				}
				if($varPost=='fuente'){
					if($and){
						$query .=' AND ';
					}
					$query .='(rf.codigoFuente)='.$value;
					$and=TRUE;
				}
				if($varPost=='estado'){
					if($and){
						$query .=' AND ';
					}
					$query .='(c.codigoFiltro)='.$value;
					$and=TRUE;
				}
				if($varPost=='eficacia'){
					if($and){
						$query .=' AND ';
					}
					$query .='(co.eficacia)="'.$value.'"';
					$and=TRUE;
				}
				if($varPost=='fecha_inicial'){
					$fecha_inicial=$value;
					if($and){
						$query .=' AND ';
					}
					$query .='(fechaHallazgo) BETWEEN "'.$value.'" AND ';
					$temp=true;
					$and=TRUE;
				}
				if ($varPost=='fecha_final') {
					if($temp){
						$query .="'".$value."'";
					}
					$and=TRUE;
				}
 			}
 			$cadena.=$query;
		}
		$this->session->set_userdata('cadena',$cadena);
	}
	/**
	 * 	
	 * @param  [type] $filtro [description]
	 * @return [type]         [description]
	 */
	public function getCadenaCalidad($filtro)
	{
		$cadena='';
		$and=false;
		$temp=FALSE;
		foreach ($filtro as $varPost => $value) {
			$query='';
			if ($value=='' || !isset($value) || empty($value)) {
				# code...
			}else{
				if ($varPost=='id_comite') {
					if($and){
						$query .=' AND ';
					}
					$query .='(idComite)='.$value;
					$and=TRUE;
				}
				if($varPost=='fecha_inicial'){
					$fecha_inicial=$value;
					if($and){
						$query .=' AND ';
					}
					$query .='(fecha) BETWEEN "'.$value.'" AND ';
					$temp=true;
					$and=TRUE;
				}
				if ($varPost=='fecha_final') {
					if($temp){
						$query .="'".$value."'";
					}
					$and=TRUE;
				}
 			}
 			$cadena.=$query;
		}
		$this->session->set_userdata('cadenaCalidad',$cadena);
	}
	/**
	 * [buildPlanAccion description]
	 * @param  [type] $codigoProceso [description]
	 * @return [type]                [description]
	 */
	public function buildPlanAccion()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->validateDelete()==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['procesos']=$this->model->getProceso();
		$data['inf']=$this->model->getInformacionPlanAccion();
		$data['option']=$this->validateDelete();
		$data['procesoUser']=$this->model->getProcesoUser($this->idUsuario);
		$data['contenidoaccion']=$this->model->getContenidoAccion();
		$data['metodologia']=$this->model->getMetodologiaAccion();
		$data['tipoAccion']=$this->model->tipoAccionMedicion();
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['correccion']=$this->model->getCorreccionAccion();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['recurso']=$this->model->getRecursos();

		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/planAccion';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_build_accion';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [viewPlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function viewPlanAccion($id)
	{
		$this->validateGet($id);

		$data['id']=$id;
		$data['contenidoaccion']=$this->model->getContenidoAccionId($id);
		if($data['contenidoaccion']==false){
			redirect('');
		}
		$data['fecha_revision']=$this->model->getFechaRevisionPlanAccion();
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['fuente_id']=$this->model->getFuenteDeteccionId($id);
		$data['metodologia']=$this->model->getMetodologiaAccion();
		$data['metodologia_id']=$this->model->getMetodologiaAccionId($id);
		$data['correccion']=$this->model->getCorreccionAccion();
		$data['correccion_id']=$this->model->getCorreccionAccionId($id);
		$data['plan']=$this->model->getPlanAccionId($id);
		$data['recurso']=$this->model->getRecursosAccion();
		$data['seguimiento']=$this->model->getSeguimientoAccion($id);
		$data['norma']=$this->model->getNormas();
		$data['conclusion']=$this->model->getConclusionAccionId($id);
		if($data['conclusion']==false){
			$data['barra_superior']=true;
		}else{
			$data['barra_superior']=false;
		}
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/planAccion';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_PlanAccion';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editPlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editPlanAccion($id)
	{
		$this->validateGet($id);

		$this->validateUsuarioProceso();
		$data['id']=$id;
		$data['contenidoaccion']=$this->model->getContenidoAccionId($id);
		if($data['contenidoaccion']==false){
			redirect('');
		}
		$data['fecha_revision']=$this->model->getFechaRevisionPlanAccion();
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['fuente_id']=$this->model->getFuenteDeteccionId($id);
		$data['metodologia']=$this->model->getMetodologiaAccion();
		$data['metodologia_id']=$this->model->getMetodologiaAccionId($id);
		$data['correccion']=$this->model->getCorreccionAccion();
		$data['correccion_id']=$this->model->getCorreccionAccionId($id);
		$data['plan']=$this->model->getPlanAccionId($id);
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['recursos']=$this->model->getRecursos();
		$data['recurso']=$this->model->getRecursosAccion();
		$data['seguimiento']=$this->model->getSeguimientoAccion($id);
		$data['conclusion']=$this->model->getConclusionAccionId($id);
		$data['tipoAccion']=$this->model->tipoAccionMedicion();
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/viewPlanAccion/'.$id;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_editPlanAccion';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Description
	 * @return type
	 */
	public function updatePlanAccion()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$idAccion=$this->input->post('idAccion');
		$fechaHallazgo=$this->input->post('fechaHallazgo');
		$fuenteD=$this->input->post('fuenteD');
		$causa=$this->input->post('causa');
		$idPorque=$this->input->post('idPorque');
		$descripcionHallazgo=$this->input->post('descripcionHallazgo');
		$primer=$this->input->post('primer');
		$segundo=$this->input->post('segundo');
		$tercer=$this->input->post('tercer');
		$frecuenciaPrimer=$this->input->post('frecuenciaPrimer');
		$frecuenciaSegundo=$this->input->post('frecuenciaSegundo');
		$frecuenciaTercer=$this->input->post('frecuenciaTercer');
		$causaRaiz=$this->input->post('causaRaiz');
		$beneficio_consecuencia=$this->input->post('beneficio_consecuencia');
		$descripcion=$this->input->post('descripcion');
		$responsable_corregir=$this->input->post('responsable_corregir');
		//---------------------------------------Plan Accion editar
		$idPlanAccion=$this->input->post('idPlan');
		$actividad_desarrollarE=$this->input->post('actividad_desarrollarE');
		$fecha_ejecucionE=$this->input->post('fecha_ejecucionE');
		$responsable_seguimientoE=$this->input->post('responsable_seguimientoE');
		$indexPlan=$this->input->post('indexPlan');
		//---------------------------------------
		$correccion=$this->input->post('correccion');
		//---------------------------------------------//
		$fecha_revision_1=$this->input->post('fecha_revision_1');
		$fecha_revision_2=$this->input->post('fecha_revision_2');
		$fecha_revision_3=$this->input->post('fecha_revision_3');
		//---------------------------------------------//
		if (isset($idPorque) && isset($idAccion) && isset($fechaHallazgo) && isset($fuenteD)
			&& isset($causa) && isset($descripcionHallazgo) && isset($primer) && isset($segundo)
			&& isset($tercer) && isset($frecuenciaPrimer) && isset($frecuenciaSegundo) && isset($frecuenciaTercer)
			&& isset($frecuenciaTercer) && isset($causaRaiz) && isset($beneficio_consecuencia) && isset($descripcion)
			&& isset($responsable_corregir) && isset($actividad_desarrollarE) && isset($fecha_ejecucionE) && isset($responsable_seguimientoE)) {
			//------------------Nuevos planes de acción---------
			$actividad_desarrollar=$this->input->post('actividad_desarrollar');
			$fecha_ejecucion=$this->input->post('fecha_ejecucion');
			$recurso=$this->input->post('recurso');
			$responsable_seguimiento=$this->input->post('responsable_seguimiento');
			if(isset($indexPlan) && isset($actividad_desarrollar) && isset($fecha_ejecucion)&& isset($responsable_seguimiento)){
				$idPlanAccionNew=$this->model->addPlanAccionNew($actividad_desarrollar,$fecha_ejecucion,$responsable_seguimiento);
				for ($i=$indexPlan; $i <=(count($idPlanAccion)+1) ; $i++) {
					$recurso=$this->input->post('recurso_'.$i);
					$this->model->InsertRelacionRecursoPlan($idPlanAccionNew[$i],$recurso);
					//-------------------------------------------------//
						$_fecha_revision_2=NULL;
						$_fecha_revision_3=NULL;
						if(isset($fecha_revision_2[$i]) && $fecha_revision_2[$i]!=''){
							$_fecha_revision_2=$fecha_revision_2[$i];
						}
						if(isset($fecha_revision_3[$i]) && $fecha_revision_3[$i]!=''){
							$_fecha_revision_3=$fecha_revision_3[$i];
						}
						$data_fecha=array('codigoPlanAccion'=>$idPlanAccionNew[$i],
								'fecha_1'=>$fecha_revision_1[$i],'fecha_2'=>$_fecha_revision_2,'fecha_3'=>$_fecha_revision_3);
						$this->model->InsertFechaRevisionAccion($data_fecha);
						//---------------------------------------------------//
				}
				$this->model->InsertRelacionPlanAccionNew($idAccion,$idPlanAccionNew);
			}
			//---------Eliminacion y actualizacion de fuente de detección-------//
			if($this->model->emptyFuenteAccion($idAccion)){
				$this->model->InsertRelacionAccionFuente($idAccion,$fuenteD);
			}
			//------------------------------------------------------------------//
			//---------Eliminacion y actualizacion de metodologia 6m-------//
			if($this->model->emptyMetodologiaAccion($idAccion)){
				$this->model->InsertRelacionMetodologiaAccion($idAccion,$causa);
			}
			//-------------------------------------------------------------------
			//-------------Actualizacion Planes de accion----------------------//
			if (isset($actividad_desarrollarE) && isset($fecha_ejecucionE) && isset($responsable_seguimientoE) && isset($indexPlan)) {
				$data=array();
				$this->model->updatePlanAccion($idPlanAccion,$actividad_desarrollarE,$fecha_ejecucionE,$responsable_seguimientoE);
				if ($this->model->emptyRecursoAccion($idPlanAccion)) {
					for ($i=1; $i <$indexPlan ; $i++) {
						$recursoE=$this->input->post('recursoE_'.$i);
						$this->model->InsertRelacionRecursoPlan($idPlanAccion[$i],$recursoE);
					}
				}
				//-------------------------------------------------------------------//
				for ($i=1; $i <=count($idPlanAccion) ; $i++) { 
					if($this->model->emptyFechaRevision($idPlanAccion[$i])){
						//-------------------------------------------------//
						$_fecha_revision_2=NULL;
						$_fecha_revision_3=NULL;
						if(isset($fecha_revision_2[$i]) && $fecha_revision_2[$i]!=''){
							$_fecha_revision_2=$fecha_revision_2[$i];
						}
						if(isset($fecha_revision_3[$i]) && $fecha_revision_3[$i]!=''){
							$_fecha_revision_3=$fecha_revision_3[$i];
						}
						$data_fecha=array('codigoPlanAccion'=>$idPlanAccion[$i],
								'fecha_1'=>$fecha_revision_1[$i],'fecha_2'=>$_fecha_revision_2,'fecha_3'=>$_fecha_revision_3);
						$this->model->InsertFechaRevisionAccion($data_fecha);
						//---------------------------------------------------//
					}
				}
				//-------------------------------------------------------------------//
			}
			//-------------------------------------------------------------------
			//-------------Actualizacion o insercion de datos de correccion-----------//
			if ($this->model->emptyCorreccionAccion($idAccion)) {
				if(isset($correccion)){
					$this->model->InsertCorreccionAccion($correccion,$idAccion);
				}
			}
			//--------------------------------------------------
			$data=array('fechaHallazgo'=>$fechaHallazgo,'beneficio_consecuencia'=>$beneficio_consecuencia,'descripcion'=>$descripcion,'codigoCargoResponsable'=>$responsable_corregir);	
			$dataPorque=array('descripcionPrimer'=>$primer,'descripcionSegundo'=>$segundo,'descripcionTercer'=>$tercer,'frecuenciaPrimer'=>$frecuenciaPrimer,'frecuenciaSegunda'=>$frecuenciaSegundo,'frecuenciaTercera'=>$frecuenciaTercer,'descripcionHallazgo'=>$descripcionHallazgo,'causaRaizHallazgo'=>$causaRaiz);
			if($this->model->updateContenidoAccion($idAccion,$data) && $this->model->updatePorqueAccion($idPorque,$dataPorque)){
				$this->session->set_userdata('mensaje','Plan de acción editado con exito');
				$nombreD=$this->nombre;
				$tipoAccion=$this->input->post('nombreTipoN');
				$nombreProceso=$this->input->post('procesoN');
				$cuerpo='Plan de acción #'.$idAccion.' fue editado por '.$nombreD.', por favor revisar.';
				$sujeto='Plan de acción '.$tipoAccion.'-'.$nombreProceso.' #'.$idAccion.' fue editado.';
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}		
				}catch(Exception $e){

				}
				
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar el plan de accion');
			}
		}
		redirect('calidad/planAccion');
	}
	/**
	 * [seguimientoPlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function seguimientoPlanAccion($id)
	{

		$this->validateGet($id);

		$data['id']=$id;
		$data['contenidoaccion']=$this->model->getContenidoAccionId($id);
		if($data['contenidoaccion']==false){
			redirect('');
		}
		$data['fecha_revision']=$this->model->getFechaRevisionPlanAccion();
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['norma']=$this->model->getNormas();
		$data['fuente_id']=$this->model->getFuenteDeteccionId($id);
		$data['metodologia']=$this->model->getMetodologiaAccion();
		$data['metodologia_id']=$this->model->getMetodologiaAccionId($id);
		$data['correccion']=$this->model->getCorreccionAccion();
		$data['correccion_id']=$this->model->getCorreccionAccionId($id);
		$data['plan']=$this->model->getPlanAccionId($id);
		$data['recursos']=$this->model->getRecursosAccion();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['recurso']=$this->model->getRecursos();
		$data['seguimiento']=$this->model->getSeguimientoAccion($id);
		$data['conclusion']=$this->model->getConclusionAccionId($id);
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/planAccion';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_buildSeguimiento';
		if($data['conclusion']==false){
			$data['barra_superior']=true;
		}else{
			$data['barra_superior']=false;
		}
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function editPlanSeguimiento($id)
	{

		$this->validateGet($id);

		$data['id']=$id;
		$data['contenidoaccion']=$this->model->getContenidoAccionId($id);
		if($data['contenidoaccion']==false){
			redirect('');
		}
		$data['fecha_revision']=$this->model->getFechaRevisionPlanAccion();
		$data['fuente']=$this->model->getFuenteDeteccion();
		$data['fuente_id']=$this->model->getFuenteDeteccionId($id);
		$data['metodologia']=$this->model->getMetodologiaAccion();
		$data['metodologia_id']=$this->model->getMetodologiaAccionId($id);
		$data['correccion']=$this->model->getCorreccionAccion();
		$data['correccion_id']=$this->model->getCorreccionAccionId($id);
		$data['plan']=$this->model->getPlanAccionId($id);
		$data['recursos']=$this->model->getRecursosAccion();
		$data['users']=$this->model->getUsers();
		$data['cargo']=$this->model->getCargo();
		$data['recurso']=$this->model->getRecursos();
		$data['seguimiento']=$this->model->getSeguimientoAccion($id);
		$data['conclusion']=$this->model->getConclusionAccionId($id);
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/planAccion';
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Plan de acciones';
		$data['content']='view_editSeguimientoAccion';
		if($data['conclusion']==false){
			$data['barra_superior']=true;
		}else{
			$data['barra_superior']=false;
		}
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [addSeguimientoAccion description]
	 */
	public function addSeguimientoAccion()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		//-------Seguimiento plan de acción-----------//
		$idAccion=$this->input->post('idContenidoAccion');
		$fecha_seguimiento=$this->input->post('fecha_seguimiento');
		$descripcion_seguimiento=$this->input->post('descripcionSeguimiento');
		$eficacia=$this->input->post('eficacia');
		$cargo_verifica=$this->input->post('cargoV');
		//--------------------
		$conclusion=$this->input->post('conclusion');
		$norma=$this->input->post('norma');
		$fechaCierre=$this->input->post('fechaCierre');
		$responsable_cierre=$this->input->post('responsable_cierre');
		$eficacia_accion=$this->input->post('eficacia_accion');
		$indexSeguimiento=$this->input->post('indexSeguimiento');
		//--------------------
		if(isset($indexSeguimiento) && $this->array_empty($fecha_seguimiento)&&$this->array_empty($descripcion_seguimiento)&&$this->array_empty($cargo_verifica)&&isset($fecha_seguimiento)&&isset($descripcion_seguimiento)&&isset($cargo_verifica)&&isset($idAccion)){
			$idSeguimiento=$this->model->addSeguimientoAccion($indexSeguimiento,$fecha_seguimiento,$descripcion_seguimiento,$cargo_verifica,$eficacia);
			if($this->model->InsertRelacionAccionSeguimiento($idSeguimiento,$idAccion)
				){
				$data=array('codigoFiltro'=>2);
				$this->model->updateContenidoAccion($idAccion,$data);
				//-----------------------------------------------------//
				for ($i=$indexSeguimiento; $i <(count($fecha_seguimiento)+$indexSeguimiento); $i++){
					if(isset($eficacia[$i])){
					}else{
						$idProceso=$this->input->post('idProceso');
						$usersP=$this->model->getUserProceso($idProceso);
						$tipoAccion=$this->input->post('tipoAccion');
						$cuerpo='Plan de acción con un seguimiento ineficaz, favor revisar';
						$sujeto='Plan de acción '.$tipoAccion.'-'.$nombreProceso.' #'.$idAccion.' ';
							if($usersP!=false){
								try{
									foreach ($usersP as $value_u) {
										$nombre=$value_u->nombre;
										$email=$value_u->email;
										$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
									}
								}catch(Exception $e){

								}
								
							}
					}
				}
				
				//----------------------------------------------------//
				$this->session->set_userdata('mensaje','Seguimiento del plan de accion agregado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar el seguimiento del plan de accion');
			}
		}
		if(isset($conclusion)&&isset($norma)&&isset($fechaCierre)&&isset($responsable_cierre)&&isset($eficacia_accion)){
			if($this->model->addControlSeguimientoAccion($idAccion,$conclusion,$norma,$fechaCierre
					,$responsable_cierre,$eficacia_accion)){
				$data=array('codigoFiltro'=>4);
				$this->model->updateContenidoAccion($idAccion,$data);
				$nombreD=$this->nombre;
				$idProceso=$this->input->post('idProceso');
				$usersP=$this->model->getUserProceso($idProceso);
				$tipoAccion=$this->input->post('tipoAccion');
				$cuerpo=$conclusion;
				$sujeto='Plan de acción '.$tipoAccion.'-'.$nombreProceso.' #'.$idAccion.' fue finalizada.';
					if($usersP!=false){
						try{
							foreach ($usersP as $value_u) {
								$nombre=$value_u->nombre;
								$email=$value_u->email;
								$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
							}
						}catch(Exception $e){
							
						}
					}
				$this->session->set_userdata('mensaje','Seguimiento del plan de accion agregado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar el seguimiento del plan de accion');
			}
		}
		redirect('calidad/planaccion');
	}
	/**
	 * Description
	 * @return type
	 */
	public function editSeguimientoAccion()
	{
		if($this->validateDelete()!=1){
			redirect('');
		}

		$id_seguimiento=$this->input->post('idSeguimiento');
		$fecha_seguimiento=$this->input->post('fecha_seguimiento');
		$descripcionSeguimiento=$this->input->post('descripcionSeguimiento');
		$eficacia=$this->input->post('eficacia');
		$cargoV=$this->input->post('cargoV');
		if($this->array_empty($id_seguimiento) && $this->array_empty($fecha_seguimiento) && $this->array_empty($descripcionSeguimiento) && $this->array_empty($cargoV)){
			if($this->model->updateSeguimientoAccion($id_seguimiento,$fecha_seguimiento,$descripcionSeguimiento,$eficacia,$cargoV)){
				$this->session->set_userdata('mensaje','Seguimiento editado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar el seguimiento.');
			}
		}
		redirect('calidad/planaccion');
	}
	/**
	 * [array_empty valida que no este vacio el array]
	 * @param  [type] $array [description]
	 * @return [type]        [description]
	 */
	private function array_empty($array)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$empty=true;
		if(is_array($array)){
			foreach ($array as $value) {
				if($empty){
					if(empty($value)){
						$empty=false;
					}
				}
			}
		}
		return $empty;
	}
	/**
	 * [addPlanAccion description]
	 */
	public function addPlanAccion()
	{

		$this->validateUsuarioProceso();

		//----------------------//
		$codigoInf=$this->input->post('codigoAccion');
		$codigoProcesoInf=$this->input->post('codigoProcesoInf');
		$version=$this->input->post('version');
		$fechaVigencia=$this->input->post('fechaVigencia');
		//--------------//
		$idProceso=$this->input->post('proceso');
		$fechaHallazgo=$this->input->post('fechaHallazgo');
		$tipoAccion=$this->input->post('tipoAccion');
		$fuenteDeteccion=$this->input->post('fuenteD');
		$causa=$this->input->post('causa');
		$descripcionHallazgo=$this->input->post('descripcionHallazgo');
		$primer=$this->input->post('primer');
		$segundo=$this->input->post('segundo');
		$tercer=$this->input->post('tercer');
		$frecuenciaPrimer=$this->input->post('frecuenciaPrimer');
		$frecuenciaSegundo=$this->input->post('frecuenciaSegundo');
		$frecuenciaTercer=$this->input->post('frecuenciaTercer');
		$causaRaiz=$this->input->post('causaRaiz');
		//-------------En caso de que aplique--------------------------------//
		$correccion=$this->input->post('correccion');
		//---------------------------------------------//
		$descripcion=$this->input->post('descripcion');
		$responsable_corregir=$this->input->post('responsable_corregir');
		$beneficio_consecuencia=$this->input->post('beneficio_consecuencia');
		$actividad_desarrollar=$this->input->post('actividad_desarrollar');
		$fecha_ejecucion=$this->input->post('fecha_ejecucion');
		$responsable_seguimiento=$this->input->post('responsable_seguimiento');
		//---------------------------------------------//
		$fecha_revision_1=$this->input->post('fecha_revision_1');
		$fecha_revision_2=$this->input->post('fecha_revision_2');
		$fecha_revision_3=$this->input->post('fecha_revision_3');
		//---------------------------------------------//
		if(isset($fechaHallazgo) && isset($tipoAccion) && isset($codigoInf) && isset($version)
			&& isset($fechaVigencia) && isset($codigoProcesoInf) && isset($idProceso) && isset($fuenteDeteccion) && isset($causa) && isset($descripcionHallazgo) && isset($primer) && isset($segundo) && isset($tercer) && isset($frecuenciaPrimer) && isset($frecuenciaSegundo)  && isset($frecuenciaTercer) && isset($causaRaiz) &&
			isset($beneficio_consecuencia) && isset($descripcion) && isset($responsable_corregir) && isset($actividad_desarrollar) && isset($fecha_ejecucion) && isset($responsable_seguimiento)
			){
			$data= array('descripcionPrimer' =>$primer,'descripcionSegundo'=>$segundo,'descripcionTercer'=>$tercer,'frecuenciaPrimer'=>$frecuenciaPrimer,'frecuenciaSegunda'=>$frecuenciaSegundo,'frecuenciaTercera'=>$frecuenciaTercer,
				'descripcionHallazgo'=>$descripcionHallazgo,'causaRaizHallazgo'=>$causaRaiz);
			$idPorque=$this->model->addPorque($data);
			//---------------------------------------------------------------------------
			$data=array('codigoAccion' =>$codigoInf ,'codigoProcesoInf'=>$codigoProcesoInf,'version'=>$version,'fechaVigencia'=>$fechaVigencia,'fechaHallazgo'=>$fechaHallazgo,'codigoTipoAccion'=>$tipoAccion,'codigoProceso'=>$idProceso,'codigoPorque'=>$idPorque,'beneficio_consecuencia'=>$beneficio_consecuencia,'descripcion'=>$descripcion,'codigoCargoResponsable'=>$responsable_corregir);
			$idAccion=$this->model->addContenidoAccion($data);
			//--------------------------------------------------------------------------
			if($idAccion!=false){
				 $this->model->InsertRelacionAccionFuente($idAccion,$fuenteDeteccion);
			}
			if(isset($correccion)){
				$this->model->InsertCorreccionAccion($correccion,$idAccion);
			}
			$idPlanAccion=$this->model->addPlanAccion($actividad_desarrollar,$fecha_ejecucion,$responsable_seguimiento);
			for ($i=1; $i <=count($idPlanAccion) ; $i++) {
				$recurso=$this->input->post('recurso_'.$i);
				$this->model->InsertRelacionRecursoPlan($idPlanAccion[$i],$recurso);
				//-------------------------------------------------//
				$_fecha_revision_2=NULL;
				$_fecha_revision_3=NULL;
				if(isset($fecha_revision_2[$i]) && $fecha_revision_2[$i]!=''){
					$_fecha_revision_2=$fecha_revision_2[$i];
				}
				if(isset($fecha_revision_3[$i]) && $fecha_revision_3[$i]!=''){
					$_fecha_revision_3=$fecha_revision_3[$i];
				}
				$data_fecha=array('codigoPlanAccion'=>$idPlanAccion[$i],
						'fecha_1'=>$fecha_revision_1[$i],'fecha_2'=>$_fecha_revision_2,'fecha_3'=>$_fecha_revision_3);
				$this->model->InsertFechaRevisionAccion($data_fecha);
				//---------------------------------------------------//
			}
			if($this->model->InsertRelacionPlanAccion($idAccion,$idPlanAccion) &&
				$this->model->InsertRelacionMetodologiaAccion($idAccion,$causa)){
				$nombreD=$this->nombre;
				$tipoAccion=$this->input->post('nombreTipoN');
				$nombreProceso=$this->input->post('procesoN');
				$cuerpo='Plan de acción #'.$idAccion.' fue agregado por '.$nombreD.', por favor revisar.';
				$sujeto='Plan de acción '.$tipoAccion.'-'.$nombreProceso.' #'.$idAccion.' fue agregado.';
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}		
				}catch(Exception $e){

				}
				$this->session->set_userdata('mensaje','Plan de accion agregado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar el plan de accion');
			}
		}
		redirect('calidad/planAccion');
	}
	/**
	 * [seguimientoAccion este metodo es un submenu de planes de accion
	 * el cual carga todos los planes de accion existentes en la bd]
	 * @return [type] [description]
	 */
	public function seguimientoAccion()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->validateDelete()==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['procesos']=$this->model->getProceso();
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['option']=$this->validateDelete();
		//------------------------------------------------//
		$data['contenidoaccion']=$this->model->getContenidoAccion();
		$data['inf']=$this->model->getInformacionSeguimientoAccion();
		$data['norma']=$this->model->getNormas();
		$data['plan']=$this->model->getPlanAccion();
		$data['conclusion']=$this->model->getConclusionAccion();
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['title']='Seguimiento de las acciones';
		$data['content']='view_list_seguimientoAccion';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editInfSeguimientoAccion este metodo actualiza la informacion
	 * documentada del seguiento de las acciones]
	 * @return [type] [description]
	 */
	public function editInfSeguimientoAccion()
	{
		if($this->validateDelete()!=1){
			redirect('calidad');
		}

		$codigo=$this->input->post('codigoAccion');
		$idProceso=$this->input->post('idProceso');
		$version=$this->input->post('version');
		$fechaV=$this->input->post('fechaV');
		if(isset($codigo) && isset($idProceso) && isset($version) && isset($fechaV)){
			$data=array('codigo'=>$codigo,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaV);
			if($this->model->editInfSeguimientoAccion($data)){
				$this->session->set_userdata('mensaje','Información editada con éxito ');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la información');
			}
		}
		redirect('calidad/seguimientoAccion');
	}
	/**
	 * Description
	 * @return type
	 */
	public function editInfSolicitudCambio()
	{
		if($this->validateDelete()!=1){
			redirect('calidad');
		}

		$codigo=$this->input->post('codigoAccion');
		$idProceso=$this->input->post('idProceso');
		$version=$this->input->post('version');
		$fechaV=$this->input->post('fechaV');
		if(isset($codigo) && isset($idProceso) && isset($version) && isset($fechaV)){
			$data=array('codigo'=>$codigo,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaV);
			if($this->model->editInfSolicitudCambio($data)){
				$this->session->set_userdata('mensaje','Información editada con éxito ');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la información');
			}
		}
		redirect('calidad/solicitudCambio');
	}
	/**
	 * [editInfMedicion description]
	 * @return [type] [description]
	 */
	public function editInfMedicion()
	{
		if($this->validateDelete()!=1){
			redirect('calidad');
		}

		$codigo=$this->input->post('codigoIndicador');
		$idProceso=$this->input->post('idProceso');
		$version=$this->input->post('version');
		$fechaV=$this->input->post('fechaVigencia');
		if(isset($codigo) && isset($idProceso) && isset($version) && isset($fechaV)){
			$data=array('codigo'=>$codigo,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaV);
			if($this->model->editInfMedicionIndicador($data)){
				$this->session->set_userdata('mensaje','Información editada con éxito ');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la información');
			}
		}
		redirect('calidad/medicionCalidad');
	}
	/**
	 * [editInfPlanAccion description]
	 * @return [type] [description]
	 */
	public function editInfPlanAccion()
	{
		if($this->validateDelete()!=1){
			redirect('calidad');
		}

		$codigo=$this->input->post('codigoAccion');
		$idProceso=$this->input->post('codigoProcesoInf');
		$version=$this->input->post('version');
		$fechaV=$this->input->post('fechaVigencia');
		if(isset($codigo) && isset($idProceso) && isset($version) && isset($fechaV)){
			$data=array('codigo'=>$codigo,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaV);
			if($this->model->editInfPlanAccion($data)){
				$this->session->set_userdata('mensaje','Información editada con éxito ');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la información');
			}
		}
		redirect('calidad/planAccion');
	}
	/**
	 * [editInfComiteCalidad description]
	 * @return [type] [description]
	 */
	public function editInfComiteCalidad()
	{
		if($this->validateDelete()!=1){
			redirect('calidad');
		}
		$codigo=$this->input->post('codigoAccionInf');
		$idProceso=$this->input->post('codigoProcesoInf');
		$version=$this->input->post('versionInf');
		$fechaV=$this->input->post('fechaVigenciaInf');
		if(isset($codigo) && isset($idProceso) && isset($version) && isset($fechaV)){
			$data=array('codigo'=>$codigo,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaV);
			if($this->model->editInfComiteCalidad($data)){
				$this->session->set_userdata('mensaje','Información editada con éxito ');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la información');
			}
		}
		redirect('calidad/comiteCalidad');
	}
	/**
	 * [verMedicion description]
	 * @param  [type] $id [id indicador]
	 * @return [type]     [description]
	 */
	public function verMedicion($id)
	{
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1 || $this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		
		$data['userCargo']=$this->model->getUserCargo();
		$data['responsableG']=$this->model->getResponsableGestionar('',$id);
		$data['fichaIndicador']=$this->model->getFichaIndicadorId($id);
		$data['indicador']=$this->model->getIndicadorId($data['fichaIndicador']->idIndicador);
		$data['max_id']=$this->model->getMaxIdIndicador($data['fichaIndicador']->idPR);
		$data['comportamiento']=$this->model->getComportamientoIndicador($id);
		$data['retorno']=base_url().'calidad/verListMedicion/'.$data['fichaIndicador']->idIndicador;
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['title']='Indicadores de gestión CRM';
		$data['content']='view_medicionCalidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function buildSeguimientoMedicion($id)
	{
		$this->validateGet($id);

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->validateDelete()!=1) {
			redirect('calidad');
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$data['fichaIndicador']=$this->model->getFichaIndicadorId($id);
		if($data['fichaIndicador']==false) redirect('calidad');
		$this->session->set_userdata('mensaje','');
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		
		$data['userCargo']=$this->model->getUserCargo();
		$data['responsableG']=$this->model->getResponsableGestionar('',$id);
		$data['indicador']=$this->model->getIndicadorId($data['fichaIndicador']->idIndicador);
		$data['comportamiento']=$this->model->getComportamientoIndicador($id);
		$data['retorno']=base_url().'calidad/verListMedicion/'.$data['fichaIndicador']->idIndicador;
		//-----Valida que el usuario tenga privilegios----------------//
		//-----de administrador y su cargo sea director de calidad----//
		$data['title']='Indicadores de gestión CRM';
		$data['content']='view_build_seguimiento_medicionCalidad';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [editMedicion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editMedicion($id)
	{
		$this->validateGet($id);
		$data['fichaIndicador']=$this->model->getFichaIndicadorId($id);
		if($data['fichaIndicador']!=FALSE){
			/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
			if ($this->validateDelete()==1) {
					$data['barra_superior']=TRUE;
				}else{
					$data['barra_superior']=FALSE;	
				}
			$data['folderD']=$this->folderD;
			$data['folderDO']=$this->folderDO;
			$data['id']=$id;
			$data['userCargo']=$this->model->getUserCargo();
			$data['responsableG']=$this->model->getResponsableGestionar('',$id);
			$data['indicador']=$this->model->getIndicadorId($data['fichaIndicador']->idIndicador);
			$data['comportamiento']=$this->model->getComportamientoIndicador($id);
			$data['retorno']=base_url().'calidad/verMedicion/'.$id;
			$data['tipoaccion']=$this->model->tipoAccionMedicion();
			$data['title']='Edit indicadores de gestión CRM';
			$data['content']='view_editMedicionCalidad';
			$this->load->vars($data);
			$this->load->view('template');
		}else{
			redirect('');
		}
	}
	/**
	 * [updateMedicion Este metodo actualiza 
	 * los datos de la medicion]
	 * @return [type] [description]
	 */
	public function updateMedicion()
	{
		$this->validateUsuarioProceso();
		$idFicha=$this->input->post('idFichaIndicador');
		//-----Informacion documentacion---------------------//
		$idIndicador=$this->input->post('idIndicador');
		$codigoIndicador=$this->input->post('codigoIndicador');
		$version=$this->input->post('version');
		$fechaVigencia=$this->input->post('fechaVigencia');
		//------------------------------------------------//

		//----------Comportamiento indicador---------//
		$idComportamiento=$this->input->post('idComportamiento');
		$fechaMedicion=$this->input->post('fechaM');
		$periodo1=$this->input->post('periodo1');
		$periodo2=$this->input->post('periodo2');
		$meta=$this->input->post('meta');
		$numerador=$this->input->post('numerador');
		$denominador=$this->input->post('denominador');
		$resultado=$this->input->post('resultado');
		//--------------------------------------------//
		//-----------analisis medicion indicador---//
		$idAnalisis=$this->input->post('idAnalisis');
		$analisis=$this->input->post('analisis');
		$accion=$this->input->post('accion');
		$idAccion=$this->input->post('idAccion');
		//-----------------------------------------//
		$nombreProceso=$this->input->post('nombreProceso');
		$nombreIndicador=$this->input->post('nombreIndicador');
		if
		(
			isset($fechaMedicion)&&isset($periodo1)&&isset($periodo2)&&
			isset($numerador)&&isset($denominador)&&isset($resultado)&&isset($analisis)&&isset($accion)&&isset($idComportamiento)
		){
			//----------------------------------------------------------------//
			$index=count($fechaMedicion)-count($idComportamiento);
			if($index>0){
				$inicio=(count($fechaMedicion)-$index)+1;
				$fin=$index+count($idComportamiento);
			//----------------------------------------------------------------//
			$meta=$this->input->post('meta');
			if(isset($meta)){
					$idComportamientoNew=$this->model->addComportamientoIndicadorNew($inicio,$fin,$fechaMedicion,$periodo1,$periodo2,$meta,$numerador,$denominador,$resultado);
					$idAnalisisNew=$this->model->addAnalisisIndicadorNew($inicio,$fin,$periodo1,$periodo2,$analisis,$accion,$idAccion);
					$this->model->addIndicadorComportamientoNew($inicio,$fin,$idFicha,$idComportamientoNew,$idAnalisisNew);
				}
			}
			//------------------identificacion documentacion---------------------//
			if(isset($idFicha)&&isset($codigoIndicador)&&isset($version)&&
			isset($fechaVigencia)){
				$resFicha=false;
				$data=array('codigoIndicador'=>$codigoIndicador,'version'=>$version,'fechaVigencia'=>$fechaVigencia);
				if($this->model->updateFichaIndicador($data,$idFicha)){
					$resFicha=true;
				}
			}  
			//----------------------------------------------------------------//
			if($this->model->updateAnalisisIndicador($idAnalisis,$periodo1,$periodo2,$analisis,$accion,$idAccion)&&$this->model->updateComportamientoIndicador($idComportamiento,$fechaMedicion,$periodo1,$periodo2,$numerador,$denominador,$resultado)){
				$this->session->set_userdata('mensaje','Medicion editada con exito');
				//---------------------
				$cuerpo='Medicion de indicador '.$nombreIndicador.' proceso '.$nombreProceso.',fue editado por '.$this->nombre.', por favor revisar.';
				$sujeto='Medicion de indicador '.$nombreIndicador.'-'.$nombreProceso.' fue editado.';
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}		
				}catch(Exception $e){

				}
				
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la medicion');
			}
		}
		redirect('calidad/verMedicion/'.$idFicha);
	}
	/**
	 * [verListMedicion description]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function verListMedicion($id)
	{
		$this->validateGet($id);
		if ($this->tipoUsuario==1||$this->tipoUsuario==3) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		//$totalRows=$this->model->numberRowsMedicionId($id);
		//$rows=$this->arrayRows($totalRows);
		//$data['rows']=$rows;
		$data['list']=$this->model->getListFichaIndicador($id);
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['comportamiento']=$this->model->getComportamientoIndicador();
		//$data['comportamiento']=$this->model->getComportamientoIndicador($id,max($rows),0);
		$data['option']=$this->validateDelete();
		$data['procesosUsuario']=$this->model->getProcesoUser($this->idUsuario);
		$data['id']=$id;
		$data['retorno']=base_url().'calidad/medicionCalidad';
		$data['title']='Indicadores de gestión CRM';
		$data['content']='view_listIndicador';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [addSeguientoMedicion description]
	 */
	public function addSeguientoMedicion()
	{
		if($this->validateDelete()!=1)
			redirect('calidad');
		$id_comportamiento=$this->input->post('id_comportamiento');
		$nombreProceso=$this->input->post('nombreProceso');
		$idProceso=$this->input->post('idProceso');
		$nombreIndicador=$this->input->post('nombreIndicador');
		$estado=$this->input->post('estado');
		$comentario=$this->input->post('comentario');
		if(isset($id_comportamiento) && isset($nombreProceso) && isset($idProceso) && isset($nombreIndicador) && isset($estado) && isset($comentario)){
			$data = array('estado' =>$estado );
			if($this->model->updateEstadoMedicion($data,$id_comportamiento)){
				$usersP=$this->model->getUserProceso($idProceso);
				try{
					$sujeto='Seguimiento Medicion de indicador '.$nombreIndicador.' proceso '.$nombreProceso.'';
					if($estado==0){
						$cuerpo='Medicion de indicador '.$nombreIndicador.' proceso '.$nombreProceso.' no fue aprobado. <br>Comentarios:<br>'.$comentario.'';
					}else{
						$cuerpo='Medicion de indicador '.$nombreIndicador.' proceso '.$nombreProceso.' fue aprobado. <br>Comentarios:<br>'.$comentario.'';
					}
					if($usersP!=false){
						foreach ($usersP as $value_u) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}
				}catch(Exception $e){

				}
				$this->session->set_userdata('mensaje','Seguimiento enviado con éxito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo enviar el seguimiento');
			}
		}
		redirect('calidad/medicionCalidad');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function inactivateMedicion($id)
	{
		$this->validateGet($id);
		$this->validateUsuarioProceso();
		$fichaIndicador=$this->model->getComportamientoIndicador($id);
		if($fichaIndicador!=false){
			$respuesta=$this->model->eliminarTabla('relacionindicadorcomportamiento',$id,'codigoFichaIndicador');
			if ($respuesta){
				foreach ($fichaIndicador as $value) {
					$respuesta=$this->model->eliminarTabla('comportamientoindicador',$value->idComportamiento,'idComportamiento');
					if($respuesta){
						$respuesta=$this->model->eliminarTabla('analisisindicador',$value->idAnalisis,'idAnalisis');
					}
				}
				$respuesta=$this->model->eliminarTabla('fichatecnicaindicador',$id,'idFichaIndicador');
			}

		}
		if ($respuesta) {
			$this->session->set_userdata('mensaje','Medicion eliminada con exito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar la medicion');
		}
		redirect('calidad/medicionCalidad');
	}
	/**
	 * [arrayRows description]
	 * @param  [type] $totalRows [description]
	 * @return [type]            [description]
	 */
	private function arrayRows($totalRows)
	{
		$array=false;
		if($totalRows!=false){
			switch ($totalRows) {
				case ($totalRows>=1 && $totalRows<=10):
					$array=array(10);
					break;
				case ($totalRows>=11 && $totalRows<=20):
					$array=array(10,20);
					break;
				case ($totalRows>=21 && $totalRows<=30):
					$array=array(10,20,30);
					break;
				case ($totalRows>=31 && $totalRows<=40):
					$array=array(10,20,30,40);
					break;
				case ($totalRows>=41 && $totalRows<=50):
					$array=array(10,20,30,40,50);
					break;
				case ($totalRows>=51 && $totalRows<=60):
					$array=array(10,20,30,40,50,60);
					break;
				case ($totalRows>=61 && $totalRows<=70):
					$array=array(10,20,30,40,50,60,70);
					break;
				case ($totalRows>=71 && $totalRows<=80):
					$array=array(10,20,30,40,50,60,70,80);
					break;
				case ($totalRows>=81 && $totalRows<=90):
					$array=array(10,20,30,40,50,60,70,80,90);
					break;
				case ($totalRows>=91 && $totalRows<=100):
					$array=array(10,20,30,40,50,60,70,80,90,100);
					break;
			}
		}
		return $array;
	}
	/**
	 * [buildMedicionIndicador description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function buildMedicionIndicador($id)
	{
		$this->validateGet($id);
		$data['indicador']=$this->model->getIndicadorId($id);
		if(!empty($data['indicador'])){
			/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
			if ($this->validateDelete()==1) {
				$data['barra_superior']=TRUE;
			}else{
				$data['barra_superior']=FALSE;	
			}
			$data['option']=$this->validateDelete();
			$data['inf']=$this->model->getInformacionMedicion();
			$data['procesos']=$this->model->getProceso();
			$data['mensaje']=$this->session->userdata('mensaje');
			$this->session->set_userdata('mensaje','');
			$data['folderD']=$this->folderD;
			$data['folderDO']=$this->folderDO;
			$data['idIndicador']=$id;
			$data['indicador']=$this->model->getIndicadorId($id);
			$data['userCargo']=$this->model->getUserCargo();
			$data['responsableG']=$this->model->getResponsableGestionar('',$id);
			$data['retorno']=base_url().'calidad/medicionCalidad';
			$data['encabezadoFicha']=$this->model->getEncabezadoMedicion();
			$data['tipoaccion']=$this->model->tipoAccionMedicion();
			$data['comportamiento']=$this->model->getComportamientoIndicador($id);
			$data['title']='Ficha técnica de indicadores';
			$data['content']='view_buildMedicion';
			$this->load->vars($data);
			$this->load->view('template');
		}else{
			redirect('');
		}
	}
	/**
	 * [addMedicion este metodo agrega una nueva medicion del indicador recibido]
	 */
	public function addMedicion()
	{
		$this->validateSession();
		//-----Informacion documentacion---------------------//
		$idIndicador=$this->input->post('idIndicador');
		$codigoIndicador=$this->input->post('codigoIndicador');
		$idProceso=$this->input->post('idProceso');
		$version=$this->input->post('version');
		$fechaVigencia=$this->input->post('fechaVigencia');
		//------------------------------------------------//
		//---------Informacion fichaIndicador--------//
		$idProcesoInf=$this->input->post('idProcesoInf');
		$nombreIndicador=$this->input->post('nombreIndicador');
		$frecuencia=$this->input->post('frecuencia');
		$objetivo=$this->input->post('objetivo');
		$medir=$this->input->post('medir');
		$gestionar=$this->input->post('gestionar');
		$numeradorF=$this->input->post('numeradorF');
		$denominadorF=$this->input->post('denominadorF');
		$unidad=$this->input->post('unidad');
		$nombreProceso=$this->input->post('nombreProceso');
		//--------------------------------------------//
		//----------Comportamiento indicador---------//
		$fechaMedicion=$this->input->post('fechaM');
		$periodo1=$this->input->post('periodo1');
		$periodo2=$this->input->post('periodo2');
		$meta=$this->input->post('meta');
		$numerador=$this->input->post('numerador');
		$denominador=$this->input->post('denominador');
		$resultado=$this->input->post('resultado');
		//--------------------------------------------//
		//-----------analisis medicion indicador---//
		$analisis=$this->input->post('analisis');
		$accion=$this->input->post('accion');
		$idAccion=$this->input->post('idAccion');
		//-----------------------------------------//
		if
		(
			isset($idIndicador)&&isset($codigoIndicador)&&isset($idProceso)&&isset($version)&&
			isset($fechaVigencia)&&isset($fechaMedicion)&&isset($periodo1)&&isset($periodo2)&&
			isset($numerador)&&isset($denominador)&&isset($resultado)&&isset($analisis)&&isset($accion)
		){
			$data=array('codigoIndicador'=>$codigoIndicador,'codigoProceso'=>$idProceso,'version'=>$version,'fechaVigencia'=>$fechaVigencia,'idIndicador'=>$idIndicador,'codigoProcesoInf'=>$idProcesoInf,'nombreIndicador'=>$nombreIndicador,'frecuencia'=>$frecuencia,'objetivo'=>$objetivo,'nombreCargoMedicion'=>$medir,'nombreCargoGestion'=>$gestionar,'numeradorFormula'=>$numeradorF,'denominadorFormula'=>$denominadorF,'unidad'=>$unidad);
			$idFichaIndicador=$this->model->addFichaIndicador($data);
			$idComportamiento=$this->model->addComportamientoIndicador($fechaMedicion,$periodo1,$periodo2,$meta,$numerador,$denominador,$resultado);
			$idAnalisis=$this->model->addAnalisisIndicador($periodo1,$periodo2,$analisis,$accion,$idAccion);
			if($this->model->addIndicadorComportamiento($idFichaIndicador,$idComportamiento,$idAnalisis)){

//--Notificacion director calidad
		try{
			$cuerpo='Medicion de indicador '.$nombreIndicador.' proceso '.$nombreProceso.',fue agregada por '.$this->nombre.', por favor revisar.';
			$sujeto='Medicion de indicador '.$nombreIndicador.'-'.$nombreProceso.' fue agregada.';
			$users=$this->model->getUsers();
			foreach ($users as $value_u) {
				if ($value_u->codigoCargo==15) {
					$nombre=$value_u->nombre;
					$email=$value_u->email;
					$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
				}
			}
			$this->session->set_userdata('mensaje','Medicion agregada con exito');
		}catch(Exception $e){
				$this->session->set_userdata('mensaje','Medicion agregada con exito. Error al enviar notificación');
		}	
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar la medicion');
			}
		}
		redirect('calidad/verListMedicion/'.$idIndicador);
	}
	/**
	 * [addSolicitudCambio description]
	 */
	public function addSolicitudCambio()
	{
		$this->validateUsuarioProceso();
		//-----Informacion documentacion---------------------//
		$codigoInf=$this->input->post('codigoAccionInf');
		$idProcesoInf=$this->input->post('codigoProcesoInf');
		$versionInf=$this->input->post('versionInf');
		$fechaVigenciaInf=$this->input->post('fechaVigenciaInf');
		//------------------------------------------------//
		//-----------------Solicitud de cambio-----------------------------------//
		$fecha=$this->input->post('fecha');
		$tipo_solicitud=$this->input->post('tipo_solicitud');
		$proceso=$this->input->post('proceso');
		$solicitante=$this->input->post('solicitante');
		$cargo_solicitante=$this->input->post('cargo_solicitante');
		$tipo_documento=$this->input->post('tipo_documento');
		$nombre_documento=$this->input->post('nombre_documento');
		$codigo_documento=$this->input->post('codigo_documento');
		$version_documento=$this->input->post('version_documento');
		$fechaV_documento=$this->input->post('fechaV_documento');
		$descripcion_solicitud=$this->input->post('descripcion_solicitud');
		$justificacion_solicitud=$this->input->post('justificacion_solicitud');
		if (isset($codigoInf) && isset($idProcesoInf) && isset($versionInf) && isset($fechaVigenciaInf) 
			&& isset($fecha) && isset($tipo_solicitud) && isset($proceso) && isset($solicitante)
			&& isset($cargo_solicitante) && isset($tipo_documento) && isset($nombre_documento)
			&& isset($codigo_documento) && isset($version_documento) && isset($fechaV_documento)
			&& isset($descripcion_solicitud) && isset($justificacion_solicitud)) {
			$data=array('fechaSolicitud'=>$fecha,'codigoTipoSolicitud'=>$tipo_solicitud,'codigoProceso'=>$proceso,
			'codigoSolicitante'=>$solicitante,'codigoTipoDocumento'=>$tipo_documento,'nombreDocumento'=>$nombre_documento,
			'codigoDocumento'=>$codigo_documento,'version'=>$version_documento,'fechaVigencia'=>$fechaV_documento,'descripcion'=>$descripcion_solicitud,
			'justificacion'=>$justificacion_solicitud,
			'codigoSolicitudInf'=>$codigoInf,
			'codigoProcesoInf'=>$idProcesoInf,
			'versionInf'=>$versionInf,
			'fechaVigenciaInf'=>$fechaVigenciaInf,
			'codigoEstado'=>1
		);
			if($this->model->addSolicitudCambio($data)){
				$this->session->set_userdata('mensaje','Solicitud agregada con exito');
				//---------------------------------------------------------------------//
				$nombreProceso=$this->input->post('procesoN');
				$nombreSolicitud=$this->input->post('nombre_solicitudN');
				$nombre_documentoN=$this->input->post('nombre_documentoN');
				$cuerpo='Solicitud de '.$nombreSolicitud.'-'.$nombre_documentoN.' proceso '.$nombreProceso.',fue agregado por '.$this->nombre.', por favor revisar.';
				$sujeto='Solicitud de '.$nombreSolicitud.' '.$nombre_documentoN.'-'.$nombreProceso.' fue agregado.';
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}		
				}catch(Exception $e){
					redirect('calidad/solicitudCambio');
				}
				
				//--------------------------------------------------------------------//
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar la solicitud');
			}
		}
		redirect('calidad/solicitudCambio');
	}
	/**
	 * [updateSolicitudCambio description]
	 * @return [type] [description]
	 */
	public function updateSolicitudCambio()
	{
		$this->validateUsuarioProceso();
		//-----------------Solicitud de cambio-----------------------------------//
		$idSolicitud=$this->input->post('idSolicitud');
		$fecha=$this->input->post('fecha');
		$tipo_solicitud=$this->input->post('tipo_solicitud');
		$solicitante=$this->input->post('solicitante');
		$cargo_solicitante=$this->input->post('cargo_solicitante');
		$tipo_documento=$this->input->post('tipo_documento');
		$nombre_documento=$this->input->post('nombre_documento');
		$codigo_documento=$this->input->post('codigo_documento');
		$version_documento=$this->input->post('version_documento');
		$fechaV_documento=$this->input->post('fechaV_documento');
		$descripcion_solicitud=$this->input->post('descripcion_solicitud');
		$justificacion_solicitud=$this->input->post('justificacion_solicitud');
		if (isset($fecha) && isset($tipo_solicitud) && isset($solicitante)
			&& isset($cargo_solicitante) && isset($tipo_documento) && isset($nombre_documento)
			&& isset($codigo_documento) && isset($version_documento) && isset($fechaV_documento)
			&& isset($descripcion_solicitud) && isset($justificacion_solicitud)) {
			$data=array('fechaSolicitud'=>$fecha,'codigoTipoSolicitud'=>$tipo_solicitud,
			'codigoSolicitante'=>$solicitante,'codigoTipoDocumento'=>$tipo_documento,'nombreDocumento'=>$nombre_documento,
			'codigoDocumento'=>$codigo_documento,'version'=>$version_documento,'fechaVigencia'=>$fechaV_documento,'descripcion'=>$descripcion_solicitud,
			'justificacion'=>$justificacion_solicitud);
			if($this->model->editSolicitudCambio($data,$idSolicitud)){
				$this->session->set_userdata('mensaje','Solicitud #'.$idSolicitud.' editada con exito');
				//---------------------------------------------------------------------//
				$nombreProceso=$this->input->post('procesoN');
				$nombreSolicitud=$this->input->post('nombre_solicitudN');
				$nombre_documentoN=$this->input->post('nombre_documentoN');
				$cuerpo='Solicitud de '.$nombreSolicitud.'-'.$nombre_documentoN.' proceso '.$nombreProceso.',fue editada por '.$this->nombre.', por favor revisar.';
				$sujeto='Solicitud de '.$nombreSolicitud.' '.$nombre_documentoN.'-'.$nombreProceso.' fue editada.';
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}		
				}catch(Exception $e){

				}
				//--------------------------------------------------------------------//
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la solicitud #'.$idSolicitud.'');
			}
			var_dump($idSolicitud);
		}
		redirect('calidad/solicitudCambio');
	}
	/**
	 * [directrizGestionCalidad description]
	 * @return [type] [description]
	 */
	public function directrizGestionCalidad(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/directrizGestionCalidad/';		
		        $config['total_rows'] =$this->model->numberRowsDirectriz(1);           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);

		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['indicador']=$this->model->getIndicadorCalidad(1,$limit,$start);
		$data['directriz']=$this->model->getDirectriz1(1,$limit,$start);
		$data['proceso']=$this->model->getProcesoDirectriz(1);
		$data['procesos']=$this->model->getProcesoDis(1);
		$data['title']='Directrices de gestión';
		$data['content']='view_directriz';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [directrizGestionCalidad description]
	 * @return [type] [description]
	 */
	public function directrizGestionCalidadSST(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/directrizGestionCalidadSST/';		
		        $config['total_rows'] =$this->model->numberRowsDirectriz(2);           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);

		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['indicador']=$this->model->getIndicadorCalidad(2,$limit,$start);
		$data['directriz']=$this->model->getDirectriz1(2,$limit,$start);
		$data['proceso']=$this->model->getProcesoDirectriz(2);
		$data['procesos']=$this->model->getProceso();
		$data['title']='Directrices de gestión SST';
		$data['content']='view_directrizSST';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Description
	 * @return type
	 */
	public function indicadorGestionSST(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/indicadorGestionSST/';		
		        $config['total_rows'] =$this->model->numberRowsIndicador(2);           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$this->folder;
		$data['cargo']=$this->model->getCargo();
		$data['simbolo']=$this->model->getSimbolo();
		$data['medicion']=$this->model->getMedicion();
		$data['tipoIndicador']=$this->model->getTipoIndicador();
		$data['procesos']=$this->model->getProcesoUser($this->idUsuario);
		$data['recursos']=$this->model->getRecursos();
		$data['indicador']=$this->model->getIndicadorCalidad(2,$limit,$start);
		$data['directriz']=$this->model->getDirectriz1(2);
		$data['recursos']=$this->model->getRecursos();
		$data['recursosInd']=$this->model->getRecursosIndicador();
		$data['responsableG']=$this->model->getResponsableGestionar(2);
		$data['title']='Indicadores de gestión SST';
		$data['content']='view_indicadorSST';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la mision de la base de datos
	 * y envia los datos a la vista. 
	 */
	public function mision(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=1;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['mision']=$this->model->getMision();
		$data['title']='MISIÓN DE CRM';
		$data['content']='view_mision';
		$this->load->vars($data);
		$this->load->view('template');
	}
	public function downloadPdf($id)
	{
		if($this->input->post('img')){
			$img=$this->input->post('img');
			$this->session->set_userdata('img',$img);
		}
		if($this->input->post('imgPie')){
			$imgPie=$this->input->post('imgPie');
			$this->session->set_userdata('imgPie',$imgPie);
		}
		if($this->input->post('imgLinea')){
			$imgLinea=$this->input->post('imgLinea');
			$this->session->set_userdata('imgLinea',$imgLinea);
		}
		$this->validateSession();
		$this->validateGet($id);
		$this->validateActa($id);
		echo $this->pdfm->createPdf($id);
	}
	public function deleteAsistente()
	{
		$this->validateUsuario();
		$id=$this->input->post('idA');
		if (isset($id)) {
			$this->model->deleteAsistente($id);
		}
	}
	public function deleteSubtitulo()
	{
		$this->validateUsuario();
		$id=$this->input->post('idSubtitulo');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'idSubtituloActa','subtitulo');
		}
	}
	public function deleteEncabezado()
	{
		$this->validateUsuario();
		$id=$this->input->post('idEncabezado');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'idEncabezadoActa','encabezado');
		}
	}
	public function deleteTexto()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTexto');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'idTextoActa','texto');
		}
	}
	public function deleteImg()
	{
		$this->validateUsuario();
		$currentsite = getcwd();
		$id=$this->input->post('idImg');	
		$idActa=$this->input->post('idActa');
		$modulo=$this->input->post('index');
		$nameImg=$this->input->post('nameImg');	
		if (isset($id)&& isset($idActa)&&isset($modulo)&&isset($nameImg)) {
			$res1=$this->model->validateImg($nameImg,$modulo,'imagentexto');
			$res2=$this->model->validateImg($nameImg,$modulo,'textoimagen');
			if(!$res1 && !$res2){
				$name=$currentsite.'/img/Acta/acta_'.$idActa.'/modulo_'.$modulo.'/'.$nameImg;
				unlink($name);
			}
			$this->model->deleteTableActa($id,'idImgActa','imgActa');
		}
	}
	public function deleteTextoImg()
	{
		$this->validateUsuario();
		$currentsite = getcwd();
		$id=$this->input->post('idTextoImg');	
		$idActa=$this->input->post('idActa');
		$modulo=$this->input->post('index');
		$nameImg=$this->input->post('nameTextoImg');	
		if (isset($id)&& isset($idActa)&&isset($modulo)&&isset($nameImg)) {
			$res1=$this->model->validateImg($nameImg,$modulo,'imgacta');
			$res2=$this->model->validateImg($nameImg,$modulo,'imagentexto');
			if(!$res1 && !$res2){
				$name=$currentsite.'/img/Acta/acta_'.$idActa.'/modulo_'.$modulo.'/'.$nameImg;
				unlink($name);
			}
			$this->model->deleteTableActa($id,'idTextoImagenActa','textoimagen');
		}
	}
	public function deleteImgTexto()
	{
		$this->validateUsuario();
		$currentsite = getcwd();
		$id=$this->input->post('idImgTexto');	
		$idActa=$this->input->post('idActa');
		$modulo=$this->input->post('index');
		$nameImg=$this->input->post('nameImgTexto');	
		if (isset($id)&& isset($idActa)&&isset($modulo)&&isset($nameImg)) {
			$res1=$this->model->validateImg($nameImg,$modulo,'imgacta');
			$res2=$this->model->validateImg($nameImg,$modulo,'textoimagen');
			if(!$res1 && !$res2){
				$name=$currentsite.'/img/Acta/acta_'.$idActa.'/modulo_'.$modulo.'/'.$nameImg;
				unlink($name);
			}	
			$this->model->deleteTableActa($id,'idImagenTextoActa','imagentexto');
		}
	}
	public function deleteTableTwo()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableTwo');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filaTwo');
			$this->model->deleteTableActa($id,'idTableTwo','tabletwo');
		}
	}
	public function deleteTableThree()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableThree');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filaThree');
			$this->model->deleteTableActa($id,'idTableThree','tablethree');
		}
	}
	public function deleteTableFour()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableFour');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filafour');
			$this->model->deleteTableActa($id,'idTableFour','tablefour');
		}
	}
	public function deleteTableFive()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableFive');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filafive');
			$this->model->deleteTableActa($id,'idTableFive','tablefive');
		}
	}
	public function deleteTableSix()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableSix');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filaSix');
			$this->model->deleteTableActa($id,'idTableSix','tableSix');
		}
	}
	public function deleteTableSeven()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableSeven');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filaSeven');
			$this->model->deleteTableActa($id,'idTableSeven','tableSeven');
		}
	}
	public function deleteGraphic()
	{
		$this->validateUsuario();
		$id=$this->input->post('idGraphic');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoGraphic','filagraphic');
			$this->model->deleteTableActa($id,'idGraphic','graphic');
		}
	}
	public function deleteFilaTwo()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableTwo');
		$idF=$this->input->post('idFilaTwo');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filatwo',$idF,'idFila');
		}
	}
	public function deleteFilaThree()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableThree');
		$idF=$this->input->post('idFilaThree');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filathree',$idF,'idFilaThree');
		}
	}
	public function deleteFilaFour()
	{
		$this->validateUsuario();
		$id=$this->input->post('idTableFour');
		$idF=$this->input->post('idFilaFour');
		if (isset($id)) {
			$this->model->deleteTableActa($id,'codigoTable','filafour',$idF,'idFilaFour');
		}
	}
	public function editActa($id)
	{
		$this->validateSession();
		$this->validateUsuario();
		$this->validateGet($id);
		$this->validateActa($id);
		//////////////////////////
		$tabla=9;
		$idActa=$id;
		$builActa=array();
		$tipo=array();
		$data['modulo']=$this->model->getModulesActa();
		$subtitulo=$this->model->getSubtituloActa($idActa);
		$texto=$this->model->getTextoActa($idActa);
		$img=$this->model->getImgActa($idActa);
		$textoImg=$this->model->getTextoImgActa($idActa);
		$imgTexto=$this->model->getImgTextoActa($idActa);
		$tableTwo=$this->model->getTableTwoActa($idActa);
		$tableThree=$this->model->getTableThreeActa($idActa);
		$tableFour=$this->model->getTableFourActa($idActa);
		$tableFive=$this->model->getTableFiveActa($idActa);
		$tableSix=$this->model->getTableSixActa($idActa);
		$tableSeven=$this->model->getTableSevenActa($idActa);
		$graphic=$this->model->getGraphicActa($idActa);
		$data['encabezado']=$this->model->getEncabezadoActa($idActa);
		$filaTwo=array();
		$filaThree=array();
		$filaFour=array();
		$filaFive=array();
		$filaSix=array();
		$filaSeven=array();
		$filaGraphic=array();
		$filaGraphicPie=array();
		$filaGraphicLinea=array();
		$tipoId=array();
		foreach ($data['modulo'] as $value) {
			if(count($subtitulo)>=1 && $subtitulo!=FALSE){
				foreach ($subtitulo as $sub) {
					if ($sub->modulo==$value->id) {
						$builActa[$value->id][$sub->ordenActa]=$sub->texto;
						$tipo[$value->id][$sub->ordenActa]='subtitulo';
						$tipoId[$value->id][$sub->ordenActa]=$sub->id;
					}
				}//fin foreach
			}
			if(count($data['encabezado'])>=1 && $data['encabezado']!=FALSE){
				foreach ($data['encabezado'] as $enc) {
					if ($enc->modulo==$value->id) {
						$builActa[$value->id][$enc->ordenActa]=$enc->texto;
						$tipo[$value->id][$enc->ordenActa]='encabezado';
						$tipoId[$value->id][$enc->ordenActa]=$enc->id;
					}
				}//fin foreach
			}
			if(count($texto)>=1 && $texto!=FALSE){
				foreach ($texto as $tex) {
					if ($tex->modulo==$value->id) {
						$builActa[$value->id][$tex->ordenActa]=$tex->texto;
						$tipo[$value->id][$tex->ordenActa]='texto';
						$tipoId[$value->id][$tex->ordenActa]=$tex->id;
					}
				}//fin foreach
			}
			if(count($img)>=1 && $img!=FALSE){
				foreach ($img as $imagen) {
					if ($imagen->modulo==$value->id) {
						$builActa[$value->id][$imagen->ordenActa]=$imagen->img;
						$tipo[$value->id][$imagen->ordenActa]='img';
						$tipoId[$value->id][$imagen->ordenActa]=$imagen->id;
					}
				}//fin foreach
			}
			if(count($textoImg)>=1 && $textoImg!=FALSE){
				foreach ($textoImg as $textoimagen) {
					if ($textoimagen->modulo==$value->id) {
						$builActa[$value->id][$textoimagen->ordenActa]=$textoimagen->img.';'.$textoimagen->texto;
						$tipo[$value->id][$textoimagen->ordenActa]='textoImagen';
						$tipoId[$value->id][$textoimagen->ordenActa]=$textoimagen->id;
					}
				}//fin foreach
			}
			if(count($imgTexto)>=1 && $imgTexto!=FALSE){
				foreach ($imgTexto as $imagentexto) {
					if ($imagentexto->modulo==$value->id) {
						$builActa[$value->id][$imagentexto->ordenActa]=$imagentexto->img.';'.$imagentexto->texto;
						$tipo[$value->id][$imagentexto->ordenActa]='imagenTexto';
						$tipoId[$value->id][$imagentexto->ordenActa]=$imagentexto->id;
					}
				}//fin foreach
			}
			if(count($tableTwo)>=1 && $tableTwo!=FALSE){
				foreach ($tableTwo as $two) {
					if ($two->modulo==$value->id) {
						$builActa[$value->id][$two->ordenActa]=$two->col1.';'.$two->col2;
						$tipo[$value->id][$two->ordenActa]='tableTwo';
						$filaTwo[$value->id][$two->ordenActa]=$this->model->getFilaTwoActa($two->id);
						$tipoId[$value->id][$two->ordenActa]=$two->id;
					}
				}//fin foreach
			}
			if(count($tableThree)>=1 && $tableThree!=FALSE){
				foreach ($tableThree as $three) {
					if ($three->modulo==$value->id) {
						$builActa[$value->id][$three->ordenActa]=$three->col1.';'.$three->col2.';'.$three->col3;
						$tipo[$value->id][$three->ordenActa]='tableThree';
						$filaThree[$value->id][$three->ordenActa]=$this->model->getFilaThreeActa($three->id);
						$tipoId[$value->id][$three->ordenActa]=$three->id;
					}
				}//fin foreach
			}
			if(count($tableFour)>=1 && $tableFour!=FALSE){
				foreach ($tableFour as $four) {
					if ($four->modulo==$value->id) {
						$builActa[$value->id][$four->ordenActa]=$four->col1.';'.$four->col2.';'.$four->col3.';'.$four->col4;
						$tipo[$value->id][$four->ordenActa]='tableFour';
						$filaFour[$value->id][$four->ordenActa]=$this->model->getFilaFourActa($four->id);
						$tipoId[$value->id][$four->ordenActa]=$four->id;
					}
				}//fin foreach
			}
			if(count($tableFive)>=1 && $tableFive!=FALSE){
				foreach ($tableFive as $five) {
					if ($five->modulo==$value->id) {
						$builActa[$value->id][$five->ordenActa]=$five->col1.';'.$five->col2.';'.$five->col3.';'.$five->col4.';'.$five->col5;
						$tipo[$value->id][$five->ordenActa]='tableFive';
						$filaFive[$value->id][$five->ordenActa]=$this->model->getFilaFiveActa($five->id);
						$tipoId[$value->id][$five->ordenActa]=$five->id;
					}
				}//fin foreach
			}
			if(count($tableSix)>=1 && $tableSix!=FALSE){
				foreach ($tableSix as $six) {
					if ($six->modulo==$value->id) {
						$builActa[$value->id][$six->ordenActa]=$six->col1.';'.$six->col2.';'.$six->col3.';'.$six->col4.';'.$six->col5.';'.$six->col6;
						$tipo[$value->id][$six->ordenActa]='tableSix';
						$filaSix[$value->id][$six->ordenActa]=$this->model->getFilaSixActa($six->id);
						$tipoId[$value->id][$six->ordenActa]=$six->id;
					}
				}//fin foreach
			}
			if(count($tableSeven)>=1 && $tableSeven!=FALSE){
				foreach ($tableSeven as $seven) {
					if ($seven->modulo==$value->id) {
						$builActa[$value->id][$seven->ordenActa]=$seven->col1.';'.$seven->col2.';'.$seven->col3.';'.$seven->col4.';'.$seven->col5.';'.$seven->col6.';'.$seven->col7;
						$tipo[$value->id][$seven->ordenActa]='tableSeven';
						$filaSeven[$value->id][$seven->ordenActa]=$this->model->getFilaSevenActa($seven->id);
						$tipoId[$value->id][$seven->ordenActa]=$seven->id;
					}
				}//fin foreach
			}
			if(count($graphic)>=1 && $graphic!=FALSE){
				foreach ($graphic as $g) {
					if ($g->modulo==$value->id) {
						$builActa[$value->id][$g->ordenActa]=$g->tituloG.';'.$g->subtituloG.';'.$g->subtituloY.';'.$g->puntoInicial.';'.$g->tipoG.';'.$g->id;
						if($g->tipoG==1){
							$filaGraphic[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==2) {
							$filaGraphicPie[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==3) {
							$filaGraphicLinea[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
						}
						$tipo[$value->id][$g->ordenActa]='graphic';
						$tipoId[$value->id][$g->ordenActa]=$g->id;
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
		$data['buildTipoId']=$tipoId;
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/viewActa';
		$data['asistentes']=$this->model->getAsistentesActa($idActa);
		$data['actaHeader']=$this->model->getActaHeader($idActa);
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['title']='Editar Acta #'.$id.' de Revisión por la Dirección';
		$data['content']='view_editarActa';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga los datos del 
	 * formato acta de revisión por la dirección 
	 */
	public function ActaRevisionDireccion($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateActa($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=9;
		$idActa=$id;
		$data['base_url']=base_url();
		$builActa=array();
		$tipo=array();
		$data['modulo']=$this->model->getModulesActa();
		$subtitulo=$this->model->getSubtituloActa($idActa);
		$texto=$this->model->getTextoActa($idActa);
		$img=$this->model->getImgActa($idActa);
		$textoImg=$this->model->getTextoImgActa($idActa);
		$imgTexto=$this->model->getImgTextoActa($idActa);
		$tableTwo=$this->model->getTableTwoActa($idActa);
		$tableThree=$this->model->getTableThreeActa($idActa);
		$tableFour=$this->model->getTableFourActa($idActa);
		$tableFive=$this->model->getTableFiveActa($idActa);
		$tableSix=$this->model->getTableSixActa($idActa);
		$tableSeven=$this->model->getTableSevenActa($idActa);
		$graphic=$this->model->getGraphicActa($idActa);
		$data['encabezado']=$this->model->getEncabezadoActa($idActa);
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
						$filaTwo[$value->id][$two->ordenActa]=$this->model->getFilaTwoActa($two->id);
					}
				}//fin foreach
			}
			if(count($tableThree)>=1 && $tableThree!=FALSE){
				foreach ($tableThree as $three) {
					if ($three->modulo==$value->id) {
						$builActa[$value->id][$three->ordenActa]=$three->col1.';'.$three->col2.';'.$three->col3;
						$tipo[$value->id][$three->ordenActa]='tableThree';
						$filaThree[$value->id][$three->ordenActa]=$this->model->getFilaThreeActa($three->id);
					}
				}//fin foreach
			}
			if(count($tableFour)>=1 && $tableFour!=FALSE){
				foreach ($tableFour as $four) {
					if ($four->modulo==$value->id) {
						$builActa[$value->id][$four->ordenActa]=$four->col1.';'.$four->col2.';'.$four->col3.';'.$four->col4;
						$tipo[$value->id][$four->ordenActa]='tableFour';
						$filaFour[$value->id][$four->ordenActa]=$this->model->getFilaFourActa($four->id);
					}
				}//fin foreach
			}
			if(count($tableFive)>=1 && $tableFive!=FALSE){
				foreach ($tableFive as $five) {
					if ($five->modulo==$value->id) {
						$builActa[$value->id][$five->ordenActa]=$five->col1.';'.$five->col2.';'.$five->col3.';'.$five->col4.';'.$five->col5;
						$tipo[$value->id][$five->ordenActa]='tableFive';
						$filaFive[$value->id][$five->ordenActa]=$this->model->getFilaFiveActa($five->id);
					}
				}//fin foreach
			}
			if(count($tableSix)>=1 && $tableSix!=FALSE){
				foreach ($tableSix as $six) {
					if ($six->modulo==$value->id) {
						$builActa[$value->id][$six->ordenActa]=$six->col1.';'.$six->col2.';'.$six->col3.';'.$six->col4.';'.$six->col5.';'.$six->col6;
						$tipo[$value->id][$six->ordenActa]='tableSix';
						$filaSix[$value->id][$six->ordenActa]=$this->model->getFilaSixActa($six->id);
					}
				}//fin foreach
			}
			if(count($tableSeven)>=1 && $tableSeven!=FALSE){
				foreach ($tableSeven as $seven) {
					if ($seven->modulo==$value->id) {
						$builActa[$value->id][$seven->ordenActa]=$seven->col1.';'.$seven->col2.';'.$seven->col3.';'.$seven->col4.';'.$seven->col5.';'.$seven->col6.';'.$seven->col7;
						$tipo[$value->id][$seven->ordenActa]='tableSeven';
						$filaSeven[$value->id][$seven->ordenActa]=$this->model->getFilaSevenActa($seven->id);
					}
				}//fin foreach
			}
			if(count($graphic)>=1 && $graphic!=FALSE){
				foreach ($graphic as $g) {
					if ($g->modulo==$value->id) {
						$builActa[$value->id][$g->ordenActa]=$g->tituloG.';'.$g->subtituloG.';'.$g->subtituloY.';'.$g->puntoInicial.';'.$g->tipoG.';'.$g->id;
						if($g->tipoG==1){
							$filaGraphic[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==2) {
							$filaGraphicPie[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
						}elseif ($g->tipoG==3) {
							$filaGraphicLinea[$g->id][$value->id]=$this->model->getFilaGraphicActa($g->id);
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
		$data['retorno']=base_url().'calidad/viewActa';
		$data['asistentes']=$this->model->getAsistentesActa($idActa);
		$data['actaHeader']=$this->model->getActaHeader($idActa);
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['title']='Acta de Revisión por la Dirección';
		$data['content']='view_acta';
		$this->load->vars($data);
		$this->load->view('template');
	}
	public function completeActa($id)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateActaIncompleta($id);
		$this->validateUsuario();
		$tabla=9;
		$data['idActa']=$id;
		$data['base_url']=base_url();
		$data['retorno']=base_url().'calidad/viewActaIncompleta';
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['modulos']=$this->model->getModulosActa();
		$data['folder']=$tabla;
		$data['title']='Completar acta #'.$id.' de Revisión por la Dirección';
		$data['content']='view_completarActa';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo muestra
	 * las actas incompletas existentes  
	 */	
	public function viewActaIncompleta()
	{		
		$data=array();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/viewActaIncompleta/';		
		        $config['total_rows'] = $this->model->numberRowsActasIncompleta();           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);
				/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=9;
		$data['retorno']=base_url().'calidad/viewActa/';
		$data['actas']=$this->model->getActasIncompleta($limit,$start);
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['title']='Actas de Revisión por la Dirección';
		$data['content']='view_list_actaIncompleta';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo muestra
	 * las actas existentes  
	 */	
	public function viewActa()
	{		
		$data=array();
		$limit=10;
		$start=$this->uri->segment(3);
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */				
				$config['base_url'] = base_url().'calidad/viewActa/';		
		        $config['total_rows'] = $this->model->numberRowsActas();           
		        $config['per_page'] =$limit;
		       	$config['uri_segment'] = 3;
		        $config['num_links'] = 5; 
		        $config['first_link'] ='Primero';
		        $config['last_link'] = 'Ultimo';
		        $config['next_link'] = 'Siguiente'.' <i class="fa fa-arrow-circle-right"></i>';
		        $config['prev_link'] = '<i class="fa fa-arrow-circle-left"></i> '.'Anterior';	
		        $config['cur_tag_open'] = '<span>';
		        $config['cur_tag_close'] = '</span>';
		        $config['full_tag_open'] = '<div class="centered"><ul class="pagination"><li>';
		        $config['full_tag_close'] = '</li></ul></div>'; 
				/* ----------- FIN DECLARACION DE VARIABLES PARA LA PAGINACION ----------- */
		$this->pagination->initialize($config);
				/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=9;
		$data['actas']=$this->model->getActas($limit,$start);
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['title']='Actas de Revisión por la Dirección';
		$data['content']='view_list_acta';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo se encarga de enviar 
	 * datos a la vista para la construccion
	 * del formato acta de la revision
	 * por la direccion
	 */
	public function buildActa()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$data=array();
		$data['base_url']=base_url();
		$data['idActa']=$this->session->userdata('idActa');
		$data['numActa']=$this->model->getIdActa(); 
		$data['mision']=$this->model->getMision(); 
		$data['vision']=$this->model->getVision(); 
		$data['politica']=$this->model->getPolitica(); 
		$data['objetivosCalidad']=$this->model->getObjetivo(1);
		$data['objetivosCalidadSG']=$this->model->getObjetivo(2); 
		$data['politicaSG']=$this->model->getPoliticaSG(); 
		$data['modulos']=$this->model->getModulosActa();
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=0;
		$data['title']='Crear Acta de Revisión por la Dirección';
		$data['content']='view_createActa';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo elimina 
	 * el acta incompleta de la revision 
	 * por la direccion y sus tablas 
	 * asociadas
	 */
	public function deleteActaIncompleta()
	{	
		$this->validateSession();
		$this->validateUsuario();
		$id=$this->input->post('id_actaI');
		$this->validateActaIncompleta($id);
		$res=FALSE;
		$nombreTabla=array('asistentesacta','acta');
		for ($i=0; $i <count($nombreTabla); $i++) { 
			$res=$this->model->deleteActaIncompleta($id,$nombreTabla[$i]);
		}
			if ($res) {
				$this->session->set_userdata('delete',1);
				$this->session->set_userdata('idActa','');
			}else{
				$this->session->set_userdata('delete',0);
			}
			redirect('calidad/viewActaIncompleta');
	}
	/**
	 * Este metodo elimina 
	 * el acta de la revision 
	 * por la direccion y sus tablas 
	 * asociadas
	 */
	public function deleteActa()
	{	
		$this->validateSession();
		$this->validateUsuario();
		$id=$this->input->post('id_acta');
		$this->validateActa($id);
		$res=FALSE;
		$nombreTabla=array('textoimagen','texto','subtitulo','imgacta','imagentexto','encabezado','asistentesacta','graphic','tabletwo','tablethree','tablefour','tablefive','tablesix','tableseven','acta');
		for ($i=0; $i <count($nombreTabla); $i++) { 
			$res=$this->model->deleteActa($id,$nombreTabla[$i]);
		}
			if ($res) {
					$root=str_replace("\\",'/',getcwd());
					$dir=$root.'/img/Acta/acta_'.$id;
				$this->deleteDirectory($dir);
				$this->session->set_userdata('delete',1);
			}else{
				$this->session->set_userdata('delete',0);
			}
			redirect('calidad/viewActa');
	}
	/**
	 * Este metodo recibe el id del plan
	 * de accion por ajax para proceder a eliminarlo
	 * @return type
	 */
	public function deletePlanAccion()
	{
		$this->validateSession();
		$id_plan=$this->input->post('id_plan');
		if (isset($id_plan)) {
			if($this->model->emptyRecursoAccion($id_plan) && $this->model->deleteRelacionContenidoPlanAccion($id_plan) && $this->model->deletePlanAccion($id_plan)){
				echo 'Eliminado';
			}else{
				echo 'No se pudo eliminar';
			}
		}
	}
	/**
	 *  Este metodo recibe el id del seguimiento plan
	 * de accion por ajax para proceder a eliminarlo
	 * @return [type] [description]
	 */
	public function deleteSeguimientoAccion(){
		$this->validateSession();
		$id_seguimiento=$this->input->post('id_seguimiento');
		if (isset($id_seguimiento)) {
			if($this->model->deleteRelacionAccionSeguimiento($id_seguimiento) && $this->model->deleteSeguimientoAccion($id_seguimiento)){
				echo 'Eliminado';
			}else{
				echo 'No se pudo eliminar';
			}
		}
	}
	/**
	 * [deleteDirectory description]
	 * @param  [type] $dir [description]
	 * @return [type]      [description]
	 */
	private function deleteDirectory($dir) {

	$this->validateSession();
	$this->validateUsuario();
	    if(!$dh = @opendir($dir)) return;
	    while (false !== ($current = readdir($dh))) {
	        if($current != '.' && $current != '..') {
	            if (!@unlink($dir.'/'.$current)) 
	                $this->deleteDirectory($dir.'/'.$current);
	        }       
	    }
	    closedir($dh);
	    @rmdir($dir);
	}
//-----------------------------------------------------------------------------------------------------------//
//Estos metodos crean los div segun el id que le envien 
//retornando el codigo HTMl
	/**
	 * Este metodo crea un div para el subtitulo
	 */ 
	public function getObjectSubtitulo()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id= $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">                
					<center>Subtitulo</center>
				</div>
			<div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-8">
                	<input type="text" placeholder="Ingrese Subtitulo" class="form-control" title="Ingrese subtitulo" name="subtituloActa_'.$index_id.'['.$index.']">
                	<input type="hidden" value="'.$index_id.'" name="subtitulo_index_id['.$index.']">
                	<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."subtitulo".']['.$index.']">
                </div> 
            <div class="col-lg-12">            
			<hr>
			</div>
			</div>';
		}else{
			redirect('');
		}
		echo $data;
	}	
	/**
	 * Tabla dos columnas
	 */
	public function getObjectTableTwo()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id=$this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
				<div class="col-lg-12">                                                                                    
					<center>Tabla dos columnas</center>
				</div>
				<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-10">
					<table class="table table-bordered" id="tableTwo_'.$index.'_'.$index_id.'">
						<tr>	
							<td colspan="2" align="center">
								<button id="bt_add" class="btn btn-default" onclick="agregarTD(event,'.$index.','.$index_id.');" value="agregar">Agregar Fila</button>
								<button id="bt_del" class="btn btn-default" onclick="eliminar(event);" value="eliminar">Eliminar Fila</button>
								<input type="hidden" id="posTableTwo_'.$index_id.'['.$index.']" name="posTableTwo_'.$index_id.'['.$index.']" value="0">
							</td>
						</tr>
						<tr>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloITD2_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloDTD2_'.$index_id.'['.$index.']"></td>
							<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."two".']['.$index.']">
							<input type="hidden" value="'.$index_id.'" name="tableTwo_index_id['.$index.']">
						</tr>
					</table>
					<div class="col-lg-1">&nbsp;</div>
				</div>
	            <div class="col-lg-12">                                                                                    
				<hr>
				</div>
			</div>	
			';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * Tabla tres columnas
	 */
	public function getObjectTableThree()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
				<div class="col-lg-12">                                                                                    
					<center>Tabla tres columnas</center>
				</div>
				<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-10">
					<table class="table table-bordered" id="tableThree_'.$index.'_'.$index_id.'">
						<tr>	
							<td colspan="3" align="center">
								<button id="bt_add" class="btn btn-default" onclick="agregarTD3(event,'.$index.','.$index_id.');" value="Agregar">Agregar Fila</button>
								<button id="bt_del" class="btn btn-default" onclick="eliminar3(event);" value="Eliminar">Eliminar Fila</button>
								<input type="hidden" id="posTableThree_'.$index_id.'['.$index.']" name="posTableThree_'.$index_id.'['.$index.']" value="0">
							</td>
						</tr>
						<tr>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloITD3_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCTD3_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloDTD3_'.$index_id.'['.$index.']"></td>
							<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."three".']['.$index.']">
							<input type="hidden" value="'.$index_id.'" name="tableThree_index_id['.$index.']">
						</tr>
					</table>
					<div class="col-lg-1">&nbsp;</div>
				</div>
	            <div class="col-lg-12">                                                                                    
				<hr>
				</div>
			</div>	
			';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * 
	 */
	public function viewGraphic()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id')==1 && $this->input->post('index') && $this->input->post('index_id')) {
				$index= $this->input->post('index');
				$index_id= $this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$start=$this->input->post('start');
				$tituloGraficoY=$this->input->post('tituloGraficoY');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
				$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "column"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
					}
					json.yAxis={
						title: {
				            text: "'.$tituloGraficoY.'"
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
						            pointStart: '.$start.'
						        }
					}
					json.series= [';
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            data:['.$datosColumna[$i].']
					        },';
							}
		$data.='	  			]
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
	    	$("#container_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}else if($this->input->post('id')==2 && $this->input->post('index') && $this->input->post('index_id')) {
				$index= $this->input->post('index');
				$index_id= $this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
			$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "pie"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
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
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            y:'.(float)$datosColumna[$i].'
					        },';
							}
		$data.='			   	]
					    			}]
	    	$("#containerP_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}else if($this->input->post('id')==3 && $this->input->post('index') && $this->input->post('index_id')){
				$index= $this->input->post('index');
				$index_id= $this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$start=$this->input->post('start');
				$tituloGraficoY=$this->input->post('tituloGraficoY');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
				$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "line"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
					}
					json.yAxis={
						title: {
				            text: "'.$tituloGraficoY.'"
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
						            pointStart: '.$start.'
						        }
					}
					json.series= [';
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            data:['.$datosColumna[$i].']
					        },';
							}
		$data.='	  			]
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
	    	$("#containerL_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}
		echo $data;
	}	/**
	 * 
	 */
	public function viewGraphicE()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id')==1 && $this->input->post('index') && $this->input->post('index_id')) {
				$index= $this->input->post('index');
				$index_id=$this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$start=$this->input->post('start');
				$tituloGraficoY=$this->input->post('tituloGraficoY');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
				$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "column"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
					}
					json.yAxis={
						title: {
				            text: "'.$tituloGraficoY.'"
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
						            pointStart: '.$start.'
						        }
					}
					json.series= [';
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            data:['.$datosColumna[$i].']
					        },';
							}
		$data.='	  			]
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
	    	$("#containerE_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}else if($this->input->post('id')==2 && $this->input->post('index') && $this->input->post('index_id')) {
				$index= $this->input->post('index');
				$index_id= $this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
			$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "pie"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
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
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            y:'.(float)$datosColumna[$i].'
					        },';
							}
		$data.='			   	]
					    			}]
	    	$("#containerPE_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}else if($this->input->post('id')==3 && $this->input->post('index') && $this->input->post('index_id')){
				$index= $this->input->post('index');
				$index_id= $this->input->post('index_id');
				$titulo=$this->input->post('titulo');
				$subtitulo=$this->input->post('subtitulo');
				$start=$this->input->post('start');
				$tituloGraficoY=$this->input->post('tituloGraficoY');
				$tituloColumna=$this->input->post('tituloColumna');
				$datosColumna=$this->input->post('datosColumna');
				$data.='<script>$(document).ready(function() { 
					var json={};
					json.chart={
					    type: "line"
					}
					json.title={
					    text:"'.$titulo.'"
					}
					json.subtitle={
					    text:"'.$subtitulo.'"
					}
					json.yAxis={
						title: {
				            text: "'.$tituloGraficoY.'"
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
						            pointStart: '.$start.'
						        }
					}
					json.series= [';
							for ($i=1; $i <count($tituloColumna) ; $i++) { 
		$data.='			{
					            name: "'.$tituloColumna[$i].'",
					            data:['.$datosColumna[$i].']
					        },';
							}
		$data.='	  			]
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
	    	$("#containerLE_'.$index_id.'_'.$index.'").highcharts(json);});</script>';
		}
		echo $data;
	}
	/**
	 * 
	 */
	public function getGraphic()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id') && $this->input->post('datos') && $this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
		$id=$this->input->post('id');
		$datos=$this->input->post('datos');
		$url=base_url();
		if ($id==1) {
			$data.='
				<div class="row fila_content" id="content_'.$id_objeto.'">
					<div class="col-lg-12">                                                                                    
						<center>Grafico de barras</center>
					</div>
					<div class="col-lg-1">&nbsp;</div>
					<div class="col-lg-10">
						<table class="table table-bordered">
							<tr>
								<td><center>Titulo Grafico</center></td>
								<td><center>Subtitulo Grafico</center></td>
								<td><center>Subtitulo Lateral del grafico</center></td>
								<td><center>Punto inicial eje X</center></td>
							</tr>
							<tr>
								<td><input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGrafico_'.$index_id.'['.$index.']" id="tituloGrafico_'.$index_id.'['.$index.']"></td>
								<td><input type="text" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGrafico_'.$index_id.'['.$index.']" id="subtituloGrafico_'.$index_id.'['.$index.']"></td>
								<td><input type="text" title="Ingrese subtitulo lateral" class="form-control" placeholder="Ingrese Subtitulo Grafico (Y)" name="tituloGraficoY_'.$index_id.'['.$index.']" id="tituloGraficoY_'.$index_id.'['.$index.']"></td>
								<td><input type="number" title="Ingrese punto de inicio" class="form-control" placeholder="Ingrese punto de inicio" name="start_'.$index_id.'['.$index.']" id="start_'.$index_id.'['.$index.']"></td>
								<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."gBarra".']['.$index.']">
								<input type="hidden" value="'.$index_id.'" min="0" name="graficoBarra_index_id['.$index.']">
							</tr>
						</table>
						</br>
						<table class="table table-bordered">
							<tr>
								<td><center>Titulo columna</center></td>
								<td><center>Datos columna</center></td>
							</tr>';
							$cont=1;
							for ($i=0; $i <$datos ; $i++) { 
							
			$data.='		<tr>
								<td>
									<input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTBarra'.$cont.'_'.$index_id.'['.$index.']" id="dataTBarra'.$cont.'_'.$index_id.'['.$index.']">
								</td>
								<td>
									<input type="text" title="Ingrese Datos separados por ," class="form-control" placeholder="Ejem: 1,2,3,4,5" onkeyup="validarData(event);" name="dataBarra'.$cont.'_'.$index_id.'['.$index.']" id="dataBarra'.$cont.'_'.$index_id.'['.$index.']">				
								</td>	
							</tr>';
							$cont++;
							}
			$data.='			
						<tr>
							<td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGrafica(event,'.$cont.','.$index_id.','.$index.','.$id.','."'".$url."'".')">ver</button></center></td>
						</tr>
							<input type="hidden" id="posBarra_'.$index_id.'['.$index.']" name="posBarra_'.$index_id.'['.$index.']" value="'.$cont.'">	
						</table>
						<div class="col-lg-1">&nbsp;</div>
					</div>
					<div id="container_'.$index_id.'_'.$index.'" class="col-lg-12"></div>
		            <div class="col-lg-12">                                                                                    
					<hr>
					</div>
				</div>
	                	';
			}else if($id==2){
				$data.='
				<div class="row fila_content" id="content_'.$id_objeto.'">
					<div class="col-lg-12">                                                                                    
						<center>Grafico de Pie</center>
					</div>
					<div class="col-lg-1">&nbsp;</div>
					<div class="col-lg-10">
						<table class="table table-bordered">
							<tr>
								<td><center>Titulo Grafico</center></td>
								<td><center>Subtitulo Grafico</center></td>
							</tr>
							<tr>
								<td><input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGraficoP_'.$index_id.'['.$index.']" id="tituloGraficoP_'.$index_id.'['.$index.']"></td>
								<td><input type="text" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGraficoP_'.$index_id.'['.$index.']" id="subtituloGraficoP_'.$index_id.'['.$index.']"></td>
								<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."gPie".']['.$index.']">
								<input type="hidden" value="'.$index_id.'" min="0" name="graficoPie_index_id['.$index.']">
							</tr>
						</table>
						</br>
						<table class="table table-bordered">
							<tr>
								<td><center>Titulo columna</center></td>
								<td><center>Datos columna</center></td>
							</tr>';
							$cont=1;
							for ($i=0; $i <$datos ; $i++) { 
							
			$data.='		<tr>
								<td>
									<input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTPie'.$cont.'_'.$index_id.'['.$index.']" id="dataTPie'.$cont.'_'.$index_id.'['.$index.']">
								</td>
								<td>
									<input type="number"  min="0" step="0.10" title="Ingrese Dato numerico" class="form-control" placeholder="Ejem: 0.5" name="dataPie'.$cont.'_'.$index_id.'['.$index.']" id="dataPie'.$cont.'_'.$index_id.'['.$index.']">				
								</td>	
							</tr>';
							$cont++;
							}
			$data.='			
						<tr>
							<td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGrafica(event,'.$cont.','.$index_id.','.$index.','.$id.','."'".$url."'".')">ver</button></center></td>
						</tr>
							<input type="hidden" name="posPie_'.$index_id.'['.$index.']" id="posPie_'.$index_id.'['.$index.']" value="'.$cont.'">	
						</table>
						<div class="col-lg-1">&nbsp;</div>
					</div>
					<div id="containerP_'.$index_id.'_'.$index.'" class="col-lg-12"></div>
		            <div class="col-lg-12">                                                                                    
					<hr>
					</div>
				</div>
	                	';
			}else if($id==3){
				$data.='
					<div class="row fila_content" id="content_'.$id_objeto.'">
						<div class="col-lg-12">                                                                                    
							<center>Grafico de lineas</center>
						</div>
						<div class="col-lg-1">&nbsp;</div>
						<div class="col-lg-10">
							<table class="table table-bordered">
								<tr>
									<td><center>Titulo Grafico</center></td>
									<td><center>Subtitulo Grafico</center></td>
									<td><center>Subtitulo Lateral del grafico</center></td>
									<td><center>Punto inicial eje X</center></td>
								</tr>
								<tr>
									<td><input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo Grafico" name="tituloGraficoL_'.$index_id.'['.$index.']" id="tituloGraficoL_'.$index_id.'['.$index.']"></td>
									<td><input type="text" title="Ingrese subtitulo" class="form-control" placeholder="Ingrese Subtitulo Grafico" name="subtituloGraficoL_'.$index_id.'['.$index.']" id="subtituloGraficoL_'.$index_id.'['.$index.']"></td>
									<td><input type="text" title="Ingrese subtitulo lateral" class="form-control" placeholder="Ingrese Subtitulo Grafico (Y)" name="tituloGraficoYL_'.$index_id.'['.$index.']" id="tituloGraficoYL_'.$index_id.'['.$index.']"></td>
									<td><input type="number" title="Ingrese punto de inicio" class="form-control" placeholder="Ingrese punto de inicio" name="startL_'.$index_id.'['.$index.']" id="startL_'.$index_id.'['.$index.']"></td>
									<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."gLinea".']['.$index.']">
									<input type="hidden" value="'.$index_id.'" min="0" name="graficoLinea_index_id['.$index.']">
								</tr>
							</table>
							</br>
							<table class="table table-bordered">
								<tr>
									<td><center>Titulo columna</center></td>
									<td><center>Datos columna</center></td>
								</tr>';
								$cont=1;
								for ($i=0; $i <$datos ; $i++) { 
								
				$data.='		<tr>
									<td>
										<input type="text" title="Ingrese Titulo" class="form-control" placeholder="Ingrese Titulo datos" name="dataTLinea'.$cont.'_'.$index_id.'['.$index.']" id="dataTLinea'.$cont.'_'.$index_id.'['.$index.']">
									</td>
									<td>
										<input type="text" title="Ingrese Datos separados por ," class="form-control" placeholder="Serie 1,Serie 2,Serie 3" onkeyup="validarData(event);" name="dataLinea'.$cont.'_'.$index_id.'['.$index.']" id="dataLinea'.$cont.'_'.$index_id.'['.$index.']">				
									</td>	
								</tr>';
								$cont++;
								}
				$data.='			
							<tr>
								<td colspan="2"><center><button class="btn btn-default" value="graphic" onclick="verGrafica(event,'.$cont.','.$index_id.','.$index.','.$id.','."'".$url."'".')">ver</button></center></td>
							</tr>
								<input type="hidden" id="posLinea_'.$index_id.'['.$index.']" name="posLinea_'.$index_id.'['.$index.']" value="'.$cont.'">	
							</table>
							<div class="col-lg-1">&nbsp;</div>
						</div>
						<div id="containerL_'.$index_id.'_'.$index.'" class="col-lg-12"></div>
			            <div class="col-lg-12">                                                                                    
						<hr>
						</div>
					</div>
		                	';
			}
		}//fin if post
		echo $data;
	}
	/**
	 * 
	 */
	public function getObjectTableFour()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
				<div class="col-lg-12">                                                                                    
					<center>Tabla cuatro columnas</center>
				</div>
				<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-10">
					<table class="table table-bordered" id="tableFour_'.$index.'_'.$index_id.'">
						<tr>	
							<td colspan="4" align="center">
								<button id="bt_add" class="btn btn-default" value="Agregar" onclick="agregarTD4(event,'.$index.','.$index_id.');">Agregar Fila</button>
								<button id="bt_del" class="btn btn-default" value="Eliminar" onclick="eliminar4(event);">Eliminar Fila</button>
								<input type="hidden" id="posTableFour_'.$index_id.'['.$index.']" name="posTableFour_'.$index_id.'['.$index.']" value="0">
							</td>
						</tr>
						<tr>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloITD4_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCITD4_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloCDTD4_'.$index_id.'['.$index.']"></td>
							<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="tituloDTD4_'.$index_id.'['.$index.']"></td>
							<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."four".']['.$index.']">
							<input type="hidden" value="'.$index_id.'" name="tableFour_index_id['.$index.']">
						</tr>
					</table>
					<div class="col-lg-1">&nbsp;</div>
				</div>
	            <div class="col-lg-12">                                                                                    
				<hr>
				</div>
			</div>	
			';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * 
	 */
	public function getObjectTableOtro()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('fila') && $this->input->post('columna') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
		$fila=$this->input->post('fila');
		$columna=$this->input->post('columna');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
				<div class="col-lg-12">                                                                                    
					<center>Tabla Columna-'.$columna.' Fila-'.$fila.'</center>
				</div>
				<div class="col-lg-1">&nbsp;</div>
					<div class="col-lg-10">
						<table class="table table-bordered" id="tableOtro_'.$index.'_'.$index_id.'">
							<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."otro".']['.$index.']">
							<input type="hidden" value="'.$index_id.'" name="tableOtro_index_id['.$index.']">
							<tr>';
							for ($i=1; $i <=$columna ; $i++) { 
			$data.='			<td><input type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="titulo_'.$i.'TD_'.$index_id.'['.$index.']"></td>';
							}
			$data.='		</tr>';
								$pos=1;
							for ($j=1; $j <=$fila ; $j++) {
			$data.='		<tr>';
							for ($i=1; $i <=$columna ; $i++) { 
			$data.='			<td><textarea type="text" title="Ingrese Titulo Columna" class="form-control" placeholder="Ingrese Titulo Columna" name="textoOtro'.$pos++.'TD_'.$index_id.'['.$index.']"></textarea></td>';
							}
			$data.='		</tr>';
							}
			$data.='
						</table>
						<input type="hidden" id="posTableOtro_'.$index_id.'['.$index.']" name="posTableOtro_'.$index_id.'['.$index.']" value="'.$pos.'">	
						<input type="hidden" id="columnaOtro_'.$index_id.'['.$index.']" name="columnaOtro_'.$index_id.'['.$index.']" value="'.$columna.'">	
						<div class="col-lg-1">&nbsp;</div>
					</div>
	            <div class="col-lg-12">                                                                                    
				<hr>
				</div>
			</div>	
			';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * 
	 */
	public function getObjectEncabezado()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$id_objeto=$this->input->post('id_objeto');
		$index_id=$this->input->post('index_id');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">                                                                                    
				<center>Encabezado</center>
			</div>
			<div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-8">
                	<input type="text" placeholder="Ingrese encabezado" class="form-control" title="Ingrese encabezado" name="encabezadoActa_'.$index_id.'['.$index.']">
                	<input type="hidden" value="'.$index_id.'" name="encabezado_index_id['.$index.']">
                	<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."encabezado".']['.$index.']">
                </div> 
            <div class="col-lg-12">                                                                                    
			<hr>
			</div>
			</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 *
	 */
	public function getObjectImgTexto()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id=$this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
		$acta=$this->input->post('idActa');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">                                                                                    
				<center>Imagen-Texto</center>
				<br>
				<center>
				<div style="margin-right:40px;margin-left:40px;">
					<img class="img-responsive" id="outputI_'.$index_id.'['.$index.']"/>
				</div>
				</center>
			</div>
			<div class="col-lg-12"> 
			&nbsp;
			</div> 
			<div class="col-lg-1">&nbsp;</div>
                <div class="col-lg-11">
                	<div class="col-lg-6">
						<div class="row">
							<div class="form-group">
								<input type="hidden" value="'.$acta.'" name="idActa">
								<div class="col-md-12 text-center">
						            <div class="input-group">
						                <span class="input-group-btn">
						                    <span class="btn btn-primary btn-file">
						                		<i class="glyphicon glyphicon-folder-open"></i>
						                        &nbsp;Seleccionar archivos
						                        <input name="userImageImgTexto_'.$index_id.'_'.$index.'" type="file" class="inputFile" accept="image/*" onchange="loadFileIT(event,'.$index_id.','.$index.')" />
						                    </span>
						                </span>
						                <input type="text" class="form-control" readonly>
					            	</div>								
								</div>
							</div>
						</div>
            		</div>
                	<div class="col-lg-4">
                		<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."imgTexto".']['.$index.']">
		            	<input type="hidden" value="'.$index_id.'" name="imgTexto_index_id['.$index.']">
                		<textarea class="form-control" title="Ingrese texto" name="textoT_'.$index_id.'['.$index.']"  placeholder="Ingrese texto"></textarea>
                	</div>
                </div> 
            <div class="col-lg-12">                                                                                    
			<hr>
			</div>
			</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}	
	/**
	 *
	 */
	public function getObjectImgTextoEdit()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id')) {
		$index = $this->input->post('index');
		$index_id=$this->input->post('index_id');
		$idImg=$this->input->post('idImg');
			$data.='
        	<div class="col-lg-6">
				<div class="row">
					<div class="form-group">
						<div class="col-md-12 text-center">
				            <div class="input-group">
				                <span class="input-group-btn">
				                    <span class="btn btn-primary btn-file">
				                		<i class="glyphicon glyphicon-folder-open"></i>
				                        &nbsp;Seleccionar archivos
				                        <input type="hidden" name="idImg_'.$index_id.'['.$index.']" value="'.$idImg.'">
				                        <input name="userImageImgTextoE_'.$index.'_'.$index_id.'" type="file" class="inputFile" accept="image/*" onchange="loadFileITE(event,'.$index.','.$index_id.')" />
				                    </span>
				                </span>
				                <input type="text" class="form-control" readonly>
			            	</div>								
						</div>
					</div>
				</div>
    		</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 *
	 */
	public function getObjectTextoImg()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		$acta=$this->input->post('idActa');
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$id_objeto=$this->input->post('id_objeto');
		$index_id=$this->input->post('index_id');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">       
				<center>Texto-Imagen</center>
				<br>
				<center>
				<div style="margin-right:40px;margin-left:40px;">
					<img class="img-responsive" id="outputT_'.$index_id.'['.$index.']"/>
				</div>
				</center>
			</div>
			<div class="col-lg-12"> 
			&nbsp;
			</div> 
			<div class="col-lg-1">&nbsp;</div>
                <div class="col-lg-11">
                	<div class="col-lg-4">
		                <input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."textoImg".']['.$index.']">
		            	<input type="hidden" value="'.$index_id.'" name="textoImg_index_id['.$index.']">
                		<textarea class="form-control" title="Ingrese texto" name="textoI_'.$index_id.'['.$index.']"  placeholder="Ingrese texto"></textarea>
                	</div>
                	<div class="col-lg-8">
						<div class="row">
							<div class="form-group">
									<input type="hidden" value="'.$acta.'" name="idActa">
								<div class="col-md-8 text-center">
							            <div class="input-group">
							                <span class="input-group-btn">
							                    <span class="btn btn-primary btn-file">
							                		<i class="glyphicon glyphicon-folder-open"></i>
							                        &nbsp;Seleccionar archivos
							                        <input name="userImageTextoImg_'.$index_id.'_'.$index.'" type="file" class="inputFile" accept="image/*" onchange="loadFileT(event,'.$index_id.','.$index.')" />
							                    </span>
							                </span>
							                <input type="text" class="form-control" readonly>
							            </div>								
								</div>
							</div>
						</div>
                	</div>
                </div> 
            <div class="col-lg-12">                                                                                    
			<hr>
			</div>
			</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}	
	/**
	 *
	 */
	public function getObjectTextoImgEdit()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id')) {
		$index = $this->input->post('index');
		$index_id=$this->input->post('index_id');
		$idImg=$this->input->post('idImg');
			$data.='
            	<div class="col-lg-8">
					<div class="row">
						<div class="form-group">
							<div class="col-md-8 text-center">
					            <div class="input-group">
					                <span class="input-group-btn">
					                    <span class="btn btn-primary btn-file">
					                		<i class="glyphicon glyphicon-folder-open"></i>
					                        &nbsp;Seleccionar archivos
					                         <input type="hidden" name="idImg_'.$index_id.'['.$index.']" value="'.$idImg.'">
					                        <input name="userImageTextoImgE_'.$index.'_'.$index_id.'" type="file" class="inputFile" accept="image/*" onchange="loadFileTE(event,'.$index.','.$index_id.')" />
					                    </span>
					                </span>
					                <input type="text" class="form-control" readonly>
					            </div>								
							</div>
						</div>
					</div>
            	</div>';
		}else{
			redirect('');
		}
		echo $data;
	}
	public function getObjectImgEdit()
	{
		$data='';
		$this->validateSession();
		if ($this->input->post('index') && $this->input->post('index_id')) {
			$i=$this->input->post('index');
			$value=$this->input->post('index_id');
			$idImg=$this->input->post('idImg');
			$data.='<div class="col-lg-10">
			    <div class="row">
			        <div class="col-md-12">
			            <div class="form-group">
			                <div class="col-md-2"></div>
				                <div class="col-md-8 text-center">
				                    <div class="input-group">
				                        <span class="input-group-btn">
				                            <span class="btn btn-primary btn-file">
				                                <i class="glyphicon glyphicon-folder-open"></i>
				                                &nbsp;Seleccionar archivos
				                                <input type="hidden" name="idImg_'.$value.'['.$i.']" value="'.$idImg.'">
				                                <input name="userImageImgE_'.$i.'_'.$value.'" type="file" class="inputFile" accept="image/*" onchange="loadFileE(event,'.$i.','.$value.')" />
				                            </span>
				                        </span>
				                        <input type="text" class="form-control" readonly>
				                    </div>                              
				                </div>
		                		<div class="col-md-2"></div>
			            	</div>
			       		</div>
			    	</div>
				</div>';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * 
	 */
	public function getObjectImg()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
		$acta=$this->input->post('idActa');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">                         
				<center>Imagen</center>
				<br>
				<center>
				<div style="margin-right:40px;margin-left:40px;">
					<img class="img-responsive" id="output_'.$index_id.'['.$index.']"/>
				</div>
				</center>
			</div>
			<div class="col-lg-12"> 
			&nbsp;
			</div> 
			<div class="col-lg-1">&nbsp;</div>
				<br>
                <div class="col-lg-10">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-2"></div>
									<input type="hidden" value="'.$acta.'" name="idActa">
									<div class="col-md-8 text-center">
							            <div class="input-group">
							                <span class="input-group-btn">
							                    <span class="btn btn-primary btn-file">
							                		<i class="glyphicon glyphicon-folder-open"></i>
							                        &nbsp;Seleccionar archivos
							                        <input name="userImageImg_'.$index_id.'_'.$index.'" type="file" class="inputFile" accept="image/*" onchange="loadFile(event,'.$index_id.','.$index.')" />
							                    </span>
							                </span>
							                <input type="text" class="form-control" readonly>
							            </div>								
									</div>
									<div class="col-md-2"></div>
								</div>
							</div>
						</div>
						<input type="hidden" value="'.$index_id.'" name="img_index_id['.$index.']">
						<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."img".']['.$index.']">
                </div> 
            <div class="col-lg-12">                                                                                    
			<hr>
			</div>
			</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}
	public function getObjectTexto()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('index') && $this->input->post('index_id') && $this->input->post('id_objeto')) {
		$index = $this->input->post('index');
		$index_id = $this->input->post('index_id');
		$id_objeto=$this->input->post('id_objeto');
			$data.='
			<div class="row fila_content" id="content_'.$id_objeto.'">
			<div class="col-lg-12">                                                                                    
				<center>Texto</center>
			</div>
			<div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-8"><textarea placeholder="Ingrese texto" class="form-control" title="Ingrese texto" name="texto_'.$index_id.'['.$index.']"></textarea>
                	<input type="hidden" value="'.$index_id.'" name="texto_index_id['.$index.']">
                	<input type="hidden" value="'.$id_objeto.'" name="ordenActa_'.$index_id.'['."texto".']['.$index.']">
                </div> 
            <div class="col-lg-12">                                                                                    
			<hr>
			</div>
			</div>
                	';
		}else{
			redirect('');
		}
		echo $data;
	}
	/**
	 * Este metodo crea otra fila
	 * para el div asistentes
	 */
	public function getAsistentesObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$data.='
			<br>
			<div class="row fila" id="fila_'.$id_objeto.'">
	                    <div class="col-lg-3">
	                        <center>Nombre:</center>
	                        <br>
	                        <input style="height:50px;" type="text" placeholder="Nombre" title="Ingrese nombre completo de la persona asistente" name="nameA['.$id_objeto.']" id="nameA_'.$id_objeto.'" class="form-control" required/>
	                    </div>
	                    <div class="col-lg-4">
	                        <center>Cargo:</center>
	                        <br>
	                        <textarea class="form-control" placeholder="Cargo" title="Ingrese cargo o cargos de la persona" name="cargoA['.$id_objeto.']" id="cargoA_'.$id_objeto.'" required/></textarea>
	                    </div>
	                    <div class="col-lg-5">
	                        <center>Proceso(s):</center>
	                        <br>
	                        <textarea class="form-control" placeholder="Proceso(s)" title="Ingrese nombre del proceso" name="procesoA['.$id_objeto.']" id="procesoA_'.$id_objeto.'" required/></textarea>
	                    </div>                                                                                     
                	</div>
				<br>
                	';
		}
		echo $data;
	}
	/**
	 * [getAsistentesComiteObjects description]
	 * @return [type] [description]
	 */
	public function getAsistentesComiteObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		$users=$this->model->getUsers();
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$data.='
			<tr class="fila" id="fila_'.$id_objeto.'">
				<td class="tableActaBody">
					<select name="nameA['.$id_objeto.']" id="nameA_'.$id_objeto.'" class="form-control">
						<option value="">Seleccione...</option>';
						foreach ($users as $value) {
			$data.='		<option value="'.$value->id.'">'.$value->nombre.'</option>';
						}
			$data.='			
					</select>
				</td>
				<td class="tableActaBody">
					<textarea placeholder="Cargo" title="Ingrese cargo de la persona asistente" name="cargoA['.$id_objeto.']" id="cargoA_'.$id_objeto.'" class="form-control"></textarea>
				</td>
			</tr>
        	';
		}
		echo $data;
	}
	/**
	 * [getAgendaComiteObjects description]
	 * @return [type] [description]
	 */
	public function getAgendaComiteObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$data.='
			<tr class="fila_agenda" id="fila_agenda_'.$id_objeto.'">
				<td class="tableActaBody">
					<textarea class="form-control" name="agenda['.$id_objeto.']" id="agenda_'.$id_objeto.'"></textarea>
				</td>
			</tr>
        	';
		}
		echo $data;
	}
	/**
	 * [getTratadosComiteObjects description]
	 * @return [type] [description]
	 */
	public function getTratadosComiteObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$data.='
			<tr class="fila_tratados" id="fila_tratados_'.$id_objeto.'">
				<td class="tableActaBody">
					<textarea class="form-control" name="tema_tratado['.$id_objeto.']" id="tema_tratado_'.$id_objeto.'"></textarea>
				</td>
				<td class="tableActaBody">
					<center>
						<input type="radio" onchange="getEficacia()" name="cumple['.$id_objeto.']" id="cumple_'.$id_objeto.'" value="SI">
					</center>	
				</td>
				<td class="tableActaBody">
					<center>
						<input type="radio" onchange="getEficacia()" name="cumple['.$id_objeto.']" id="cumple_'.$id_objeto.'" value="NO">
					</center>
				</td>
			</tr>
        	';
		}
		echo $data;
	}
	/**
	 * [getAcuerdosComiteObjects description]
	 * @return [type] [description]
	 */
	public function getAcuerdosComiteObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$data.='
			<tr class="fila_acuerdos" id="fila_acuerdos_'.$id_objeto.'">
				<td class="tableActaBody">
					<textarea name="acuerdos['.$id_objeto.']" id="acuerdos_'.$id_objeto.'" class="form-control"></textarea>
				</td>
			</tr>
        	';
		}
		echo $data;
	}
	/**
	 * [getAccionObjects description]
	 * @return [type] [description]
	 */
	public function getAccionObjects(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_accion') && $this->input->post('id_objeto') && $this->input->post('id_proceso')) {
			$id_objeto = $this->input->post('id_objeto');
			$id_accion = $this->input->post('id_accion');
			$id_proceso = $this->input->post('id_proceso');
			$planaccion=$this->model->getPlanAccionDashboard($id_accion,$id_proceso);
			$data.='
			<select name="idAccion['.$id_objeto.']" id="idAccion_'.$id_objeto.'" class="form-control">';
			if($planaccion==false){
			$data.='<option value="">No se encontro plan de accion correspondiente</option>';
			}else{
				foreach ($planaccion as $value) {
					$data.='<option value="'.$value->id.'">#'.$value->id.'-'.$value->nombreProceso.'-'.$value->descripcion.'</option>';
				}
			}		
			$data.='
			</select>
			';
		}
		echo $data;	
	}
	/**
	 * [getPlanAccionObjects description]
	 * @return [type] [description]
	 */
	public function getPlanAccionObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$recurso=$this->model->getRecursos();
			$cargo=$this->model->getCargo();
			$data.='
			<tr id="fila_accion_'.$id_objeto.'" class="fila_accion">
        		<td class="tableIndicadorHead"><center>Actividades a desarrollar</center></td>
        		<td class="tableIndicadorHead"><center>Fecha de ejecución</center></td>
        		<td class="tableIndicadorHead"><center>Fecha de revisión</center></td>
        		<td class="tableIndicadorHead"><center>Recursos</center></td>
        		<td class="tableIndicadorHead"><center>Responsable</center></td>
        	</tr>
        	<tr id="fila_accionContenido_'.$id_objeto.'" class="fila_accionContenido">
        		<td class="tableActaBody">
        			<textarea class="form-control" name="actividad_desarrollar['.$id_objeto.']" id="actividad_desarrollar['.$id_objeto.']"></textarea>
        		</td>
        		<td class="tableActaBody">
        			<input type="date" class="form-control" name="fecha_ejecucion['.$id_objeto.']" id="fecha_ejecucion['.$id_objeto.']">
        		</td>
        		<td class="tableActaBody">
	    			<input type="date" class="form-control" name="fecha_revision_1['.$id_objeto.']" id="fecha_revision_1_'.$id_objeto.'" required/>
        			<div id="div_fecha_revision_2_'.$id_objeto.'">
        				<input type="button" class="form-control" name="fecha_revision_2['.$id_objeto.']" id="fecha_revision_2_'.$id_objeto.'" onClick="addInputDateRevision(this.name,this.id,'.$id_objeto.');" value="Agregar">
        			</div>
        			<div id="div_fecha_revision_3_'.$id_objeto.'">
        				<input type="button" class="form-control" name="fecha_revision_3['.$id_objeto.']" id="fecha_revision_3_'.$id_objeto.'" onClick="addInputDateRevision(this.name,this.id,'.$id_objeto.');" value="Agregar" disabled>
        			</div>
	    		</td>
        		<td class="tableActaBody">
        			<select name="recurso_'.$id_objeto.'[]" id="recurso" class="form-control" multiple="true">';
        				foreach ($recurso as $value) {
    $data.='                <option value="'.$value->id.'">'.$value->nombre.'</option>';
        				}
    $data.='   				
        			</select>
        		</td>
        		<td class="tableActaBody">
        			<select name="responsable_seguimiento['.$id_objeto.']" id="responsable_seguimiento['.$id_objeto.']" class="form-control">'; 
    $data.='    		<option value="">Seleccione...</option>';
        				foreach ($cargo as $value) {
    $data.='	             <option value="'.$value->id.'">'.$value->nombre.'</option>';
        				}
    $data.='
        			</select>
        		</td>
        	</tr>
                	';
		}
		echo $data;
	}
	/**
	 * [getSeguimientoAccionObjects description]
	 * @return [type] [description]
	 */
	public function getSeguimientoAccionObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		if ($this->input->post('id_objeto')) {
			$id_objeto = $this->input->post('id_objeto');
			$cargo=$this->model->getCargo();
			$data.='
			<tr id="fila_seguimientoSubtitle_'.$id_objeto.'" class="fila_seguimientoSubtitle">
        		<td class="tableIndicadorHead" width="15%"><center>Fecha</center></td>
        		<td class="tableIndicadorHead" width="50%"><center>Descripción de seguimiento</center></td>
        		<td class="tableIndicadorHead" width="10%"><center>Eficacia</center></td>
        		<td class="tableIndicadorHead" width="25%"><center>Cargo que verifica</center></td>
        	</tr>
        	<tr id="fila_seguimientoC_'.$id_objeto.'" class="fila_seguimientoC">
        		<td class="tableActaBody"><input type="date" name="fecha_seguimiento['.$id_objeto.']" id="fecha_seguimiento_'.$id_objeto.'" class="form-control"></td>
        		<td class="tableActaBody"><textarea class="form-control" name="descripcionSeguimiento['.$id_objeto.']" id="descripcionSeguimiento_'.$id_objeto.'"></textarea></td>
        		<td class="tableActaBody"><center><input value="SI" type="checkbox" name="eficacia['.$id_objeto.']" id="eficacia"></center></td>
        		<td class="tableActaBody">
        			<select name="cargoV['.$id_objeto.']" id="cargoV_'.$id_objeto.'" class="form-control">';
        	$data.='		<option value="">Seleccione...</option>';
        				foreach ($cargo as $value) {
  	
        	$data.='		<option value="'.$value->id.'">'.$value->nombre.'</option>';
        				}
        	$data.='
        			</select>
        		</td>
        	</tr>
                	';
		}
		echo $data;
	}
	/**
	 * [getComportamientoObjects este metodo obtiene otra fila para el
	 * comportamiento de indicador]
	 * @return [type] [description]
	 */
	public function getComportamientoObjects()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$data='';
		$accion=$this->model->tipoAccionMedicion();
		$base_url=base_url();
		if ($this->input->post('id_objeto') && $this->input->post('read')&&$this->input->post('meta')) {
			$id_objeto = $this->input->post('id_objeto');
			$read = $this->input->post('read');
			$meta=$this->input->post('meta');
			$tipoaccion=$this->model->tipoAccionMedicion();
			$data.='
			<tr id="filaBR_'.$id_objeto.'">
				<td><br></td>
			</tr>
			<tr id="filaT_'.$id_objeto.'">
                <td class="tableActaBack" colspan="7">COMPORTAMIENTO DE INDICADOR</td>
            </tr>
            <tr id="filaS_'.$id_objeto.'">
                <td class="tableIndicadorHead">FECHA MEDICIÓN</td>
                <td class="tableIndicadorHead">FECHA DE PERIODO EVALUADO</td>
                <td class="tableIndicadorHead">META</td>
                <td class="tableIndicadorHead">VALOR NUMERADOR</td>
                <td class="tableIndicadorHead">VALOR DENOMINADOR</td>
                <td class="tableIndicadorHead">RESULTADOS</td>
            </tr>
			<tr class="fila" id="fila_'.$id_objeto.'">
                <td class="tableActaBody">
                    <input type="date"  class="form-control" name="fechaM['.$id_objeto.']" id="fechaM_'.$id_objeto.'">
                </td>
                <td class="tableActaBody">
                    <input type="date"  class="form-control" name="periodo1['.$id_objeto.']" id="periodo1_'.$id_objeto.'" onchange="sincronizarFechas();"><center>-</center><input type="date"  class="form-control" name="periodo2['.$id_objeto.']" id="periodo2_'.$id_objeto.'" onchange="sincronizarFechas();">
                </td>
                <td class="tableActaBody">
                    <input type="text"  class="form-control" name="meta['.$id_objeto.']" id="meta_'.$id_objeto.'" readonly value='.$meta.'>
                </td>
                <td class="tableActaBody">
                    <input type="number"  class="form-control"  min="1" onkeyup="calculateResult();" name="numerador['.$id_objeto.']" id="numerador_'.$id_objeto.'">
                </td>
                <td class="tableActaBody">
                    <input type="number" class="form-control" min="1"  onkeyup="calculateResult();" name="denominador['.$id_objeto.']" id="denominador_'.$id_objeto.'" '; 
                    if($read=='N/A'){
        $data.='     readonly value="0"'; 	
                    }else{
        $data.='     > ';      	
                    }
        $data.='</td>
                <td class="tableActaBody">
                    <input type="number" class="form-control" value="0" name="resultado['.$id_objeto.']" id="resultado_'.$id_objeto.'" readonly/>
                </td>
            </tr>
            <tr id="filaTA_'.$id_objeto.'">
                <td class="tableActaBack" colspan="2">PERIODO</td>
                <td class="tableActaBack" colspan="2">ANALISIS Y PLAN DE MEJORA</td>
                <td class="tableActaBack" colspan="2">N°ACCIÓN</td>
            </tr>
            <tr class="filaM" id="filaM_'.$id_objeto.'">
                <td class="tableActaBody" colspan="2">
                    <input type="date"  class="form-control" name="periodoA1['.$id_objeto.']" id="periodoA1_'.$id_objeto.'" readonly><center>-</center><input type="date"  class="form-control" name="periodoA2['.$id_objeto.']" id="periodoA2_'.$id_objeto.'" readonly="">
                </td>
                <td colspan="2" class="tableActaBody">
                    <textarea class="form-control" name="analisis['.$id_objeto.']" id="analisis_'.$id_objeto.'"></textarea>
                </td>
                <td colspan="2" class="tableActaBody">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-8">
                                <select name="accion['.$id_objeto.']" id="accion_'.$id_objeto.'" class="form-control"  onchange="agregarAccion(this.id,'."'".$base_url."'".');">';
                                        foreach ($tipoaccion as $value) {
        $data.='                            <option value="'.$value->id.'" data-id="'.$value->id.'">'.$value->nombre.'</option>';
                                        }
        $data.='                                
                                </select>
                            </div>
                            <div class="col-lg-4 hidden" id="btn-crear_'.$id_objeto.'">
                                <a href="'.base_url().'calidad/buildPlanAccion" class="btn btn-default"  target="_blank">Crear</a>
                            </div>
                        </div>
                        <div class="col-lg-12" style="margin-top:5px;">
                            <div id="contenedorAccion_'.$id_objeto.'"></div>
                        </div>
                    </div>
                </td>
            </tr>
                	';
		}
		echo $data;
	}
//------------------------------------------------------------------------------------------------------------------------------------------------// 	
	/**
	 * 
	 */
	public function folderSystemActa($targetPathImg,$index)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$res=FALSE;
		if (isset($targetPathImg)) {
			if (!file_exists($targetPathImg)) {
				mkdir($targetPathImg,0777,false);					
				chmod($targetPathImg, 0777);
				if(!file_exists($targetPathImg.'/'.'modulo_'.$index)){ 
				mkdir($targetPathImg.'/'.'modulo_'.$index,0777,false);					
				chmod($targetPathImg.'/'.'modulo_'.$index, 0777);
				}
			}else{
				if(!file_exists($targetPathImg.'/'.'modulo_'.$index)){ 
				mkdir($targetPathImg.'/'.'modulo_'.$index,0777,false);					
				chmod($targetPathImg.'/'.'modulo_'.$index, 0777);
				}
			}
			$res=TRUE;
		}else{
			redirect('');
		}
		return $res;
	}
	/**
	 * Este metodo carga  el despliegue de objetivos 
	 * de la base de datos y envia los datos a la vista. 
	 */
	public function despliegueObjetivos(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=7;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['despliegue']=$this->model->getDespliegueObjetivos();
		$data['indicador']=$this->model->getIndicador(1);
		$data['indicadorSG']=$this->model->getIndicador(2);
		$data['responsableG']=$this->model->getResponsableGestionar(1);
		$data['responsableG_SG']=$this->model->getResponsableGestionar(2);
		$data['recursos']=$this->model->getRecursosIndicador();
		$data['title']='Despliegue de objetivos';
		$data['orden']=$this->model->getAjusteTablaSST(1,9);
		$data['content']='view_despliegue';
		//---verifica que la directriz tenga asociado indicadores-----------------//
		$directrizSG=$this->model->getDirectriz(2);
		$verificarDirectrizSST=[];
		$verificar=[];
		$indexD=0;
		for ($i=0; $i <count($directrizSG) ; $i++) { 
			$verificar[$i]=$this->model->getDirectrizIndicadorId(($directrizSG[$i]->idDirectriz),2);
			if(count($verificar[$i])!=0){
				$verificarDirectrizSST[$indexD++]=$directrizSG[$i]; 
			}
		}
		$data['directrizSG']=$verificarDirectrizSST;

		$directriz=$this->model->getDirectriz(1);
		$verificarDirectriz=[];
		$verificar=[];
		$indexD=0;
		for ($i=0; $i <count($directriz) ; $i++) { 
			$verificar[$i]=$this->model->getDirectrizIndicadorId(($directriz[$i]->idProceso),1);
			if(count($verificar[$i])!=0){
				$verificarDirectriz[$indexD++]=$directriz[$i]; 
			}
		}
		$data['directriz']=$verificarDirectriz;
		//--------------------------------------------------------------------------//
		$this->load->vars($data);
		$this->load->view('template');
	}	
	/**
	 * Este objetivo carga los datos del despliegue de 
	 * objetivos para ser visualizados y editados por el usuario
	 */
	public function editDespliegue($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=7;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['despliegue']=$this->model->getDespliegueObjetivos();
		$data['idDespliegue']=$id;
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		//------------------------------------------//
		$data['title']='Editar Despliegue de Objetivos';
		$data['content']='view_editarDespliegue';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo actualiza el despliegue de 
	 * objetivos segun los datos recibidos 
	 */
	public function updateDespliegue()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$mensaje='';
		$res=FALSE;
		//id tabla
		$id=$this->input->post('id');
		//Variables tabla control de cambio
		$codigoDespliegue=$this->input->post('codigoDespliegue');
		$desc=$this->input->post('desc');
		$fechaVigencia=$this->input->post('fechaVigencia');
		$version=$this->input->post('version');
		//variables tabla revision
		$tabla=7;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaE=$this->input->post('fechaE');
		/**-------Variables revisado-----------*/
		$codigoR=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		/**-------Variables aprobado-----------*/
		$codigoA=$this->input->post('aprobado');
		$fechaA=$this->input->post('fechaA');

		//Variables nivel 2 despliegue objetivos
		$politicaSG=$this->input->post('politicaSST');

		if (isset($id) && isset($codigoDespliegue) && 
	        isset($desc) && isset($fechaVigencia) && 
	    	isset($codigoA) && isset($fechaE) && 
	    	isset($codigoE) && isset($fechaR) && 
	        isset($codigoR) && isset($fechaA) && 
	        isset($version) && isset($politicaSG)){
	        $data=array("codigoDespliegue"=>$codigoDespliegue);
	    	if( 
				$this->model->editRevision($codigoA,$fechaA,3,$tabla) &&
				$this->model->editRevision($codigoR,$fechaR,2,$tabla) &&
				$this->model->editRevision($codigoE,$fechaE,1,$tabla) &&
				$this->model->editDespliegue($id,$data) &&
				$this->model->editPoliticaSG(1,$politicaSG) &&
				$this->model->insertCambio($version,$desc,$fechaVigencia,$tabla)
			)
			{
				$res=TRUE;
			}
		}else{
			redirect('');
		}
		if($res){
			$mensaje="Despliegue de objetivos editado con exito";
		}else{
			$mensaje="Falló al editar el despliegue de objetivos";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/despliegueObjetivos');
	}
	/**
	 * Este metodo carga  la mision de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function editMision($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=1;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['idMision']=$id;
		$data['mision']=$this->model->getMision();
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		$data['title']='EDITAR MISIÓN DE CRM';
		$data['content']='view_editarMision';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo se encarga de editar los objetivos del sgc o del sst
	 */
	public function editObjetivo(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		$id=$this->input->post('id');
		$text=$this->input->post('objetivoE');
		$tipo=$this->input->post('tipoE');
		if (isset($id) && isset($text) && isset($tipo)) {
			$data=array("texto"=>$text,"tipo"=>$tipo);
			$this->model->editObjetivo($id,$data);
		}
		redirect('calidad/getObjetivo');
	}
	/**
	 * Este metodo se encarga de editar los procesos
	 */
	public function editProceso(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		$id=$this->input->post('id');
		$name=$this->input->post('nombreP');
		if (isset($id) && isset($name)) {
			$data=array("nombreProceso"=>$name);
			$this->model->editProceso($id,$data);
		}
		redirect('calidad/proceso');
	}
	/**
	 * [editIndicador description]
	 * @return [type] [description]
	 */
	public function editIndicador()
	{
		$proceso=$this->input->post('procesoIE');
		$idTipo=$this->input->post('tipoIE');
		$indicador=$this->input->post('nombreE');
		$numerador=$this->input->post('numeradorE');
		$denominador=$this->input->post('denominadorE');
		$x=$this->input->post('xe');
		$idSimbolo=$this->input->post('simboloE');
		$meta=$this->input->post('metaE');
		$rMedir=$this->input->post('rMedirE');
		$rGestionar=$this->input->post('rGestionarE');
		$medicion=$this->input->post('frecuenciaE');
		$idIndicador=$this->input->post('id');
		$recursos=$this->input->post('recursosE');
		if (isset($idIndicador) &&isset($proceso) && isset($idTipo)&& isset($indicador)&& isset($numerador)&& isset($denominador)&& isset($idSimbolo)
			&& isset($meta)&& isset($rMedir)&& isset($rGestionar)&& isset($medicion) && isset($recursos)) {
			if($this->model->editIndicador($recursos,$idIndicador,$indicador,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$medicion,$rMedir,$rGestionar,$proceso,1,$x)){
				$this->session->set_userdata('mensaje','Indicador editado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar el indicador');
			}
		}
		redirect('calidad/indicadorGestionCalidad');
	}
	/**
	 * [editDirectriz description]
	 * @return [type] [description]
	 */
	public function editDirectriz()
	{
		$directriz=$this->input->post('directrizE');
		$descripcion=$this->input->post('descripcionE');
		$proceso=$this->input->post('procesoE');
		$procesoDis=$this->input->post('procesoDis');
		$id=$this->input->post('id');
		if(isset($directriz)&&isset($descripcion)&&isset($id)&&isset($proceso)){
			$procesoDis=explode(',',$procesoDis);
			if($this->model->editDirectriz($id,$directriz,$descripcion,$proceso,$procesoDis,1)){
				$this->session->set_userdata('mensaje','Directriz editado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar la directriz');
			}
		}
		redirect('calidad/directrizGestionCalidad');
	}	
	/**
	 * Description
	 * @return type
	 */
	public function editDirectrizSST()
	{
		$directriz=$this->input->post('directrizE');
		$descripcion=$this->input->post('descripcionE');
		$proceso=$this->input->post('procesoE');
		$id=$this->input->post('id');
		if(isset($directriz)&&isset($descripcion)&&isset($id)){
			if($this->model->editDirectriz($id,$directriz,$descripcion,$proceso,'',2)){
				$this->session->set_userdata('mensaje','Directriz editado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar el directriz');
			}
		}
		redirect('calidad/directrizGestionCalidadSST');
	}
	/**
	 * [editIndicadorSST description]
	 * @return [type] [description]
	 */
	public function editIndicadorSST()
	{
		$proceso=$this->input->post('procesoIE');
		$idTipo=$this->input->post('tipoIE');
		$indicador=$this->input->post('nombreE');
		$numerador=$this->input->post('numeradorE');
		$denominador=$this->input->post('denominadorE');
		$x=$this->input->post('xe');
		$idSimbolo=$this->input->post('simboloE');
		$meta=$this->input->post('metaE');
		$rMedir=$this->input->post('rMedirE');
		$rGestionar=$this->input->post('rGestionarE');
		$medicion=$this->input->post('frecuenciaE');
		$idIndicador=$this->input->post('id');
		$recursos=$this->input->post('recursosE');
		if (isset($idIndicador) &&isset($proceso) && isset($idTipo)&& isset($indicador)&& isset($numerador)&& isset($denominador)&& isset($idSimbolo)
			&& isset($meta)&& isset($rMedir)&& isset($rGestionar)&& isset($medicion) && isset($recursos)) {
			if($this->model->editIndicador($recursos,$idIndicador,$indicador,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$medicion,$rMedir,$rGestionar,$proceso,2,$x)){
				$this->session->set_userdata('mensaje','Indicador editado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo editar el indicador');
			}
		}
		redirect('calidad/indicadorGestionSST');
	}
	/**
	 * Este metodo carga los datos del objetivo en el modals
	 */
	public function loadEditObjetivo(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$id=$this->input->post('id');
		if(isset($id)){
			echo json_encode($this->model->getObjetivoId($id));
		}else{
			redirect(' ');
		}
	}
	/**
	 * Este metodo carga los datos del objetivo en el modals
	 */
	public function loadEditProceso(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$id=$this->input->post('id');
		if(isset($id)){
			echo json_encode($this->model->getProcesoId($id));
		}else{
			redirect(' ');
		}
	}
	/**
	 * [loadEditIndicador description]
	 * @return [type] [description]
	 */
	public function loadEditIndicador()
	{
		$this->validateSession();
		$id=$this->input->post('id');
		$this->validateGet($id);
		$result=array_merge((array)$this->model->getIndicadorId($id),(array)$this->model->getResponsableGestionarId($id),(array)$this->model->getRecursosId($id));
		echo json_encode($result);
	}
	/**
	 * [loadEditDirectriz description]
	 * @return [type] [description]
	 */
	public function loadEditDirectriz()
	{
		$this->validateSession();
		$id=$this->input->post('id');
		$this->validateGet($id);
		$result=array_merge((array)$this->model->getDirectrizId($id),(array)$this->model->getProcesoDirectrizId($id));
		echo json_encode($result);
	}
	/**
	 * Este metodo carga  el mapa de procesos de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function editMapa($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=4;
		//Creacion de lighbox y select de procesos
		$vista="";
		$data['proceso']=$this->model->getProceso();
		$vista .= "
					<div id='lightboxOverlay' class='lightboxOverlay'></div>
					  	<div id='lightbox' class='lightbox'>
						  	<div class='lb-outerContainer'>
						  		<div class='lb-container'>
						  			<img class='lb-image' src='' />
						  			<div class='lb-nav'>
						  				<a class='lb-prev' href='' ></a>
						  				<a class='lb-next' href='' ></a>
						  			</div>
						  			<div class='lb-loader'>
						  				<a class='lb-cancel'></a>
						  			</div>
						  		</div>
						  	</div>
						  	<div class='lb-dataContainer'>
						  		<div>

									<select class='form-control' name='proceso' id='proceso'>
										<option value='0'>Seleccione Proceso</option>";
									foreach ($data['proceso'] as $value) {
										$vista.="<option value='".$value->nombre."'>".$value->nombre."</option>";
									}
		$vista .="						
									</select>
									<div style='height:5px;'>&nbsp</div>	
						  			<input id='coordsText' type='hidden' placeholder='Coordenadas' class='form-control'>	
						  			<div style='height:5px;'>&nbsp</div>		
						  			<textarea name='areaText' style='overflow:hidden;' placeholder='Area coordenadas' id='areaText' class='form-control' rows='2' onkeypress='return KeyPress(event);' onmousemove='ajustarText(this);'/>
						  		</textarea>	
						  		</div>
						  		<div class='lb-data'>
						  			<div class='lb-details'>
						  				<span class='lb-caption'></span>
						  				<span class='lb-number'></span>
						  			</div>
						  			<div class='lb-closeContainer'>
						  				<a class='lb-close'></a>
						  		</div>
						  	</div>
						</div>
					</div>";
		$data['vista']=$vista;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['idMapa']=$id;
		$data['mapa']=$this->model->getMapaProcesos();
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		$data['title']='EDITAR MISIÓN DE CRM';
		$data['content']='view_editarMapa';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * En este metodo se realiza el CRUD
	 * de los procesos 
	 */
	public function proceso(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/**---Envio de datos a la vista-*/
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=10;
		$data['proceso']=$this->model->getProceso();
		$data['title']='Procesos';
		$data['content']='view_proceso';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga el alcance de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function editAlcance($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=6;
		$data['folderD']=$this->folderD;
		$data['folder']=$tabla;
		$data['folderDO']=$this->folderDO;
		$data['idAlcance']=$id;
		$data['alcance']=$this->model->getAlcance();
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		$data['title']='EDITAR ALCANCE DEL SGC';
		$data['content']='view_editarAlcance';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la vision de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function editVision($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
		$this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=2;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['idVision']=$id;
		$data['vision']=$this->model->getVision();
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		$data['title']='EDITAR VISIÓN DE CRM';
		$data['content']='view_editarVision';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la politica de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function editPolitica($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateUsuario();
        $this->validateGet($id);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$tabla=3;
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['idPolitica']=$id;
		$data['politica']=$this->model->getPolitica();
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['users']=$this->model->getUsers();
		$data['user']=$this->idUsuario;
		$data['title']='EDITAR POLITICA DE CALIDAD DE CRM';
		$data['content']='view_editarPolitica';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la mision de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updateMision(){
		$codigoE='';
		$fechaR='';
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';
		$text=$this->input->post('text');
		$id=$this->input->post('id');
		$codigo=$this->input->post('codigoMision');
		$version=$this->input->post('version');
		$desc=$this->input->post('desc');
		$fecha=$this->input->post('fechaVigencia');
		$tabla=1;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaR=$this->input->post('fechaE');
		$revisadoE=$this->model->editRevision($codigoE,$fechaR,1,$tabla);
		/**-------Variables revisado-----------*/
		$codigoE=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		$revisadoR=$this->model->editRevision($codigoE,$fechaR,2,$tabla);
		/**-------Variables aprobado-----------*/
		$codigoE=$this->input->post('aprobado');
		$fechaR=$this->input->post('fechaA');
		$revisadoA=$this->model->editRevision($codigoE,$fechaR,3,$tabla);

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data=array("codigoMision"=>$codigo,"texto"=>$text);
		if($this->model->editMision($id,$data) && $this->model->insertCambio($version,$desc,$fecha,$tabla) && $revisadoA && $revisadoR && $revisadoE){
			$mensaje="Misión editada con exito";
		}else{
			$mensaje="Falló al editar la Misión";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/mision');
	}
	/**
	 * Este metodo carga  la mision de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updateDOFA(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';

		$id=$this->input->post('id');
		$codigo=$this->input->post('codigo');
		$responsable=$this->input->post('responsable');
		$fechaI=$this->input->post('fidentificacion');
		$version=$this->input->post('version');
		$fechaV=$this->input->post('fvigencia');
		$nombreFactor=$this->input->post('nombreFactor');
		$idFactor=$this->input->post('idFactor');
		$fortaleza=$this->input->post('fortaleza');
		$debilidad=$this->input->post('debilidad');
		$oportunidad=$this->input->post('oportunidad');
		$ofensivas=$this->input->post('ofensivas');
		$reorientacion=$this->input->post('reorientacion');
		$amenaza=$this->input->post('amenaza');
		$defensivas=$this->input->post('defensivas');
		$supervivencia=$this->input->post('supervivencia');
		$nota=$this->input->post('nota');
		if (isset($codigo)&&isset($responsable)&&isset($fechaI)&&
			isset($version)&&isset($fechaV)&&isset($nombreFactor)&&
			isset($idFactor)&&isset($fortaleza)&&isset($debilidad)&&
			isset($oportunidad)&&isset($ofensivas)&&isset($reorientacion)&&
			isset($amenaza)&&isset($defensivas)&&isset($supervivencia)&&isset($nota)&&isset($id)
			) 
		{
			$res=FALSE;
			$dataFactor=array("idFactor"=>$idFactor,"nombreFactor"=>$nombreFactor);
			$dataDOFA=array("codigoDOFA"=>$codigo,"version"=>$version,"fechaVigencia"=>$fechaV,
				"fechaIdentificacion"=>$fechaI,"nota"=>$nota);
			if (($this->model->editResponsablesDOFA($id,$responsable))) {
				$res=TRUE;
			}
			if($this->model->editDOFA($dataDOFA,$id) && $res && $this->model->updateFO($ofensivas) && $this->model->updateDO($reorientacion) && $this->model->updateFA($defensivas) && $this->model->updateDA($supervivencia) && 
				$this->model->updateNameFactor($idFactor,$nombreFactor) && $this->model->updateFactorFortaleza($idFactor,$fortaleza) && $this->model->updateFactorDebilidad($idFactor,$debilidad) && $this->model->updateFactorOportunidad($idFactor,$oportunidad) && $this->model->updateFactorAmenaza($idFactor,$amenaza)){
				$mensaje="DOFA editado con exito";
			}else{
				$mensaje="Falló al editar el DOFA";
			}
			$this->session->set_userdata('mensaje',$mensaje);
			redirect('calidad/dofa');
		}else{
			redirect('');
		}
	}
	/**
	 * Este metodo carga  el mapa de procesos de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updateMapa(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';
		$url=$this->input->post('url');
		$id=$this->input->post('id');
		$codigo=$this->input->post('codigoMapa');
		$version=$this->input->post('version');
		$desc=$this->input->post('desc');
		$fecha=$this->input->post('fechaVigencia');
		$tabla=4;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaR=$this->input->post('fechaE');
		$revisadoE=$this->model->editRevision($codigoE,$fechaR,1,$tabla);
		/**-------Variables revisado-----------*/
		$codigoE=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		$revisadoR=$this->model->editRevision($codigoE,$fechaR,2,$tabla);
		/**-------Variables aprobado-----------*/
		$codigoE=$this->input->post('aprobado');
		$fechaR=$this->input->post('fechaA');
		$revisadoA=$this->model->editRevision($codigoE,$fechaR,3,$tabla);
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data=array("codigoMapa"=>$codigo);
		if($this->model->editMapa($id,$data) && $this->model->insertCambio($version,$desc,$fecha,$tabla) && $revisadoA && $revisadoR && $revisadoE){
			$mensaje="Mapa editado con exito";
		}else{
			$mensaje="Falló al editar el mapa";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/seeMapP');
	}
	/**
	 * Este metodo carga el alcance de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updateAlcance(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';
		$text=$this->input->post('text');
		$id=$this->input->post('id');
		$codigo=$this->input->post('codigoAlcance');
		$version=$this->input->post('version');
		$desc=$this->input->post('desc');
		$fecha=$this->input->post('fechaVigencia');
		$tabla=6;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaR=$this->input->post('fechaE');
		$revisadoE=$this->model->editRevision($codigoE,$fechaR,1,$tabla);
		/**-------Variables revisado-----------*/
		$codigoE=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		$revisadoR=$this->model->editRevision($codigoE,$fechaR,2,$tabla);
		/**-------Variables aprobado-----------*/
		$codigoE=$this->input->post('aprobado');
		$fechaR=$this->input->post('fechaA');
		$revisadoA=$this->model->editRevision($codigoE,$fechaR,3,$tabla);

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data=array("codigoAlcance"=>$codigo,"texto"=>$text);
		if($this->model->editAlcance($id,$data) && $this->model->insertCambio($version,$desc,$fecha,$tabla) && $revisadoA && $revisadoR && $revisadoE){
			$mensaje="Alcance editado con exito";
		}else{
			$mensaje="Falló al editar el Alcance";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/alcance');
	}
	/**
	 * Este metodo carga  la vision de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updateVision(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';
		$text=$this->input->post('text');
		$id=$this->input->post('id');
		$codigo=$this->input->post('codigoVision');
		$version=$this->input->post('version');
		$desc=$this->input->post('desc');
		$fecha=$this->input->post('fechaVigencia');
		$tabla=2;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaR=$this->input->post('fechaE');
		$revisadoE=$this->model->editRevision($codigoE,$fechaR,1,$tabla);
		/**-------Variables revisado-----------*/
		$codigoE=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		$revisadoR=$this->model->editRevision($codigoE,$fechaR,2,$tabla);
		/**-------Variables aprobado-----------*/
		$codigoE=$this->input->post('aprobado');
		$fechaR=$this->input->post('fechaA');
		$revisadoA=$this->model->editRevision($codigoE,$fechaR,3,$tabla);

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data=array("codigoVision"=>$codigo,"texto"=>$text);
		if($this->model->editVision($id,$data) && $this->model->insertCambio($version,$desc,$fecha,$tabla) && $revisadoA && $revisadoR && $revisadoE){
			$mensaje="Visión editada con exito";
		}else{
			$mensaje="Falló al editar la Visión";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/vision');
	}
	/**
	 * Este metodo ingresa los datos 
	 * de la informacion general 
	 * del acta de la revision por
	 * la direccion en la tabla acta
	 */
	public function insertActa()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$periodo=$this->input->post('periodo');
		$periodo1=$this->input->post('periodo1');
		$fechaReunion=date("Y-m-d", strtotime($this->input->post('fechaR')));
		$lugar=$this->input->post('lugarR');
		$hora=$this->input->post('hora');
		$hora1=$this->input->post('hora1');
		$preambulo=$this->input->post('preambulo');
		$mision=$this->input->post('mision');
		$vision=$this->input->post('vision');
		$politica=$this->input->post('politica');
		$objetivos=$this->input->post('objetivos');
		$politicaSG=$this->input->post('politicaSG');
		$objetivosSG=$this->input->post('objetivosSG');
		//
		$codigoActa=$this->input->post('codigoActa');
		$version=$this->input->post('version');
		$fechaVigencia=date("Y-m-d", strtotime($this->input->post('fVigencia')));
		//Variables asistentes 
		$nombreA=$this->input->post('nameA');
		$cargoA=$this->input->post('cargoA');
		$procesoA=$this->input->post('procesoA');
		$idActa=$this->input->post('idActa');
		if (isset($periodo) && isset($periodo1) && isset($hora)
			&& isset($hora1) && isset($preambulo) && isset($mision)
			&& isset($vision) && isset($politica) && isset($objetivos)
			&& isset($politicaSG) && isset($objetivosSG) && isset($nombreA)
			&& isset($cargoA) && isset($procesoA) && isset($idActa)
			&& isset($fechaReunion)
		){
			$per=$periodo.'/'.$periodo1;
			$hor=date("g:i a",strtotime($hora)).' - '.date("g:i a",strtotime($hora1));
			$idActa=$this->model->insertActaInformacionGeneral($per,$fechaReunion,$lugar,$hor,$preambulo,$mision,$vision,$politica,$objetivos,$politicaSG,$objetivosSG,$codigoActa,$version,$fechaVigencia);
			if ($idActa!=FALSE
				&& $this->model->insertAsistentes($nombreA,$cargoA,$procesoA,$idActa)
				){
				$this->session->set_userdata('idActa',$idActa);
				redirect('calidad/buildActa');
			}else{
				redirect('');
			}
		}else{ 
			redirect('');
		}
	}
	public function updateActa()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		$periodo=$this->input->post('periodo');
		$periodo1=$this->input->post('periodo1');
		$fechaReunion=date("Y-m-d", strtotime($this->input->post('fechaR')));
		$lugar=$this->input->post('lugarR');
		$hora=$this->input->post('hora');
		$hora1=$this->input->post('hora1');
		$preambulo=$this->input->post('preambulo');
		$mision=$this->input->post('mision');
		$vision=$this->input->post('vision');
		$politica=$this->input->post('politica');
		$objetivos=$this->input->post('objetivos');
		$politicaSG=$this->input->post('politicaSG');
		$objetivosSG=$this->input->post('objetivosSG');
		//Variables asistentes 
		$nombreA=$this->input->post('nameA');
		$cargoA=$this->input->post('cargoA');
		$procesoA=$this->input->post('procesoA');
		$idActa=$this->input->post('idActa');
		$idAsistente=$this->input->post('idAsistente');

		//
		$codigoActa=$this->input->post('codigoActa');
		$version=$this->input->post('version');
		$fechaVigencia=date("Y-m-d", strtotime($this->input->post('fVigencia')));
		if (isset($periodo) && isset($periodo1) && isset($hora)
			&& isset($hora1) && isset($preambulo) && isset($mision)
			&& isset($vision) && isset($politica) && isset($objetivos)
			&& isset($politicaSG) && isset($objetivosSG) && isset($nombreA)
			&& isset($cargoA) && isset($procesoA) && isset($idActa)
			&& isset($fechaReunion)
		){
			$per=$periodo.'/'.$periodo1;
			$hor=date("g:i a",strtotime($hora)).' - '.date("g:i a",strtotime($hora1));
			if ($this->model->updateActaInformacionGeneral($idActa,$per,$fechaReunion,$lugar,$hor,$preambulo,$mision,$vision,$politica,$objetivos,$politicaSG,$objetivosSG,$codigoActa,$version,$fechaVigencia)
				&& $this->model->insertNewAsistentes($idAsistente,$nombreA,$cargoA,$procesoA,$idActa)&& $this->model->updateAsistentesActa($idAsistente,$nombreA,$cargoA,$procesoA)
			)
				$this->session->set_userdata('mensaje','Informacion General editada con exito');
				redirect('calidad/editActa/'.$idActa);
		}else{ 
			redirect('');
		}
	}
	/**
	 * [insertEditActaContenido description]
	 * @return [type] [description]
	 */
    public function insertEditActaContenido(){

        /* ----------- VALIDA ACCESO USUARIO ----------- */
        $this->validateSession();

        $this->validateUsuario();
        $modulos=7;
        $acta=$this->input->post('idActa');
        $valor=TRUE;
        $mensaje=' ';
        $resData;
        $res=TRUE;
        $arrayImg=array();
        $arrayTextoImg=array();
        $arrayImgTexto=array();
        if (!empty($_FILES)) {
       	 for ($j=1; $j <=$modulos ; $j++) { 
            for ($i=1; $i <=count($_FILES) ; $i++) { 
            if (!empty($_FILES['userImageImg_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageImg_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImg_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('img_index_id['.$j.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Imagen
                                            if (!empty($img)) {
                                                $arrayImg=array("nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."img".']['.$j.']'));
                                                $resData=$this->model->InsertImgActa($arrayImg);
                                                    if(!$resData){
                                                        $res=$resData;
                                                        }
                                            }       
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
                                }                                       
                            } else {
                                $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
                        }
                    }
                }//fin if img
                if (!empty($_FILES['userImageImgTexto_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageImgTexto_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImgTexto_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('img_index_id['.$j.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Imagen-Texto
                                            $imgTexto=$this->input->post('imgTexto_index_id['.$j.']');
                                            if (!empty($imgTexto)) {
                                                $arrayImgTexto=array("texto"=>$this->input->post('textoT_'.$i.'['.$j.']'),"nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."imgTexto".']['.$j.']'));
                                                $resData=$this->model->InsertImgTextoActa($arrayImgTexto);
                                                    if(!$resData){
                                                        $res=$resData;
                                                    }       
                                            }   
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
                                }                                       
                            } else {
                                $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
                        }
                    }
                }//fin if imgtexto
                if (!empty($_FILES['userImageTextoImg_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageTextoImg_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageTextoImg_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('img_index_id['.$j.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Texto-Imagen
                                                $textoImg=$this->input->post('textoImg_index_id['.$j.']');
                                                if (!empty($textoImg)) {
                                                    $arrayTextoImg=array("texto"=>$this->input->post('textoI_'.$i.'['.$j.']'),"nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."textoImg".']['.$j.']'));
                                                    $resData=$this->model->InsertTextoImgActa($arrayTextoImg);
                                                        if(!$resData){
                                                            $res=$resData;
                                                        }       
                                                }   
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
                                }                                       
                            } else {
                                $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
                        }
                    }
                }//fin if textoimg
            }//fin foreach $i

            //Editar imagenes
            $k=$this->input->post('img_index_id['.$j.']');
            for ($i=1; $i <=$k ; $i++) { 
            	if (!empty($_FILES['userImageImgE_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageImgE_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImgE_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('idImg_'.$j.'['.$i.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Imagen
                                            if (!empty($img)) {
                                                $resData=$this->model->updateImgActa($nombre_Doc,$img);
                                                    if(!$resData){
                                                        $res=$resData;
                                                        }
                                            }       
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
                                }                                       
                            } else {
                               $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.', cambie el nombre e intente de nuevo.';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
                        }
                    }
                }//fin if img
            }
            $k=$this->input->post('imgTexto_index_id['.$j.']');
            for ($i=1; $i <=$k ; $i++) { 
            if (!empty($_FILES['userImageImgTextoE_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageImgTextoE_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImgTextoE_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('img_index_id['.$j.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Imagen-Texto
                                            $imgTexto=$this->input->post('idImg_'.$j.'['.$i.']');
                                            if (!empty($imgTexto)) {
                                                $resData=$this->model->updateImgTextoActa($nombre_Doc,$imgTexto,'');
                                                    if(!$resData){
                                                        $res=$resData;
                                                    }       
                                            }   
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'\n';
                                }                                       
                            } else {
                                $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.', cambie el nombre e intente de nuevo.';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'\n';
                        }
                    }
                }//fin if imgtextoE
            }//fin k
            $k=$this->input->post('textoImg_index_id['.$j.']');
            for ($i=1; $i <=$k ; $i++) { 
            	if (!empty($_FILES['userImageTextoImgE_'.$i.'_'.$j])) {
                $targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
                    $tempFile = utf8_encode($_FILES['userImageTextoImgE_'.$i.'_'.$j]['tmp_name']);
                    $nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageTextoImgE_'.$i.'_'.$j]['name']));
                    $fileTypes = array('jpg','jpeg','png','gif');
                    $fileParts = pathinfo($nombre_Doc);
                    $ext_Doc = strtolower($fileParts['extension']);
                    $longitud_nombre = strlen($nombre_Doc); 
                    $fecha = date('o-m-d-H');
                    if ($this->folderSystemActa($targetPathDoc,$j)) {
                    $targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
                        if (in_array($ext_Doc,$fileTypes)) {
                            if (!file_exists($targetFile)) {
                                if (move_uploaded_file($tempFile,$targetFile)) {
                                        $mensaje .='Imagenes cargado correctamente   ';
                                        $valor=TRUE;
                                        $img=$this->input->post('img_index_id['.$j.']');
                                        list($ancho, $alto) = getimagesize($targetFile);
                                                        if ($ancho >= 475 || $alto >= 330)
                                                        {
                                                            if ($ancho >= 475) {
                                                                $ancho_final = 475;     
                                                            } else {
                                                                $ancho_final = $ancho;
                                                            }
                                                            if ($alto >= 330) {
                                                                $alto_final =330;
                                                            } else {
                                                                $alto_final = $alto;
                                                            }
                                                                $this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
                                                            $mensaje .=' Tamaño corregido  ';
                                                        }
                                            //Datos Texto-Imagen
                                                $imgTexto=$this->input->post('idImg_'.$j.'['.$i.']');
	                                            if (!empty($imgTexto)) {
	                                                $resData=$this->model->updateTextoImgActa($nombre_Doc,$imgTexto,'');
	                                                    if(!$resData){
	                                                        $res=$resData;
	                                                    }       
	                                            }     
                                    }
                                 else {
                                    $mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
                                }                                       
                            } else {
                                $mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
                            }
                        } else {
                            $mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
                        }
                    }
                }//fin if textoimg
            }
        }//fin foreach $j
        
        }else{
            $mensaje.=' ';
            $valor=TRUE;
        }   
        if ($valor && isset($acta)) {
        $arraySubtitulo=array();
        $arrayEncabezado=array();
        $arrayTexto=array();
        $arrayTableTwo=array();
        $arrayFilaTwo=array();
        for ($i=1; $i <=$modulos ; $i++) { 
            $subtitulo=$this->input->post('subtitulo_index_id['.$i.']');
            $encabezado=$this->input->post('encabezado_index_id['.$i.']');
            $texto=$this->input->post('texto_index_id['.$i.']');
            $tableTwo=$this->input->post('tableTwo_index_id['.$i.']');
            $tableThree=$this->input->post('tableThree_index_id['.$i.']');
            $tableFour=$this->input->post('tableFour_index_id['.$i.']');
            $tableOtro=$this->input->post('tableOtro_index_id['.$i.']');
            $graphicBarra=$this->input->post('graficoBarra_index_id['.$i.']');
            $graphicPie=$this->input->post('graficoPie_index_id['.$i.']');
            $graphicLineal=$this->input->post('graficoLinea_index_id['.$i.']');
            //----variables editar 
            $ordenSubtitulo=$this->input->post('numeroOrden_'.$i.'[subtitulo]');
            $ordenEncabezado=$this->input->post('numeroOrden_'.$i.'[encabezado]');
            $ordenTexto=$this->input->post('numeroOrden_'.$i.'[texto]');
            $ordenImagenTexto=$this->input->post('imgTexto_index_id['.$i.']');
            $ordenTextoImagen=$this->input->post('textoImg_index_id['.$i.']');
            $ordenTableTwo=$this->input->post('tableTwoE_index_id['.$i.']');
            $ordenTableThree=$this->input->post('tableThreeE_index_id['.$i.']');
            $ordenTableFour=$this->input->post('tableFourE_index_id['.$i.']');
            $ordenTableFive=$this->input->post('tableFiveE_index_id['.$i.']');
            $ordenTableSix=$this->input->post('tableSixE_index_id['.$i.']');
            $ordenTableSeven=$this->input->post('tableSevenE_index_id['.$i.']');
            $ordenGraphicBarra=$this->input->post('graficoBarraE_index_id['.$i.']');
            $ordenGraphicPie=$this->input->post('graficoPieE_index_id['.$i.']');
            $ordenGraphicLinea=$this->input->post('graficoLineaE_index_id['.$i.']');

            //----------
            //Datos subtitulo
            if (!empty($subtitulo)) {
                for ($j=1; $j <=$subtitulo; $j++) { 
                $arraySubtitulo=array("texto"=>$this->input->post('subtituloActa_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."subtitulo".']['.$i.']'));
                $resData=$this->model->InsertSubtituloActa($arraySubtitulo);
                    if(!$resData){
                        $res=$resData;
                    }
                }        
            }
            if(!empty($ordenSubtitulo)){
        		for ($j=1; $j <=$ordenSubtitulo; $j++) { 
                    $arraySubtitulo=array('texto'=>$this->input->post('subtituloActaE_'.$j.'['.$i.']'));
                    $idSub=$this->input->post('idSubtitulo_'.$j.'['.$i.']');
                    $resData=$this->model->updateSubtituloActa($idSub,$arraySubtitulo);
                    if(!$resData){
                        $res=$resData;
                    }
       			}
            }
            //Datos encabezado
            if (!empty($encabezado)) {
                for ($j=1; $j <=$encabezado; $j++) { 
                $arrayEncabezado=array("texto"=>$this->input->post('encabezadoActa_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."encabezado".']['.$i.']'));
                $resData=$this->model->InsertEncabezadoActa($arrayEncabezado);
                    if(!$resData){
                        $res=$resData;
                    }
                }       
            }
            if(!empty($ordenEncabezado)){
            	for ($j=1; $j <=$ordenEncabezado; $j++) { 
                    $arrayEncabezado=array('texto'=>$this->input->post('encabezadoActaE_'.$j.'['.$i.']'));
                    $idEnc=$this->input->post('idEncabezado_'.$j.'['.$i.']');
                    $resData=$this->model->updateEncabezadoActa($idEnc,$arrayEncabezado);
                    if(!$resData){
                        $res=$resData;
                    }
       			}
            }
            //Datos Texto
            if (!empty($texto)) {
                for ($j=1; $j <=$texto; $j++) { 
                $arrayTexto=array("texto"=>$this->input->post('texto_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."texto".']['.$i.']'));
                $resData=$this->model->InsertTextoActa($arrayTexto);
                    if(!$resData){
                        $res=$resData;
                    }
                }       
            }
            if(!empty($ordenTexto)){
            	for ($j=1; $j <=$ordenTexto; $j++) { 
                    $arrayTexto=array('texto'=>$this->input->post('textoE_'.$j.'['.$i.']'));
                    $idTex=$this->input->post('idTexto_'.$j.'['.$i.']');
                    $resData=$this->model->updateTextoActa($idTex,$arrayTexto);
                    if(!$resData){
                        $res=$resData;
                    }
       			}
            }
            if(!empty($ordenImagenTexto)){
            	for ($j=1; $j <=$ordenImagenTexto; $j++) { 
                    $tex=$this->input->post('textoTE_'.$j.'['.$i.']');
                    $imgTexto=$this->input->post('idImgTexto_'.$i.'['.$j.']');//id
                    $resData=$this->model->updateImgTextoActa('',$imgTexto,$tex);
                    if(!$resData){
                        $res=$resData;
                    }
       			}
            }
            if(!empty($ordenTextoImagen)){
            	for ($j=1; $j <=$ordenTextoImagen; $j++) { 
                    $tex=$this->input->post('textoIE_'.$j.'['.$i.']');
                    $imgTexto=$this->input->post('idTextoImg_'.$i.'['.$j.']');//id
                    $resData=$this->model->updateTextoImgActa('',$imgTexto,$tex);
                    if(!$resData){
                        $res=$resData;
                    }
       			}
            }
            if (!empty($ordenTableTwo)) {
            	for ($j=1; $j<=$ordenTableTwo ; $j++) { 
            		$countFila=$this->input->post('filaTwoE_index_id'.$j.'['.$i.']');
            		$id=$this->input->post('idTableTwoE_'.$i.'['.$j.']');
            		$name1=$this->input->post('tituloITDE2_'.$j.'['.$i.']');
            		$name2=$this->input->post('tituloDTDE2_'.$j.'['.$i.']');
            		$resData=$this->model->updateTableTwo($id,$name1,$name2);
                    if(!$resData){
                        $res=$resData;
                    }
            		for ($k=1; $k <=$countFila ; $k++) { 
            			$idF=$this->input->post('idFilaTwoE'.$j.'_'.$k.'['.$i.']" ');
            			$text1=$this->input->post('textoITDE'.$j.'_'.$k.'['.$i.']');
            			$text2=$this->input->post('textoDTDE'.$j.'_'.$k.'['.$i.']');
            			if(isset($text2)&&isset($text1)){
            				$resData=$this->model->updateFilaTwo($idF,$text1,$text2);
	            			if(!$resData){
	                        $res=$resData;
	                    	}
            			}
            		}
            		$countFila=$this->input->post('con_'.$j.'['.$i.']');
            		for ($k=1; $k <=$countFila ; $k++) { 
            			$text1=$this->input->post('textoITDN_'.$j.'_'.$k.'['.$i.']');
            			$text2=$this->input->post('textoDTDN_'.$j.'_'.$k.'['.$i.']');
            			if(isset($text1)&&isset($text2)){
							$resData=$this->model->insertFilaTwo($text1,$text2,$id);
		            			if(!$resData){
		                        $res=$resData;
		                    	}
            			}
            			
            		}
            	}
            }
            if (!empty($ordenTableThree)) {
            	for ($j=1; $j<=$ordenTableThree ; $j++) { 
            		$countFila=$this->input->post('filaThreeE_index_id'.$j.'['.$i.']');
            		$id=$this->input->post('idTableThreeE_'.$i.'['.$j.']');
            		$name1=$this->input->post('tituloITDE3_'.$j.'['.$i.']');
            		$name2=$this->input->post('tituloCTDE3_'.$j.'['.$i.']');
            		$name3=$this->input->post('tituloDTDE3_'.$j.'['.$i.']');
            		$resData=$this->model->updateTableThree($id,$name1,$name2,$name3);
                    if(!$resData){
                        $res=$resData;
                    }
            		for ($k=1; $k <=$countFila ; $k++) { 
            			$idF=$this->input->post('idFilaThreeE'.$j.'_'.$k.'['.$i.']');
            			$text1=$this->input->post('textoITD3E_'.$j.'_'.$k.'['.$i.']');
            			$text2=$this->input->post('textoCTD3E_'.$j.'_'.$k.'['.$i.']');
            			$text3=$this->input->post('textoDTD3E_'.$j.'_'.$k.'['.$i.']');
            			if(isset($text1)&&isset($text2)&&isset($text3)){ 
            				$resData=$this->model->updateFilaThree($idF,$text1,$text2,$text3);
	            			if(!$resData){
	                        $res=$resData;
	                    	}
            			}
            		}
            		$countFila=$this->input->post('con3_'.$j.'['.$i.']');
            		for ($k=1; $k <=$countFila ; $k++) { 
            			$text1=$this->input->post('textoITD3N_'.$j.'_'.$k.'['.$i.']');
            			$text2=$this->input->post('textoCTD3N_'.$j.'_'.$k.'['.$i.']');
            			$text3=$this->input->post('textoDTD3N_'.$j.'_'.$k.'['.$i.']');
            			if(isset($text1)&&isset($text2)&&isset($text3)){
							$resData=$this->model->insertFilaThree($text1,$text2,$text3,$id);
		            			if(!$resData){
		                        $res=$resData;
		                    	}
            			}
            		}
            	}
            }
            if (!empty($ordenTableFour)) {
            	for ($j=1; $j <=$ordenTableFour ; $j++) { 
            		$countFila=$this->input->post('filaFourE_index_id'.$j.'['.$i.']');
					$id=$this->input->post('idTableFourE_'.$i.'['.$j.']');
					$name1=$this->input->post('tituloITDE4_'.$j.'['.$i.']');
					$name2=$this->input->post('tituloCITDE4_'.$j.'['.$i.']');
					$name3=$this->input->post('tituloCDTDE4_'.$j.'['.$i.']');
					$name4=$this->input->post('tituloDTDE4_'.$j.'['.$i.']');
					$resData=$this->model->updateTableFour($id,$name1,$name2,$name3,$name4);
			        if(!$resData){
			            $res=$resData;
			        }
					for ($k=1; $k <=$countFila ; $k++) { 
						$idF=$this->input->post('idFilaFourE'.$j.'_'.$k.'['.$i.']');
						$text1=$this->input->post('textoITD4E_'.$j.'_'.$k.'['.$i.']');
						$text2=$this->input->post('textoCITD4E_'.$j.'_'.$k.'['.$i.']');
						$text3=$this->input->post('textoCDTD4E_'.$j.'_'.$k.'['.$i.']');
						$text4=$this->input->post('textoDTD4E_'.$j.'_'.$k.'['.$i.']');
						if(isset($text1)&&isset($text2)&&isset($text3)&&isset($text4)){
							$resData=$this->model->updateFilaFour($idF,$text1,$text2,$text3,$text4);
			    			if(!$resData){
			                $res=$resData;
			            	}
						}
					}
					$countFila=$this->input->post('con4_'.$j.'['.$i.']');
					for ($k=1; $k <=$countFila ; $k++) { 
						$text1=$this->input->post('textoITD4N_'.$j.'_'.$k.'['.$i.']');
						$text2=$this->input->post('textoCITD4N_'.$j.'_'.$k.'['.$i.']');
						$text3=$this->input->post('textoCDTD4N_'.$j.'_'.$k.'['.$i.']');
						$text4=$this->input->post('textoDTD4N_'.$j.'_'.$k.'['.$i.']');
						if(isset($text1)&&isset($text2)&&isset($text3)&&isset($text4)){
							$resData=$this->model->insertFilaFour($text1,$text2,$text3,$text4,$id);
			        			if(!$resData){
			                    $res=$resData;
			                	}
						}
					}
            	}
            }
            if (!empty($ordenTableFive)) {	
				for ($j=1; $j <=$ordenTableFive; $j++) {
					$colum1='';
					$colum2='';
					$colum3='';
					$colum4='';
					$colum5='';
            		$textoColumna1=[];
					$textoColumna2=[];
					$textoColumna3=[];
					$textoColumna4=[];
					$textoColumna5=[];
					$filasCol1=[];
					$filasCol2=[];
					$filasCol3=[];
					$filasCol4=[];
					$filasCol5=[];
					$textoColumna='';
					$conTexto1=0;
					$conTexto2=0;
					$conTexto3=0;
					$conTexto4=0;
					$conTexto5=0; 
					$columnaOtroE=$this->input->post('columnaFiveE_'.$j.'['.$i.']');
						for ($m=1; $m <=5; $m++) { 
			        		if ($m==1) {
			            		$colum1=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
			        		}else if($m==2){
			            		$colum2=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');   
			        		}else if($m==3){
			            		$colum3=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
			        		}else if($m==4){
			            		$colum4=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
			        		}else if($m==5){
			            		$colum5=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
			        		}
		    			}

					$id=$this->input->post('idTableFiveE_'.$i.'['.$columnaOtroE.']');
					if(!empty($colum1)&&!empty($colum2)&&!empty($colum3)&&!empty($colum4)&&!empty($colum5)&&!empty($id)){
						$res=$this->model->updateTableFive($id,$colum1,$colum2,$colum3,$colum4,$colum5);

					}
					//Filas
					$posTableOtroE=$this->input->post('posTableFiveE_'.$j.'['.$i.']');
					    for ($k=1; $k <=$posTableOtroE; $k++) { 
					        $indexCol=0;
					        $fc=1;
					        $filasCol1[$indexCol++]=$fc;
					        while($fc<$posTableOtroE) { 
					            $fc=$fc+5;
					            $filasCol1[$indexCol++]=$fc;
					        }
					        $indexCol=0;
					        $fc=2;
					        $filasCol2[$indexCol++]=$fc;
					        while($fc<$posTableOtroE) { 
					            $fc=$fc+5;
					            $filasCol2[$indexCol++]=$fc;
					        }
					        $indexCol=0;
					        $fc=3;
					        $filasCol3[$indexCol++]=$fc;
					        while($fc<=$posTableOtroE) { 
					            $fc=$fc+5;
					            $filasCol3[$indexCol++]=$fc;
					        }
					        $indexCol=0;
					        $fc=4;
					        $filasCol4[$indexCol++]=$fc;
					        while($fc<=$posTableOtroE) { 
					            $fc=$fc+5;
					            $filasCol4[$indexCol++]=$fc;
					        }
					        $indexCol=0;
					        $fc=5;
					        $filasCol5[$indexCol++]=$fc;
					        while($fc<=$posTableOtroE) { 
					            $fc=$fc+5;
					            $filasCol5[$indexCol++]=$fc;
					        }
					        unset($filasCol1[array_pop($filasCol1)]);
					        unset($filasCol2[array_pop($filasCol2)]);
					        unset($filasCol3[array_pop($filasCol3)]);
					        unset($filasCol4[array_pop($filasCol4)]);
					        unset($filasCol5[array_pop($filasCol5)]);                       
					    }
					    for ($l=0; $l <count($filasCol1); $l++) { 
					            $textoColumna=$this->input->post('textoOtroN'.$filasCol1[$l].'TD_'.$i.'['.$columnaOtroE.']');
					            $textoColumna1[$conTexto1++]=$textoColumna;
					        }
					    for ($l=0; $l <count($filasCol2); $l++) { 
					        $textoColumna=$this->input->post('textoOtroN'.$filasCol2[$l].'TD_'.$i.'['.$columnaOtroE.']');
					        $textoColumna2[$conTexto2++]=$textoColumna;
					    }
					    for ($l=0; $l <count($filasCol3); $l++) { 
					        $textoColumna=$this->input->post('textoOtroN'.$filasCol3[$l].'TD_'.$i.'['.$columnaOtroE.']');
					        $textoColumna3[$conTexto3++]=$textoColumna;
					    }
					    for ($l=0; $l <count($filasCol4); $l++) { 
					        $textoColumna=$this->input->post('textoOtroN'.$filasCol4[$l].'TD_'.$i.'['.$columnaOtroE.']');
					        $textoColumna4[$conTexto4++]=$textoColumna;
					    }
					    for ($l=0; $l <count($filasCol5); $l++) { 
					        $textoColumna=$this->input->post('textoOtroN'.$filasCol5[$l].'TD_'.$i.'['.$columnaOtroE.']');
					        $textoColumna5[$conTexto5++]=$textoColumna;
					    }
						$conId=$this->input->post('filaFiveE_index_id'.$j.'['.$i.']');
						$posTexto=0;
						for ($p=1; $p <=$conId ; $p++) {
						$id=$this->input->post('idFilaFiveE'.$j.'_'.$p.'['.$i.']');
							if(!empty($textoColumna1)&&!empty($textoColumna2)&&!empty($textoColumna3)&&!empty($textoColumna4)&&!empty($textoColumna5)&&!empty($id)){
								$res=$this->model->updateFilaFive($textoColumna1[$posTexto],$textoColumna2[$posTexto],$textoColumna3[$posTexto],$textoColumna4[$posTexto],$textoColumna5[$posTexto],$id);
								$posTexto++;
							}
						}
				}
            } 
            if(!empty($ordenTableSeven)){
	            for ($j=1; $j <=$ordenTableSeven; $j++){
	            	$colum1='';
					$colum2='';
					$colum3='';
					$colum4='';
					$colum5='';
					$colum6='';
					$colum7='';
            		$textoColumna1=[];
                    $textoColumna2=[];
                    $textoColumna3=[];
                    $textoColumna4=[];
                    $textoColumna5=[];
                    $textoColumna6=[];
                    $textoColumna7=[];
                    $filasCol1=[];
                    $filasCol2=[];
                    $filasCol3=[];
                    $filasCol4=[];
                    $filasCol5=[];
                    $filasCol6=[];
                    $filasCol7=[];
                    $textoColumna='';
                    $conTexto1=0;
                    $conTexto2=0;
                    $conTexto3=0;
                    $conTexto4=0;
                    $conTexto5=0; 
                    $conTexto6=0; 
                    $conTexto7=0;
                    $columnaOtroE=$this->input->post('columnaSevenE_'.$i.'['.$j.']');
                    for ($m=1; $m <=7; $m++) { 
                        if ($m==1) {
                            $colum1=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }else if($m==2){
                            $colum2=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');   
                        }else if($m==3){
                            $colum3=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }else if($m==4){
                            $colum4=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }else if($m==5){
                            $colum5=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }else if($m==6){
                            $colum6=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }else if($m==7){
                            $colum7=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
                        }
                    }
                    $id=$this->input->post('idTableSevenE_'.$i.'['.$columnaOtroE.']');
			        if(!empty($colum1)&&!empty($colum2)&&!empty($colum3)&&!empty($colum4)&&!empty($colum5)&&!empty($colum6)&&!empty($colum7)&&!empty($id)){
						$res=$this->model->updateTableSeven($id,$colum1,$colum2,$colum3,$colum4,$colum5,$colum6,$colum7);
					}
					//Filas
					$posTableOtroE=$this->input->post('posTableSevenE_'.$i.'['.$j.']');
                    for ($k=1; $k <=$posTableOtroE; $k++) { 
                        $indexCol=0;
                        $fc=1;
                        $filasCol1[$indexCol++]=$fc;
                        while($fc<$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol1[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=2;
                        $filasCol2[$indexCol++]=$fc;
                        while($fc<$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol2[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=3;
                        $filasCol3[$indexCol++]=$fc;
                        while($fc<=$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol3[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=4;
                        $filasCol4[$indexCol++]=$fc;
                        while($fc<=$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol4[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=5;
                        $filasCol5[$indexCol++]=$fc;
                        while($fc<=$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol5[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=6;
                        $filasCol6[$indexCol++]=$fc;
                        while($fc<=$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol6[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=7;
                        $filasCol7[$indexCol++]=$fc;
                        while($fc<=$posTableOtroE) { 
                            $fc=$fc+7;
                            $filasCol7[$indexCol++]=$fc;
                        }
                        unset($filasCol1[array_pop($filasCol1)]);
                        unset($filasCol2[array_pop($filasCol2)]);
                        unset($filasCol3[array_pop($filasCol3)]);
                        unset($filasCol4[array_pop($filasCol4)]);
                        unset($filasCol5[array_pop($filasCol5)]);
                        unset($filasCol6[array_pop($filasCol6)]);
                        unset($filasCol7[array_pop($filasCol7)]);                       
                    }
                    for ($l=0; $l <count($filasCol1); $l++) { 
                            $textoColumna=$this->input->post('textoSevenN'.$filasCol1[$l].'TD_'.$i.'['.$columnaOtroE.']');
                            $textoColumna1[$conTexto1++]=$textoColumna;
                        }
                    for ($l=0; $l <count($filasCol2); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol2[$l].'TD_'.$i.'['.$columnaOtroE.']');
                        $textoColumna2[$conTexto2++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol3); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol3[$l].'TD_'.$i.'['.$columnaOtroE.']');
                        $textoColumna3[$conTexto3++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol4); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol4[$l].'TD_'.$i.'['.$columnaOtroE.']');
                        $textoColumna4[$conTexto4++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol5); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol5[$l].'TD_'.$i.'['.$columnaOtroE.']');
                        $textoColumna5[$conTexto5++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol6); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol6[$l].'TD_'.$i.'['.$columnaOtroE.']');
                        $textoColumna6[$conTexto6++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol7); $l++) { 
                        $textoColumna=$this->input->post('textoSevenN'.$filasCol7[$l].'TD_'.$i.'['.$j.']');
                        $textoColumna7[$conTexto7++]=$textoColumna;
                    }
                    $conId=$this->input->post('filaSevenE_index_id'.$j.'['.$i.']');
					$posTexto=0;
					for ($p=1; $p <=$conId ; $p++) {
						$id=$this->input->post('idFilaSevenE'.$j.'_'.$p.'['.$i.']');
						if(!empty($textoColumna1)&&!empty($textoColumna2)&&!empty($textoColumna3)&&!empty($textoColumna4)&&!empty($textoColumna5)&&!empty($textoColumna6)&&!empty($textoColumna7)&&!empty($id)){
							$res=$this->model->updateFilaSeven($textoColumna1[$posTexto],$textoColumna2[$posTexto],$textoColumna3[$posTexto],$textoColumna4[$posTexto],$textoColumna5[$posTexto],$textoColumna6[$posTexto],$textoColumna7[$posTexto],$id);
							$posTexto++;
						}
					}
	            }
	        }//fin if
            if (!empty($ordenTableSix)) {
            	for ($j=1; $j <=$ordenTableSix; $j++) {
            		$colum1='';
					$colum2='';
					$colum3='';
					$colum4='';
					$colum5='';
					$colum6='';
            		$textoColumna1=[];
					$textoColumna2=[];
					$textoColumna3=[];
					$textoColumna4=[];
					$textoColumna5=[];
					$textoColumna6=[];
					$filasCol1=[];
					$filasCol2=[];
					$filasCol3=[];
					$filasCol4=[];
					$filasCol5=[];
					$filasCol6=[];
					$textoColumna='';
					$conTexto1=0;
					$conTexto2=0;
					$conTexto3=0;
					$conTexto4=0;
					$conTexto5=0; 
					$conTexto6=0; 
            		$columnaOtroE=$this->input->post('columnaSixE_'.$j.'['.$i.']');
	                    for ($m=1; $m <=6; $m++) { 
	                        if ($m==1) {
	                            $colum1=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
	                        }else if($m==2){
	                            $colum2=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');   
	                        }else if($m==3){
	                            $colum3=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
	                        }else if($m==4){
	                            $colum4=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
	                        }else if($m==5){
	                            $colum5=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
	                        }else if($m==6){
	                            $colum6=$this->input->post('tituloN_'.$m.'TD_'.$i.'['.$columnaOtroE.']');
	                        }
	                    }
	                    $id=$this->input->post('idTableSixE_'.$i.'['.$columnaOtroE.']');
	                    if(!empty($colum1)&&!empty($colum2)&&!empty($colum3)&&!empty($colum4)&&!empty($colum5)&&!empty($colum6)&&!empty($id)){
							$res=$this->model->updateTableSix($id,$colum1,$colum2,$colum3,$colum4,$colum5,$colum6);
						}
	                    //Filas
	                    $posTableOtroE=$this->input->post('posTableSixE_'.$j.'['.$i.']');
	                    for ($k=1; $k <=$posTableOtroE; $k++) { 
	                        $indexCol=0;
	                        $fc=1;
	                        $filasCol1[$indexCol++]=$fc;
	                        while($fc<$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol1[$indexCol++]=$fc;
	                        }
	                        $indexCol=0;
	                        $fc=2;
	                        $filasCol2[$indexCol++]=$fc;
	                        while($fc<$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol2[$indexCol++]=$fc;
	                        }
	                        $indexCol=0;
	                        $fc=3;
	                        $filasCol3[$indexCol++]=$fc;
	                        while($fc<=$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol3[$indexCol++]=$fc;
	                        }
	                        $indexCol=0;
	                        $fc=4;
	                        $filasCol4[$indexCol++]=$fc;
	                        while($fc<=$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol4[$indexCol++]=$fc;
	                        }
	                        $indexCol=0;
	                        $fc=5;
	                        $filasCol5[$indexCol++]=$fc;
	                        while($fc<=$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol5[$indexCol++]=$fc;
	                        }
	                        $indexCol=0;
	                        $fc=6;
	                        $filasCol6[$indexCol++]=$fc;
	                        while($fc<=$posTableOtroE) { 
	                            $fc=$fc+6;
	                            $filasCol6[$indexCol++]=$fc;
	                        }
	                        unset($filasCol1[array_pop($filasCol1)]);
	                        unset($filasCol2[array_pop($filasCol2)]);
	                        unset($filasCol3[array_pop($filasCol3)]);
	                        unset($filasCol4[array_pop($filasCol4)]);
	                        unset($filasCol5[array_pop($filasCol5)]);
	                        unset($filasCol6[array_pop($filasCol6)]);                       
	                    }
	                    for ($l=0; $l <count($filasCol1); $l++) { 
	                            $textoColumna=$this->input->post('textoOtroN'.$filasCol1[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                            $textoColumna1[$conTexto1++]=$textoColumna;
	                        }
	                    for ($l=0; $l <count($filasCol2); $l++) { 
	                        $textoColumna=$this->input->post('textoOtroN'.$filasCol2[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                        $textoColumna2[$conTexto2++]=$textoColumna;
	                    }
	                    for ($l=0; $l <count($filasCol3); $l++) { 
	                        $textoColumna=$this->input->post('textoOtroN'.$filasCol3[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                        $textoColumna3[$conTexto3++]=$textoColumna;
	                    }
	                    for ($l=0; $l <count($filasCol4); $l++) { 
	                        $textoColumna=$this->input->post('textoOtroN'.$filasCol4[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                        $textoColumna4[$conTexto4++]=$textoColumna;
	                    }
	                    for ($l=0; $l <count($filasCol5); $l++) { 
	                        $textoColumna=$this->input->post('textoOtroN'.$filasCol5[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                        $textoColumna5[$conTexto5++]=$textoColumna;
	                    }
	                    for ($l=0; $l <count($filasCol6); $l++) { 
	                        $textoColumna=$this->input->post('textoOtroN'.$filasCol6[$l].'TD_'.$i.'['.$columnaOtroE.']');
	                        $textoColumna6[$conTexto6++]=$textoColumna;
	                    }
	                    $conId=$this->input->post('filaSixE_index_id'.$j.'['.$i.']');
						$posTexto=0;
						for ($p=1; $p <=$conId ; $p++) {
							$id=$this->input->post('idFilaSixE'.$j.'_'.$p.'['.$i.']');
							if(!empty($textoColumna1)&&!empty($textoColumna2)&&!empty($textoColumna3)&&!empty($textoColumna4)&&!empty($textoColumna5)&&!empty($textoColumna6)&&!empty($id)){
								$res=$this->model->updateFilaSix($textoColumna1[$posTexto],$textoColumna2[$posTexto],$textoColumna3[$posTexto],$textoColumna4[$posTexto],$textoColumna5[$posTexto],$textoColumna6[$posTexto],$id);
								$posTexto++;
							}
						}
	            }//fin column6   
            }
			if(!empty($ordenGraphicBarra)){
	            for ($j=1; $j <=$ordenGraphicBarra; $j++){
	            	$id=$this->input->post('idGraphicEd_'.$i.'['.$j.']');
	            	$tituloG=$this->input->post('tituloGraficoE_'.$j.'['.$i.']');
	            	$subtituloG=$this->input->post('subtituloGraficoE_'.$j.'['.$i.']');
	            	$subtituloY=$this->input->post('tituloGraficoYE_'.$j.'['.$i.']');
	            	$puntoInicial=$this->input->post('startE_'.$j.'['.$i.']');
	            	$res=$this->model->updateGraphic($id,$tituloG,$subtituloG,$subtituloY,$puntoInicial);
	            	if($res){
						$posBarra=$this->input->post('posBarraE_'.$j.'['.$i.']');
						for ($k=1; $k <$posBarra; $k++) { 
							$idFila=$this->input->post('idFilaGraphicBarraE'.$j.'_'.$k.'['.$i.']');
							$tituloColumna=$this->input->post('dataTBarraE'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataBarraE'.$k.'_'.$j.'['.$i.']');
							if(!empty($idFila)&&!empty($tituloColumna)&&!empty($datosColumna))
							$res=$this->model->updateFilaGraphic($tituloColumna,$datosColumna,$idFila);
						}
	            	}
	           }
	        }
	        if(!empty($ordenGraphicPie)){
	            for ($j=1; $j <=$ordenGraphicPie; $j++){
	            	$id=$this->input->post('idGraphicPeE_'.$i.'['.$j.']');
	            	$tituloG=$this->input->post('tituloGraficoPE_'.$j.'['.$i.']');
	            	$subtituloG=$this->input->post('subtituloGraficoPE_'.$j.'['.$i.']');
	            	$subtituloY=0;
	            	$puntoInicial=0;
	            	$res=$this->model->updateGraphic($id,$tituloG,$subtituloG,$subtituloY,$puntoInicial);
	            	if($res){
						$posPie=$this->input->post('posPieE_'.$j.'['.$i.']');
						for ($k=1; $k <$posPie; $k++) { 
							$idFila=$this->input->post('idFilaGraphicPieE'.$j.'_'.$k.'['.$i.']');
							$tituloColumna=$this->input->post('dataTPieE'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataPieE'.$k.'_'.$j.'['.$i.']');
							if(!empty($idFila)&&!empty($tituloColumna)&&!empty($datosColumna))
							$res=$this->model->updateFilaGraphic($tituloColumna,$datosColumna,$idFila);
						}
	            	}
	           }
	        }
	        if(!empty($ordenGraphicLinea)){
	            for ($j=1; $j <=$ordenGraphicLinea; $j++){
	            	$id=$this->input->post('idGraphicLE_'.$i.'['.$j.']');
	            	$tituloG=$this->input->post('tituloGraficoLE_'.$j.'['.$i.']');
	            	$subtituloG=$this->input->post('subtituloGraficoLE_'.$j.'['.$i.']');
	            	$subtituloY=$this->input->post('tituloGraficoYLE_'.$j.'['.$i.']');
	            	$puntoInicial=$this->input->post('startLE_'.$j.'['.$i.']');
	            	$res=$this->model->updateGraphic($id,$tituloG,$subtituloG,$subtituloY,$puntoInicial);
	            	if($res){
						$posBarra=$this->input->post('posLineaE_'.$j.'['.$i.']');
						for ($k=1; $k <$posBarra; $k++) { 
							$idFila=$this->input->post('idFilaGraphicLineaE'.$j.'_'.$k.'['.$i.']');
							$tituloColumna=$this->input->post('dataTLineaE'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataLineaE'.$k.'_'.$j.'['.$i.']');
							if(!empty($idFila)&&!empty($tituloColumna)&&!empty($datosColumna))
							$res=$this->model->updateFilaGraphic($tituloColumna,$datosColumna,$idFila);
						}
	            	}
	           }
	        }
            //Datos tabla dos columnas
            $textoColumna1=[];
            $textoColumna2=[];
            $textoColumna='';
            $conTexto1=0;
            $conTexto2=0;
            if (!empty($tableTwo)) {
                for ($j=1; $j <=$tableTwo; $j++) { 
                $arrayTableTwo=array("nombreColumna1"=>$this->input->post('tituloITD2_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloDTD2_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."two".']['.$i.']'));
                $resData=$this->model->InsertTableTwoActa($arrayTableTwo);
                    $posTableTwo=$this->input->post('posTableTwo_'.$j.'['.$i.']');
                    for ($k=1; $k <=$posTableTwo; $k++) { 
                        $textoColumna=$this->input->post('textoTD_'.$j.'['.$i.']['.$k.']');
                        if ($k%2 ==0) {
                            $textoColumna2[$conTexto2]=$textoColumna;
                            $conTexto2++;
                        }else{
                            $textoColumna1[$conTexto1]=$textoColumna;
                            $conTexto1++;
                        }
                        
                    }
                    if($resData!=FALSE){
                        $res=$this->model->InsertFilaTwoActa($textoColumna1,$textoColumna2,$resData);
                    }
                    $conTexto1=0;
                    $conTexto2=0;
                }
            }
            //Datos tabla tres columnas
            if (!empty($tableThree)) {
                for ($j=1; $j <=$tableThree; $j++) { 
                    $textoColumna1=[];
                    $textoColumna2=[];
                    $textoColumna3=[];
                    $filasCol1=[];
                    $filasCol2=[];
                    $filasCol3=[];
                    $textoColumna='';
                    $conTexto1=0;
                    $conTexto2=0;
                    $conTexto3=0;
                $arrayTableThree=array("nombreColumna1"=>$this->input->post('tituloITD3_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloCTD3_'.$j.'['.$i.']'),"nombreColumna3"=>$this->input->post('tituloDTD3_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."three".']['.$i.']'));
                $resData=$this->model->InsertTableThreeActa($arrayTableThree);
                    $posTableThree=$this->input->post('posTableThree_'.$j.'['.$i.']');
                    for ($k=1; $k <=$posTableThree; $k++) { 
                        $indexCol=0;
                        $fc=1;
                        $filasCol1[$indexCol++]=$fc;
                        while($fc<$posTableThree) { 
                            $fc=$fc+3;
                            $filasCol1[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=2;
                        $filasCol2[$indexCol++]=$fc;
                        while($fc<$posTableThree) { 
                            $fc=$fc+3;
                            $filasCol2[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=3;
                        $filasCol3[$indexCol++]=$fc;
                        while($fc<=$posTableThree) { 
                            $fc=$fc+3;
                            $filasCol3[$indexCol++]=$fc;
                        }
                        unset($filasCol1[array_pop($filasCol1)]);
                        unset($filasCol2[array_pop($filasCol2)]);
                        unset($filasCol3[array_pop($filasCol3)]);                       
                    }
                    for ($l=0; $l <count($filasCol1); $l++) { 
                            $textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol1[$l].']');
                            $textoColumna1[$conTexto1++]=$textoColumna;
                        }
                    for ($l=0; $l <count($filasCol2); $l++) { 
                        $textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol2[$l].']');
                        $textoColumna2[$conTexto2++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol3); $l++) { 
                        $textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol3[$l].']');
                        $textoColumna3[$conTexto3++]=$textoColumna;
                    }

                    if($resData!=FALSE){
                        $res=$this->model->InsertFilaThreeActa($textoColumna1,$textoColumna2,$textoColumna3,$resData);                      
                    }
                }
            }//fin if
            //Datos tabla cuatro columnas
            if (!empty($tableFour)) {
                for ($j=1; $j <=$tableFour; $j++){ 
                    $textoColumna1=[];
                    $textoColumna2=[];
                    $textoColumna3=[];
                    $textoColumna4=[];
                    $filasCol1=[];
                    $filasCol2=[];
                    $filasCol3=[];
                    $filasCol4=[];
                    $textoColumna='';
                    $conTexto1=0;
                    $conTexto2=0;
                    $conTexto3=0;
                    $conTexto4=0;
                $arrayTableFour=array("nombreColumna1"=>$this->input->post('tituloITD4_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloCITD4_'.$j.'['.$i.']'),"nombreColumna3"=>$this->input->post('tituloCDTD4_'.$j.'['.$i.']'),"nombreColumna4"=>$this->input->post('tituloDTD4_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."four".']['.$i.']'));
                $resData=$this->model->InsertTableFourActa($arrayTableFour);
                    $posTableFour=$this->input->post('posTableFour_'.$j.'['.$i.']');
                    for ($k=1; $k <=$posTableFour; $k++) { 
                        $indexCol=0;
                        $fc=1;
                        $filasCol1[$indexCol++]=$fc;
                        while($fc<$posTableFour) { 
                            $fc=$fc+4;
                            $filasCol1[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=2;
                        $filasCol2[$indexCol++]=$fc;
                        while($fc<$posTableFour) { 
                            $fc=$fc+4;
                            $filasCol2[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=3;
                        $filasCol3[$indexCol++]=$fc;
                        while($fc<=$posTableFour) { 
                            $fc=$fc+4;
                            $filasCol3[$indexCol++]=$fc;
                        }
                        $indexCol=0;
                        $fc=4;
                        $filasCol4[$indexCol++]=$fc;
                        while($fc<=$posTableFour) { 
                            $fc=$fc+4;
                            $filasCol4[$indexCol++]=$fc;
                        }
                        unset($filasCol1[array_pop($filasCol1)]);
                        unset($filasCol2[array_pop($filasCol2)]);
                        unset($filasCol3[array_pop($filasCol3)]);
                        unset($filasCol4[array_pop($filasCol4)]);                       
                    }
                    for ($l=0; $l <count($filasCol1); $l++) { 
                            $textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol1[$l].']');
                            $textoColumna1[$conTexto1++]=$textoColumna;
                        }
                    for ($l=0; $l <count($filasCol2); $l++) { 
                        $textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol2[$l].']');
                        $textoColumna2[$conTexto2++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol3); $l++) { 
                        $textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol3[$l].']');
                        $textoColumna3[$conTexto3++]=$textoColumna;
                    }
                    for ($l=0; $l <count($filasCol4); $l++) { 
                        $textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol4[$l].']');
                        $textoColumna4[$conTexto4++]=$textoColumna;
                    }
                    if($resData!=FALSE){
                        $res=$this->model->InsertFilaFourActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$resData);                      
                    }
                }
            }//fin if   
            //Datos tabla otro 
            if (!empty($tableOtro)) {
                $colum1='';
                $colum2='';
                $colum3='';
                $colum4='';
                $colum5='';
                $colum6='';
                $colum7='';
                for ($j=1; $j <=$tableOtro ; $j++) {
                    $textoColumna1=[];
                    $textoColumna2=[];
                    $textoColumna3=[];
                    $textoColumna4=[];
                    $textoColumna5=[];
                    $textoColumna6=[];
                    $textoColumna7=[];
                    $filasCol1=[];
                    $filasCol2=[];
                    $filasCol3=[];
                    $filasCol4=[];
                    $filasCol5=[];
                    $filasCol6=[];
                    $filasCol7=[];
                    $textoColumna='';
                    $conTexto1=0;
                    $conTexto2=0;
                    $conTexto3=0;
                    $conTexto4=0;
                    $conTexto5=0; 
                    $conTexto6=0; 
                    $conTexto7=0; 
                    $columnaOtro=$this->input->post('columnaOtro_'.$j.'['.$i.']');
                    //5 columnas
                    if ((int)$columnaOtro===5) {
                        for ($m=1; $m <=$columnaOtro; $m++) { 
                            if ($m==1) {
                                $colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==2){
                                $colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');   
                            }else if($m==3){
                                $colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==4){
                                $colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==5){
                                $colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }
                        }
                        $arrayTableFive=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
                        $resData=$this->model->InsertTableFiveActa($arrayTableFive);
                        //Filas
                        $posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
                        for ($k=1; $k <=$posTableOtro; $k++) { 
                            $indexCol=0;
                            $fc=1;
                            $filasCol1[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+5;
                                $filasCol1[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=2;
                            $filasCol2[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+5;
                                $filasCol2[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=3;
                            $filasCol3[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+5;
                                $filasCol3[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=4;
                            $filasCol4[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+5;
                                $filasCol4[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=5;
                            $filasCol5[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+5;
                                $filasCol5[$indexCol++]=$fc;
                            }
                            unset($filasCol1[array_pop($filasCol1)]);
                            unset($filasCol2[array_pop($filasCol2)]);
                            unset($filasCol3[array_pop($filasCol3)]);
                            unset($filasCol4[array_pop($filasCol4)]);
                            unset($filasCol5[array_pop($filasCol5)]);                       
                        }
                        for ($l=0; $l <count($filasCol1); $l++) { 
                                $textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
                                $textoColumna1[$conTexto1++]=$textoColumna;
                            }
                        for ($l=0; $l <count($filasCol2); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna2[$conTexto2++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol3); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna3[$conTexto3++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol4); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna4[$conTexto4++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol5); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna5[$conTexto5++]=$textoColumna;
                        }
                        if($resData!=FALSE){
                            $res=$this->model->InsertFilaFiveActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$resData);                     
                        }
                    }//fin column5

                    //6 columnas
                    if ((int)$columnaOtro===6) {
                        for ($m=1; $m <=$columnaOtro; $m++) { 
                            if ($m==1) {
                                $colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==2){
                                $colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');   
                            }else if($m==3){
                                $colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==4){
                                $colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==5){
                                $colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==6){
                                $colum6=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }
                        }
                        $arrayTableSix=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"nombreColumna6"=>$colum6,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
                        $resData=$this->model->InsertTableSixActa($arrayTableSix);
                        //Filas
                        $posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
                        for ($k=1; $k <=$posTableOtro; $k++) { 
                            $indexCol=0;
                            $fc=1;
                            $filasCol1[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol1[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=2;
                            $filasCol2[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol2[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=3;
                            $filasCol3[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol3[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=4;
                            $filasCol4[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol4[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=5;
                            $filasCol5[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol5[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=6;
                            $filasCol6[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+6;
                                $filasCol6[$indexCol++]=$fc;
                            }
                            unset($filasCol1[array_pop($filasCol1)]);
                            unset($filasCol2[array_pop($filasCol2)]);
                            unset($filasCol3[array_pop($filasCol3)]);
                            unset($filasCol4[array_pop($filasCol4)]);
                            unset($filasCol5[array_pop($filasCol5)]);
                            unset($filasCol6[array_pop($filasCol6)]);                       
                        }
                        for ($l=0; $l <count($filasCol1); $l++) { 
                                $textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
                                $textoColumna1[$conTexto1++]=$textoColumna;
                            }
                        for ($l=0; $l <count($filasCol2); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna2[$conTexto2++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol3); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna3[$conTexto3++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol4); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna4[$conTexto4++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol5); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna5[$conTexto5++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol6); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol6[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna6[$conTexto6++]=$textoColumna;
                        }
                        if($resData!=FALSE){
                            $res=$this->model->InsertFilaSixActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$textoColumna6,$resData);                       
                        }
                    }//fin column6
                        
                    //7 columnas
                    if ((int)$columnaOtro===7) {
                        for ($m=1; $m <=$columnaOtro; $m++) { 
                            if ($m==1) {
                                $colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==2){
                                $colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');   
                            }else if($m==3){
                                $colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==4){
                                $colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==5){
                                $colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==6){
                                $colum6=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }else if($m==7){
                                $colum7=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
                            }
                        }
                        $arrayTableSeven=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"nombreColumna6"=>$colum6,"nombreColumna7"=>$colum7,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
                        $resData=$this->model->InsertTableSevenActa($arrayTableSeven);
                        //Filas
                        $posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
                        for ($k=1; $k <=$posTableOtro; $k++) { 
                            $indexCol=0;
                            $fc=1;
                            $filasCol1[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol1[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=2;
                            $filasCol2[$indexCol++]=$fc;
                            while($fc<$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol2[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=3;
                            $filasCol3[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol3[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=4;
                            $filasCol4[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol4[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=5;
                            $filasCol5[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol5[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=6;
                            $filasCol6[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol6[$indexCol++]=$fc;
                            }
                            $indexCol=0;
                            $fc=7;
                            $filasCol7[$indexCol++]=$fc;
                            while($fc<=$posTableOtro) { 
                                $fc=$fc+7;
                                $filasCol7[$indexCol++]=$fc;
                            }
                            unset($filasCol1[array_pop($filasCol1)]);
                            unset($filasCol2[array_pop($filasCol2)]);
                            unset($filasCol3[array_pop($filasCol3)]);
                            unset($filasCol4[array_pop($filasCol4)]);
                            unset($filasCol5[array_pop($filasCol5)]);
                            unset($filasCol6[array_pop($filasCol6)]);
                            unset($filasCol7[array_pop($filasCol7)]);                       
                        }
                        for ($l=0; $l <count($filasCol1); $l++) { 
                                $textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
                                $textoColumna1[$conTexto1++]=$textoColumna;
                            }
                        for ($l=0; $l <count($filasCol2); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna2[$conTexto2++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol3); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna3[$conTexto3++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol4); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna4[$conTexto4++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol5); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna5[$conTexto5++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol6); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol6[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna6[$conTexto6++]=$textoColumna;
                        }
                        for ($l=0; $l <count($filasCol7); $l++) { 
                            $textoColumna=$this->input->post('textoOtro'.$filasCol7[$l].'TD_'.$j.'['.$i.']');
                            $textoColumna7[$conTexto7++]=$textoColumna;
                        }
                        if($resData!=FALSE){
                            $res=$this->model->InsertFilaSevenActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$textoColumna6,$textoColumna7,$resData);                      
                        }
                    }//fin column7
                }
            }//fin if
            if (!empty($graphicBarra)) {
                for ($j=1; $j <=$graphicBarra; $j++) { 
                $arrayGraphicBarra=array("tituloG"=>$this->input->post('tituloGrafico_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGrafico_'.$j.'['.$i.']'),"subtituloY"=>$this->input->post('tituloGraficoY_'.$j.'['.$i.']'),"puntoInicial"=>$this->input->post('start_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gBarra".']['.$i.']'),"codigoTipoG"=>1);
                $resData=$this->model->InsertGraphic($arrayGraphicBarra);
                    if(!$resData){
                        $res=$resData;
                    }else{
                        $posBarra=$this->input->post('posBarra_'.$j.'['.$i.']');
                        for ($k=1; $k <$posBarra; $k++) { 
                            $tituloColumna=$this->input->post('dataTBarra'.$k.'_'.$j.'['.$i.']');
                            $datosColumna=$this->input->post('dataBarra'.$k.'_'.$j.'['.$i.']');
                            $res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
                        }
                    }//fin else
                }
            }//fin if empty $graphicBarra
            if (!empty($graphicPie)) {
                for ($j=1; $j <=$graphicPie; $j++) { 
                $arrayGraphicPie=array("tituloG"=>$this->input->post('tituloGraficoP_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGraficoP_'.$j.'['.$i.']'),"subtituloY"=>0,"puntoInicial"=>0,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gPie".']['.$i.']'),"codigoTipoG"=>2);
                $resData=$this->model->InsertGraphic($arrayGraphicPie);
                    if(!$resData){
                        $res=$resData;
                    }else{
                        $posPie=$this->input->post('posPie_'.$j.'['.$i.']');
                        for ($k=1; $k <$posPie; $k++) { 
                            $tituloColumna=$this->input->post('dataTPie'.$k.'_'.$j.'['.$i.']');
                            $datosColumna=$this->input->post('dataPie'.$k.'_'.$j.'['.$i.']');
                            $res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
                        }
                    }//fin else
                }
            }//fin if empty $graphicPie
            if (!empty($graphicLineal)) {
                for ($j=1; $j <=$graphicLineal; $j++) { 
                $arrayGraphicLineal=array("tituloG"=>$this->input->post('tituloGraficoL_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGraficoL_'.$j.'['.$i.']'),"subtituloY"=>$this->input->post('tituloGraficoYL_'.$j.'['.$i.']'),"puntoInicial"=>$this->input->post('startL_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gLinea".']['.$i.']'),"codigoTipoG"=>3);
                $resData=$this->model->InsertGraphic($arrayGraphicLineal);
                    if(!$resData){
                        $res=$resData;
                    }else{
                        $posLinea=$this->input->post('posLinea_'.$j.'['.$i.']');
                        for ($k=1; $k <$posLinea; $k++) { 
                            $tituloColumna=$this->input->post('dataTLinea'.$k.'_'.$j.'['.$i.']');
                            $datosColumna=$this->input->post('dataLinea'.$k.'_'.$j.'['.$i.']');
                            $res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
                        }
                    }//fin else
                }
            }//fin if empty $graphicLineal
        }//fin for 
    }
        if (!empty($mensaje)) {
            echo $mensaje;
        }
            if(!$res){
                echo 'Algo salio mal';
            }else {
                echo 'Exito al editar el acta #'.$acta;
            }
    }//Fin insertarEditActaContenido
	/**
	 * 
	 */ 
	public function insertActaContenido(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		$modulos=7;
		$acta=$this->session->userdata('idActa');
		$valor=TRUE;
		$mensaje=' ';
		$resData;
		$res=TRUE;
		$arrayImg=array();
		$arrayTextoImg=array();
		$arrayImgTexto=array();
		if (!empty($_FILES)) {
		for ($j=1; $j <=$modulos ; $j++) { 
			for ($i=1; $i <=count($_FILES) ; $i++) { 
			if (!empty($_FILES['userImageImg_'.$i.'_'.$j])) {
				$targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
					$tempFile = utf8_encode($_FILES['userImageImg_'.$i.'_'.$j]['tmp_name']);
					$nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImg_'.$i.'_'.$j]['name']));
					$fileTypes = array('jpg','jpeg','png','gif');
					$fileParts = pathinfo($nombre_Doc);
					$ext_Doc = strtolower($fileParts['extension']);
					$longitud_nombre = strlen($nombre_Doc);	
					$fecha = date('o-m-d-H');
					if ($this->folderSystemActa($targetPathDoc,$j)) {
					$targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
						if (in_array($ext_Doc,$fileTypes)) {
							if (!file_exists($targetFile)) {
								if (move_uploaded_file($tempFile,$targetFile)) {
										$mensaje .='Imagenes cargado correctamente   ';
										$valor=TRUE;
										$img=$this->input->post('img_index_id['.$j.']');
										list($ancho, $alto) = getimagesize($targetFile);
														if ($ancho >= 475 || $alto >= 330)
														{
															if ($ancho >= 475) {
																$ancho_final = 475;		
															} else {
																$ancho_final = $ancho;
															}
															if ($alto >= 330) {
																$alto_final =330;
															} else {
																$alto_final = $alto;
															}
																$this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
															$mensaje .=' Tamaño corregido  ';
														}
											//Datos Imagen
											if (!empty($img)) {
												$arrayImg=array("nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."img".']['.$j.']'));
												$resData=$this->model->InsertImgActa($arrayImg);
													if(!$resData){
														$res=$resData;
														}
											}		
									}
								 else {
									$mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
								}										
							} else {
								$mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
							}
						} else {
							$mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
						}
					}
				}//fin if img
				if (!empty($_FILES['userImageImgTexto_'.$i.'_'.$j])) {
				$targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
					$tempFile = utf8_encode($_FILES['userImageImgTexto_'.$i.'_'.$j]['tmp_name']);
					$nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageImgTexto_'.$i.'_'.$j]['name']));
					$fileTypes = array('jpg','jpeg','png','gif');
					$fileParts = pathinfo($nombre_Doc);
					$ext_Doc = strtolower($fileParts['extension']);
					$longitud_nombre = strlen($nombre_Doc);	
					$fecha = date('o-m-d-H');
					if ($this->folderSystemActa($targetPathDoc,$j)) {
					$targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
						if (in_array($ext_Doc,$fileTypes)) {
							if (!file_exists($targetFile)) {
								if (move_uploaded_file($tempFile,$targetFile)) {
										$mensaje .='Imagenes cargado correctamente   ';
										$valor=TRUE;
										$img=$this->input->post('img_index_id['.$j.']');
										list($ancho, $alto) = getimagesize($targetFile);
														if ($ancho >= 475 || $alto >= 330)
														{
															if ($ancho >= 475) {
																$ancho_final = 475;		
															} else {
																$ancho_final = $ancho;
															}
															if ($alto >= 330) {
																$alto_final =330;
															} else {
																$alto_final = $alto;
															}
																$this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
															$mensaje .=' Tamaño corregido  ';
														}
											//Datos Imagen-Texto
											$imgTexto=$this->input->post('imgTexto_index_id['.$j.']');
											if (!empty($imgTexto)) {
												$arrayImgTexto=array("texto"=>$this->input->post('textoT_'.$i.'['.$j.']'),"nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."imgTexto".']['.$j.']'));
												$resData=$this->model->InsertImgTextoActa($arrayImgTexto);
													if(!$resData){
														$res=$resData;
													}		
											}	
									}
								 else {
									$mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
								}										
							} else {
								$mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
							}
						} else {
							$mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
						}
					}
				}//fin if imgtexto

				if (!empty($_FILES['userImageTextoImg_'.$i.'_'.$j])) {
				$targetPathDoc= FCPATH.'img/Acta/acta_'.$acta;
					$tempFile = utf8_encode($_FILES['userImageTextoImg_'.$i.'_'.$j]['tmp_name']);
					$nombre_Doc = str_replace(' ', '-',utf8_decode($_FILES['userImageTextoImg_'.$i.'_'.$j]['name']));
					$fileTypes = array('jpg','jpeg','png','gif');
					$fileParts = pathinfo($nombre_Doc);
					$ext_Doc = strtolower($fileParts['extension']);
					$longitud_nombre = strlen($nombre_Doc);	
					$fecha = date('o-m-d-H');
					if ($this->folderSystemActa($targetPathDoc,$j)) {
					$targetFile =rtrim($targetPathDoc.'/modulo_'.$j).'/'.$nombre_Doc;
						if (in_array($ext_Doc,$fileTypes)) {
							if (!file_exists($targetFile)) {
								if (move_uploaded_file($tempFile,$targetFile)) {
										$mensaje .='Imagenes cargado correctamente   ';
										$valor=TRUE;
										$img=$this->input->post('img_index_id['.$j.']');
										list($ancho, $alto) = getimagesize($targetFile);
														if ($ancho >= 475 || $alto >= 330)
														{
															if ($ancho >= 475) {
																$ancho_final = 475;		
															} else {
																$ancho_final = $ancho;
															}
															if ($alto >= 330) {
																$alto_final =330;
															} else {
																$alto_final = $alto;
															}
																$this->resize($ancho_final, $alto_final, $nombre_Doc,$targetFile,$targetFile);
															$mensaje .=' Tamaño corregido  ';
														}
											//Datos Texto-Imagen
												$textoImg=$this->input->post('textoImg_index_id['.$j.']');
												if (!empty($textoImg)) {
													$arrayTextoImg=array("texto"=>$this->input->post('textoI_'.$i.'['.$j.']'),"nombreImg"=>$nombre_Doc,"modulo"=>$j,"orden"=>$i,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$i.'['."textoImg".']['.$j.']'));
													$resData=$this->model->InsertTextoImgActa($arrayTextoImg);
														if(!$resData){
															$res=$resData;
														}		
												}	
									}
								 else {
									$mensaje.='No fue posible mover el archivo en la posición '.$i.' Modulo'.$j.'<br>';
								}										
							} else {
								$mensaje.= 'El archivo ya existe en la posición '.$i.' Modulo'.$j.'<br>';
							}
						} else {
							$mensaje.= 'Tipo de archivo invalido en la posición '.$i.' Modulo'.$j.'<br>';
						}
					}
				}//fin if textoimg
			}//fin foreach $j
		}//fin foreach $i
		}else{
			$mensaje.=' ';
			$valor=TRUE;
		}	
		if ($valor) {
		$arraySubtitulo=array();
		$arrayEncabezado=array();
		$arrayTexto=array();
		$arrayTableTwo=array();
		$arrayFilaTwo=array();
		for ($i=1; $i <=$modulos ; $i++) { 
			$subtitulo=$this->input->post('subtitulo_index_id['.$i.']');
			$encabezado=$this->input->post('encabezado_index_id['.$i.']');
			$texto=$this->input->post('texto_index_id['.$i.']');
			$tableTwo=$this->input->post('tableTwo_index_id['.$i.']');
			$tableThree=$this->input->post('tableThree_index_id['.$i.']');
			$tableFour=$this->input->post('tableFour_index_id['.$i.']');
			$tableOtro=$this->input->post('tableOtro_index_id['.$i.']');
			$graphicBarra=$this->input->post('graficoBarra_index_id['.$i.']');
			$graphicPie=$this->input->post('graficoPie_index_id['.$i.']');
			$graphicLineal=$this->input->post('graficoLinea_index_id['.$i.']');
			//Datos subtitulo
			if (!empty($subtitulo)) {
				for ($j=1; $j <=$subtitulo; $j++) { 
				$arraySubtitulo=array("texto"=>$this->input->post('subtituloActa_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."subtitulo".']['.$i.']'));
				$resData=$this->model->InsertSubtituloActa($arraySubtitulo);
					if(!$resData){
						$res=$resData;
					}
				}			
			}
			//Datos encabezado
			if (!empty($encabezado)) {
				for ($j=1; $j <=$encabezado; $j++) { 
				$arrayEncabezado=array("texto"=>$this->input->post('encabezadoActa_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."encabezado".']['.$i.']'));
				$resData=$this->model->InsertEncabezadoActa($arrayEncabezado);
					if(!$resData){
						$res=$resData;
					}
				}		
			}
			//Datos Texto
			if (!empty($texto)) {
				for ($j=1; $j <=$texto; $j++) { 
				$arrayTexto=array("texto"=>$this->input->post('texto_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."texto".']['.$i.']'));
				$resData=$this->model->InsertTextoActa($arrayTexto);
					if(!$resData){
						$res=$resData;
					}
				}		
			}
			//Datos tabla dos columnas
			$textoColumna1=[];
			$textoColumna2=[];
			$textoColumna='';
			$conTexto1=0;
			$conTexto2=0;
			if (!empty($tableTwo)) {
				for ($j=1; $j <=$tableTwo; $j++) { 
				$arrayTableTwo=array("nombreColumna1"=>$this->input->post('tituloITD2_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloDTD2_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."two".']['.$i.']'));
				$resData=$this->model->InsertTableTwoActa($arrayTableTwo);
					$posTableTwo=$this->input->post('posTableTwo_'.$j.'['.$i.']');
					for ($k=1; $k <=$posTableTwo; $k++) { 
						$textoColumna=$this->input->post('textoTD_'.$j.'['.$i.']['.$k.']');
						if ($k%2 ==0) {
							$textoColumna2[$conTexto2]=$textoColumna;
							$conTexto2++;
						}else{
							$textoColumna1[$conTexto1]=$textoColumna;
							$conTexto1++;
						}
						
					}
					if($resData!=FALSE){
						$res=$this->model->InsertFilaTwoActa($textoColumna1,$textoColumna2,$resData);
					}
					$conTexto1=0;
					$conTexto2=0;
				}
			}
			//Datos tabla tres columnas
			if (!empty($tableThree)) {
				for ($j=1; $j <=$tableThree; $j++) { 
					$textoColumna1=[];
					$textoColumna2=[];
					$textoColumna3=[];
					$filasCol1=[];
					$filasCol2=[];
					$filasCol3=[];
					$textoColumna='';
					$conTexto1=0;
					$conTexto2=0;
					$conTexto3=0;
				$arrayTableThree=array("nombreColumna1"=>$this->input->post('tituloITD3_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloCTD3_'.$j.'['.$i.']'),"nombreColumna3"=>$this->input->post('tituloDTD3_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."three".']['.$i.']'));
				$resData=$this->model->InsertTableThreeActa($arrayTableThree);
					$posTableThree=$this->input->post('posTableThree_'.$j.'['.$i.']');
					for ($k=1; $k <=$posTableThree; $k++) { 
						$indexCol=0;
						$fc=1;
						$filasCol1[$indexCol++]=$fc;
						while($fc<$posTableThree) { 
							$fc=$fc+3;
							$filasCol1[$indexCol++]=$fc;
						}
						$indexCol=0;
						$fc=2;
						$filasCol2[$indexCol++]=$fc;
						while($fc<$posTableThree) { 
							$fc=$fc+3;
							$filasCol2[$indexCol++]=$fc;
						}
						$indexCol=0;
						$fc=3;
						$filasCol3[$indexCol++]=$fc;
						while($fc<=$posTableThree) { 
							$fc=$fc+3;
							$filasCol3[$indexCol++]=$fc;
						}
						unset($filasCol1[array_pop($filasCol1)]);
						unset($filasCol2[array_pop($filasCol2)]);
						unset($filasCol3[array_pop($filasCol3)]);						
					}
					for ($l=0; $l <count($filasCol1); $l++) { 
							$textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol1[$l].']');
							$textoColumna1[$conTexto1++]=$textoColumna;
						}
					for ($l=0; $l <count($filasCol2); $l++) { 
						$textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol2[$l].']');
						$textoColumna2[$conTexto2++]=$textoColumna;
					}
					for ($l=0; $l <count($filasCol3); $l++) { 
						$textoColumna=$this->input->post('textoTD3_'.$j.'['.$i.']['.$filasCol3[$l].']');
						$textoColumna3[$conTexto3++]=$textoColumna;
					}

					if($resData!=FALSE){
						$res=$this->model->InsertFilaThreeActa($textoColumna1,$textoColumna2,$textoColumna3,$resData);						
					}
				}
			}//fin if

			//Datos tabla cuatro columnas
			if (!empty($tableFour)) {
				for ($j=1; $j <=$tableFour; $j++){ 
					$textoColumna1=[];
					$textoColumna2=[];
					$textoColumna3=[];
					$textoColumna4=[];
					$filasCol1=[];
					$filasCol2=[];
					$filasCol3=[];
					$filasCol4=[];
					$textoColumna='';
					$conTexto1=0;
					$conTexto2=0;
					$conTexto3=0;
					$conTexto4=0;
				$arrayTableFour=array("nombreColumna1"=>$this->input->post('tituloITD4_'.$j.'['.$i.']'),"nombreColumna2"=>$this->input->post('tituloCITD4_'.$j.'['.$i.']'),"nombreColumna3"=>$this->input->post('tituloCDTD4_'.$j.'['.$i.']'),"nombreColumna4"=>$this->input->post('tituloDTD4_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."four".']['.$i.']'));
				$resData=$this->model->InsertTableFourActa($arrayTableFour);
					$posTableFour=$this->input->post('posTableFour_'.$j.'['.$i.']');
					for ($k=1; $k <=$posTableFour; $k++) { 
						$indexCol=0;
						$fc=1;
						$filasCol1[$indexCol++]=$fc;
						while($fc<$posTableFour) { 
							$fc=$fc+4;
							$filasCol1[$indexCol++]=$fc;
						}
						$indexCol=0;
						$fc=2;
						$filasCol2[$indexCol++]=$fc;
						while($fc<$posTableFour) { 
							$fc=$fc+4;
							$filasCol2[$indexCol++]=$fc;
						}
						$indexCol=0;
						$fc=3;
						$filasCol3[$indexCol++]=$fc;
						while($fc<=$posTableFour) { 
							$fc=$fc+4;
							$filasCol3[$indexCol++]=$fc;
						}
						$indexCol=0;
						$fc=4;
						$filasCol4[$indexCol++]=$fc;
						while($fc<=$posTableFour) { 
							$fc=$fc+4;
							$filasCol4[$indexCol++]=$fc;
						}
						unset($filasCol1[array_pop($filasCol1)]);
						unset($filasCol2[array_pop($filasCol2)]);
						unset($filasCol3[array_pop($filasCol3)]);
						unset($filasCol4[array_pop($filasCol4)]);						
					}
					for ($l=0; $l <count($filasCol1); $l++) { 
							$textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol1[$l].']');
							$textoColumna1[$conTexto1++]=$textoColumna;
						}
					for ($l=0; $l <count($filasCol2); $l++) { 
						$textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol2[$l].']');
						$textoColumna2[$conTexto2++]=$textoColumna;
					}
					for ($l=0; $l <count($filasCol3); $l++) { 
						$textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol3[$l].']');
						$textoColumna3[$conTexto3++]=$textoColumna;
					}
					for ($l=0; $l <count($filasCol4); $l++) { 
						$textoColumna=$this->input->post('textoTD4_'.$j.'['.$i.']['.$filasCol4[$l].']');
						$textoColumna4[$conTexto4++]=$textoColumna;
					}
					if($resData!=FALSE){
						$res=$this->model->InsertFilaFourActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$resData);						
					}
				}
			}//fin if	

			//Datos tabla otro 
			if (!empty($tableOtro)) {
				$colum1='';
				$colum2='';
				$colum3='';
				$colum4='';
				$colum5='';
				$colum6='';
				$colum7='';
				for ($j=1; $j <=$tableOtro ; $j++) {
					$textoColumna1=[];
					$textoColumna2=[];
					$textoColumna3=[];
					$textoColumna4=[];
					$textoColumna5=[];
					$textoColumna6=[];
					$textoColumna7=[];
					$filasCol1=[];
					$filasCol2=[];
					$filasCol3=[];
					$filasCol4=[];
					$filasCol5=[];
					$filasCol6=[];
					$filasCol7=[];
					$textoColumna='';
					$conTexto1=0;
					$conTexto2=0;
					$conTexto3=0;
					$conTexto4=0;
					$conTexto5=0; 
					$conTexto6=0; 
					$conTexto7=0; 
					$columnaOtro=$this->input->post('columnaOtro_'.$j.'['.$i.']');
					//5 columnas
					if ((int)$columnaOtro===5) {
						for ($m=1; $m <=$columnaOtro; $m++) { 
							if ($m==1) {
								$colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==2){
								$colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');	
							}else if($m==3){
								$colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==4){
								$colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==5){
								$colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}
						}
						$arrayTableFive=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
						$resData=$this->model->InsertTableFiveActa($arrayTableFive);
						//Filas
						$posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
						for ($k=1; $k <=$posTableOtro; $k++) { 
							$indexCol=0;
							$fc=1;
							$filasCol1[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+5;
								$filasCol1[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=2;
							$filasCol2[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+5;
								$filasCol2[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=3;
							$filasCol3[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+5;
								$filasCol3[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=4;
							$filasCol4[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+5;
								$filasCol4[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=5;
							$filasCol5[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+5;
								$filasCol5[$indexCol++]=$fc;
							}
							unset($filasCol1[array_pop($filasCol1)]);
							unset($filasCol2[array_pop($filasCol2)]);
							unset($filasCol3[array_pop($filasCol3)]);
							unset($filasCol4[array_pop($filasCol4)]);
							unset($filasCol5[array_pop($filasCol5)]);						
						}
						for ($l=0; $l <count($filasCol1); $l++) { 
								$textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
								$textoColumna1[$conTexto1++]=$textoColumna;
							}
						for ($l=0; $l <count($filasCol2); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
							$textoColumna2[$conTexto2++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol3); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
							$textoColumna3[$conTexto3++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol4); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
							$textoColumna4[$conTexto4++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol5); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
							$textoColumna5[$conTexto5++]=$textoColumna;
						}
						if($resData!=FALSE){
							$res=$this->model->InsertFilaFiveActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$resData);						
						}
					}//fin column5

					//6 columnas
					if ((int)$columnaOtro===6) {
						for ($m=1; $m <=$columnaOtro; $m++) { 
							if ($m==1) {
								$colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==2){
								$colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');	
							}else if($m==3){
								$colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==4){
								$colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==5){
								$colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==6){
								$colum6=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}
						}
						$arrayTableSix=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"nombreColumna6"=>$colum6,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
						$resData=$this->model->InsertTableSixActa($arrayTableSix);
						//Filas
						$posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
						for ($k=1; $k <=$posTableOtro; $k++) { 
							$indexCol=0;
							$fc=1;
							$filasCol1[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+6;
								$filasCol1[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=2;
							$filasCol2[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+6;
								$filasCol2[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=3;
							$filasCol3[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+6;
								$filasCol3[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=4;
							$filasCol4[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+6;
								$filasCol4[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=5;
							$filasCol5[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+6;
								$filasCol5[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=6;
							$filasCol6[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+6;
								$filasCol6[$indexCol++]=$fc;
							}
							unset($filasCol1[array_pop($filasCol1)]);
							unset($filasCol2[array_pop($filasCol2)]);
							unset($filasCol3[array_pop($filasCol3)]);
							unset($filasCol4[array_pop($filasCol4)]);
							unset($filasCol5[array_pop($filasCol5)]);
							unset($filasCol6[array_pop($filasCol6)]);						
						}
						for ($l=0; $l <count($filasCol1); $l++) { 
								$textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
								$textoColumna1[$conTexto1++]=$textoColumna;
							}
						for ($l=0; $l <count($filasCol2); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
							$textoColumna2[$conTexto2++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol3); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
							$textoColumna3[$conTexto3++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol4); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
							$textoColumna4[$conTexto4++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol5); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
							$textoColumna5[$conTexto5++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol6); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol6[$l].'TD_'.$j.'['.$i.']');
							$textoColumna6[$conTexto6++]=$textoColumna;
						}
						if($resData!=FALSE){
							$res=$this->model->InsertFilaSixActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$textoColumna6,$resData);						
						}
					}//fin column6
						
					//7 columnas
					if ((int)$columnaOtro===7) {
						for ($m=1; $m <=$columnaOtro; $m++) { 
							if ($m==1) {
								$colum1=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==2){
								$colum2=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');	
							}else if($m==3){
								$colum3=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==4){
								$colum4=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==5){
								$colum5=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==6){
								$colum6=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}else if($m==7){
								$colum7=$this->input->post('titulo_'.$m.'TD_'.$j.'['.$i.']');
							}
						}
						$arrayTableSeven=array("nombreColumna1"=>$colum1,"nombreColumna2"=>$colum2,"nombreColumna3"=>$colum3,"nombreColumna4"=>$colum4,"nombreColumna5"=>$colum5,"nombreColumna6"=>$colum6,"nombreColumna7"=>$colum7,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."otro".']['.$i.']'));
						$resData=$this->model->InsertTableSevenActa($arrayTableSeven);
						//Filas
						$posTableOtro=$this->input->post('posTableOtro_'.$j.'['.$i.']');
						for ($k=1; $k <=$posTableOtro; $k++) { 
							$indexCol=0;
							$fc=1;
							$filasCol1[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+7;
								$filasCol1[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=2;
							$filasCol2[$indexCol++]=$fc;
							while($fc<$posTableOtro) { 
								$fc=$fc+7;
								$filasCol2[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=3;
							$filasCol3[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+7;
								$filasCol3[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=4;
							$filasCol4[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+7;
								$filasCol4[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=5;
							$filasCol5[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+7;
								$filasCol5[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=6;
							$filasCol6[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+7;
								$filasCol6[$indexCol++]=$fc;
							}
							$indexCol=0;
							$fc=7;
							$filasCol7[$indexCol++]=$fc;
							while($fc<=$posTableOtro) { 
								$fc=$fc+7;
								$filasCol7[$indexCol++]=$fc;
							}
							unset($filasCol1[array_pop($filasCol1)]);
							unset($filasCol2[array_pop($filasCol2)]);
							unset($filasCol3[array_pop($filasCol3)]);
							unset($filasCol4[array_pop($filasCol4)]);
							unset($filasCol5[array_pop($filasCol5)]);
							unset($filasCol6[array_pop($filasCol6)]);
							unset($filasCol7[array_pop($filasCol7)]);						
						}
						for ($l=0; $l <count($filasCol1); $l++) { 
								$textoColumna=$this->input->post('textoOtro'.$filasCol1[$l].'TD_'.$j.'['.$i.']');
								$textoColumna1[$conTexto1++]=$textoColumna;
							}
						for ($l=0; $l <count($filasCol2); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol2[$l].'TD_'.$j.'['.$i.']');
							$textoColumna2[$conTexto2++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol3); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol3[$l].'TD_'.$j.'['.$i.']');
							$textoColumna3[$conTexto3++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol4); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol4[$l].'TD_'.$j.'['.$i.']');
							$textoColumna4[$conTexto4++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol5); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol5[$l].'TD_'.$j.'['.$i.']');
							$textoColumna5[$conTexto5++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol6); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol6[$l].'TD_'.$j.'['.$i.']');
							$textoColumna6[$conTexto6++]=$textoColumna;
						}
						for ($l=0; $l <count($filasCol7); $l++) { 
							$textoColumna=$this->input->post('textoOtro'.$filasCol7[$l].'TD_'.$j.'['.$i.']');
							$textoColumna7[$conTexto7++]=$textoColumna;
						}
						if($resData!=FALSE){
							$res=$this->model->InsertFilaSevenActa($textoColumna1,$textoColumna2,$textoColumna3,$textoColumna4,$textoColumna5,$textoColumna6,$textoColumna7,$resData);						
						}
					}//fin column7
				}
			}//fin if
			if (!empty($graphicBarra)) {
				for ($j=1; $j <=$graphicBarra; $j++) { 
				$arrayGraphicBarra=array("tituloG"=>$this->input->post('tituloGrafico_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGrafico_'.$j.'['.$i.']'),"subtituloY"=>$this->input->post('tituloGraficoY_'.$j.'['.$i.']'),"puntoInicial"=>$this->input->post('start_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gBarra".']['.$i.']'),"codigoTipoG"=>1);
				$resData=$this->model->InsertGraphic($arrayGraphicBarra);
					if(!$resData){
						$res=$resData;
					}else{
						$posBarra=$this->input->post('posBarra_'.$j.'['.$i.']');
						for ($k=1; $k <$posBarra; $k++) { 
							$tituloColumna=$this->input->post('dataTBarra'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataBarra'.$k.'_'.$j.'['.$i.']');
							$res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
						}
					}//fin else
				}
			}//fin if empty $graphicBarra
			if (!empty($graphicPie)) {
				for ($j=1; $j <=$graphicPie; $j++) { 
				$arrayGraphicPie=array("tituloG"=>$this->input->post('tituloGraficoP_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGraficoP_'.$j.'['.$i.']'),"subtituloY"=>0,"puntoInicial"=>0,"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gPie".']['.$i.']'),"codigoTipoG"=>2);
				$resData=$this->model->InsertGraphic($arrayGraphicPie);
					if(!$resData){
						$res=$resData;
					}else{
						$posPie=$this->input->post('posPie_'.$j.'['.$i.']');
						for ($k=1; $k <$posPie; $k++) { 
							$tituloColumna=$this->input->post('dataTPie'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataPie'.$k.'_'.$j.'['.$i.']');
							$res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
						}
					}//fin else
				}
			}//fin if empty $graphicPie
			if (!empty($graphicLineal)) {
				for ($j=1; $j <=$graphicLineal; $j++) { 
				$arrayGraphicLineal=array("tituloG"=>$this->input->post('tituloGraficoL_'.$j.'['.$i.']'),"subtituloG"=>$this->input->post('subtituloGraficoL_'.$j.'['.$i.']'),"subtituloY"=>$this->input->post('tituloGraficoYL_'.$j.'['.$i.']'),"puntoInicial"=>$this->input->post('startL_'.$j.'['.$i.']'),"modulo"=>$i,"orden"=>$j,"codigoActa"=>$acta,"ordenActa"=>$this->input->post('ordenActa_'.$j.'['."gLinea".']['.$i.']'),"codigoTipoG"=>3);
				$resData=$this->model->InsertGraphic($arrayGraphicLineal);
					if(!$resData){
						$res=$resData;
					}else{
						$posLinea=$this->input->post('posLinea_'.$j.'['.$i.']');
						for ($k=1; $k <$posLinea; $k++) { 
							$tituloColumna=$this->input->post('dataTLinea'.$k.'_'.$j.'['.$i.']');
							$datosColumna=$this->input->post('dataLinea'.$k.'_'.$j.'['.$i.']');
							$res=$this->model->InsertFilaGraphic($tituloColumna,$datosColumna,$resData);
						}
					}//fin else
				}
			}//fin if empty $graphicLineal
		}//fin for 
	}
		if (!empty($mensaje)) {
			echo $mensaje;
		}
			if(!$res){
				echo 'Algo salio mal';
			}else {
				echo 'Exito al crear el acta';
				if($this->model->completarActa($acta)){
					$this->session->set_userdata('idActa','');
					$this->session->set_userdata('retorno',1);
				}
			}
	}//Fin insertarActaContenido
	/**
	 * Este metodo carga  la vision de la base de datos
	 * y envia los datos a la vista. 
	 */
	public function vision(){
				/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=2;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['vision']=$this->model->getVision();
		$data['title']='VISIÓN DE CRM';
		$data['content']='view_vision';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la politica de calidad de la base de datos
	 * y envia los datos a la vista. 
	 */
	public function politica(){
				/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=3;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=3;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['politica']=$this->model->getPolitica();
		$data['title']='POLITICA DE CALIDAD';
		$data['content']='view_politica';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo recibe el id del proceso
	 * para la construcción de las carpetas 
	 * en acordeón  
	 */
	public function gestionDocumentalObsoletos($id){ 
		/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
			$this->validateGet($id);
		if ($this->validateGestionDocumental($id)!= false) {	
			/**
			 * Este metodo recibe el id del proceso
			 * para la construcción de las carpetas 
			 * en acordeón  
			 */
			/**---Envio de datos a la vista-*/
			$title='';
			$rutaDescarga='';
			$content='';
			$data['option']=$this->validateDelete();
			$root=str_replace("\\",'/',getcwd());
			$ruta=$root;
			$datos=array();
			$data['folderDO']=0;
			$data['folderD']=$this->folderD;
			$data['barra_superior']=false;
				//Validación para envio de vista
				//y construccion acordeon 
				if ($id==1) {
					$title='Planeación Estratégica';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=11;
					$rutaDescarga='File/Documentos obsoletos/Planeacion Estrategica (PE)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==2) {
					$title='Administración de Riesgos (AR)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=1;
					$rutaDescarga='File/Documentos obsoletos/Administracion de Riesgos';
					$ruta.='/'.$rutaDescarga;
				}if ($id==3) {
					$title='Infraestructura (IF)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=10;
					$rutaDescarga='File/Documentos obsoletos/Infraestructura (IF)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==4) {
					$title='Gestion Comercial  (GC)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=7;
					$rutaDescarga='File/Documentos obsoletos/Gestion Comercial  (GC)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==5) {
					$title='Siniestros (SI)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=13;
					$rutaDescarga='File/Documentos obsoletos/Siniestros (SI)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==6) {
					$title='Gestion Humana (GH)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=9;
					$rutaDescarga='File/Documentos obsoletos/Gestion Humana (GH)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==7) {
					$title='Gestion Financiera (GF)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=8;
					$rutaDescarga='File/Documentos obsoletos/Gestion Financiera (GF)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==8) {
					$title='Gestion de Calidad (GQ)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=6;
					$rutaDescarga='File/Documentos obsoletos/Gestion de Calidad (GQ)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==10) {
					$title='Servicio al Cliente (SV)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=12;
					$rutaDescarga='File/Documentos obsoletos/Servicio al Cliente (SV)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==11) {
					$title='Diseño y Desarrollo (DD)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=4;
					$rutaDescarga='File/Documentos obsoletos/Diseno y Desarrollo (DD)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==12) {
					$title='Compras (CO)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=3;
					$rutaDescarga='File/Documentos obsoletos/Compras (CO)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==13) {
					$title='Seguridad y Salud en el Trabajo (SST)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=14;
					$rutaDescarga='File/Documentos obsoletos/Seguridad y Salud en el Trabajo (SST)';
					$ruta.='/'.$rutaDescarga;		
				}
				if ($id==15) {
					$title='Asesoría en suscripción';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=2;
					$rutaDescarga='File/Documentos obsoletos/Asesoria en Suscripcion';
					$ruta.='/'.$rutaDescarga;	
				}
				if ($id==16) {
					$title='Divulgación de procesos';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderDO']=5;
					$rutaDescarga='File/Documentos obsoletos/Divulgacion de procesos';
					$ruta.='/'.$rutaDescarga;	
				}				
			$data['acordeon']=$this->buildAcoordion($datos,$title,$ruta,$rutaDescarga,$data['barra_superior'],$id,$data['option']);
			$data['folder']=0;
			$data['title']=$title;
			$data['content']=$content;
			$this->load->vars($data);
			$this->load->view('template');
		}else{
			redirect('');
		}
	}
	/**
	 * Este metodo recibe el id del proceso
	 * para la construcción de las carpetas 
	 * en acordeón  
	 */
	public function gestionDocumental($id){ 
		/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
			$this->validateGet($id);
		if ($this->validateGestionDocumental($id)!= false) {
			
			if ($this->tipoUsuario==1) {
				$data['barra_superior']=TRUE;
			}else{
				$data['barra_superior']=FALSE;	
			}
			/**---Envio de datos a la vista-*/
			$title='';
			$rutaDescarga='';
			$content='';
			$root=str_replace("\\",'/',getcwd());
			$ruta=$root;
			$datos=array();
			$data['folderD']=0;
			$data['option']=0;
			$data['folderDO']=$this->folderDO;
				//Validación para envio de vista
				//y construccion acordeon 
				if ($id==1) {
					$title='Planeación Estratégica';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=10;
					$rutaDescarga='File/Documentacion/Planeacion Estrategica (PE)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==2) {
					$title='Administración de Riesgos (AR)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=1;
					$rutaDescarga='File/Documentacion/Administracion de Riesgos';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==3) {
					$title='Infraestructura (IF)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=9;
					$rutaDescarga='File/Documentacion/Infraestructura (IF)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==4) {
					$title='Gestion Comercial  (GC)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=5;
					$rutaDescarga='File/Documentacion/Gestion Comercial  (GC)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==5) {
					$title='Siniestros (SI)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=13;
					$rutaDescarga='File/Documentacion/Siniestros (SI)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==6) {
					$title='Gestion Humana (GH)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=8;
					$rutaDescarga='File/Documentacion/Gestion Humana (GH)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==7) {
					$title='Gestion Financiera (GF)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=7;
					$rutaDescarga='File/Documentacion/Gestion Financiera (GF)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==8) {
					$title='Gestion de Calidad (GQ)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=6;
					$rutaDescarga='File/Documentacion/Gestion de Calidad (GQ)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==10) {
					$title='Servicio al Cliente (SV)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=12;
					$rutaDescarga='File/Documentacion/Servicio al Cliente (SV)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==11) {
					$title='Diseño y Desarrollo (DD)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=3;
					$rutaDescarga='File/Documentacion/Diseno y Desarrollo (DD)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==12) {
					$title='Compras (CO)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=2;
					$rutaDescarga='File/Documentacion/Compras (CO)';
					$ruta.='/'.$rutaDescarga;
				}
				if ($id==13) {
					$title='Seguridad y Salud en el Trabajo (SST)';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=11;
					$rutaDescarga='File/Documentacion/Seguridad y Salud en el Trabajo (SST)';
					$ruta.='/'.$rutaDescarga;		
				}
				if ($id==16) {
					$title='Divulgación de procesos';
					$content='view_acordeonDocumentacionPlaneacion.php';
					$datos=$this->model->getFolder($id);
					$data['folderD']=4;
					$rutaDescarga='File/Documentacion/Divulgacion de procesos';
					$ruta.='/'.$rutaDescarga;	
				}
			$data['acordeon']=$this->buildAcoordion($datos,$title,$ruta,$rutaDescarga,$data['barra_superior'],$id,0);
			$data['folder']=0;
			$data['title']=$title;
			$data['content']=$content;
			$this->load->vars($data);
			$this->load->view('template');
		}else{
			redirect('');
		}	
	}
	/**
	 * [buildAcoordion 
	 * Este metodo construye el acordeon 
	 * segun datos recibidos retornando 
	 * el codigo html]
	 * @param  [type] $datos          [description]
	 * @param  [type] $title          [description]
	 * @param  [type] $ruta           [description]
	 * @param  [type] $rutaDescarga   [description]
	 * @param  [type] $barra_superior [description]
	 * @param  [type] $idG            [description]
	 * @param  [type] $option         [description]
	 * @return [type]                 [description]
	 */
	public function buildAcoordion($datos,$title,$ruta,$rutaDescarga,$barra_superior,$idG,$option){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$html='';
		$url='';
		$arreglo=0;
		$id=count($datos);
		$arraySubAcordion=array();
		$rutaDescargaS=$rutaDescarga;
		$text=$rutaDescargaS;
		$urlSecond='';
		$index=0;
		$indexAcordion=0;
		if (isset($barra_superior)) {
			if ($barra_superior) {
					$mostrar_barra='visible';
			}else{
				$mostrar_barra='hidden';
				}
		}
		if ($option==1) {
			$mostrarE='visible';
		}else{
			$mostrarE='hidden';
		}
		$html.='<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                        <input type="hidden" id="id" name="id" value="'.$idG.'">';
		$html.= '<h4>'.$title.'</h4>';                	
        $html.='        
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">';
                            	foreach ($datos as $values=>$key) {
        $html.=                 '<div class="panel panel-default">
                                    <div class="panel-heading">                                 
                                		<h4 class="panel-title">';
        $html.=                         	'<a class="panel-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$values.'">';
        $html.=									$datos[$values]->nombreCarpeta;						           
        $html.='                            </a>				
                       					</h4>
                                    </div>
                                	<div id="'.$values.'" class="panel-collapse collapse out">
                                    	<div class="panel-body">
                                    	';
        	                           	$url.=$ruta.'/'.$datos[$values]->nombreCarpeta.';';	
        	                           	$cont=$this->seeContent($url);
        	                           	foreach ($cont[0] as $archivo) {
        	                           		$pos=strpos($archivo,'.');
        	                           		if ($archivo=='VACIO' || empty($archivo)) {
         $html.=	                        			'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';
        	                           		}else if ($pos){
        	                           		if (substr($archivo,-3)=='pdf') {
        $html.=		                           	'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';
        	                           		}else if(substr($archivo,-4)=='xlsx' || substr($archivo,-3)=='xls'){
        $html.=	                       			'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';
        	                           		}else if(substr($archivo,-4)=='docx' || substr($archivo,-3)=='doc'){
        $html.=                            		'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';											
        	                           		}else if(substr($archivo,-3)=='txt'){
        $html.=                            		'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';	                           			
        	                           		}else if(substr($archivo,-3)=='mp4'||substr($archivo,-3)=='wmv'||substr($archivo,-3)=='avi'){
        $html.=                            		'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-video-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';	                           			
        	                           		}
        	                           		else if(substr($archivo,-4)=='pptx'||substr($archivo,-3)=='ppt'){
        $html.=                            		'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download><i class="fa fa-file-powerpoint-o fa-2x" aria-hidden="true"></i>&nbsp;'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';	                           			
        	                           		}else if(substr($archivo,-3)=='ico'){
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';
        	                           		}else{
        $html.=                            		'<table><tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" download>'.$archivo.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o  fa-lg"></i></a><a href="" id="'.$ruta.'/'.$datos[$values]->nombreCarpeta.'/'.$archivo.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg"></i></a><br></td></tr>';
        $html.=									'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';	                           			
        	                           		}
        	                           		$indexArreglo=$index;
        	                           	}else{
        	                           		if ($text==$rutaDescargaS){
        	                           		    $urlSecond.=$ruta.'/'.$datos[$values]->nombreCarpeta;
        										$rutaDescargaS.='/'.$datos[$values]->nombreCarpeta;
        	                           		}	              	        
        									$indexArreglo++;
		$html.=	                        		'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$datos[$values]->nombreCarpeta.'/'.'">';
		$html.=									'<tr><td colspan="2" class="col-sm-12"><br>'.$this->buildSecondAccordion($archivo,$urlSecond,$rutaDescargaS,++$id,$mostrar_barra,++$indexArreglo,$option).'</td></tr><br>';
        								}
    											}//Fin foreach
										$url='';
		$html.=							'</table>
											<br>
											<div class="'.$mostrar_barra.'">
											<form enctype="multipart/form-data" class="'.$mostrar_barra.'">
												<input type="file" id="file-'.$index++.'" class="file" value="Subir Archivo" multiple>
											</form>	
											</div>
											';							
		$html.=' 	                   	</div>
                           			</div>
        		                </div>';
        		            	}        	
        $html.='            </div>
            			</div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->';

        return $html;
	}
	/**
	 * Este metodo construye un segundo nivel
	 * del acordeon
	 */
	public function buildSecondAccordion($name,$url,$rutaDescarga,$id,$mostrar_barra,$index,$option){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		++$index;
		$html='';
		if ($option==1) {
			$mostrarE='visible';
		}else{
			$mostrarE='hidden';
		}
		$cont=$this->seeContent($url.'/'.$name);
		$html.='
				<div class="panel panel-default">
		            <div class="panel-heading" role="tab" id="subHeadingTwo">
		              <h4 class="panel-title">
		                <a class="panel-toggle collapsed" class="collapsed" role="button" data-toggle="collapse" data-parent="#sub-accordion" href="#'.$id.'" aria-expanded="false" aria-controls="'.$id.'">
		                '.$name.'
		                </a>
		              </h4>
		            </div>
		            <div id="'.$id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSubTwo">
		              	<div class="panel-body">
		              	<table>';
		                foreach ($cont[0] as $value) {
		                	$pos=strpos($value,'.');
        	                        if ($value=='VACIO' || empty($cont[0])) {
        $html.=                  		'<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$name.'">';
        	                           	}else if ($pos) {
	                           		if (substr($value,-3)=='pdf') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';
	                           		}else if (substr($value,-4)=='xlsx' || substr($value,-3)=='xls') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';
	                           		}else if (substr($value,-4)=='docx' || substr($value,-3)=='doc') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if (substr($value,-3)=='txt') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if (substr($value,-3)=='mp4'||substr($value,-3)=='wmv'||substr($value,-3)=='avi') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-video-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if (substr($value,-4)=='pptx') {
	    $html.=                  	'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-powerpoint-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if(substr($value,-3)=='ico'){
	                           		}else{
        $html.=                     '<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$rutaDescarga.'/'.$name.'/'.$value.'" download>'.$value.'<a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$rutaDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';
        	                           	}
	                           	}else{	              	        
		$html.=						'<tr><td class="col-sm-12" colspan="2">'.$this->buildThirdAccordion($value,++$id,$url.'/'.$name,$rutaDescarga.'/'.$name,$mostrar_barra,++$index,$option).'</td></tr>';
								}
		                }
		$html.=		'</table>
					<br>
					<div class="'.$mostrar_barra.'">
					<form enctype="multipart/form-data" class="'.$mostrar_barra.'">
						<input type="hidden" id="targetPath-'.$index.'" value="'.$rutaDescarga.'/'.$name.'">
						<input type="file" id="file-'.$index++.'" class="file" value="Subir Archivo" multiple>
					</form>
					</div>';
		$html.='    	</div>
		          	</div>
		        </div>';
        return $html;
	}
	/**
	 * [buildThirdAccordion description]
	 * Este metodo construye el tercer subnivel del acordeon
	 */
	public function buildThirdAccordion($name,$id,$url,$urlDescarga,$mostrar_barra,$index,$option){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$html='';
		if ($option==1) {
			$mostrarE='visible';
		}else{
			$mostrarE='hidden';
		}
		$cont=$this->seeContent($url.'/'.$name);
		$html.='<br>
		<div class="panel panel-default">
            <div class="panel-heading" role="tab" id="subHeadingTwo">
              	<h4 class="panel-title">
                	<a class="panel-toggle collapsed" class="collapsed" role="button" data-toggle="collapse" data-parent="#sub-accordion" href="#'.$id.'" aria-expanded="false" aria-controls="'.$id.'">
                  		'.$name.'
                	</a>
              	</h4>
            </div>
            <div id="'.$id.'" class="panel-collapse collapse" role="tabpanel" >
              		<div class="panel-body"> 
              			<table>';
              		foreach ($cont[0] as $value) {
              				if ($value=='VACIO') {
                 			}else if (substr($value,-3)=='pdf') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';
	                           		}else if (substr($value,-4)=='xlsx' || substr($value,-3)=='xls') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';
	                           		}else if (substr($value,-4)=='docx' || substr($value,-3)=='doc') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if (substr($value,-3)=='txt') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                      			
	                           		}else if (substr($value,-3)=='mp4'||substr($value,-3)=='wmv'||substr($value,-3)=='avi') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-video-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if (substr($value,-4)=='pptx') {
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download><i class="fa fa-file-powerpoint-o fa-2x" aria-hidden="true"></i>&nbsp;'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}else if(substr($value,-3)=='ico'){
	                           		}else{
	    $html.=			'<tr><td class="col-sm-12"><a class="descarga" href="'.base_url().$urlDescarga.'/'.$name.'/'.$value.'" download>'.$value.'</a></td><td class="col-sm-2">&nbsp;<a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrar_barra.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><a href="" id="'.FCPATH.$urlDescarga.'/'.$name.'/'.$value.'" class="'.$mostrarE.' btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a><br></td></tr>';                       			
	                           		}
        			}
        		++$index;
		$html.=			'</table>
						<br>
						<div class="'.$mostrar_barra.'">
						<form enctype="multipart/form-data" class="'.$mostrar_barra.'">
							<input type="file" id="file-'.++$index.'" class="file" value="Subir Archivo" multiple>
						<input type="hidden" id="targetPath-'.$index.'" value="'.$urlDescarga.'/'.$name.'";			
						</form>
						</div>';			
   		$html.=		'</div>
            </div>
         </div>';
         return $html;
	}
	/**
	 * Este metodo construye el menu de los usuario
	 * segun permisos dados 
	 */
	public function buildMenu(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		foreach ($this->proceso as $value) {
			$value->codigoProceso.'<br>';
		}
	}
	/**
	 * Este metodo carga el alcance de la base de datos
	 * y envia los datos a la vista. 
	 */
	public function alcance(){
				/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$tabla=6;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['alcance']=$this->model->getAlcance();
		$data['title']='ALCANCE DEL SGC CRM';
		$data['content']='view_alcance';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo carga  la politica de la base de datos
	 * y envia los datos a la vista para ser editados. 
	 */
	public function updatePolitica(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$mensaje='';
		$text=$this->input->post('text');
		$id=$this->input->post('id');
		$codigo=$this->input->post('codigoPolitica');
		$version=$this->input->post('version');
		$desc=$this->input->post('desc');
		$fecha=$this->input->post('fechaVigencia');
		$tabla=3;
		/**-------Variables elaborado-----------*/
		$codigoE=$this->input->post('elaborado');
		$fechaR=$this->input->post('fechaE');
		$revisadoE=$this->model->editRevision($codigoE,$fechaR,1,$tabla);
		/**-------Variables revisado-----------*/
		$codigoE=$this->input->post('revisado');
		$fechaR=$this->input->post('fechaR');
		$revisadoR=$this->model->editRevision($codigoE,$fechaR,2,$tabla);
		/**-------Variables aprobado-----------*/
		$codigoE=$this->input->post('aprobado');
		$fechaR=$this->input->post('fechaA');
		$revisadoA=$this->model->editRevision($codigoE,$fechaR,3,$tabla);

		/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
		$data=array("codigoPolitica"=>$codigo,"texto"=>$text);
		if($this->model->editPolitica($id,$data) && $this->model->insertCambio($version,$desc,$fecha,$tabla) && $revisadoA && $revisadoR && $revisadoE){
			$mensaje="Politica editada con exito";
		}else{
			$mensaje="Falló al editar la Politica";
		}
		$this->session->set_userdata('mensaje',$mensaje);
		redirect('calidad/politica');
	}
	/**
	 *	Este metodo valida que el cargo del usuario sea 
	 * 	directora de calidad para que pueda eliminar.
	 * $idCargo=15;->Directora de calidad
	 */
	private function validateDelete(){
		$this->validateSession();
		$idUsuario=$this->session->userdata('idUsuario');
		$cargo=$this->model->getIdCargo($idUsuario);
		$res=0;
			if ($cargo->codigoCargo==15 && $this->tipoUsuario==1) {
				$res=1;
			}
		return $res;
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validateSession()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar la session del usuario
	| -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validateSession(){
		if( $this->session->userdata('login') == 0 ||
			$this->session->userdata('REMOTE_ADDR') != $_SERVER['REMOTE_ADDR'] || 
			$this->session->userdata('HTTP_USER_AGENT') != $_SERVER['HTTP_USER_AGENT']){
			redirect('');
		}
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validateUsuario()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar la session del usuario administrador
	| -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validateUsuario(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		if ($this->tipoUsuario==1) {
		}else{
			redirect('calidad/');
		}
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validateProceso()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar la session del usuario dueño de proceso
	| -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validateUsuarioProceso(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		if ($this->tipoUsuario==3 ||$this->tipoUsuario==1) {
			return true;
		}else{
			redirect('calidad/');
		}
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validateGet()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar que se reciba algo en la url
	| -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validateGet($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		if (isset($id)) {
		}else{
			redirect('calidad/');
		}
	}
	/**
	 * Metodo para encryptar la contraseña generada aleatoreamente 
	 * $password->Contraseña del usuario
	 */
	function PasswordHash($password){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
	 return password_hash($password, PASSWORD_DEFAULT);
	}
	/**
	 * Metodo que carga la vista para cambiar la contraseña
	 */
	public function changePassword(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/**---Envio de datos a la vista-*/
		$data['id']=$this->session->userdata('idUsuario');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=0;
		$data['title']='Cambiar Contraseña';
		$data['content']='view_changePassword';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo se encarga de cargar los objetivos de SGC Y DE SST
	 */
	public function getObjetivo(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		/**---Envio de datos a la vista-*/
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=8;
		$data['sgc']=$this->model->getObjetivo(1);
		$data['sst']=$this->model->getObjetivo(2);
		$data['title']='Objetivos de calidad';
		$data['content']='view_objetivo';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * Este metodo cambia la visibilidad de 1 a 0 
	 */
	public function inactivateObjetivo($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateUsuario();
		if (isset($id)) {
			$data=array("visibilidad"=>0);
			$respuesta=$this->model->inactivateObjetivo($id,$data);
		}
		redirect('calidad/getObjetivo');
	}
	/**
	 * [addIndicador description]
	 */
	public function addIndicador()
	{
		$this->validateUsuario();
		$proceso=$this->input->post('procesoI');
		$idTipo=$this->input->post('tipoI');
		$indicador=$this->input->post('nombre');
		$numerador=$this->input->post('numerador');
		$denominador=$this->input->post('denominador');
		$x=$this->input->post('x');
		$idSimbolo=$this->input->post('simbolo');
		$meta=$this->input->post('meta');
		$rMedir=$this->input->post('rMedir');
		$rGestionar=$this->input->post('rGestionar');
		$recursos=$this->input->post('recursos');
		$medicion=$this->input->post('frecuencia');
		if (isset($proceso) && isset($idTipo)&& isset($indicador) && isset($numerador)&& isset($denominador)&& isset($idSimbolo)
			&& isset($meta)&& isset($rMedir)&& isset($rGestionar)&& isset($medicion) && isset($recursos)) {
			if($this->model->addIndicador($recursos,'',$indicador,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$medicion,$rMedir,$rGestionar,$proceso,1,$x)){
				$this->session->set_userdata('mensaje','Indicador agregado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar el indicador');
			}
 		}
		redirect('calidad/indicadorGestionCalidad');
	}
	/**
	 * [addDirectriz description]
	 */
	public function addDirectriz()
	{
		$this->validateUsuario();
		$directriz=$this->input->post('directriz');
		$descripcion=$this->input->post('descripcion');
		$proceso=$this->input->post('proceso');
		if(isset($directriz)&&isset($descripcion)){
			if($this->model->addDirectriz($directriz,$descripcion,$proceso,1)&& $this->model->updateDisponibilidadProceso($proceso,0)){
				$this->session->set_userdata('mensaje','Directriz agregada con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar la directriz');
			}
		}
		redirect('calidad/directrizGestionCalidad');
	}
	/**
	 * [addDirectrizSST description]
	 */
	public function addDirectrizSST()
	{
		$this->validateUsuario();
		$directriz=$this->input->post('directriz');
		$descripcion=$this->input->post('descripcion');
		$proceso=$this->input->post('proceso');
		if(isset($directriz)&&isset($descripcion)&&isset($proceso)){
			if($this->model->addDirectriz($directriz,$descripcion,$proceso,2)){
				$this->session->set_userdata('mensaje','Directriz agregada con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar la directriz');
			}
		}
		redirect('calidad/directrizGestionCalidadSST');
	}
	/**
	 * Description
	 * @return type
	 */
	public function addIndicadorSST()
	{
		$this->validateUsuario();
		$proceso=$this->input->post('procesoI');
		$idTipo=$this->input->post('tipoI');
		$indicador=$this->input->post('nombre');
		$numerador=$this->input->post('numerador');
		$denominador=$this->input->post('denominador');
		$x=$this->input->post('x');
		$idSimbolo=$this->input->post('simbolo');
		$meta=$this->input->post('meta');
		$rMedir=$this->input->post('rMedir');
		$rGestionar=$this->input->post('rGestionar');
		$medicion=$this->input->post('frecuencia');
		$directriz=$this->input->post('directriz');
		$recursos=$this->input->post('recursos');
		if (isset($directriz) && isset($proceso) && isset($idTipo)&& isset($indicador)&& isset($numerador)&& isset($denominador)&& isset($idSimbolo)
			&& isset($meta)&& isset($rMedir)&& isset($rGestionar)&& isset($medicion) && isset($recursos)) {
			if($this->model->addIndicador($recursos,$directriz,$indicador,$idTipo,$numerador,$denominador,$idSimbolo,$meta,$medicion,$rMedir,$rGestionar,$proceso,2,$x)){
				$this->session->set_userdata('mensaje','Indicador agregado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar el indicador');
			}
		}
		redirect('calidad/indicadorGestionSST');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function inactivateIndicador($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateUsuario();
		$data=array("visibilidad"=>0);
		$respuesta=$this->model->inactivateIndicador($id,$data);
		if ($respuesta) {
			$this->session->set_userdata('mensaje','Indicador eliminado con exito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar el indicador');
		}
		redirect('calidad/indicadorGestionCalidad');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function inactivateDirectriz(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateUsuario();
		$id=$this->input->post('id');
		$proceso=$this->input->post('proceso');
		if(isset($id) && isset($proceso)){
			$proceso=explode(',',$proceso);
			$data=array("visibilidad"=>0);
				$respuesta=$this->model->inactivateDirectriz($id,$data,1);
				$respuestaProceso=$this->model->updateDisponibilidadProceso($proceso,1);
				if ($respuesta && $respuestaProceso){
					echo 'Directriz eliminado con exito';
				}else{
					echo 'No se pudo eliminar la directriz';
				}
		}else{
			echo 'problemas al eliminar la directriz';
		}
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function inactivateDirectrizSST($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateUsuario();
		$data=array("visibilidad"=>0);
		$respuesta=$this->model->inactivateDirectriz($id,$data,2);
		if ($respuesta) {
			$this->session->set_userdata('mensaje','Directriz eliminado con exito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar la directriz');
		}
		redirect('calidad/directrizGestionCalidadSST');
	}
	/**
	 * Description
	 * @param type $id 
	 * @return type
	 */
	public function inactivateIndicadorSST($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		$this->validateUsuario();
		$data=array("visibilidad"=>0);
		$respuesta=$this->model->inactivateIndicador($id,$data);
		if ($respuesta) {
			$this->session->set_userdata('mensaje','Indicador eliminado con exito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar el indicador');
		}
		redirect('calidad/indicadorGestionSST');
	}
	/**
	 * Este metodo cambia la visibilidad de 1 a 0 
	 */
	public function inactivateProceso($id){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateGet($id);
		$this->validateUsuario();
		$data=array("visibilidad"=>0);
		$respuesta=$this->model->inactivateProceso($id,$data);
		redirect('calidad/proceso');
	}
	/**
	 * 	
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function inactivateComiteCalidad($id)
	{
		$this->validateGet($id);
		$data=array("visibilidad"=>0);
		$respuesta=$this->model->inactivateComiteCalidad($id,$data);
		if ($respuesta) {
			$this->session->set_userdata('mensaje','Comite #'.$id.' eliminado con exito');
		}else{
			$this->session->set_userdata('mensaje','No se pudo eliminar el comite #'.$id.'');
		}
		redirect('calidad/comiteCalidad');
	}
	/**
	 * [inactivatePlanAccion description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function inactivatePlanAccion($id)
	{
		$this->validateGet($id);
		$this->validateUsuarioProceso();
		if (isset($id)) {
			$data=array("visibilidad"=>0);
			if($this->model->inactivatePlanAccion($id,$data)){
				$this->session->set_userdata('mensaje','Plan de accion eliminado con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo elimanar el plan de acción');
			}
		}
		redirect('calidad/planAccion');
	}
	/**
	 * Este metodo agrega unn nuevo objetivo 
	 */
	public function addObjetivo(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$text=$this->input->post('objetivo');
		$tipo=$this->input->post('tipo');
		if (isset($text) && isset($tipo)) {
			$this->model->addObjetivo($tipo,$text);
		}
		redirect('calidad/getObjetivo');
	}
	/**
	 * Este metodo agrega unn nuevo proceso 
	 */
	public function addProceso(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$name=$this->input->post('nombre');
		if (isset($name)) {
			$this->model->addProceso($name);
		}
		redirect('calidad/proceso');
	}
	/**
	 * Este metodo actualiza la contraseña en la base de datos
	 */
	public function updatePass(){

		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$id='';
		$id=$this->input->post('id');
		$Password=$this->model->getPass($id);
		$oldPassword=$this->input->post('old');
		$newPass=$this->PasswordHash($this->input->post('new'));
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=0;
		$data['id']=$id;
		$data['title']='Change Password';
		if ($this->validatePassword($Password->password,$oldPassword)) {
			$this->model->savePass($id,$newPass);
			$data['mensaje']='Contraseña actualizada exitosamente';
			$this->logout();
		}else{
			$data['mensaje']='Contraseña antigua no es valida';
		}
		$data['content']='view_changePassword';
		$this->load->vars($data);
		$this->load->view('template');
	}

	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validatePassword()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar la contraseña ingresada por el usuario
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validatePassword($passwordEncrypt,$password){
			/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
		if (password_verify($password,$passwordEncrypt)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  logout()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de cerrar la sesion de usuario
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function logout() {

		$this->session->sess_destroy();
	}
	/**
	 * [seeMapP description]
	 * Este metodo carga la informacion del mapa de procesos
	 */
	public function seeMapP(){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
		if ($this->tipoUsuario==1) {
			$data['barra_superior']=TRUE;
		}else{
			$data['barra_superior']=FALSE;	
		}
		/**---Envio de datos a la vista-*/
		$tabla=4;
		$data['mensaje']=$this->session->userdata('mensaje');
		$this->session->set_userdata('mensaje','');
		$data['folderD']=$this->folderD;
		$data['folderDO']=$this->folderDO;
		$data['folder']=$tabla;
		$data['control']=$this->model->getControlCambio($tabla);
		$data['elaborado']=$this->model->getRevisionId(1,$tabla);
		$data['revisado']=$this->model->getRevisionId(2,$tabla);
		$data['aprobado']=$this->model->getRevisionId(3,$tabla);
		$data['mapa']=$this->model->getMapaProcesos();
		$data['coordenadas']=$this->model->getCoordenadas();
		$data['folder']=$tabla;
		$data['title']='Mapa de Procesos';
		$data['content']='view_map';
		$this->load->vars($data);
		$this->load->view('template');
	}
	/**
	 * [uploadj description]
	 * Este metodo carga los archivos 
	 * a la alguna subcarpeta  de documentacion 
	 */
		public function uploadC(){
		/**
		 * Creacion carpeta imagenes
		 */
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$carpeta=$this->session->userdata('package');
			if ($carpeta!='') {		
				$id=1;
				$valor='upps ocurrio algo';
				$targetPathDoc= $carpeta;
				if (!empty($_FILES)) {
					foreach ($_FILES as $key){
						$tempFile = utf8_encode($key['tmp_name']);
						$nombre_Doc = str_replace(' ', '-',utf8_decode($key['name']));
						$fileTypes = array('doc','docx','pdf','xlsx','xls','ppt','pptx','mp4','avi','wmv','txt','msg');
						$fileParts = pathinfo($nombre_Doc);
						$ext_Doc = strtolower($fileParts['extension']);
						$longitud_nombre = strlen($nombre_Doc);	
						$fecha = date('o-m-d');
						$targetFile = rtrim($targetPathDoc,'/') . '/' .$nombre_Doc;	
							if (in_array($ext_Doc,$fileTypes)) {
								if (!file_exists($targetFile)) {
									if (move_uploaded_file($tempFile,$targetFile)) {
											$valor ='Documento cargado correctamente';
										}
									 else {
										$valor ='No fue posible mover el archivo';
									}										
								} else {
									$valor = 'El archivo ya existe';
								}
							} else {
								$valor = 'Tipo de archivo invalido';
							}					
					}				
				} else {
					$valor = 'Archivo vacio';
				}
				echo $valor;
			}else{
				echo 'Ocurrio un problema,¡intentelo más tarde!';
			}
		/* ----------- FIN FUNCIONES DEL METODO: INICIA PROCESO CARGAR DOCUMENTO AL SERVIDOR  ----------- */
		$carpeta=$this->session->set_userdata('package',' ');
		}	
	/**
	 * [deleteFile 
	 * 	Este metodo elimina los archivos 
	 *  de documentacion obsoleta]
	 * @return [type] [description]
	 */
	public function deleteFile()
	{
		$this->validateSession();
		$this->validateUsuario();
		$oldname=$this->input->post('oldname');
		if (isset($oldname)) {
			if(unlink(utf8_decode($oldname))){
				echo 'eliminado con exito';
			} else{
				echo 'fallo al eliminar';
			}
		}else{
			redirect('');
		}
	}
	/**
	 * Este metodo mueve el archivo de documentacion
	 * a documentacion obsoleta.
	 * En caso de que no exista la carpeta será creada
	 */
	public function moveFile(){
		$this->validateSession();
		$this->validateUsuario();
		$oldname=$this->input->post('oldname');
		if (isset($oldname)) {
		$name=explode('/',$oldname);
		$index=count($name);
		$root=str_replace("\\",'/',getcwd());
		$carpeta=explode('Documentacion',$oldname);
		$newname=$root.'/File/Documentos obsoletos';
		$creacionCarpeta=str_replace($name[$index-1],'',$carpeta);	
		if (file_exists(substr($newname.$creacionCarpeta[1], 0,-1))){
			rename(utf8_decode($oldname),utf8_decode($newname.$carpeta[1]));
			echo 'Archivo pasado a obsoletos';
		}else{
			$creacionSubCarpeta=explode('/',$creacionCarpeta[1]);
			for ($i=0; $i <count($creacionSubCarpeta) ; $i++) { 
				if ($creacionSubCarpeta[$i]!="") {
					if(file_exists($newname.'/'.$creacionSubCarpeta[$i])){
						error_reporting(0);
						rename(utf8_decode($oldname),utf8_decode($newname.$carpeta[1]));
					}else {
						echo "Creando carpeta...vuelva a intentar";
						mkdir($newname.$creacionCarpeta[1],0777,false);	
						chmod($newname.$creacionCarpeta[1], 0777);
					}
				}				
			}
		}
		}else{
			redirect('');
		}
	}
	/**
	 * Description
	 * Este metodo sube una nueva imagen del mapa de proceso
	 */
	public function uploadj(){

		/**
		 * Creacion carpeta imagenes
		 */
		/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
			if (empty($_FILES)) {
				redirect('');
			}
		$id=1;
		$valor='upps ocurrio algo';
		$targetFolderBasic = 'img';
		$targetPathBasic = FCPATH. $targetFolderBasic;
		$targetPathImg= $targetPathBasic.'\imagen_mapa';
		if (!empty($_FILES)) {
		$folderSystem = $this->folderSystem($targetPathImg,$targetPathBasic);
			if ($folderSystem == TRUE) {
				foreach ($_FILES as $key){
					$tempFile = $key['tmp_name'];
					$nombre_imagen = str_replace(' ', '-',$key['name']);
					$fileTypes = array('jpg','jpeg','gif','png');
					$fileParts = pathinfo($nombre_imagen);
					$ext_imagen = strtolower($fileParts['extension']);
					$longitud_nombre = strlen($nombre_imagen);	
					$fecha = date('o-m-d');
					$targetFile = rtrim($targetPathImg,'/') . '/' . $nombre_imagen;	
					if ($longitud_nombre <= '40') {
							if (in_array($ext_imagen,$fileTypes)) {
								if (!file_exists($targetFile)) {
									if (move_uploaded_file($tempFile,$targetFile)) {
										$datos = array('idMapa' => $id,'urlImage' => $nombre_imagen);
										$respuesta = $this->model->setUploadImage($datos);
										if ($respuesta == TRUE) {
											list($ancho, $alto) = getimagesize($targetFile);
											if ($ancho >= 1047 || $alto >= 728)
											{
												if ($ancho >= 1047) {
													$ancho_final = 1047;											
												} else {
													$ancho_final = $ancho;
												}
												if ($alto >= 728) {
													$alto_final = 728;
												} else {
													$alto_final = $alto;
												}
													$this->resize($ancho_final, $alto_final, $nombre_imagen,$targetPathImg, $targetPathImg);
											$valor ='Documento cargado correctamente.';
											} else {		
											$this->resize(1047, 728, $nombre_imagen,$targetPathImg,$targetPathImg);
											$valor ='Documento cargado correctamente';
												}
										} else {
											unlink($targetFile);
											$valor ='No fue posible cargar el archivo';
										}
									} else {
										$valor ='No fue posible mover el archivo';
									}										
								} else {
									$valor = 'El archivo ya existe';
								}
							} else {
								$valor = 'Tipo de archivo invalido';
							}				
					} else {
						$valor ='Numero de caracteres no valido';
					}	
				}				
			} else {
				$valor = 'El directorio no pudo ser creado correctamente';
			}
		} else {
			$valor = 'Archivo vacio';
		}
		echo $valor;
		/* ----------- FIN FUNCIONES DEL METODO: INICIA PROCESO CARGAR DOCUMENTO AL SERVIDOR  ----------- */
		}
		/**
		 * Este metodo recibe la ubicacion de la carpeta
		 * en la cual se va a almacenar el archivo
		 */
		public function getPackage(){
			$carpeta=$this->input->post('carpeta');
			if (isset($carpeta)) {
				$this->session->set_userdata('package',$carpeta);
			}else{
			redirect(' ');
			}
		}
		/* --------------------------------------------------------------------------------------------------------------------------------------
	|  folderSystem()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método recibe como parámetros:
	|
	|  targetPathActa 				--> String que contiene la ruta donde se desea crear el directorio del Acta
	|  targetPathCapitulo 			--> String que contiene la ruta donde se desea crear el directorio del capitulo
	|  targetPathImgMini 			--> String que contiene la ruta donde se desea crear el directorio de las imagenes redimensionadas
	|  targetPathImgOriginal 		--> String que contiene la ruta donde se desea crear el directorio de las imagenes
	|  targetPathImgPdf 			--> String que contiene la ruta donde se desea crear el directorio de las imagenes redimensionadas
	|  targetPathDocRecomendacion 	--> String que contiene la ruta donde se desea crear el directorio de los documentos para Recomendacion
	|
	|  La función de este método es verificar si la ruta proporcionada existe dentro del servidor, si los directorios no existen se crearán 
	|  y darán los permisos necesarios.
	| -------------------------------------------------------------------------------------------------------------------------------------- */
		public function folderSystem($targetPathImg,$targetPathBasic = null)
		{
			/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
			$retorno = FALSE;

		if (file_exists($targetPathBasic)) {
			$retorno = TRUE;
			if (isset($targetPathImg) && !file_exists($targetPathImg))
			{
				mkdir($targetPathImg,0777,false);					
				chmod($targetPathImg, 0777);	
				$retorno =TRUE;					
			}
		}else{
			mkdir($targetPathBasic,0777,false);	
			chmod($targetPathBasic, 0777);	
			$retorno =TRUE;
			if (isset($targetPathImg) && !file_exists($targetPathImg))
			{
				mkdir($targetPathImg,0777,false);					
				chmod($targetPathImg, 0777);	
				$retorno =TRUE;					
			}
		} 		
		return $retorno;
		}
/* --------------------------------------------------------------------------------------------------------------------------------------
|  resize()
|  --------------------------------------------------------------------------------------------------------------------------------------
|  Este método recibe como parámetros:
|
|  $width 				--> Ancho deseado para redimensionar
|  $height 				--> Alto deseado para redimensionar
|  $nombre_imagene 		--> Nombre de la Imágenes que se esta redimensionando
|  $directiorio_origen 	--> Directorio del cual se obtiene la imagen que se desea redimensionar
|  $directorio_destino 	--> Directorio destino donde se almacenara la nueva imagen.
|
|  Este método tiene como función obtener una imagen que se encuentre en el servidor y con los parametros dados redimensionarla y almacenarla
|  en la ubicación que se especifique.
| -------------------------------------------------------------------------------------------------------------------------------------- */	
	public function resize($width, $height, $nombre_imagen, $directorio_origen, $directorio_destino) {	
		/* ----------- VALIDA ACCESO USUARIO ----------- */
			$this->validateSession();
		$rtOriginal = $directorio_origen.'/'.$nombre_imagen;
		$rtFinal = $directorio_destino.'/'.$nombre_imagen;	

		$config['image_library'] = 'gd2';
		$config['source_image'] =  $rtOriginal; 
		$config['new_image']= $rtFinal; 
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
        
        $this->image_lib->initialize($config);     
       
		$this->image_lib->resize();
	}
	/**
	 * Este metodo guarda las coordenadas en la bd 
	 */
	public function saveCoordenadas(){
		$respuestaBD=false;
		$arrayCoordenadas=array();
		$arrayNombres=array();
		$idMapa=$this->input->post('id');
		$str=$this->input->post('str');
		$res=$this->input->post('respuesta');
		if (isset($idMapa) && isset($str) && isset($res) ) {
			for ($i=0; $i <count($str) ; $i++) { 
			$id=$this->model->getProcessNameId($str[$i][0]);
			$arrayNombres[$i]=$id->idProceso;
			}
			for ($i=0; $i <count($res) ; $i++) { 
				$arrayCoordenadas[$i]=(explode(":",$res[$i]));
			}
			for ($i=0; $i <count($arrayNombres) ; $i++) { 
				$respuestaBD=($this->model->saveCoordenadas($arrayNombres[$i],$arrayCoordenadas[$i][1],$idMapa));
			}
			if ($respuestaBD) {
				echo "Datos ingresados con exito";
			}else{
				echo 'Error al cargar los datos :('; 
			}
		}else{
			echo 'variables vacias';
			redirect('');
		}
	}
	/**
	 * [seeContent 
	 * Este metodo envia las url 
	 * de las carpetas al metodo obternerListadoDeArchivos
	 * obteniendo los archivos de dicha ubicacion ]
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function seeContent($url){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$arrayUrl=array();
		$arrayUrl=(explode(";",$url));
		$arrayArchivos=array();
		for ($i=0; $i <count($arrayUrl); $i++) { 
			$arrayArchivos[$i]=$this->obtenerListadoDeArchivos($arrayUrl[$i].'/');
		}
		return $arrayArchivos;
	}
	/**
	 * [obtenerListadoDeArchivos 
	 * Este metodo obtiene un listado 
	 *  de archivos de una carpeta especifica
	 *  $carpeta->ubicacion de la carpeta]
	 * @param  [type] $carpeta [description]
	 * @return [type]          [description]
	 */
	public function obtenerListadoDeArchivos($carpeta){
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$index=0;//FCPATH
		$arrayArchivos=array();
		if(is_dir($carpeta)){
	    	if($dir = opendir($carpeta)){
	    		$carpeta = @scandir($carpeta);
				if (count($carpeta) > 2){
				}else{
					$arrayArchivos[$index]='VACIO';
				}
	            while(($archivo = readdir($dir)) !== false){
	            	//$ext=substr($archivo,-3);
	            	$index++;
	                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess' && (substr($archivo,-2)!='db') &&  (substr($archivo,0,1)!='~')){
						$arrayArchivos[$index]=utf8_encode($archivo);
	                }
	            }
	            closedir($dir);
	        }
		}
		return $arrayArchivos;
	}
	/**
	 * Este metodo valida que el id
	 * recibido por get concuerde con 
	 * los datos de la BD 
	 */
	public function validateActa($id)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$this->validateGet($id);
		if($this->model->getActaHeader($id)!=FALSE){
		}else{
			redirect('calidad/viewActa');
		}
	}
	/**
	 * Este metodo valida que el id
	 * recibido por get concuerde con 
	 * los datos de la BD 
	 */
	public function validateActaIncompleta($id)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */

		$this->validateGet($id);

		if($this->model->validateActaIncompleta($id)!=FALSE){
		}else{
			redirect('calidad/viewActaIncompleta');
		}
	}
	/**
	 * Este metodo valida que exista el id de los 
	 * procesos recibidos por el metodo get 
	 */
	public function validateGestionDocumental($id){

		/* ----------- VALIDA ACCESO USUARIO ----------- */

		$this->validateGet($id);
		$res=false;
		$res=$this->model->getProcesoId($id);
		return $res;
	}
	/**
	 * [envioNoAprobado description]
	 * @return [type] [description]
	 */
	public function envioNoAprobado()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$id=$this->input->post('idAccion');
		$idProceso=$this->input->post('procesoId');
		$cuerpo=$this->input->post('text_noAprobado');
		$tipoAccion=$this->input->post('tipoAccion');
		$nombreProceso=$this->input->post('nombreProceso');
		if (isset($id)&& isset($cuerpo) && isset($tipoAccion) && isset($nombreProceso)) {
			$sujeto='Plan de acción '.$tipoAccion.'-'.$nombreProceso.' #'.$id.' no fue aprobado';
			$usersP=$this->model->getUserProceso($idProceso);
			$message='';
			if($usersP!=false){
				try{
					foreach ($usersP as $value_u) {
					$nombre=$value_u->nombre;
					$email=$value_u->email;
					$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
					if($mensaje)
					{}else{
						$message.='Error al enviar a '.$email.' <br>';
					}
				}		
			}catch(Exception $e){

			}
			}else{
				$message.='Por favor asociar usuarios a este proceso(Contacte al administrador)';
			}
			if($message==''){
				$data=array('codigoFiltro'=>5);
				$this->model->updateContenidoAccion($id,$data);
				$message.='Descripcion enviada con exito';
			}
			$this->session->set_userdata('mensaje',$message);
		}
		redirect('calidad/planAccion');
	}
	/**
	 * [envioCambioRealizado description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
 	public function envioCambioRealizado($id){

 		$this->validateGet($id);

 		if($this->model->getSolicitudCambioId($id)==false){ 
 			redirect('calidad');
 		}
 		$id=$this->input->post('idSolicitud');
		$idProceso=$this->input->post('procesoId');
		$cuerpo=$this->input->post('text_realizado');
		$tipoSolicitud=$this->input->post('tipoSolicitud');
		$nombreProceso=$this->input->post('nombreProceso');
		if (isset($id)&& isset($cuerpo) && isset($tipoSolicitud) && isset($nombreProceso)) {
			$sujeto='Cambio solicitado en Solicitud de '.$tipoSolicitud.'-'.$nombreProceso.' #'.$id.' fue realizado';
			$usersP=$this->model->getUserProceso($idProceso);
			$message='';
			if($usersP!=false){
				try{
					foreach ($usersP as $value_u) {
						$nombre=$value_u->nombre;
						$email=$value_u->email;
						$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						if($mensaje)
						{}else{
							$message.='Error al enviar a '.$email.' <br>';
						}
					}		
				}catch(Exception $e){

				}
				
			}else{
				$message.='Por favor asociar usuarios a este proceso(Contacte al administrador)';
			}
			if($message==''){
				$data=array('codigoEstado'=>2);
				$this->model->updateEstadoSolicitud($id,$data);
				$message.='Descripcion enviada con exito';
			}
			$this->session->set_userdata('mensaje',$message);
		}
		redirect('calidad/solicitudCambio');
 	}
 	/**
 	 * [envioRevisionSolicitud description]
 	 * @param  [type] $id [description]
 	 * @return [type]     [description]
 	 */
 	public function envioRevisionSolicitud($id){

 		$this->validateGet($id);

 		if($this->model->getSolicitudCambioId($id)==false){ 
 			redirect('calidad');
 		}
 		$id=$this->input->post('idSolicitud');
		$idProceso=$this->input->post('idProceso');
		$cuerpo=$this->input->post('observacion_r');
		$tipoSolicitud=$this->input->post('tipo_solicitud');
		$nombreProceso=$this->input->post('nombreProceso');
		$aprobado_r=$this->input->post('aprobado_r');
		$fecha_r=$this->input->post('fecha_r');
		$id_user=$this->input->post('nombre_r');
		$mensaje='';
		if (isset($id)&& isset($cuerpo) && isset($tipoSolicitud) && isset($nombreProceso) && isset($id_user)
			&& isset($fecha_r)
	) {
			$sujeto='Solicitud de '.$tipoSolicitud.'-'.$nombreProceso.' #'.$id.' fue revisada';
			if(isset($aprobado_r)){
				$mensaje.='<br> Revisión fue aprobada por '.$this->nombre;
				$aprobado=1;
				$data=array('codigoEstado'=>3);
				$this->model->updateEstadoSolicitud($id,$data);
			}else{
				$mensaje.='<br> Revisión no fue aprobada por '.$this->nombre;
				$aprobado=0;
				$data=array('codigoEstado'=>6);
				$this->model->updateEstadoSolicitud($id,$data);
			}
			$data=array('codigoSolicitud'=>$id,'codigoUsuario'=>$id_user,'fecha_revision'=>$fecha_r,'observacion'=>$cuerpo,'aprobado'=>$aprobado);
			
			if($this->model->getRevisionSolicitud($id)==false){
				$res=$this->model->insertRevisionSolicitud($data);
			}else{
				$res=$this->model->updateRevisionSolicitud($id,$data);
			}
			if($res){
				$cuerpo.=$mensaje;
				$users=$this->model->getUsers();
				try{
					foreach ($users as $value_u) {
						//Cargo principal del representante de la dirección(19) es gerente administrativa(9)
						if($aprobado==1){
							if ($value_u->codigoCargo==15 || $value_u->codigoCargo==9) {
								$nombre=$value_u->nombre;
								$email=$value_u->email;
								$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
							}
						}else{
								if ($value_u->codigoCargo==15) {
								$nombre=$value_u->nombre;
								$email=$value_u->email;
								$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
							}
						}
						
					}		
				}catch(Exception $e){
					redirect('calidad');
				}
				$this->session->set_userdata('mensaje','Revisión agregada con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar revisión');
			}
		}
		redirect('calidad/solicitudCambio');
 	}
 	/**
 	 * [AddSeguimientoSolicitudCambio description]
 	 * @param [type] $id [description]
 	 */
 	public function AddSeguimientoSolicitudCambio()
 	{
 		/* ----------- VALIDA ACCESO USUARIO ----------- */
 		$this->validateSession();

 		$id=$this->input->post('idSolicitud');
 		if($this->model->getSolicitudCambioId($id)==false){ 
 			redirect('calidad');
 		}
		$idProceso=$this->input->post('idProceso');
		$tipoSolicitud=$this->input->post('tipo_solicitud');
		$nombreProceso=$this->input->post('nombreProceso');
		$mensaje='';
 		//------------------Revision-----------------//
 		$aprobado_r=$this->input->post('aprobado_r');
		$fecha_r=$this->input->post('fecha_r');
		$id_user_r=$this->input->post('nombre_r');
		$observacion_r=$this->input->post('observacion_r');
 		//------------------Aprobacion---------------//
 		$aprobado_a=$this->input->post('aprobado_a');
		$fecha_a=$this->input->post('fecha_a');
		$id_user_a=$this->input->post('nombre_a');
		$observacion_a=$this->input->post('observacion_a');
		//----------------Divulgacion---------------//
		$fecha_d=$this->input->post('fecha_divulgacion');
		$tipoDivulgacion=$this->input->post('tipoDivulgacion');
		$fecha_implementacion=$this->input->post('fecha_implementacion');
		$descripcion_divu=$this->input->post('descripcion_divu');
		//------------Elaboro-------------------------------------------------//
		$id_elaboro=$this->input->post('elaboro');
		$fecha_e=$this->input->post('fecha_e');
		if(isset($id) && isset($idProceso) && isset($tipoSolicitud) && isset($nombreProceso) 
			&& isset($aprobado_r) && isset($fecha_r) && isset($id_user_r) && isset($observacion_r)
			&& isset($aprobado_a) && isset($fecha_a) && isset($id_user_a) && isset($observacion_a)
			&& isset($fecha_d) && isset($tipoDivulgacion) && isset($fecha_implementacion) && isset($id_elaboro)
		    && isset($fecha_e) && isset($descripcion_divu)){
			
			$data_r=array('codigoSolicitud'=>$id,'codigoUsuario'=>$id_user_r,'fecha_revision'=>$fecha_r,'observacion'=>$observacion_r,'aprobado'=>$aprobado_r);
			if($this->model->getRevisionSolicitud($id)==false){
				$res_r=$this->model->insertRevisionSolicitud($data_r);
			}else{
				$res_r=$this->model->updateRevisionSolicitud($id,$data_r);
			}
			$data_a=array('codigoSolicitud'=>$id,'codigoUsuario'=>$id_user_a,'fecha_aprobacion'=>$fecha_a,'observacion'=>$observacion_a,'aprobado'=>$aprobado_a);
			if($this->model->getAprobacionSolicitud($id)==false){
				$res_a=$this->model->insertAprobacionSolicitud($data_a);
			}else{
				$res_a=$this->model->updateAprobacionSolicitud($id,$data_a);
			}
			if($res_a && $res_r){
				$data_d=array('codigoSolicitud'=>$id,'fecha_divulgacion'=>$fecha_d,
					'codigoTipoDivulgacion'=>$tipoDivulgacion,'fecha_implementacion'=>$fecha_implementacion,
				'codigo_elaboro'=>$id_elaboro,'fecha_elaboracion'=>$fecha_e);
				if($this->model->insertDivulgacionSolicitud($data_d)){ 
					$data=array('codigoEstado'=>7);
					$this->model->updateEstadoSolicitud($id,$data);
					$this->session->set_userdata('mensaje','Seguimiento agregado con exito');
					if ($tipoDivulgacion==2) {
						try{
							$nombre=$this->nombre;
							$sujeto='Cambios del SGC - '.$nombreProceso;
							$cuerpo='Solicitud de '.$tipoSolicitud.'-'.$nombreProceso.' #'.$id.':<br>'.$descripcion_divu;
							//$email='todos_crm@cargorisk.com';
							$email='jcanchon@cargorisk.com';
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}catch(Exception $e){

						}
					}
				}else{
				$this->session->set_userdata('mensaje','No se pudo agregar seguimiento');
				} 
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar seguimiento');
			}
		}
		redirect('calidad/solicitudcambio');
 	}
 	/**
 	 * [envioAprobacionSolicitud description]
 	 * @param  [type] $id [description]
 	 * @return [type]     [description]
 	 */
 	public function envioAprobacionSolicitud($id){

 		$this->validateGet($id);

 		if($this->model->getSolicitudCambioId($id)==false){ 
 			redirect('calidad');
 		}
 		$id=$this->input->post('idSolicitud');
		$idProceso=$this->input->post('idProceso');
		$cuerpo=$this->input->post('observacion_a');
		$tipoSolicitud=$this->input->post('tipo_solicitud');
		$nombreProceso=$this->input->post('nombreProceso');
		$aprobado_a=$this->input->post('aprobado_a');
		$fecha_a=$this->input->post('fecha_a');
		$id_user=$this->input->post('nombre_a');
		$mensaje='';
		if (isset($id)&& isset($cuerpo) && isset($tipoSolicitud) && isset($nombreProceso) && isset($id_user)
			&& isset($fecha_a)
	) {
			$sujeto='Solicitud de '.$tipoSolicitud.'-'.$nombreProceso.' #'.$id.' fue aprobada';
			if(isset($aprobado_a)){
				$mensaje.='<br> Aprobado por '.$this->nombre;
				$aprobado=1;
				$data_estado=array('codigoEstado'=>4);
			}else{
				$mensaje.='<br> Aprobado por '.$this->nombre;
				$aprobado=0;
				$data_estado=array('codigoEstado'=>5);
			}
			$data=array('codigoSolicitud'=>$id,'codigoUsuario'=>$id_user,'fecha_aprobacion'=>$fecha_a,'observacion'=>$cuerpo,'aprobado'=>$aprobado);
			if($this->model->getAprobacionSolicitud($id)==false){
				$res=$this->model->insertAprobacionSolicitud($data);
			}else{
				$res=$this->model->updateAprobacionSolicitud($id,$data);
			}
			if($res){
				$cuerpo.=$mensaje;
				try{
					$users=$this->model->getUsers();
					foreach ($users as $value_u) {
						//Cargo principal del representante de la dirección(19) es gerente administrativa(9)
						if ($value_u->codigoCargo==15) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}
				}catch(Exception $e){
					redirect('calidad/');
				}
				try{
					$usersP=$this->model->getUserProceso($idProceso);
					if($usersP!=false){
						foreach ($usersP as $value_u) {
							$nombre=$value_u->nombre;
							$email=$value_u->email;
							$mensaje=$this->envioNotificacion($email,$sujeto,$cuerpo,$nombre);
						}
					}
				}catch(Exception $e){
					redirect('calidad/');
				}
				$this->model->updateEstadoSolicitud($id,$data_estado);
				$this->session->set_userdata('mensaje','Aprobación agregada con exito');
			}else{
				$this->session->set_userdata('mensaje','No se pudo agregar la aprobación');
			}
		}
		redirect('calidad/solicitudCambio');
 	}
	/**
	 * [envioNotificacion description]
	 * @param  [type] $email  [description]
	 * @param  [type] $sujeto [description]
	 * @param  [type] $cuerpo [description]
	 * @param  [type] $nombre [description]
	 * @return [type]         [description]
	 */
	protected function envioNotificacion($email,$sujeto,$cuerpo,$nombre)
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();

		$mail = new PHPMailer();
		if (isset($email)) {
			/**-------Envio y configuracion datos email------*/
	        $mail->IsSMTP(); // establecemos que utilizaremos SMTP
	        $mail->IsHTML(true);
	        $mail->SMTPAuth   = true; // habilitamos la autenticación SMT
	        $mail->SMTPSecure = "tls";//"ssl";  // establecemos el prefijo del protocolo seguro de comunicación con el servidor
	       // $mail->SMTPDebug  = 2;
	        $mail->Host  ="smtp.office365.com";// "smtp.gmail.com"; // establecemos GMail como nuestro servidor SMTP
	        $mail->Port = 587;//465;  // establecemos el puerto SMTP en el servidor de GMail
			$mail->Username = "jcanchon@cargorisk.com";
			$mail->Password = "CRM_6745*";
	        $mail->SetFrom('jcanchon@cargorisk.com', 'SGC');  //Quien envía el correo
	        $mail->AddReplyTo("jcanchon@cargorisk.com","SGC");  //A quien debe ir dirigida la respuesta
	        $mail->Subject = $sujeto;  //Asunto del mensaje
	        $mail->Body =$cuerpo;
	        $mail->AddAddress($email,$nombre);
	        // Activo condificacción utf-8
			$mail->CharSet = 'UTF-8';
		}

        //$mail->AddAttachment("images/phpmailer.gif");      // añadimos archivos adjuntos si es necesario
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // tantos como queramos

        if(!$mail->Send()) {
            $data["message"] = FALSE;
        } else {
            $data["message"] = TRUE;
        }

        return $data["message"];
	}
	/**
	 * Este metodo verifica si el usuario tiene cargo de 
	 * representante de la dirección
	 * @return [type] [description]
	 */
	protected function getRepresentanteDireccion()
	{
		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$res=FALSE;
		$_usuario=$this->model->getUserCargo();
		foreach ($_usuario as $value) {
			if($value->idCargo==19 && $value->codigoUsuario==$this->idUsuario){
				$res=true;
			}
		}

		return $res;
	}
	/**
	 * [val description] Este metodo cambia el estado de login a 
	 * 0 cuando esta en la pagina
	 *  y lo eliminan
	 * @return [type] [description]
	 */
	public function val()
	{

		/* ----------- VALIDA ACCESO USUARIO ----------- */
		$this->validateSession();
		$x=1;
		$_user=$this->model->getUserId($this->idUsuario);
		if($_user->visibilidad==0){
			$this->logout();
			$x=0;
		}
		echo $x;
	}
}