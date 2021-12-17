<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\foro\MensajeForo;
use es\ucm\fdi\aw\foro\FormularioMensajeForoCrear;
use es\ucm\fdi\aw\foro\FormularioMensajeForoEliminar;
use es\ucm\fdi\aw\foro\FormularioMensajeForoRespuesta;

$tituloPagina = 'Mensajes hilo foro';
$raizApp = RUTA_APP;
$contenidoPrincipal= "";

function listaMensajesPaginados($idForo, $idPadre, $numPorPagina = 4, $numPagina = 1)
{

    $contenidoPrincipal = '';
    $mensajes = MensajeForo::buscaMensajesPaginados($idForo, $idPadre, $numPorPagina+1, $numPagina-1);
    $numMensajes = count($mensajes);
    $haySiguientePagina = false;
    if ($numMensajes > $numPorPagina) {
        $numMensajes = $numPorPagina;
        $haySiguientePagina = true;
    }
    $idx = 0;
    while($idx < $numMensajes) {
        $mensaje = $mensajes[$idx];

		$idAux = $mensaje->getId();

		$usuarioNombre = $mensaje->getAutor()->username();
		$idForo = $mensaje->getIdForo();
		$idUsuario = idUsuarioLogado();
		
		$contenidoPrincipal.= '<div class="cartaForo">';
		$contenidoPrincipal.='<p id="tituloServicios">'.$usuarioNombre.'</p>
							<p id="descripcionServicios">'.$mensaje->getContenido().'</p>
							<p id="categoríaServicios">'.$mensaje->getFecha().'</p><div class="btnGroup">';

		if($idUsuario == $mensaje->getAutor()->id()){
			$contenidoPrincipal.= <<<EOS
			<div><a class="boton" href="editarMensajeForoVista.php?id={$idAux}">Editar</a></div>
			EOS;
		}

		if($idUsuario == $mensaje->getAutor()->id() || esAdmin()){

			$formularioMensajeEliminar = new FormularioMensajeForoEliminar($idAux);
			$gestionaFormularioMensajeEliminar = $formularioMensajeEliminar->gestiona();
			
			$contenidoPrincipal.= <<<EOS
				<div>$gestionaFormularioMensajeEliminar</div>
			EOS;
		} 
		$contenidoPrincipal.= '</div></div>';
        $idx++;
    }

    $clasesPrevia='deshabilitado';
    $clasesSiguiente = 'deshabilitado';
    $hrefPrevia = '';
    $hrefSiguiente = '';

    if ($numPagina > 1) {

        $paginaPrevia = $numPagina - 1;
        $clasesPrevia = '';
        $hrefPrevia = 'href="'.RUTA_APP.'/mensajesHiloForoVista.php?idForo='.$idForo.'&idPadre='.$idPadre.'&numPagina='.$paginaPrevia.'&numPorPagina='.$numPorPagina.'"';
    }

    if ($haySiguientePagina) {

        $paginaSiguiente = $numPagina + 1;
        $clasesSiguiente = '';
		
        $hrefSiguiente = 'href="'.RUTA_APP.'/mensajesHiloForoVista.php?idForo='.$idForo.'&idPadre='.$idPadre.'&numPagina='.$paginaSiguiente.'&numPorPagina='.$numPorPagina.'"';
    }

    $contenidoPrincipal .=<<<EOS
        <div>
            Página: $numPagina <a class="boton $clasesPrevia" $hrefPrevia>Previa</a><a class="boton $clasesSiguiente" $hrefSiguiente>Siguiente</a>
        </div>
    EOS;

    return $contenidoPrincipal;
}



    $idForo = filter_input(INPUT_GET, 'idForo', FILTER_SANITIZE_NUMBER_INT);
	$idPadre = filter_input(INPUT_GET, 'idPadre', FILTER_SANITIZE_NUMBER_INT);
	$numPagina = filter_input(INPUT_GET, 'numPagina', FILTER_SANITIZE_NUMBER_INT) ?? 1;
	$numPorPagina = filter_input(INPUT_GET, 'numPorPagina', FILTER_SANITIZE_NUMBER_INT) ?? 4;

    $contenidoPrincipal.= <<<EOS
			<h1> Mensajes del Hilo </h1>
		EOS;
	$contenidoPrincipal .= '<div class="flex-container-tablon-mensajes-foro">';
	
	$listaMensajes = listaMensajesPaginados($idForo, $idPadre, $numPorPagina, $numPagina);
    if (estaLogado()) {
        $idUsuario = idUsuarioLogado();

        $formularioMensajeCrear = new  FormularioMensajeForoRespuesta($idForo, $idUsuario, $idPadre);
        $gestionaFormularioMensajeCrear = $formularioMensajeCrear->gestiona();

        $contenidoPrincipal .= <<<EOS
        $gestionaFormularioMensajeCrear
        EOS;
    }
	$contenidoPrincipal.= <<<EOS
	$listaMensajes
	EOS;

	


require __DIR__.'/includes/comun/layout.php';
?>