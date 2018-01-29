<?php 
require_once 'Model.php';
/**
 * 
 */
class Controlador extends Model
{
	private $model;	
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * [getPlanAccion description]
	 * @return [type] [description]
	 */
	public function getPlanAccion(){
        $row=$this->getAllAccion();
        return $row;
	}
	/**
	 * [envioNotificacion description]
	 * @param  [type] $email  [description]
	 * @param  [type] $sujeto [description]
	 * @param  [type] $cuerpo [description]
	 * @param  [type] $nombre [description]
	 * @return [type]         [description]
	 */
	public function envioNotificacion($email,$sujeto,$cuerpo,$nombre)
	{
		require_once '../application/libraries/PHPMailer/class.smtp.php';
		require_once '../application/libraries/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer();
		if (isset($email)) {
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
	        $mail->Subject = $sujeto;  //Asunto del mensaje
	        $mail->Body =$cuerpo;
	        $mail->AddAddress($email,$nombre);
	        // Activo condificacción utf-8
			$mail->CharSet = 'UTF-8';
		}
        if(!$mail->Send()) {
            $data["message"] = FALSE;
        } else {
            $data["message"] = TRUE;
        }
        return $data["message"];
	}
}
$co=new Controlador();
$datos=$co->getPlanAccion();
//$co->envioNotificacion('jcanchon@cargorisk.com','hola','hola','luis');echo getcwd();
require_once 'view_planAccion.phtml';
 ?>