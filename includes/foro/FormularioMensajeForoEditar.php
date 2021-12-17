<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\foro\MensajeForo;

class FormularioMensajeForoEditar extends Form{

    private $idMensaje;

    public function __construct($idMensaje) {
        parent::__construct('formMensajeForoEditar');
        $this->idMensaje = $idMensaje;
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){

        $contenidoMensaje = $datos['contenidoMensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorContenido = self::createMensajeError($errores, 'contenidoMensaje');

        $contenidoPrincipal=<<<EOS
        <h1>Editar mensaje</h1>
        <fieldset>
        $htmlErroresGlobales
            <div><label>Editar mensaje:</label> 
            <input class="control" type="text" placeholder="Mensaje" name="contenidoMensaje" value="$contenidoMensaje"/>$errorContenido
            <input type="hidden" name="idMensaje" value="{$this->idMensaje}" />
            </div>
            <div><button type="submit">Editar</button></div>
            </fieldset>
        EOS;
        return $contenidoPrincipal;
    }
    
    protected function procesaFormulario($datos){
        $result = array();

        $idMensaje = htmlspecialchars(trim(strip_tags($datos['idMensaje']))) ?? null;
        $contenido = htmlspecialchars(trim(strip_tags($datos['contenidoMensaje']))) ?? null;
        
        if ( empty($contenido)) {
            $result['contenidoMensaje'] = "El mensaje debe de tener un contenido.";
        }
        
        if (count($result) === 0) {

            if (estaLogado()) {

                $mensajeForo = MensajeForo::buscarMensajeporId($idMensaje);
                $idForo = $mensajeForo->getIdForo();
                $contenido .= "  (editado)";
                $mensajeForo->setContenido($contenido);
                $mensajeForo->setFecha();
                $mensajeForo->actualiza($mensajeForo);                
            }
            else{
                $contenidoPrincipal=<<<EOS
                    <h1>Acceso Denegado!</h1>
                    <p>No tienes permisos suficientes para editar este mensaje.</p>
                EOS;
            }
            $result = "mensajeForoVista.php?id={$idForo}";
        }       
        return $result;
    }
}