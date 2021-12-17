<?php

namespace es\ucm\fdi\aw\resena;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\usuarios\Rol;

class FormularioEliminarResena extends Form{

    public function __construct() {
        parent::__construct('formEliminarResena', array());
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);

        $camposFormulario='';
        $camposFormulario.='<fieldset>';
        $camposFormulario.='<legend> Eliminar Reseña </legend>';
        $camposFormulario.=$htmlErroresGlobales;
        $listaResenas = Resena::devolverTodasResenas();  // Obtenemos la lista de Resenas de la base de datos
        $camposFormulario.='<div><label for="idResena">   Número:  </label>
            <select for="idResena" name="idResena">';
        foreach($listaResenas as $resena){
            $camposFormulario.='<option value="' . $resena->getId() . '">' . $resena->getId() . '</option>';
        }
        $camposFormulario.='</select>';
        $camposFormulario.=<<<EOS
            <div><button type="submit" onclick="return confirm('¿Quieres eliminar la reseña?');"> Eliminar </button></div>
        EOS;
        $camposFormulario.='</br>';
        $camposFormulario.='</fieldset>';
        $result = $camposFormulario;

        return $result;
    }
    
    protected function procesaFormulario($datos)
    {
        $result = array();
        $ok = true;

        // ID_RESENA
        if(isset($datos["idResena"])){
            $idResena = htmlspecialchars(trim(strip_tags($datos["idResena"])));
        }
        else{
            $result[] = "No existe idResena en el array de datos...";
            $ok = false;
        }

        if(Resena::elimina($idResena)){
            $result = 'EliminarResena.php';
        }else{
            $result[] = " No se ha podido eliminar la reseña correctamente...";
        }

        return $result;
    }
}
