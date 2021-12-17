<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/autorizacion.php';

$raizApp = RUTA_APP;
$tituloPagina = 'Sobre Nosotros';

$contenidoPrincipal='';
$contenidoPrincipal=<<<EOS
    <h1>Sobre Nosotros</h1>
        <h2>Componentes : </h2>

        <h3 id = "Gabriel"> Gabriel Emilio Lugo Estevez </h3>
        <img src="img/Gabriel.jpg" 
            alt="Gabriel Emilio Lugo Estevez" 
            width="118"
            height="139"/>
        <p> Hola soy Gabriel, estoy realizando el grado en ingeniería de computadores en la Universidad Complutense de Madrid, soy desarrollador fullstack en Java y me gustan los deportes.  Mi correo electrónico es: glugo@ucm.es.</p>

        <h3 id = "Cintia"> Cintia Maria Herrera Arenas </h3>
        <img src="img/Cintia.jpg"  
            alt="Cintia Maria Herrera Arenas" 
            width="118"
            height="139"/>
        <p> Hola soy Cintia. Estudio ingeniería de comptadores en la UCM. Mis aficiones son ver películas y jugar videojuegos. Mi correo electrónico es: cintiamh@ucm.es. </p>

        <h3 id = "Victor"> Victor Martínez Alcón </h3>
        <img src="img/Victor.jpg" 
            alt="Victor Martínez Alcón" 
            width="118"
            height="139"/>
        <p> Hola soy Victor , actualmente estoy estudiando en la UCM el grado de Ingenieria Informática . Entre mis principales aficiones están programar, ver peliculas 
            y series, leer y jugar a videojuegos. Mi correo de contaco es : victma08@ucm.es

        </p>
        <h3 id = "Mariana"> Mariana Villar Rojas</h3> 
        <img src="img/Mariana.jpg" 
            alt="Mariana Villar Rojas" 
            width="118"
            height="139"/>
        <p> Hola soy Mariana, estoy estudiando la carrera de Ingeniería Informática en la UCM. Mis intereses principales relacionados con la
            carrera son las redes y la seguridad, así como la programación de páginas web. En mi tiempo libre me gusta salir, ver series y películas, y relajarme con mi familia y amigos. 
            Mi correo de contaco es: marivi09@ucm.es </p>

        <h3 id = "Michelle"> Michelle Benacir Guerra Gallegos</h3>
        <img src="img/Michelle.jpg" 
            alt="Michelle Benacir Guerra Gallegos" 
            width="118"
            height="139"/>
        <p> Hola soy Michelle, estudiante de Ingeniería Informática en la Universidad Complutense de Madrid. Cuando no estoy con el ordenador, en mi tiempo libre me 
            gusta aprovechar para salir hacer deporte al aire libre, ya sea en bici o paseando por la montaña. Otras de mis aficiones son leer, hacer sudokus, bailar, cocinar algun postre o simplemente
            ver una película. Mi correo: micgue01@ucm.es</p>

        <h3 id = "David"> David Stetco</h3>
        <img src="img/David.jpg" 
            alt="David Stetco" 
            width="118"
            height="139"/>
        <p> Hola me llamo David, me encuentro cursando la carrera de Ingeniería Informática en la Universidad Complutense de Madrid. Mis pasatiempos son, entre otras cosas,
            programar, ver series y los videojuegos. Mi correo de contacto es: davidste@ucm.es </p>


EOS;
require __DIR__.'/includes/comun/layout.php';