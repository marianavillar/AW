<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\foro\MensajeForo;

class FormularioMensajeForoEliminar extends Form{

    private $idMensaje;

    public function __construct($idMensaje) {
        parent::__construct('formMensajeForoEliminar');
        $this->idMensaje = $idMensaje;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario=<<<EOF
          <input type="hidden" name="idMensajeForo" value="{$this->idMensaje}" />
          <button type="submit" onclick="return confirm('¿Quieres eliminar el mensaje del foro?');">Borrar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos)
    {
        if (estaLogado()) {
    
            $idMensaje = $datos['idMensajeForo'] ?? null ;
        
            $mensajeABorrar = MensajeForo::buscarMensajeporId($idMensaje);
            $idForoMensaje = $mensajeABorrar->getIdForo();

            MensajeForo::borraPorId($idMensaje);
            
        }else{
            $contenidoPrincipal=<<<EOS
            <h1>Acceso Denegado!</h1>
            <p>No tienes permisos suficientes para borrar un mensaje.</p>
            EOS;
        } 
         $result = "mensajeForoVista.php?id={$idForoMensaje}";
        return $result;
    }
}
