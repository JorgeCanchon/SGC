<?php 
/**
* 
*/
class Model_sistema extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  checkUser()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método recibe como parametros: 
	|  $username  --> Nombre de usuario ingresado por el usuario
	|  Este método se encarga de validar los datos del usuario
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function checkUser($username){
		$data=array();
		$this->db->select('id,email,nombre,usuario,password,codigoTipoUsuario');
		$this->db->where('visibilidad',1);
		$this->db->where('usuario',$username);
		$query=$this->db->get('usuario');
		if ($query->num_rows()==1) {
			$data=$query->row();
		}else{
			$data=false;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene los procesos 
	 * a los que el usuario puede tener 
	 * acceso
	 */
	public function checkAccess($id){
		$data=array();
		$this->db->select('codigoProceso');
		$this->db->where('codigoUsuario',$id);
		$query=$this->db->get('relacionprocesousuario ');
		if ($query->num_rows()>0) {
			$data=$query->result();
		}else{
			$data=false;
		}
		$query->free_result();
		return $data;
	}
	/**
	 * Este metodo obtiene el nombre de usuario,email e id del usuario de sgc
	 */
	public function getEmail($email){
		$data=array();
		$this->db->select('id,email,nombre');
		$this->db->where('visibilidad',1);
		$this->db->where('email',$email);
		$query=$this->db->get('usuario');
		if ($query->num_rows()==1) {
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
	|  $email 	--> email único de usuario
	|  $pass    --> Contraseña única de usuario
	|  Este método se encarga de actualizar la contraseña 
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function savePass($id,$pass){
		$data=array('password'=>$pass);
		$this->db->where('id',$id);
		$this->db->update('usuario',$data);
	}
}
 ?>