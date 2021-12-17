<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\servicios\Servicio;
use es\ucm\fdi\aw\contrataciones\Contratacion;
use es\ucm\fdi\aw\contrataciones\FormularioSolicitarContratacion;
use es\ucm\fdi\aw\servicios\FormularioFavoritos;
use es\ucm\fdi\aw\mensajes\FormularioConversacionCrear;

$tituloPagina = 'Buscar Servicios';
$raizApp = RUTA_APP;

$contenidoPrincipal = '<h3>Empieza a contratar</h3>';

$listaServicios = Servicio::devolverListaServicios();

$idUsuario = idUsuarioLogado();
$usuarioLogado = Usuario::buscaPorId($idUsuario);

$contenidoPrincipal .= '
			<div class="flex-container-tablon-servicios">';
foreach($listaServicios as $servicio){

		$idServicio = $servicio->getId();

		$usuarioOfer = Usuario::devolverSegunServicio($servicio->getId());
		$idUsuarioOfer= $usuarioOfer->id();
		$username = $usuarioOfer->username();

		$strUsuarioOfer = '<a href="'.$raizApp.'/perfilUsuario.php?user='.$username.'"><i class="material-icons md-24">person</i>'.$username.'</a>';

		$contratada = Contratacion::existenContrataciones($idUsuario, $idServicio);

	if(estaLogado() && ($idUsuario != $idUsuarioOfer)){

		$formularioSolicitarContratacion = new  FormularioSolicitarContratacion($idUsuario, $idServicio, $idUsuarioOfer);
		$gestionaFormularioSolicitarContratacion = $formularioSolicitarContratacion->gestiona();

		$FormularioFavoritos = new  FormularioFavoritos($idUsuario, $idServicio);
		$gestionaFormularioFavoritos = $FormularioFavoritos->gestiona();

		$FormularioConversacion = new  FormularioConversacionCrear($idUsuario, $idUsuarioOfer);
		$gestionaFormularioConversacionCrear = $FormularioConversacion->gestiona();

		if (!$contratada && $usuarioLogado->getSaldoMonedero() > 0){
			$contenidoPrincipal .= '
				
					<div class="cartaUsuario">
						<div id="contenedorUsuarioLike"> 
							<div id="ofertanteServicio">'.$strUsuarioOfer.'</div>
							<div id="like">'.$gestionaFormularioFavoritos.'</div>
						</div> 
						<img src="'.$servicio->getImagen().'" id="serv_img" alt="imagen del servicio">
						<div class="contenedor-carta">
							<p id="tituloServicios">'.$servicio->getTitulo().'</p>
							<p id="descripcionServicios">'.$servicio->getDescripcion().'</p>
							<p>'.$gestionaFormularioSolicitarContratacion.'</p>
							<p>'.$gestionaFormularioConversacionCrear.'</p>
							<p id="categoríaServicios">'. $servicio->getCategoria().'</p>
						</div>
					</div>';
		}
		else{
			$contenidoPrincipal .= '
				
				<div class="cartaUsuario">
					<div id="contenedorUsuarioLike">  
						<div id="ofertanteServicio">'.$strUsuarioOfer.'</div>
						<div id="like">'.$gestionaFormularioFavoritos.'</div>
					</div>
					<img src="'.$servicio->getImagen().'" id="serv_img" alt="imagen del servicio">
					<div class="contenedor-carta">
						<p id="tituloServicios">'.$servicio->getTitulo().'</p>
						<p id="descripcionServicios">'.$servicio->getDescripcion().'</p>
						<p>'.$gestionaFormularioConversacionCrear.'</p>
						<p id="categoríaServicios">'. $servicio->getCategoria().'</p>	
					</div>
				</div>';
		}
	}
	else{
		$contenidoPrincipal .= '
				<div class="cartaUsuario">
					<div id="contenedorUsuarioLike"> 
						<div id="ofertanteServicio">'.$username.'</div>
					</div> 
					<img src="'.$servicio->getImagen().'" alt="imagen del servicio" id="serv_img">
					<div class="contenedor-carta">
						<p id="tituloServicios">'.$servicio->getTitulo().'</p>
						<p id="descripcionServicios">'.$servicio->getDescripcion() .'</p>
						<p id="categoríaServicios">'.$servicio->getCategoria().'</p>
					</div>
				</div>';
	}
}
$contenidoPrincipal .= '</div>';

require __DIR__.'/includes/comun/layout.php';