<?php
namespace es\ucm\fdi\aw\mensajes;
use es\ucm\fdi\aw\Aplicacion as App;

//Objeto y Acceso a la BBDD
class Conversacion
{
	private $id; 
	private $usuario1; 
	private $usuario2; 

	private function __construct($usuario1, $usuario2, $id = NULL){

		$this->id = $id;
		$this->usuario1 = $usuario1;
		$this->usuario2 = $usuario2;
	}
	public function getId() {

		return $this->id;
	}

	public function getUsuario1() {

		return $this->usuario1;
	}

	public function getUsuario2()  {

		return $this->usuario2;
	}

	public static function crea($usuario1, $usuario2){
		$conversacion = new Conversacion($usuario1, $usuario2);
  
		return $conversacion;
	}

	public static function buscarConversacionPorId($id) {

		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf('SELECT * FROM CONVERSACIONES C WHERE C.ID = %d', $id);
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
		  $fila = $rs->fetch_assoc();
		  
		  $conversacion = new Conversacion($fila['USUARIO1'], $fila['USUARIO2'],$fila['ID']);
		  $rs->free();
	
		  return $conversacion;
		}

		return null;
	}

    public static function existeConversacion($idUsuario1, $idUsuario2) {

		$app = App::getInstancia();
		$conn = $app->getConexionBD();
	
		$query = sprintf('SELECT * FROM CONVERSACIONES WHERE (USUARIO1 = %d AND USUARIO2 = %d) OR 
        		(USUARIO1 = %d AND USUARIO2 = %d)', $idUsuario1, $idUsuario2, $idUsuario2, $idUsuario1);
		$rs = $conn->query($query);

		if ($rs && $rs->num_rows == 1) {
            $fila = $rs->fetch_assoc();
            
            $conversacion = new Conversacion($fila['USUARIO1'], $fila['USUARIO2'],$fila['ID']);
            $rs->free();
      
            return $conversacion;
        }
	
		return null;
	}

	//para devolver todos las conversaciones de ese usuario
	public static function devuelveConversacionesPorUsuario($usuarioLogado){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf('SELECT * FROM CONVERSACIONES WHERE USUARIO1 =%d OR USUARIO2 = %d', $usuarioLogado, $usuarioLogado);  

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Conversacion( $fila['USUARIO1'], $fila['USUARIO2'], $fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	public static function inserta($conversacion) {

		$result = false;

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		
		$query=sprintf("INSERT INTO CONVERSACIONES(USUARIO1, USUARIO2) VALUES('%d', '%d')"
			, $conversacion->usuario1
			, $conversacion->usuario2);

		$result = $conn->query($query);
		
		if ($result) {
		  $conversacion->id = $conn->insert_id;
		  $result = $conversacion;
		} else {
		  error_log($conn->error);  
		}
	
		return $result;
	}

}