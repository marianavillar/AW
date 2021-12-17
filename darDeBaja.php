<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\FormularioDarDeBaja;
$raizApp = RUTA_APP;
$tituloPagina = 'Eliminar cuenta de usuario';
$contenidoPrincipal = <<<EOS
    <h3>Configuracion</h3>
    <div id='configuracionLista' class="pill-nav">
    <a href='${raizApp}/editarPerfil.php' >Perfil</a>
    <a href='${raizApp}/registrarServicioVista.php'' >Servicio</a>
    <a href='${raizApp}/darDeBaja.php' class="active">Eliminar cuenta</a>
    </div>
EOS;
$form = new FormularioDarDeBaja();
$contenidoPrincipal.=$form->gestiona();


require __DIR__.'/includes/comun/layout.php';