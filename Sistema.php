<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Sistema extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_sistema','mod_sistema');
		$this->load->library('My_PHPMailer');
	}
	public function index(){
		$this->administrador();
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  administrador()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga del acceso a la pagina principal o de redirigir 
	|  al login con un mensaje de error.
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function administrador(){

		$textoMensaje='';
		$textoMensaje = $this->session->flashdata('textoMensaje');
		$tipo_usuario=$this->session->userdata('codigoTipoUsuario');
		$id_usuario = $this->session->userdata('idUsuario');

		$data['base']=base_url();

		if ($tipo_usuario!='' && $id_usuario != '') {

			$data['user'] = $this->session->userdata('user');
			$data['name'] = $this->session->userdata('name');
			$data['id_usuario'] = $id_usuario;
			$data['tipo_usuario'] = $tipo_usuario;
			/* ----------- Control de acceso por medio de variable sesion---------- */
			$this->session->set_userdata('login',1);
			redirect('calidad');

		}else{
			/* ----------- Control de acceso por medio de variable sesion---------- */
			$this->session->set_userdata('login',0);
			/* ----------- ENVIO DE DATOS A LA VISTA ----------- */
			$data['mensaje'] = $textoMensaje;
			$data['content'] ='login'; 
			$this->load->vars($data); 
			$this->load->view('login');
		}

	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validateUser()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar los datos ingresados por el usuario.
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validateUser(){
		if ($this->input->post('login')) {
			$datosLogin=$this->input->post('login');
			$checkUser=$this->mod_sistema->checkUser($datosLogin['username']);
				if ($checkUser!=FALSE) 
				{
					$validate=$this->validatePassword($checkUser->password,$datosLogin['password']);
					if($validate)
					{
						$checkAccess=$this->mod_sistema->checkAccess($checkUser->id);
						$data=array(
							'is_logued_in'=>TRUE,
							'idUsuario'=>$checkUser->id,
							'codigoTipoUsuario'=>$checkUser->codigoTipoUsuario,
							'name'=>$checkUser->nombre,
							'email'=>$checkUser->email,
							'user'=>$checkUser->usuario,
							'proceso'=>$checkAccess
							);
						$this->session->set_userdata('REMOTE_ADDR',$_SERVER['REMOTE_ADDR']);
						$this->session->set_userdata('HTTP_USER_AGENT',$_SERVER['HTTP_USER_AGENT']);
					$this->session->set_userdata($data);			
					redirect('sistema/administrador');
					}else{
					$this->session->set_flashdata('textoMensaje', 'Password Incorrecto!');
						redirect('');
					}
				}else{
					$this->session->set_flashdata('textoMensaje', 'Usuario Incorrecto!');
					redirect('');
				}
		}else{
			redirect('');
		}
		
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  validatePassword()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de validar la contraseña ingresada por el usuario
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function validatePassword($passwordEncrypt,$password){
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
		redirect('');
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  restorePassword()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de enviar la contraseña 
	|  -------------------------------------------------------------------------------------------------------------------------------------- */
	public function restorePassword()
	{
		$email=$this->input->post('email');
		$var=$this->mod_sistema->getEmail($email);
		$password=$this->generaPass();
		$mail = new PHPMailer();
		if (isset($email) && $var!=FALSE) {

			/**-------Envio y configuracion datos email------*/
	        $mail->IsSMTP(); // establecemos que utilizaremos SMTP
	        $mail->SMTPAuth   = true; // habilitamos la autenticación SMT
	        $mail->SMTPSecure = "tls";//"ssl";  // establecemos el prefijo del protocolo seguro de comunicación con el servidor
	       // $mail->SMTPDebug  = 2;
	        $mail->Host  ="smtp.office365.com";// "smtp.gmail.com"; // establecemos GMail como nuestro servidor SMTP
	        $mail->Port = 587;//465;  // establecemos el puerto SMTP en el servidor de GMail
			$mail->Username = "jcanchon@cargorisk.com";
			$mail->Password = "CRM_6745*";
	        $mail->SetFrom('jcanchon@cargorisk.com', 'SGC');  //Quien envía el correo
	        $mail->AddReplyTo("jcanchon@cargorisk.com","SGC");  //A quien debe ir dirigida la respuesta
	        $mail->Subject = 'Restablecer Contraseña';  //Asunto del mensaje
	        $mail->Body = 'Contraseña:'.$password.'';
	        $destino = $email;
	        $mail->AddAddress($email,$var->nombre);
	        // Activo condificacción utf-8
			$mail->CharSet = 'UTF-8';
		}

        //$mail->AddAttachment("images/phpmailer.gif");      // añadimos archivos adjuntos si es necesario
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // tantos como queramos

        if(!$mail->Send()) {
            $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
        } else {
        	/**-------Generar,encritar y guardar contraseña ----------*/
			$encryptPass=$this->PasswordHash($password);
			$this->mod_sistema->savePass($var->id,$encryptPass);
            $data["message"] = "¡Mensaje enviado correctamente!";
        }
        $data['mensaje']='';
        $data['base']=base_url();
       $this->load->view('login',$data);
	}
	/* --------------------------------------------------------------------------------------------------------------------------------------
	|  generaPass()
	|  --------------------------------------------------------------------------------------------------------------------------------------
	|  Este método se encarga de generar una contraseña aleatoria
	| -------------------------------------------------------------------------------------------------------------------------------------- */
	public  function generaPass(){
	    //Se define una cadena de caractares. Te recomiendo que uses esta.
	    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	    //Obtenemos la longitud de la cadena de caracteres
	    $longitudCadena=strlen($cadena);
	     
	    //Se define la variable que va a contener la contraseña
	    $pass = "";
	    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	    $longitudPass=10;
	     
	    //Creamos la contraseña
	    for($i=1 ; $i<=$longitudPass ; $i++){
	        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	        $pos=rand(0,$longitudCadena-1);
	     
	        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	        $pass .= substr($cadena,$pos,1);
	    }
	    return $pass;
	}
	/**
	 * Metodo para encryptar la contraseña generada aleatoreamente 
	 * $password->Contraseña del usuario
	 */
	function PasswordHash($password){
	 return password_hash($password, PASSWORD_DEFAULT);
	}
}
?>