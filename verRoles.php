<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\Rol;

$tituloPagina = 'Roles Usuario';
$raizApp = RUTA_APP;
$contenidoPrincipal=<<<EOS
    <div id='administrarLista' class="pill-nav">
    <a id='administrarLista'  href='${raizApp}/registrarCategoriaVista.php'>Crear una categoría</a>
    <a id='administrarLista'  href='${raizApp}/EliminarResena.php'>Eliminar una reseña</a>
    <a id='administrarLista' href='${raizApp}/editarRoles.php'>Editar un rol</a>
    <a id='administrarLista'  class="active"  href='${raizApp}/verRoles.php'>Ver roles</a>
    </div>
EOS;
$contenidoPrincipal.= '<h3>Roles </h3>';

$listaRolesUsuario =  Rol::devolverListaRolesUsuario();

$contenidoPrincipal.= '<div class="flex-container-tablon-roles">';

foreach($listaRolesUsuario as $rolesUsuario){
    $nombre = $rolesUsuario["USUARIO"];
    $rolUser = $rolesUsuario["ROL"]["USER"] == 1? "USER" : " ";
    $rolAdmin = $rolesUsuario["ROL"]["ADMIN"] == 1? "ADMIN" : " ";

    $contenidoPrincipal .= '
        <div class="cartaRol">
            <div id="contenedorNombreRol">
                <span id="nombreRol">' .  $nombre 		  .  '</span>
            </div>
            <div id="contenedorInfoRol">
                <span id="userRol">'   .  $rolUser       .  '</span>
                <span id="adminRol">'  .  $rolAdmin      .  '</span>
            </div>
        </div>';
}

$contenidoPrincipal .= '</div>';

require __DIR__.'/includes/comun/layout.php';