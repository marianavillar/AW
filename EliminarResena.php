<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\resena\Resena;
use es\ucm\fdi\aw\resena\FormularioEliminarResena;

$tituloPagina = 'Eliminar Reseñas';
$raizApp = RUTA_APP;
if(esAdmin()){
    $listaResenas = Resena::devolverTodasResenas();
    $contenidoPrincipal=<<<EOS
		<div id='administrarLista' class="pill-nav">
		<a id='administrarLista'  href='${raizApp}/registrarCategoriaVista.php'>Crear una categoría</a>
		<a id='administrarLista' class="active" href='${raizApp}/EliminarResena.php'>Eliminar una reseña</a>
		<a id='administrarLista' href='${raizApp}/editarRoles.php'>Editar un rol</a>
		<a id='administrarLista' href='${raizApp}/verRoles.php'>Ver roles</a>
		</div>
	EOS;
    $contenidoPrincipal.='<h3>Reseñas</h3>';
    $contenidoPrincipal .='
        <table style="width:100%">
            <tr>
                <th>Número</th>
                <th>Contratador</th>
                <th>Trabajador</th>
                <th>Puntuación</th>
                <th>Comentario</th>
                <th>Fecha</th>
            </th>';
    foreach($listaResenas as $resena){
        $usuarioCreador = Usuario::buscaPorId($resena->getUsuarioCreador());
        $usuarioValorado = Usuario::buscaPorId($resena->getUsuarioValorado());
        
        $contenidoPrincipal .= '
        <tr>
            <td>' .  $resena->getId()		            .	'</td>
            <td>' .  $usuarioCreador->username() 		.	'</td>
            <td>' .  $usuarioValorado->username() 		.	'</td>
            <td>' .  $resena->getPuntuacion()           . 	'</td>
            <td>' .  $resena->getComentario()           . 	'</td>
            <td>' .  $resena->getFecha()                . 	'</td>
        </tr>';

    }
    $contenidoPrincipal .= '</table>';

	if(count($listaResenas) != 0){
        $formEliminarResena = new FormularioEliminarResena();
	    $contenidoPrincipal .= $formEliminarResena->gestiona();
    }
}else{
	$contenidoPrincipal = <<<EOS
		<h1>Error</h1>
		<p>Necesitas estar logueado como administrador para administrar los roles.</p>
	EOS;
}
require __DIR__.'/includes/comun/layout.php';
?>