<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\foro\MensajeForo;

//Objeto y Acceso a la BBDD
class MensajeForo
{
	private $id; //id del foro
	private $idForo; //id del foro al que pertenece el mensaje
    private $idUsuario; //id del que escribio el mensaje
    private $contenido;
    private $fecha;
	private $idPadre;
	private $mensajePadre;

	private function __construct($idForo, $idUsuario, $contenido, $fecha = NULL, $idPadre = NULL, $id = NULL){
		$this->id = $id;
        $this->idForo = $idForo;
		$this->idUsuario = $idUsuario;
        $this->contenido = $contenido;
		$this->fecha = $fecha ?? date('Y-m-d H:i:s');
		$this->idPadre = $idPadre;  
	}

	public function getId() {

		return $this->id;
	}

	public function getIdForo(){

		return $this->idForo;
	}

	public function getIdUsuario(){

		return $this->idUsuario;
	}

    public function getAutor(){
        if ($this->idUsuario) {
            $this->autor = Usuario::buscaPorId($this->idUsuario);
        }

        return $this->autor;
    }
  
	public function getContenido(){

		return $this->contenido;
	}

	public function getFecha(){

		return $this->fecha;
	}

	/**
	 * Mensaje Padre
	 */
	public function getMensajePadre(){
		if ($this->idMensajePadre) {
			$this->mensajePadre = self::buscaMensajePorId($this->idPadre);
		  }
		  return $this->mensajePadre;
	}

	public function setMensajePadre($nuevoMensajePadre)
	{
	  $this->mensajePadre = $nuevoMensajePadre;
	  $this->idMensajePadre = $nuevoMensajePadre->id();
	}
	/*----------------------------------*/

	public function setFecha() {

		$this->fecha = date('Y-m-d H:i:s');
	}

	public function setContenido($contenido){

		$this->contenido = $contenido;
	}

    public static function crea($idForo, $idUsuario, $contenido, $idPadre = NULL) {

      $mensaje = new MensajeForo($idForo, $idUsuario, $contenido, date('Y-m-d H:i:s'), $idPadre);
      return $mensaje;
    }

