<?php

namespace es\ucm\fdi\aw\resena;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\resena\Resena;

class FormularioResena extends Form
{

    private $idCreador;     // Id del usuario creador de la reseña
    private $idValorado;    // Id del usuario que se esta valorando en la reseña

    public function __construct($idCreador, $idValorado)
    {
        $this->idCreador = $idCreador;
        $this->idValorado = $idValorado;
        parent::__construct('formResena', array());
    }

    protected function generaCamposFormulario($datosIniciales,  $errores = array())
    {
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorArchivo = self::createMensajeError($errores, 'archivo', 'span', array('class' => 'error'));

        $camposFormulario='';
        $camposFormulario.=$htmlErroresGlobales;
        $camposFormulario.=<<<EOS
            <input type="hidden" name="idCreador" value="{$this->idCreador}" />
            <input type="hidden" name="idValorado" value="{$this->idValorado}" />
            EOS;
        $camposFormulario.='<div>
                            <input id="comentario" class="control" type="text" placeholder="Deja una reseña" name="comentario" required/>
                            <input type="hidden" name="rating[post_id]" value="3" />
                            <button id="stars" type="submit" name="puntuacion" value="5">&#9733;</button>
                            <button id="stars" type="submit" name="puntuacion" value="4">&#9733;</button>
                            <button id="stars" type="submit" name="puntuacion" value="3">&#9733;</button>
                            <button id="stars" type="submit" name="puntuacion" value="2">&#9733;</button>
                            <button id="stars" type="submit" name="puntuacion" value="1">&#9733;</button>
                            </div>';
        $camposFormulario.= $errorArchivo;

        $result = $camposFormulario;

        return $result;
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
     * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
     */
    protected function procesaFormulario($datos)
    {
    	$result = array();
        $ok = true;

        // ID_CREADOR
        if(isset($datos["idCreador"])){
            $idCreador = htmlspecialchars(trim(strip_tags($datos["idCreador"])));
        }
        else{
            $result[] = "Rellenar el campo idCreador para validarlo";
            $ok = false;
        }

        // ID_VALORADO
        if(isset($datos["idValorado"])){
            $idValorado = htmlspecialchars(trim(strip_tags($datos["idValorado"])));
        }
        else{
            $result[] = "Rellenar el campo idValorado para validarlo";
            $ok = false;
        }

        // COMENTARIO
        if(isset($datos["comentario"])){
            $comentario = htmlspecialchars(trim(strip_tags($datos["comentario"])));
        }
        else{
            $result[] = "Rellenar el campo comentario para validarlo";
            $ok = false;
        }

        // PUNTUACION
        if(isset($datos["puntuacion"])){
            $puntuacion = htmlspecialchars(trim(strip_tags($datos["puntuacion"])));
        }
        else{
            $result[] = "Rellenar el campo puntuacion para validarlo";
            $ok = false;
        }

        if ( count($result) === 0 ) {

            // Realizar operaciones en BBDD
            /* Crear Resena */
            $resena = Resena::crea($idCreador, $idValorado, $puntuacion, $comentario);
            /* Insertamos la reseña en la BBDD */
            $resena->inserta($resena);
            $result ='ServiciosFinalizadosVista.php';

        }

        return $result;
    }

}