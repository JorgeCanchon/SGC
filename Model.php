<?php 
require_once 'conectar.php';
/**
* 
*/
class Model extends Conexion
{
	/**
	 * [$con description]
	 * @var [type]
	 */
	private $con;
	/**
	 * [__construct description]
	 */
	function __construct()
	{
		$this->con=self::conectar();
	}
	/**
	 * [db description]
	 * @return [type] [description]
	 */
	public function db()
	{
		$this->con=self::conectar();
		return $this->con;
	}
	/**
	 * [getAllAccion description]
	 * @return [type] [description]
	 */
	public function getAllAccion(){
		$resultSet=false;
        $query=$this->db()->query("
        	SELECT p.*, c.nombreCargo cargo,f.`nombreFiltro` estado
			FROM planAccion p
			INNER JOIN cargo c
			ON p.codigoCargoResponsable=c.idCargo
			INNER JOIN `relacionaccionplan` r
			ON r.`codigoPlanAccion`=p.`idAccion`
			INNER JOIN contenidoaccion ca
			ON ca.`idContenidoAccion`=r.`codigoContenidoAccion`
			INNER JOIN filtro f
			ON f.`idFiltro`=ca.`codigoFiltro`
			WHERE ca.`visibilidad`=1
			ORDER BY p.`fechaejecucion`
        	");
        //stdclass clases predefinidas
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
      	//	self::desconectar($this->db());
        return $resultSet;
    }
}
