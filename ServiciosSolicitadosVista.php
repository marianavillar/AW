<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';


use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\servicios\Servicio;
use es\ucm\fdi\aw\servicios\Categoria;
use es\ucm\fdi\aw\contrataciones\Contratacion;
use es\ucm\fdi\aw\contrataciones\FormularioAceptarContratacion;
use es\ucm\fdi\aw\contrataciones\FormularioRechazarContratacion;

$tituloPagina = 'Mis Servicios Solicitados';
$raizApp = RUTA_APP;

$contenidoPrincipal =<<<EOS
    <h3>Servicios</h3>
    <div id='misServiciosLista' class="pill-nav">
    <a href='${raizApp}/ServiciosEnCursoVista.php' > En Curso     </a>
    <a href='${raizApp}/ServiciosFinalizadosVista.php'>Finalizados  </a>
    <a href='${raizApp}/ServiciosRechazadosVista.php' >Rechazados   </a>
    <a href='${raizApp}/ServiciosSolicitadosVista.php' class="active">Pendientes</a>
    </div>
EOS;

$idUsuario = idUsuarioLogado();

$listaSolicitados = Contratacion::devuelveSolicitudes($idUsuario);

$contenidoPrincipal .= '<p>Listado con todos los servicios que otros usuarios te han solicitado.</p>';
$contenidoPrincipal .= '<div class="flex-container-tablon-mis-servicios">';

if($listaSolicitados != false){
    foreach($listaSolicitados as $contratacion){

        $servicio = Servicio::buscaPorId($contratacion->getIdServicio());

        $usuario = Usuario::buscaPorId($contratacion->getIdUsuarioSolicita());
        $username = $usuario->username();
        $strUsuarioOfer = '<a href="'.$raizApp.'/perfilUsuario.php?user='.$username.'"><i class="material-icons md-24">person</i>'.$username.'</a>';

        $categoria = Categoria::buscaPorId($servicio->getCategoria());

        $idContratacion = $contratacion->getId();

        $formularioAceptarContratacion = new  FormularioAceptarContratacion($idContratacion);
        $gestionaFormularioAceptarContratacion = $formularioAceptarContratacion->gestiona();
    
        $formularioRechazarContratacion = new  es\ucm\fdi\aw\contrataciones\FormularioRechazarContratacion($idContratacion);
        $gestionaFormularioRechazarContratacion = $formularioRechazarContratacion->gestiona();

        $contenidoPrincipal .= '
            <div class="cartaForo">
            <p id="tituloServicios">'.$servicio->getTitulo().'</p>
            <div id="ofertanteServicio"><p id="descripcionServicios">Contratante:'.$strUsuarioOfer .'</p></div>
            <p id="categoríaMisServicios">'.$categoria->getNombre().', Fecha Solicitud:'.$contratacion->getFechaSolicitud().'</p>
            <div class="btnGroup">
            <div><p id="descripcionServicios">' . $gestionaFormularioAceptarContratacion.'</p></div>
            <div><p id="descripcionServicios">' . $gestionaFormularioRechazarContratacion.'</p></div>
            </div>
            </div>';
    }
}
$contenidoPrincipal .= '</div>';

require __DIR__.'/includes/comun/layout.php';