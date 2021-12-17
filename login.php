<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\FormularioLogin;

$tituloPagina = 'Login';

$form = new FormularioLogin();
$contenidoPrincipal=$form->gestiona();


require __DIR__.'/includes/comun/layout.php';