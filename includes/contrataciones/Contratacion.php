<?php
namespace es\ucm\fdi\aw\contrataciones;
use es\ucm\fdi\aw\Aplicacion as App;

//Objeto y Acceso a la BBDD
class Contratacion
{
	private $id; //id de la contratacion
    private $idUsuarioSolicita; //id del usuario que solicita
    private $idUsuarioServicio; //id del usuario de ese servicio (el que ofrece el servicio)
	private $idServicio; //id del servicio
    private $fechaSolicitud; //cuando solicita el servicio
    private $fechaInicio; //cuando acepta el servicio
    private $fechaFin; //servicio terminado
    private $estado; //id del estado

	private function __construct($idUsuarioSolicita, $idUsuarioServicio, $idServicio, $fechaSolicitud = NULL, $fechaInicio = NULL, $fechaFin = NULL, $estado = NULL, $id = NULL){

		$this->id = $id;
		$this->idUsuarioSolicita = $idUsuarioSolicita;
		$this->idUsuarioServicio = $idUsuarioServicio;
        $this->idServicio = $idServicio;
        $this->fechaSolicitud = $fechaSolicitud ?? date('Y-m-d H:i:s');
        $this->fechaInicio = $fechaInicio ?? date('Y-m-d H:i:s'); 
        $this->fechaFin = $fechaFin ?? date('Y-m-d H:i:s');
        $this->estado = 1;//$estado;
		/*
		estado:
			1 => solicitado
			2 => en curso
			3 => finalizado
			4 => rechazado
		*/

	}
	public function getId() {

		return $this->id;
	}

	public function getIdUsuarioSolicita() {

		return $this->idUsuarioSolicita;
	}

	public function getIdUsuarioServicio()  {

		return $this->idUsuarioServicio;
	}

    public function getFechaSolicitud() {

		return $this->fechaSolicitud;
	}

	public function getFechaInicio() {

		return $this->fechaInicio;
	}

	public function getFechaFin()  {

		return $this->fechaFin;
	}

    public function getEstado() {

		return $this->estado;
	}

	public function getIdServicio() {

		return $this->idServicio;
	}

	public function setEstado($estado) {

		$this->estado = $estado;
	}

	public function setFechaFin() {

		$this->fechaFin = date('Y-m-d H:i:s');
	}

	public function setFechaInicio() {

		$this->fechaInicio = date('Y-m-d H:i:s');
	}

    
	public static function crea($idUsuarioSolicita, $idUsuarioServicio, $idServicio){
        
		$contratacion = new Contratacion($idUsuarioSolicita, $idUsuarioServicio, $idServicio, date('Y-m-d H:i:s')/*,NULL, NULL, 1*/);
		return $contratacion;
	}

	//busca una contratacion y la devuelve
	public static function buscarContratacion($usuarioContratador, $idServicio) {

		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS SC WHERE SC.USUARIO_CONTRATADOR = %d AND SC.SERVICIO = %d;', $usuarioContratador, $idServicio);
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
		  $fila = $rs->fetch_assoc();
		  
		  $contratacion = new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  $rs->free();
	
		  return $contratacion;
		}

