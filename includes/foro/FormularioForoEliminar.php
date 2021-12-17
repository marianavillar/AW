<?php
namespace es\ucm\fdi\aw\foro;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\foro\Foro;

class FormularioForoEliminar extends Form{

    private $idForo;

    public function __construct($idForo) {
        parent::__construct('formForoEliminar');
        $this->idForo = $idForo;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario=<<<EOF
          <input type="hidden" name="idForo" value="{$this->idForo}" />
          <button type="submit" onclick="return confirm('¿Quieres eliminar el foro?');">Borrar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos)
    {
        if (estaLogado() && esAdmin()) {
    
            $idForo = $datos['idForo'] ?? null ;
        
            Foro::borraPorId($idForo);
            
        }else{
            $contenidoPrincipal=<<<EOS
                <h1>Acceso Denegado!</h1>
                <p>No tienes permisos suficientes para borrar un tema.</p>
            EOS;
        } 

        $result = 'ForoVista.php';

        return $result;
    }
}
