<?php
namespace es\ucm\fdi\aw\mensajes;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\mensajes\Conversacion;
use es\ucm\fdi\aw\mensajes\Mensaje;

class FormularioConversacionCrear extends Form{

    private $idUsuario1;
    private $idUsuario2;

    public function __construct($idUsuario1, $idUsuario2) {
        parent::__construct('formConversacionCrear');
        $this->idUsuario1 = $idUsuario1;
        $this->idUsuario2 = $idUsuario2;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario='';
        if($errores){
            //$camposFormulario .= '<h1>ERROR</h1>';
            $error = parent::generaListaErroresGlobales($errores);
        }

        $camposFormulario.=<<<EOF
            <input type="hidden" name="idUsuario1" value="{$this->idUsuario1}" />
            <input type="hidden" name="idUsuario2" value="{$this->idUsuario2}" />
            <button type="submit" id="buttonChatear">Chat</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $idUsuario1 = $datos['idUsuario1'] ?? null ;
        $idUsuario2 = $datos['idUsuario2'] ?? null ;
        
        if (count($result) === 0) {

            $conversacion = Conversacion::existeConversacion($idUsuario1, $idUsuario2);

            //si no existe la conversacion entre esos usuarios, se crea
            if(!$conversacion){

                /* Crear conversacion */
                $conversacionNueva = Conversacion::crea($idUsuario1, $idUsuario2);
                /* Insertamos la conversacion en la BBDD */
                $conversacionNueva->inserta($conversacionNueva);
                $idConversacion = $conversacionNueva->getId();
            }

            //si la conversacion existia, obtienes su id
            else{
                $idConversacion= $conversacion->getId();
            }

            $result = "mensajesVista.php?id={$idConversacion}";

        }
        return $result;
    }
}
