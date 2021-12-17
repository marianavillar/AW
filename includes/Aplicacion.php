<?php

namespace es\ucm\fdi\aw;

class Aplicacion{

    const ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION = 'attsPeticion';

    private static $instancia;
    private $datosConexionBD;
    private $ini=false;
    private $conexion;

    private function __construct() {}

    public function __clone()
	{
		throw new Exception('No tiene sentido el clonado');
	}

    public function __sleep()
	{
		throw new Exception('No tiene sentido el serializar el objeto');
	}

    public function __wakeup()
	{
		throw new Exception('No tiene sentido el deserializar el objeto');
	}

    
    public static function getInstancia(){
        if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
    }

    public function init($datosConexionBD){
        if(! $this->ini){
            $this->datosConexionBD= $datosConexionBD;;
            session_start();
            $this->ini = true;
        }
    }

    public function shutdown(){
        $this->compruebaInstanciaInicializada();
        if($this->conexion !==null)
            $this->conexion->close();
    }

    private function compruebaInstanciaInicializada(){
        if(! $this->ini){
            echo "App no inicializada";
            exit();

        }
    }


    public function getConexionBD(){
        $this->compruebaInstanciaInicializada();
        if(! $this->conexion){
            $host= $this->datosConexionBD['host'];
            $bd= $this->datosConexionBD['bd'];
            $user= $this->datosConexionBD['user'];
            $pass= $this->datosConexionBD['pass'];
            $this->conexion = new \mysqli($host, $user, $pass, $bd);
            if ( $this->conexion->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conexion->connect_errno . ") " . utf8_encode($this->conexion->connect_error);
				exit();
			}
			if ( ! $this->conexion->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conexion->errno . ") " . utf8_encode($this->conexion->error);
				exit();
			}
        }
        return $this->conexion;
        
    }

    public function resuelve($path = '')
    {
      $this->compruebaInstanciaInicializada();
      $rutaRaizAppLongitudPrefijo = mb_strlen($this->rutaRaizApp);
      if( mb_substr($path, 0, $rutaRaizAppLongitudPrefijo) === $this->rutaRaizApp ) {
        return $path;
      }
  
      if (mb_strlen($path) > 0 && mb_substr($path, 0, 1) !== '/') {
        $path = '/' . $path;
      }
  
      return $this->rutaRaizApp . $path;
    }

    /**
	 * Añade un atributo <code>$valor</code> para que esté disponible en la siguiente petición bajo la clave <code>$clave</code>.
	 * 
	 * @param string $clave Clave bajo la que almacenar el atributo.
	 * @param any    $valor Valor a almacenar como atributo de la petición.
	 * 
	 */
	public function putAtributoPeticion($clave, $valor)
	{
	  $this->compruebaInstanciaInicializada();
		$atts = null;
		if (isset($_SESSION[self::ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION])) {
			$atts = &$_SESSION[self::ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION];
		} else {
			$atts = array();
			$_SESSION[self::ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION] = &$atts;
		}
		$atts[$clave] = $valor;
	}

	/**
	 * Devuelve un atributo establecido en la petición actual o en la petición justamente anterior.
	 * 
	 * 
	 * @param string $clave Clave sobre la que buscar el atributo.
	 * 
	 * @return any Attributo asociado a la sesión bajo la clave <code>$clave</code> o <code>null</code> si no existe.
	 */
	public function getAtributoPeticion($clave)
	{
    $this->compruebaInstanciaInicializada();
		$result = $this->atributosPeticion[$clave] ?? null;
		if(is_null($result) && isset($_SESSION[self::ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION])) {
			$result = $_SESSION[self::ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION][$clave] ?? null;
		}
		return $result;
	}

}

