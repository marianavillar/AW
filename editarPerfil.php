<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\FormularioEditarPerfil;
use es\ucm\fdi\aw\usuarios\FormularioEditarCuenta;
$raizApp = RUTA_APP;
$tituloPagina = 'Edición del perfil';
$contenidoPrincipal = '';
$contenidoPrincipal.= <<<EOS
        <h3>Configuracion</h3>
        <div id='configuracionLista' class="pill-nav">
        <a href='${raizApp}/editarPerfil.php' class="active">Perfil</a>
        <a href='${raizApp}/registrarServicioVista.php''>Servicio</a>
        <a href='${raizApp}/darDeBaja.php'>Eliminar cuenta</a>
        </div>
        <a id="redirectEditarPerfil" class="blueButton" href="#formEditarPerfil">Editar perfil</a>
        <a id="redirectEditarCuenta" class="blueButton" href="#formEditarCuenta">Editar cuenta</a>
    
EOS;
$contenidoPrincipal.='<div class="contenedorEditarPerfil">';

$form = new FormularioEditarPerfil();
$contenidoPrincipal.=$form->gestiona();

$form = new FormularioEditarCuenta();
$contenidoPrincipal.=$form->gestiona();

$contenidoPrincipal.='</div>';


require __DIR__.'/includes/comun/layout.php';