<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';


$raizApp = RUTA_APP;
$tituloPagina = 'Admin';

$contenidoPrincipal='';

if (esAdmin()) {
	$contenidoPrincipal=<<<EOS
		<div id='administrarLista' class="pill-nav">
		<a id='administrarLista' href='${raizApp}/registrarCategoriaVista.php'>Crear una categoría</a>
		<a id='administrarLista' href='${raizApp}/EliminarResena.php'>Eliminar una reseña</a>
		<a id='administrarLista' href='${raizApp}/editarRoles.php'>Editar un rol</a>
		<a id='administrarLista' href='${raizApp}/verRoles.php'>Ver roles</a>
		</div>
	EOS;
} else {
	$contenidoPrincipal='<h1> Error </h1>
		<p1> No tienes permisos suficientes. </p1>';
}

require __DIR__.'/includes/comun/layout.php';

