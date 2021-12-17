<?php
namespace es\ucm\fdi\aw\contrataciones;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\contrataciones\Contratacion;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioSolicitarContratacion extends Form{

    private $idUsuarioSolicita;
    private $idServicio;
    private  $idUsuarioServicio;

    public function __construct($idUsuarioSolicita, $idServicio, $idUsuarioServicio) {
        parent::__construct('formSolicitarContratacion');
        $this->idUsuarioSolicita = $idUsuarioSolicita;
        $this->idServicio = $idServicio;
        $this->idUsuarioServicio = $idUsuarioServicio;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario='';
        if($errores){
            //$camposFormulario .= '<h1>ERROR</h1>';
            $error = parent::generaListaErroresGlobales($errores);
        }

        $camposFormulario.=<<<EOF
            <input type="hidden" name="idServicio" value="{$this->idServicio}" />
            <input type="hidden" name="idUsuario" value="{$this->idUsuarioSolicita}" />
            <input type="hidden" name="idUsuarioServicio" value="{$this->idUsuarioServicio}" />
            <button type="submit" id="buttonSolicitarContratacion" onclick="alert('Has enviado la solicitud de contratación del servicio.');">Solicitar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos){
        $result = array();

        $idUsuarioSolicita = $datos['idUsuario'] ?? null ;
        $idServicio = $datos['idServicio'] ?? null ;
        $idUsuarioServicio = $datos['idUsuarioServicio'] ?? null ;

        $usuarioSolicita = Usuario::buscaPorId($idUsuarioSolicita);

        //si el usuario tiene saldo suficiente
        if($usuarioSolicita->getSaldoMonedero() >= 1){

            $existen = Contratacion::existenContrataciones($idUsuarioSolicita, $idServicio);
            
            if(!$existen){
                //Se registra el servicio con estado “Solicitado.” y los usuarios en la tabla  Contrataciones_Servicio
                $contratacion = Contratacion::crea($idUsuarioSolicita, $idUsuarioServicio, $idServicio);
                $contratacionInsertada = $contratacion->inserta($contratacion);

                $usuarioSolicita->setSaldoMonederoDecrementa();
                $usuarioSolicita->actualizaSaldo($usuarioSolicita);

            }
            else{
                $result[]='
                <h1>Error!</h1>
                <p>Ya has contratado este servicio.</p>';
            }
        }            
        else{
            //$app = Aplicacion::getInstancia();
            //$app->putAtributoPeticion('mensajes', array('No tiene suficiente saldo para solicitar este servicio.'));
            $result[]='
                <h1>Acceso Denegado!</h1>
                <p>No tiene suficiente saldo para solicitar este servicio.</p>
                <p>Realice otros servicios antes de solicitar uno nuevo.</p>';
        }

        if (count($result) === 0) {
            $result = 'index.php';
        }
 
        return $result;
    }
}