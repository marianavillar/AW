<?php
    require_once __DIR__.'/includes/config.php';
    require_once __DIR__.'/includes/autorizacion.php';

    use es\ucm\fdi\aw\foro\Foro;
    use es\ucm\fdi\aw\foro\FormularioForoCrear;
    use es\ucm\fdi\aw\foro\FormularioForoEliminar;

    $tituloPagina = 'Foro';
    $raizApp = RUTA_APP;
   $contenidoPrincipal= <<<EOS
        <h3> Foros disponibles</h3>
    EOS;
               
        $listaForos =  Foro::devuelveForos();
        
        if(estaLogado()){
            $formularioCrear = new FormularioForoCrear();
            $gestionaFormularioCrear = $formularioCrear->gestiona();
            $contenidoPrincipal .=<<<EOS
                $gestionaFormularioCrear
            EOS;
        }
        else{
            $contenidoPrincipal .=<<<EOS
            <p>Debes iniciar sesión o registrarte para crear un foro.</p>
            EOS;
        }

        if($listaForos != false){
            $contenidoPrincipal .= '
			<div class="flex-container-tablon-foro">';
            
            foreach($listaForos as $foro){
                $idAux = $foro->getId();
                $contenidoPrincipal.= '<div class="cartaForo">';
                $contenidoPrincipal.=<<<EOS
                    <a href="mensajeForoVista.php?id={$idAux}">
                EOS;
                $contenidoPrincipal.='<p id="tituloServicios">'.$foro->getTema().'</p>
                <p id="descripcionServicios">'.$foro->getAsunto(). '</p></a>';
                
                if(esAdmin()){

                $formularioEliminar = new  FormularioForoEliminar($idAux);
                $gestionaFormularioEliminar = $formularioEliminar->gestiona();

                $contenidoPrincipal.= <<<EOS
                    $gestionaFormularioEliminar
                EOS;
                
                }  
                $contenidoPrincipal.= '</div>';
                
            }
            $contenidoPrincipal.= '</div>';  
            
        }
        
    require __DIR__.'/includes/comun/layout.php';
?>