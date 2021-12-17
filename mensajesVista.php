<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\mensajes\Mensaje;
use es\ucm\fdi\aw\mensajes\Conversacion;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\mensajes\FormularioMensajeCrear;

$tituloPagina = 'Chat';
$raizApp = RUTA_APP;
$contenidoPrincipal= '';

if (estaLogado()) {

	$idConversacion = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$listaMensajes = Mensaje::devuelveMensajes($idConversacion);

	$idUsuario = idUsuarioLogado();

	$conver = Conversacion::buscarConversacionPorId($idConversacion);
	if($conver->getUsuario1() != $idUsuario){
		$usuarioChat = Usuario::buscaPorId($conver->getUsuario1());
	}
	else{
		$usuarioChat=Usuario::buscaPorId($conver->getUsuario2());
	}
	$strUsuarioOfer = '<a id="chatnombre" href="'.$raizApp.'/perfilUsuario.php?user='.$usuarioChat->username().'"><i class="material-icons md-24">person</i>'.$usuarioChat->username().'</a>';
	$contenidoPrincipal.= <<<EOS
		$strUsuarioOfer 
	EOS;

	$formularioMensajeCrear = new FormularioMensajeCrear($idConversacion, $idUsuario);
	$gestionaFormularioMensajeCrear = $formularioMensajeCrear->gestiona();

	if($listaMensajes != false){
		$contenidoPrincipal.= '<div class="flex-container-mensajes-chats">';
		
		foreach($listaMensajes as $mensaje){

			$usuarioNombre = $mensaje->getAutor()->username();
			if($usuarioNombre===$_SESSION["nombre"]){
				$contenidoPrincipal.= '<div class="cartaForo" id="userMe">';
				$contenidoPrincipal.='<p> '.$mensaje->getContenido().'</p>
									  <p id="fechaMensajesChat">'.$mensaje->getFecha().'</p>';
			}else{
				if($mensaje->getEstado() == 1){
					$mensaje->setEstado(2);
					$mensaje->actualizaEstado($mensaje, $idConversacion);
				}	

				$contenidoPrincipal.= '<div class="cartaForo" id="userYou">';
				$contenidoPrincipal.='<p> '.$mensaje->getContenido().'</p>
									  <p id="fechaMensajesChat">'.$mensaje->getFecha().'</p>';
			}
			
			$contenidoPrincipal.= '</div>';
		
		}
		$contenidoPrincipal.= '</div>';
	}

	$contenidoPrincipal .= <<<EOS
	$gestionaFormularioMensajeCrear
	EOS;
}

require __DIR__.'/includes/comun/layout.php';
?>