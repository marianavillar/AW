<?php
namespace es\ucm\fdi\aw\mensajes;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\mensajes\Mensaje;

class FormularioMensajeCrear extends Form{

    private $idConversacion;
    private $idUsuario;

    public function __construct($idConversacion, $idUsuario) {
        parent::__construct('formMensajeCrear');
        $this->idConversacion = $idConversacion;
        $this->idUsuario = $idUsuario;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $contenidoMensaje = $datos['contenidoMensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorContenido = self::createMensajeError($errores, 'contenidoMensaje');

        $contenidoPrincipal=<<<EOS
        <fieldset>
        $htmlErroresGlobales
        <div>
        <input class="control" type="text" placeholder="Mensaje" name="contenidoMensaje" value="$contenidoMensaje"/>$errorContenido
        <input type="hidden" name="idConversacion" value="{$this->idConversacion}" />
        <input type="hidden" name="idUsuario" value="{$this->idUsuario}" />
        <button type="submit">Enviar</button>
        </div>
        </fieldset>
        EOS;

        return $contenidoPrincipal;
    }
    
    protected function procesaFormulario($datos)
    {
 
        $result = array();
                
        $contenidoMensaje = htmlspecialchars(trim(strip_tags($datos['contenidoMensaje']))) ?? null;
        $idConversacion = $datos['idConversacion'] ?? null;
        $idUsuario = $datos['idUsuario'] ?? null;

        if ( empty($contenidoMensaje)) {
            $result['contenidoMensaje'] = "El mensaje no puede estar en blanco.";
        }
        
        if ( empty($idConversacion)) {
            $result['idConversacion'] = "Error al relacionar el mensaje con el chat.";
        }

        if ( empty($idUsuario)) {
            $result['idUsuario'] = "Error al relacionar el mensaje con el usuario.";
        }
        
        if (count($result) === 0) {

            /* Crear mensaje */
            $mensaje = Mensaje::crea($idConversacion, $idUsuario, $contenidoMensaje);

            /* Insertamos el mensaje en la BBDD */
            $mensaje->inserta($mensaje);

         $result = "mensajesVista.php?id={$idConversacion}";
        }
        return $result;
    }
}
