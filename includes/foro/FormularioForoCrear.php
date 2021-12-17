<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\servicios\Categoria;
use es\ucm\fdi\aw\foro\Foro;
use es\ucm\fdi\aw\foro\MensajeForo;

class FormularioForoCrear extends Form{
    public function __construct() {
        parent::__construct('formForoCrear');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
	    $tema = $datos['tema'] ?? '';
        $asunto = $datos['asunto'] ?? '';
        $contenidoMensaje = $datos['contenidoMensaje'] ?? '';
        $contenidoPrincipal='';
        // Se generan los mensajes de error si existen.
        $contenidoPrincipal.=$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTema = self::createMensajeError($errores, 'tema');
        $errorAsunto = self::createMensajeError($errores, 'asunto');
        $errorContenido = self::createMensajeError($errores, 'contenidoMensaje');

        $listaTemas = Categoria::devolverListaCategorias();
        // $tituloPagina = 'Nuevo foro';

        $contenidoPrincipal=<<<EOS
        <h3 class="foro">Crear un foro</h3>
        <fieldset>
        $htmlErroresGlobales
            <legend>Escriba un tema y asunto para un foro</legend>
            <div><label>Asunto:</label> 
            <input class="control" type="text" placeholder="Asunto" name="asunto" value="$asunto"/>$errorAsunto
            </div>
        EOS;
        $contenidoPrincipal.=<<<EOS
            <div><label>Seleccione un tema:</label>
            <select name="tema">
        EOS;
        foreach ($listaTemas as $value){
            $contenidoPrincipal.='<option value='.$value->getId().'>'.$value->getNombre().'</option>';
        }
        $contenidoPrincipal.=<<<EOS
            </select>
            </div>
            <div><label>Mensaje:</label> 
            <input class="control" type="text" placeholder="Mensaje" name="contenidoMensaje" value="$contenidoMensaje"/>$errorContenido
            </div>
            <div><button type="submit">Crear</button></div>
            </fieldset>
        EOS;
        return $contenidoPrincipal;
    }
    
    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $tema = htmlspecialchars(trim(strip_tags($datos['tema']))) ?? null;
        
        if ( empty($tema) ) {
            $result['tema'] = "El foro debe de tener un tema.";
        }
        
        $asunto = htmlspecialchars(trim(strip_tags($datos['asunto']))) ?? null;
        if ( empty($asunto) ) {
            $result['asunto'] = "El foro debe de tener un asunto.";
        }
        
        $contenido = htmlspecialchars(trim(strip_tags($datos['contenidoMensaje']))) ?? null;
        if ( empty($contenido)) {
            $result['contenidoMensaje'] = "El foro debe de tener un contenido.";
        }
        
        if (count($result) === 0) {

            /* Crear foro */
            $foro = Foro::crea($tema, $asunto);

            /* Insertamos el foro en la BBDD */
            $foroInsertado = $foro->inserta($foro);

            if($foroInsertado->getId()){
                $idForo = $foroInsertado->getId();
                $idUsuario = idUsuarioLogado();

                /* Crear mensaje */
                $mensajeForo = MensajeForo::crea($idForo, $idUsuario, $contenido);
            
                /* Insertamos el mensaje en la BBDD */
                $mensajeForo->inserta($mensajeForo);

                $result = 'ForoVista.php';
            }
        }
        return $result;
    }
}
