<?php
namespace es\ucm\fdi\aw\contrataciones;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\contrataciones\Contratacion;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioRechazarContratacion extends Form{

    private $idContratacion;

    public function __construct($idContratacion) {
        parent::__construct('formRechazarContratacion');
        $this->idContratacion = $idContratacion;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario=<<<EOF
        <input type="hidden" name="idContratacion" value="{$this->idContratacion}" />
        <button type="submit" onclick="alert('Has rechazado la contratación del servicio.');">Rechazar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos){

        $idContratacion = $datos['idContratacion'] ?? null ;

        //obtener el usuario que realizo el servicio asignado a esa contratacion
        $contratacion = Contratacion::buscarContratacionPorId($idContratacion);
        $idUsuarioSolicita = $contratacion->getIdUsuarioSolicita();

        //modificar el estado del servicio a “rechazo” en la tabla  Contrataciones_Servicio. (4 => finalizado)
        $contratacion->setEstado(4);
        $contratacion->actualiza($contratacion);
        
        // se devuelve la unidad al usuario contratador que se restó al “contratar”   
        $usuarioSolicita = Usuario::buscaPorId($idUsuarioSolicita);
        $usuarioSolicita->setSaldoMonederoIncrementa();
        $usuarioSolicita->actualizaSaldo($usuarioSolicita);    

        $result = 'ServiciosSolicitadosVista.php';

        return $result;
    }
}