<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\foro\MensajeForo;

class FormularioMensajeForoRespuesta extends Form{

    private $idForo;
    private $idUsuario;
    private $idPadre;

    public function __construct($idForo, $idUsuario, $idPadre) {
        parent::__construct('formMensajeForoRespuesta');
        $this->idForo = $idForo;
        $this->idUsuario = $idUsuario;
        $this->idPadre = $idPadre;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $contenidoMensaje = $datos['contenidoMensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorContenido = self::createMensajeError($errores, 'contenidoMensaje');

        $contenidoPrincipal=<<<EOS
        <input type="hidden" name="idPadre" value="{$this->idPadre}" />
        <input type="hidden" name="idForo" value="{$this->idForo}" />
        <input type="hidden" name="idUsuario" value="{$this->idUsuario}" />
        <fieldset>
        $htmlErroresGlobales
        <div><label>Nuevo comentario:</label> 
            <input class="control" type="text" placeholder="Comentario" name="contenidoMensaje" value="$contenidoMensaje"/>$errorContenido
        </div>
        <div><button type="submit">Añadir</button></div>
        </fieldset>
        EOS;
        return $contenidoPrincipal;
    }
    
    protected function procesaFormulario($datos)
    {
 
        $result = array();
        $ok = true;
                
        $contenidoMensaje = htmlspecialchars(trim(strip_tags($datos['contenidoMensaje']))) ?? null;
        $idForo = $datos['idForo'] ?? null;
        $idUsuario = $datos['idUsuario'] ?? null;
        $idPadre = $datos['idPadre'] ?? null;

        if ( empty($contenidoMensaje)) {
            $result['contenidoMensaje'] = "El mensaje no puede estar en blanco.";
        }

        if ( empty($idForo)) {
            $result['idForo'] = "Error al relacionar el mensaje con el foro.";
        }

        if ( empty($idUsuario)) {
            $result['idUsuario'] = "Error al relacionar el mensaje con el usuario.";
        }
        if(!$idPadre){
            $result['idPadre'] = 'No se ha podido añadir la respuesta.';
        }

        
        if (count($result) === 0) {

            /* Crear mensaje */
            $mensajeForo = MensajeForo::crea($idForo, $idUsuario, $contenidoMensaje, $idPadre);

            /* Insertamos el mensaje en la BBDD */
            $mensajeForo->inserta($mensajeForo);

         $result = "mensajeForoVista.php?id={$idForo}";
        }
        return $result;
    }
}