	public static function buscarMensajeporId($id) {

		$result = null;

		$app= App::getInstancia();
    	$conn = $app->getConexionBD();	

		$query = sprintf("SELECT * FROM COMENTARIOS_FORO C WHERE C.ID = $id");
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
		  while($fila = $rs->fetch_assoc()) {
			$result = new MensajeForo( $fila['FORO'], $fila['USUARIO_CREADOR'],$fila['CONTENIDO'], $fila['FECHA_CREACION'], $fila['ID_PADRE'], $fila['ID']);
		  }
		  $rs->free();
		}
		return $result;
    }

	public static function devuelveMensajesForo($idForo){
		$app= App::getInstancia();
    	$conn = $app->getConexionBD();
		$result = false;
		
		$query = sprintf("SELECT * FROM COMENTARIOS_FORO WHERE FORO = $idForo ORDER BY FECHA_CREACION asc");
		$rs = $conn->query($query);	
		
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new MensajeForo( $fila['FORO'], $fila['USUARIO_CREADOR'],$fila['CONTENIDO'], $fila['FECHA_CREACION'], $fila['ID_PADRE'], $fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	public static function inserta($mensaje) {
	
        $result = false;
        $app= App::getInstancia();
    	$conn = $app->getConexionBD();
		
		$query=sprintf("INSERT INTO COMENTARIOS_FORO( FORO, USUARIO_CREADOR, CONTENIDO, FECHA_CREACION, ID_PADRE) VALUES(%d, %d, '%s', '%s', %s)"
        , $mensaje->idForo
		, $mensaje->idUsuario
        , $conn->real_escape_string($mensaje->contenido)
		, $conn->real_escape_string($mensaje->fecha)
		, !is_null($mensaje->idPadre) ? $mensaje->idPadre : 'NULL');
        $result = $conn->query($query);

		if ($result) {
            $mensaje->id = $conn->insert_id;
            $result = $mensaje;
          } else {
            error_log($conn->error);  
          }
      
          return $result;
	}

	public static function borra($mensaje){
		
        return self::borraPorId($mensaje->id);
    }
  
    public static function borraPorId($id){
      
		$result = false;
		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf("DELETE FROM COMENTARIOS_FORO WHERE ID = %d", $id);
		$result = $conn->query($query);
		
		if (!$result) {
		error_log($conn->error);
		} 
		else if ($conn->affected_rows != 1) {
		error_log("Se han borrado '$conn->affected_rows' !");
		}
	
		return $result;
    }

	public static function actualiza($mensaje){
			
        $result = false;
		$app= App::getInstancia();
    	$conn = $app->getConexionBD();
		$query = sprintf("UPDATE COMENTARIOS_FORO  SET FORO = %d, CONTENIDO = '%s', USUARIO_CREADOR = %d, FECHA_CREACION = '%s', ID_PADRE = %s WHERE ID = %d"
          , $mensaje->idForo
          , $conn->real_escape_string($mensaje->contenido)
          , $mensaje->idUsuario
		  , $conn->real_escape_string($mensaje->fecha)
		  ,!is_null($mensaje->idPadre)?$mensaje->idPadre : 'NULL'
		  , $mensaje->id);

		$result = $conn->query($query);

		if (!$result) {
			error_log($conn->error);  
		} 
		else if ($conn->affected_rows != 1) {
		error_log("Se han actualizado '$conn->affected_rows' !");
		}
		return $result;
	}

	public static function numMensajes($idForo)
	{
		$result = 0;
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT COUNT(*) FROM COMENTARIOS_FORO WHERE FORO = $idForo ORDER BY FECHA_CREACION asc");
		$rs = $conn->query($query);
		if ($rs) {
		$result = (int) $rs->fetch_row()[0];
		$rs->free();
		}
		return $result;
	}

	
	public static function buscaMensajesPaginados($idForo, $idPadre, $numPorPagina = -1, $numPagina = 0){
		$result = [];

    	$app= App::getInstancia();
    	$conn = $app->getConexionBD();

    	$query = 'SELECT * FROM COMENTARIOS_FORO C WHERE C.FORO = '.$idForo.' AND ';
		if($idPadre) {
			$query = $query . ' C.ID_PADRE = %d';
			$query = sprintf($query, $idPadre);
		  } else {
			$query = $query . ' C.ID_PADRE IS NULL';
		  }
	  
		  $query .= ' ORDER BY C.FECHA_CREACION ASC';

		if ($numPorPagina > 0) {
			$query .= " LIMIT $numPorPagina";
			
			/* XXX NOTA: Este método funciona pero poco eficiente (OFFSET y LIMIT se aplican una vez se ha ejecutado la
			* consulta), lo utilizo por simplicidad. En un entorno real se debe utilizar la cláusula WHERE para "saltar"
			* los elementos que NO interesen y utilizar exclusivamente la cláusula LIMIT
			*/
			$offset = $numPagina * ($numPorPagina - 1);
			if ($offset > 0) {
				$query .= " OFFSET $offset";
			}
    	}

		$rs = $conn->query($query);
		if ($rs) {
			while($fila = $rs->fetch_assoc()) {
				$result[] = new MensajeForo( $fila['FORO'], $fila['USUARIO_CREADOR'],$fila['CONTENIDO'], $fila['FECHA_CREACION'], $fila['ID_PADRE'], $fila['ID']);
		  	}
			$rs->free();
		}

   		return $result;
	}

	public static function buscaMensajesHilo($idForo, $idPadre){
		$result = [];

    	$app= App::getInstancia();
    	$conn = $app->getConexionBD();

    	$query = sprintf("SELECT * FROM COMENTARIOS_FORO  WHERE FORO = $idForo AND ID_PADRE = $idPadre ORDER BY FECHA_CREACION DESC");


		$rs = $conn->query($query);
		if ($rs) {
			while($fila = $rs->fetch_assoc()) {
				$result[] = new MensajeForo( $fila['FORO'], $fila['USUARIO_CREADOR'],$fila['CONTENIDO'], $fila['FECHA_CREACION'], $fila['ID_PADRE'], $fila['ID']);
		  }
		$rs->free();
		}

   		 return $result;
	}

}