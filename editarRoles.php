<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\usuarios\FormularioRolOtorgar;
use es\ucm\fdi\aw\usuarios\FormularioRolQuitar;

$tituloPagina = 'Editar Roles';
$raizApp = RUTA_APP;
if(esAdmin()){
	$contenidoPrincipal=<<<EOS
		<div id='administrarLista' class="pill-nav">
		<a id='administrarLista'  href='${raizApp}/registrarCategoriaVista.php'>Crear una categoría</a>
		<a id='administrarLista'  href='${raizApp}/EliminarResena.php'>Eliminar una reseña</a>
		<a id='administrarLista' class="active" href='${raizApp}/editarRoles.php'>Editar un rol</a>
		<a id='administrarLista' href='${raizApp}/verRoles.php'>Ver roles</a>
		</div>
	EOS;
	$formOtorgar = new FormularioRolOtorgar();
	$contenidoPrincipal.=$formOtorgar->gestiona();
	$formQuitar = new FormularioRolQuitar();
	$contenidoPrincipal.=$formQuitar->gestiona();
}
else{
	$contenidoPrincipal = <<<EOS
		<h1>Error</h1>
		<p>Necesitas estar logueado como administrador para administrar los roles.</p>
	EOS;
}
require __DIR__.'/includes/comun/layout.php';
?>