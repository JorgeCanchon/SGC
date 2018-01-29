<?php 
/**
* 
*/
class Conexion 
{
//Atributos
protected static $conec;
//Metodos
	public static function conectar(){
		$conec=new mysqli("localhost","root","","sistema_calidad");
		if($conec->connect_error)
		die('Problemas con la conexion a la base de datos');
		return $conec;
	}
	public static function desconectar($con)
	{
		return mysqli_close($con);
	}
}
?>