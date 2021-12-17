<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Aplicacion as App;

//Objeto y Acceso a la BBDD
class Foro
{
	private $id; //id del foto
	private $tema; //tema del que va el foro
	private $asunto; //tema del que va el foro

	private function __construct($tema, $asunto, $id = NULL){

		$this->id = $id;
		$this->tema = $tema;
		$this->asunto = $asunto;
	}
	public function getId() {

		return $this->id;
	}

	public function getTema() {

		return $this->tema;
	}

	public function getAsunto()  {

		return $this->asunto;
	}

	public static function crea($tema, $asunto){
		$foro = new Foro($tema, $asunto);
  
		return $foro;
	}

	//busca un foro y lo devuelve
	public static function buscarForoPorId($id) {

		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf('SELECT * FROM FORO F WHERE F.ID = %d', $id);
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
		  $fila = $rs->fetch_assoc();
		  
		  $foro = new Foro( $fila['TEMA_FOROS'], $fila['ASUNTO'],$fila['ID']);
		  $rs->free();
	
		  return $foro;
		}

		return null;
	}

	//para devolver todos los foros
	public static function devuelveForos(){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf("SELECT F.ID, CS.NOMBRE, F.ASUNTO FROM FORO F JOIN CATEGORIA_SERVICIOS CS ON F.TEMA_FOROS = CS.ID /*ORDER BY TEMA_FOROS asc*/");  

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Foro( $fila['NOMBRE'], $fila['ASUNTO'], $fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	public static function inserta($foro) {

		$result = false;

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		
		//falta enlazar el tema_foros con el id de la tabla categoria servicios
		$query=sprintf("INSERT INTO FORO(TEMA_FOROS, ASUNTO) VALUES('%d', '%s')"
			, $foro->tema
			, $conn->real_escape_string($foro->asunto));

		$result = $conn->query($query);
		
		if ($result) {
		  $foro->id = $conn->insert_id;
		  $result = $foro;
		} else {
		  error_log($conn->error);  
		}
	
		return $result;
	}

	public static function borra($foro){
		
	  return self::borraPorId($foro->id);
	}

	public static function borraPorId($id){
	
		$result = false;
		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf("DELETE FROM FORO WHERE ID = %d", $id);
		$result = $conn->query($query);
		
		if (!$result) {
		  error_log($conn->error);
		} 
		else if ($conn->affected_rows != 1) {
		  error_log("Se han borrado '$conn->affected_rows' !");
		}
	
		return $result;
	}

	public static function actualiza($foro){
		
		$result = false;

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$query = sprintf("UPDATE FORO F SET TEMA_FOROS = '%d', ASUNTO = '%s' WHERE F.ID = %d"
		  , $foro->id
		  , $foro->tema
		  , $conn->real_escape_string($foro->asunto));

		$result = $conn->query($query);

		if (!$result) {
		  error_log($conn->error);  
		} 
		else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado '$conn->affected_rows' !");
		}
	
		return $result;
	}

}