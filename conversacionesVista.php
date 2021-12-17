<?php
    require_once __DIR__.'/includes/config.php';
    require_once __DIR__.'/includes/autorizacion.php';

    use es\ucm\fdi\aw\mensajes\Conversacion;
    use es\ucm\fdi\aw\mensajes\Mensaje;
    use es\ucm\fdi\aw\usuarios\Usuario;

    $tituloPagina = 'Chats';
    $raizApp = RUTA_APP;
   $contenidoPrincipal= <<<EOS
        <h3> Chats </h3>
    EOS;
    if(estaLogado()){
        $idUsuario = idUsuarioLogado();       
        $listaConversaciones =  Conversacion::devuelveConversacionesPorUsuario($idUsuario);
        if(empty($listaConversaciones)){
            $contenidoPrincipal .= '<p>No tienes niguna conversación</p>';
        }
        else{
            $contenidoPrincipal.= '<div id="containerChats" class="flex-container-tablon-servicios">';
            foreach($listaConversaciones as $conversacion){
                $idAux = $conversacion->getId();
                $mensajes = Mensaje::devuelveMensajes($idAux);

                if($mensajes){
                    $contenidoPrincipal.= '<div id="containerChats" class="cartaUsuario">';
                    
                    if($conversacion->getUsuario1() != $idUsuario){
                        $usuarioChat = Usuario::buscaPorId($conversacion->getUsuario1());
                    }
                    else{
                        $usuarioChat = Usuario::buscaPorId($conversacion->getUsuario2());
                    }

                    $ultimoMensaje = end($mensajes);                    
                    $strUsuarioOfer = '<a id="chat" href="'.$raizApp.'/perfilUsuario.php?user='.$usuarioChat->username().'">'.$usuarioChat->username().'</a>';
                    $contenidoPrincipal.='<img id="imgChat" src="'.$usuarioChat->imagen().'" alt="Imagen del usuario">';
                    $contenidoPrincipal.= ' '.$strUsuarioOfer. ' ';  
                    $enlaceChat = '<a id="chat2" href="'.$raizApp.'/mensajesVista.php?id='.$idAux.'">'.$ultimoMensaje->getContenido().'</a>';
                    $contenidoPrincipal.= ' '.$enlaceChat. ' ';

                    if($ultimoMensaje->getIdAutor() != $idUsuario){
                        if ($ultimoMensaje->getEstado() == 1){
                            $numMensjNoLeido = Mensaje::numeroMensajesNoLeidos($idAux);
                            $notificacionChat='<a href="'.$raizApp.'/mensajesVista.php?id='.$idAux.'" class="notification" id="aNotification"><span class="bag">'.$numMensjNoLeido.'</span></a>';
                            $contenidoPrincipal.= ' '.$notificacionChat. ' ';
                        }
                    }
                    $contenidoPrincipal.= '</div>';
                }
            }
            $contenidoPrincipal.= '</div>';
        }
   
    } else{
        $contenidoPrincipal .=<<<EOS
        <p>Debes estar logeado para poder chatear con los usuarios.</p>
        EOS;
        
    }
    require __DIR__.'/includes/comun/layout.php';
?>