		return null;
	}

	public static function buscarContratacionPorId($id) {

		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf("SELECT * FROM SERVICIOS_CONTRATADOS SC WHERE SC.ID = $id");
		$rs = $conn->query($query);

		if ($rs && $rs->num_rows == 1) {
		  $fila = $rs->fetch_assoc();
		  
		  $contratacion = new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);

		  $rs->free();
	
		  return $contratacion;
		}

		return null;
	}

	//busca si hay contrataciones en curso o solicitadas por un mismo usuario para un mismo servicio
	//devuelve false si no hay contrataciones anteriores para ese servicio, o las que hay se rechazaron o finalizaron en su momento
	public static function existenContrataciones($usuarioContratador, $idServicio) {

		$app = App::getInstancia();
		$conn = $app->getConexionBD();
	
		$query = sprintf('SELECT COUNT(SC.ID) FROM SERVICIOS_CONTRATADOS SC WHERE SC.USUARIO_CONTRATADOR = %d 
						AND SC.SERVICIO = %d AND SC.ESTADO != %d AND SC.ESTADO != %d', $usuarioContratador, $idServicio, 3, 4);
		$rs = $conn->query($query);
		$fila = $rs->fetch_assoc();
		if ($fila['COUNT(SC.ID)'] > 0) {

			$rs->free();
		  
			return true;
		}
	
		return false;
	}

	//para devolver todos las contrataciones
	public static function devuelveContrataciones(){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf("SELECT SC.ID, SC.USUARIO_CONTRATADOR, SC.USUARIO_REALIZADOR,SC.ID, SC.SERVICIO, SC.FECHA_SOLICITUD ,SC.FECHA_REALIZACION, 
          SC.FECHA_FINALIZACION, SC.ESTADO FROM SERVICIOS_CONTRATADOS SC");  
          
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	//para devolver todos las solicitudes de contrataciones
	public static function devuelveSolicitudes($idUsuario){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS WHERE USUARIO_REALIZADOR = %d AND ESTADO = %d', $idUsuario, 1);  
          
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	//para devolver todos las solicitudes de contrataciones
	public static function devuelveRechazados($idUsuario){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS WHERE USUARIO_CONTRATADOR = %d AND ESTADO = %d', $idUsuario, 4);  
          
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	//para devolver todos las solicitudes de contrataciones
	public static function devuelveFinalizados($idUsuario){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS WHERE ESTADO = %d AND (USUARIO_REALIZADOR = %d OR USUARIO_CONTRATADOR = %d)', 3, $idUsuario, $idUsuario);  
          
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	//para devolver todos las solicitudes de contrataciones
	public static function devuelveEnCursoContratados($idUsuario){

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$result=false;

  		$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS WHERE ESTADO = %d AND USUARIO_CONTRATADOR = %d', 2, $idUsuario);  
          
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
		  }
		  $rs->free();
		}
	
		return $result;
	}

	//para devolver todos las solicitudes de contrataciones
	public static function devuelveEnCursoRealizar($idUsuario){

		$app = App::getInstancia();
		$conn = $app->getConexionBD();
		$result=false;

			$query = sprintf('SELECT * FROM SERVICIOS_CONTRATADOS WHERE ESTADO = %d AND USUARIO_REALIZADOR = %d', 2, $idUsuario);  
			
		$rs = $conn->query($query);
		if ($rs) {
			while($fila = $rs->fetch_assoc()) {
			$result[] =  new Contratacion($fila['USUARIO_CONTRATADOR'], $fila['USUARIO_REALIZADOR'], $fila['SERVICIO'], $fila['FECHA_SOLICITUD'], $fila['FECHA_REALIZACION'], $fila['FECHA_FINALIZACION'], $fila['ESTADO'],$fila['ID']);
			}
			$rs->free();
		}
	
		return $result;
	}


	public static function inserta($contratacion) {

		$result = false;

		$app = App::getInstancia();
        $conn = $app->getConexionBD();
      
		$query=sprintf("INSERT INTO SERVICIOS_CONTRATADOS(USUARIO_CONTRATADOR, USUARIO_REALIZADOR,SERVICIO, FECHA_SOLICITUD,
        FECHA_REALIZACION,FECHA_FINALIZACION,ESTADO) VALUES(%d, %d, %d, '%s','%s','%s', %d)"
        , $contratacion->idUsuarioSolicita
		, $contratacion->idUsuarioServicio
        , $contratacion->idServicio
        , $conn->real_escape_string($contratacion->fechaSolicitud)
        , $conn->real_escape_string($contratacion->fechaInicio)
		, $conn->real_escape_string($contratacion->fechaFin)
        , $contratacion->estado);

 		$result = $conn->query($query);
		
		if ($result) {
		  $contratacion->id = $conn->insert_id;
		  $result = $contratacion;
		} else {
		  error_log($conn->error);  
		}
	
		return $result;
	}

	public static function borra($contratacion){
		
	  return self::borraPorId($contratacion->id);
	}

	public static function borraPorId($id){
	
		$result = false;
		$app = App::getInstancia();
        $conn = $app->getConexionBD();

		$query = sprintf("DELETE FROM SERVICIOS_CONTRATADOS WHERE ID = %d", $id);
		$result = $conn->query($query);
		
		if (!$result) {
		  error_log($conn->error);
		} 
		else if ($conn->affected_rows != 1) {
		  error_log("Se han borrado '$conn->affected_rows' !");
		}
	
		return $result;
	}

	public static function actualiza($contratacion){
		
		$result = false;
        
		$app = App::getInstancia();
        $conn = $app->getConexionBD();
		$query = sprintf("UPDATE SERVICIOS_CONTRATADOS C SET USUARIO_CONTRATADOR = '%d', USUARIO_REALIZADOR = '%d',
        SERVICIO = '%d', FECHA_SOLICITUD = '%s', FECHA_REALIZACION = '%s', FECHA_FINALIZACION = '%s', ESTADO = '%d' WHERE C.ID = %d"
          , $contratacion->idUsuarioSolicita
          , $contratacion->idUsuarioServicio
          , $contratacion->idServicio
		  , $conn->real_escape_string($contratacion->fechaSolicitud)
          , $conn->real_escape_string($contratacion->fechaInicio)
          , $conn->real_escape_string($contratacion->fechaFin)
          , $contratacion->estado
		  , $contratacion->id);
		
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