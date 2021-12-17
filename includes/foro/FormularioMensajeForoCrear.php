<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\foro\MensajeForo;

class FormularioMensajeForoCrear extends Form{

    private $idForo;
    private $idUsuario;

    public function __construct($idForo, $idUsuario) {
        parent::__construct('formMensajeForoCrear');
        $this->idForo = $idForo;
        $this->idUsuario = $idUsuario;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $contenidoMensaje = $datos['contenidoMensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorContenido = self::createMensajeError($errores, 'contenidoMensaje');

        $contenidoPrincipal=<<<EOS
        <input type="hidden" name="idForo" value="{$this->idForo}" />
        <input type="hidden" name="idUsuario" value="{$this->idUsuario}" />
        <fieldset>
        $htmlErroresGlobales
        <div><label>Nuevo comentario:</label> 
        <input class="control" type="text" placeholder="Comentario" name="contenidoMensaje" value="$contenidoMensaje"/>$errorContenido
        </div>
        <div><button type="submit">Crear</button></div>
        </fieldset>
        EOS;
        return $contenidoPrincipal;
    }
    
    protected function procesaFormulario($datos)
    {
 
        $result = array();
                
        $contenidoMensaje = htmlspecialchars(trim(strip_tags($datos['contenidoMensaje']))) ?? null;
        $idForo = $datos['idForo'] ?? null;
        $idUsuario = $datos['idUsuario'] ?? null;

        if ( empty($contenidoMensaje)) {
            $result['contenidoMensaje'] = "El mensaje no puede estar en blanco.";
        }
        
        if ( empty($idForo)) {
            $result['idForo'] = "Error al relacionar el mensaje con el foro.";
        }

        if ( empty($idUsuario)) {
            $result['idUsuario'] = "Error al relacionar el mensaje con el usuario.";
        }
        
        if (count($result) === 0) {

            /* Crear mensaje */
            $mensajeForo = MensajeForo::crea($idForo, $idUsuario, $contenidoMensaje, NULL);

            /* Insertamos el mensaje en la BBDD */
            $mensajeForo->inserta($mensajeForo);

         $result = "mensajeForoVista.php?id={$idForo}";
        }
        return $result;
    }
}
