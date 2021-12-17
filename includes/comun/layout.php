<?php

require_once __DIR__.'/../autorizacion.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="<?= RUTA_CSS.'/estilo.css'?>" />
	<link rel="stylesheet" type="text/css"  href="<?= RUTA_CSS.'/estilosMovil.css'?>" />
	<link rel="shortcut icon" type="image/jpg" href="<?= RUTA_IMGS.'/logotipo.png'?>"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script type="text/javascript" src="<?= RUTA_JS.'/scripts.js'?>"></script>

	<title><?= $tituloPagina ?></title>
</head>
<body>
<div id="contenedor">
<?php

require(__DIR__.'/cabecera.php');
require(__DIR__.'/menuPrincipal.php');

?>
<main>
	<article>
		<?= $contenidoPrincipal ?>
	</article>
</main>
<?php

if(estaLogado()){
	require(__DIR__.'/sidebarDer.php');
}

require(__DIR__.'/pie.php');

?>
</div>
</body>
</html>