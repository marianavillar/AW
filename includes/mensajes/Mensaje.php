<?php
namespace es\ucm\fdi\aw\mensajes;
use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\usuarios\Usuario;

//Objeto y Acceso a la BBDD
class Mensaje
{
  private $id; 
  private $idConversacion; 
  private $idAutor;
  private $contenido;
  private $fecha;
  private $estado;
  private $numMensjNoLeidos;

	private function __construct($idConversacion, $idAutor, $contenido, $estado, $fecha = NULL, $id = NULL){
		$this->id = $id;
    	$this->idConversacion = $idConversacion;
		$this->idAutor = $idAutor;
    	$this->contenido = $contenido;
		$this->fecha = $fecha ?? date('Y-m-d H:i:s');
		$this->estado = $estado;//$estado;
		/*
		estado:
			1 => no leido
			2 => leido
		*/
	}

	public function getId() {

		return $this->id;
	}

	public function getIdConversacion(){

		return $this->idConversacion;
	}

	public function getIdAutor(){

		return $this->idAutor;
	}

	public function getAutor(){
        if ($this->idAutor) {
            $this->autor = Usuario::buscaPorId($this->idAutor);
        }

        return $this->autor;
    }

	public function getContenido(){

		return $this->contenido;
	}

	public function getFecha(){

		return $this->fecha;
	}

	public function getEstado() {

		return $this->estado;
	}

	public function setEstado($estado) {

		$this->estado = $estado;
	}

  public static function crea($idConversacion, $idAutor, $contenido) {

    $mensaje = new Mensaje($idConversacion, $idAutor, $contenido, 1, date('Y-m-d H:i:s'));
    return $mensaje;
  }

	public static function buscarMensajeporId($id) {

		$result = null;

		$app= App::getInstancia();
    	$conn = $app->getConexionBD();	

		$query = sprintf("SELECT * FROM MENSAJES M WHERE M.ID = $id");
		$rs = $conn->query($query);

		if ($rs && $rs->num_rows == 1) {
		  while($fila = $rs->fetch_assoc()) {
			$result = new Mensaje( $fila['CONVERSACION'], $fila['AUTOR'],$fila['CONTENIDO'], $fila['ESTADO'], $fila['FECHA_HORA'], $fila['ID']);
		  }
		  $rs->free();
		}
		return $result;
    }

	public static function devuelveMensajes($idConversacion){
		$app= App::getInstancia();
    	$conn = $app->getConexionBD();
		$result = false;
		
		$query = sprintf("SELECT * FROM MENSAJES WHERE CONVERSACION = $idConversacion ORDER BY FECHA_HORA asc");
		$rs = $conn->query($query);	
		
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Mensaje( $fila['CONVERSACION'], $fila['AUTOR'],$fila['CONTENIDO'], $fila['ESTADO'], $fila['FECHA_HORA'], $fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	public static function inserta($mensaje) {
	
      $result = false;
      $app= App::getInstancia();
    	$conn = $app->getConexionBD();
		
		$query=sprintf("INSERT INTO MENSAJES( CONVERSACION, AUTOR, CONTENIDO, FECHA_HORA, ESTADO) VALUES(%d, %d, '%s', '%s', %d)"
      , $mensaje->idConversacion
      , $mensaje->idAutor
      , $conn->real_escape_string($mensaje->contenido)
      , $conn->real_escape_string($mensaje->fecha)
	  , $mensaje->estado);
        $result = $conn->query($query);

		if ($result) {
      $mensaje->id = $conn->insert_id;
      $result = $mensaje;
    } 
    else {
      error_log($conn->error);  
    }
    return $result;
	}

	public static function actualizaEstado($mensaje){

		$result = false;
	
		$app = App::getInstancia();
		$conn = $app->getConexionBD();
			$query = sprintf("UPDATE MENSAJES M SET ESTADO = %d WHERE M.ID = $mensaje->id"
			  , $mensaje->estado);
	
			$result = $conn->query($query);
	
			if (!$result) {
			  error_log($conn->error);  
			} 
			else if ($conn->affected_rows != 1) {
			  error_log("Se han actualizado '$conn->affected_rows' !");
			}
		
			return $result;
	}

	public  static function numeroMensajesNoLeidos($idConversacion){
		$mensajesNoLeidos=0;
		$app = App::getInstancia();
		$conn = $app->getConexionBD();

		$query = sprintf('SELECT * FROM MENSAJES WHERE ESTADO = %d AND CONVERSACION = %d',1, $idConversacion);
		$rs = $conn->query($query);
			if($rs){
				$mensajesNoLeidos=$rs->num_rows;
				$rs->free();
			}
			
	  
	  return $mensajesNoLeidos;
  	}
}