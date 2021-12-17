<?php
namespace es\ucm\fdi\aw\contrataciones;
use es\ucm\fdi\aw\Form;

class FormularioAceptarContratacion extends Form{

    private $idContratacion;

    public function __construct($idContratacion) {
        parent::__construct('formAceptarContratacion');
        $this->idContratacion = $idContratacion;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario=<<<EOF
        <input type="hidden" name="idContratacion" value="{$this->idContratacion}" />
        <button type="submit" onclick="alert('Has aceptado la contratación del servicio.');">Aceptar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos){
  
        $idContratacion = $datos['idContratacion'] ?? null ;

        $contratacion = Contratacion::buscarContratacionPorId($idContratacion);

        //cambiar el estado "en curso" en la tabla  Contrataciones_Servicio (2 => en curso)
        $contratacion->setEstado(2);
        //actualizar fecha servicio
        $contratacion->setFechaInicio();
        $contratacion->actualiza($contratacion);
    
        $result = 'ServiciosSolicitadosVista.php';

        return $result;
    }
}