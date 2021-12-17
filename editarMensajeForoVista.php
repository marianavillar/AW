<?php
    require_once __DIR__.'/includes/config.php';
    require_once __DIR__.'/includes/autorizacion.php';


    use es\ucm\fdi\aw\foro\FormularioMensajeForoEditar;
    
    $tituloPagina = 'Editar comentario';
    $raizApp = RUTA_APP;

    $idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $formularioMensajeEditar = new  FormularioMensajeForoEditar($idMensaje);
    $gestionaFormularioMensajeEditar = $formularioMensajeEditar->gestiona();

    $contenidoPrincipal= <<<EOS
        $gestionaFormularioMensajeEditar
    EOS;

require __DIR__.'/includes/comun/layout.php';