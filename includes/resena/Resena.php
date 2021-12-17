<?php
namespace es\ucm\fdi\aw\resena;
use es\ucm\fdi\aw\Aplicacion as App;

//Objeto y Acceso a la BBDD
class Resena
{
	
	// Crear una resena

	public static function crea($usuarioCreador, $usuarioValorado, $puntuacion, $comentario){
		$r = new Resena($usuarioCreador, $usuarioValorado, $puntuacion, $comentario, null);		
		return $r;
	}
	
	private $id; 					// Id de la resena
	private $usuarioCreador; 		// Creador de la resena
	private $usuarioValorado; 		// Usuario de la valoracion
	private $puntuacion;			// Puntuacion otorgada a la resena
	private $comentario;			// Comentario sobre el servicio
	private $fecha;		    		// Fecha de la resena

	// Constructor

	private function __construct($usuarioCreador, $usuarioValorado, $puntuacion, $comentario, $fecha, $id = NULL){
		$this->usuarioCreador = $usuarioCreador;
		$this->usuarioValorado = $usuarioValorado;
		$this->puntuacion = $puntuacion;
		$this->comentario = $comentario;
		$this->fecha = $fecha;
		$this->id = $id;
	}
	
	// Getters
	
	public function getId() {
		return $this->id;
	}
	
	public function getUsuarioCreador() {
		return $this->usuarioCreador;
	}
	
	public function getUsuarioValorado() {
		return $this->usuarioValorado;
	}
	
	public function getPuntuacion() {
		return $this->puntuacion;
	}
	
	public function getComentario() {
		return $this->comentario;
	}

	public function getFecha() {
		return $this->fecha;
	}

    // Inserta una reseña en la BBDD
	
	public static function inserta($resena) {

		$result = false;
		$app= App::getInstancia();
		$conn = $app->getConexionBD();
		
		$query=sprintf("INSERT INTO RESENA (USUARIO_CREADOR, USUARIO_VALORADO, PUNTUACION, COMENTARIO, FECHA_VALORACION) VALUES ( %d, %d, %d, '%s', NOW() )"
			, $resena->usuarioCreador
			, $resena->usuarioValorado
			, $resena->puntuacion
			, $conn->real_escape_string($resena->comentario)
			);

		$result = $conn->query($query);
		if ($result) {
			$resena->id = $conn->insert_id;
			$result = $resena;
		} else {
		  	error_log($conn->error);  
		}
	
		return $result;
	}

	// Eliminar una reseña en la BBDD

	public static function elimina($idResena) {

		$result = false;
		$app= App::getInstancia();
		$conn = $app->getConexionBD();
		
		$query=sprintf("DELETE FROM RESENA WHERE ID=%d"
			, $idResena);
		$result = $conn->query($query);

		//echo $query;

		if (!$result) {
			error_log($conn->error);  
		} 
		else if ($conn->affected_rows != 1) {
			error_log("Se han borrado '$conn->affected_rows' !");
		}
	  
		return $result;
		
	}

	// Devuelve la reseña del idCreador al idValora o FALSE si no existe 

	public static function getResena($idCreador, $idValorado) {

		$app= App::getInstancia();
		$conn = $app->getConexionBD();
		
		$query=sprintf("SELECT * FROM RESENA 
			WHERE USUARIO_CREADOR=%d AND USUARIO_VALORADO=%d", $idCreador, $idValorado );

		$rs = $conn->query($query);

		if ($rs && $rs->num_rows == 1) {
			$fila = $rs->fetch_assoc();  
			$resena = new Resena($fila['USUARIO_CREADOR'], 
				$fila['USUARIO_VALORADO'], 
				$fila['PUNTUACION'], 
				$fila['COMENTARIO'], 
				$fila['FECHA_VALORACION'],
				$fila['ID']);   
			$rs->free();
			return $resena;
		}
	
		return false;
	}

	// Devuelve todas las reseñas asociadas al usuario dado

	public static function devolverListaResenas($idUsuario) {

		$result = false;
		$app= App::getInstancia();
		$conn = $app->getConexionBD();
		
		$query=sprintf(" SELECT * FROM RESENA WHERE USUARIO_VALORADO=%s ", $idUsuario);
		$result = $conn->query($query);
		$array = array();
		if ($result) {
			
			while ($fila = $result->fetch_assoc()) {
				array_push($array, new Resena($fila["USUARIO_CREADOR"]
					, $fila["USUARIO_VALORADO"]
					, $fila["PUNTUACION"]
					, $fila["COMENTARIO"]
					, $fila["FECHA_VALORACION"]
					, $fila["ID"]
				));
			}
			$result->free();
			
		} else{
			error_log($conn->error);  
		}
	
		return $array;
	}

	// Devolver todas las reseñas (funcionalidad solo para admin)

	public static function devolverTodasResenas() {

		$result = false;
		$app= App::getInstancia();
		$conn = $app->getConexionBD();
		
		$query=sprintf(" SELECT * FROM RESENA  ");
		$result = $conn->query($query);
		$array = array();
		if ($result) {
			
			while ($fila = $result->fetch_assoc()) {
				array_push($array, new Resena($fila["USUARIO_CREADOR"]
					, $fila["USUARIO_VALORADO"]
					, $fila["PUNTUACION"]
					, $fila["COMENTARIO"]
					, $fila["FECHA_VALORACION"]
					, $fila["ID"]
				));
			}
			$result->free();
			
		} else{
			error_log($conn->error);  
		}
	
		return $array;
	}

}