<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\servicios\Servicio;
use es\ucm\fdi\aw\servicios\Categoria;
use es\ucm\fdi\aw\contrataciones\Contratacion;

$tituloPagina = 'Mis Servicios Rechazados';
$raizApp = RUTA_APP;

$contenidoPrincipal =<<<EOS
    <h3>Servicios</h3>
    <div id='misServiciosLista' class="pill-nav">
    <a href='${raizApp}/ServiciosEnCursoVista.php' >En Curso     </a>
    <a href='${raizApp}/ServiciosFinalizadosVista.php'>Finalizados  </a>
    <a href='${raizApp}/ServiciosRechazadosVista.php' class="active">Rechazados   </a>
    <a href='${raizApp}/ServiciosSolicitadosVista.php' >Pendientes</a>
    </div>
EOS;

$idUsuario = idUsuarioLogado();

$listaRechazados = Contratacion::devuelveRechazados($idUsuario);

$contenidoPrincipal .= '<p>Listado con los servicios que has solicitado y han sido rechazados por el ofertante.</p>';
$contenidoPrincipal .= '<div class="flex-container-tablon-mis-servicios">';

if($listaRechazados != false){
    foreach($listaRechazados as $contratacion){

        $servicio = Servicio::buscaPorId($contratacion->getIdServicio());

        $usuario = Usuario::buscaPorId($contratacion->getIdUsuarioServicio());
        $username = $usuario->username();

        $strUsuarioOfer = '<a href="'.$raizApp.'/perfilUsuario.php?user='.$username.'"><i class="material-icons md-24">person</i>'.$username.'</a>';
        
        $categoria = Categoria::buscaPorId($servicio->getCategoria());

        $contenidoPrincipal .= '
            <div class="cartaForo">
            <p id="tituloServicios">'.$servicio->getTitulo().'</p>
            <div id="ofertanteServicio"><p id="descripcionServicios">Ofertante:'.$strUsuarioOfer .'</p></div>
            <p id="categoríaMisServicios">'.$categoria->getNombre().', Fecha Solicitud:'.$contratacion->getFechaSolicitud().'</p>
            </div>';
    }
}
$contenidoPrincipal .= '</div>';

require __DIR__.'/includes/comun/layout.php';