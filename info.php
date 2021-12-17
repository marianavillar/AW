<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Servitrade';

$contenidoPrincipal=<<<EOS

<div class="flex-container-tablon-servicios">
	<h3 class="bienvenida">Bienvenidos a Servitrade!</h3>
	<p class="info"> 
	ServiTrade es una tienda virtual de servicios, donde podrás encontrar cualquier tipo de servicio que 
	puedas necesitar en tu día a día: servicios de electricistas, informáticos, fontaneros, contables, etc. 
	Lo mejor de nuestra tienda, es que no necesitarás dinero para contratar servicios, sino que
	podrás pagarlos con servicios que puedas ofrecer al resto de los usuarios de la plataforma. 
	</p>
	<div class="container-ul"> 
	<ol id="lista2">
    <li>Para empezar regístrate como usuario si no lo has hecho antes</li>
    <li>También registra el servicio que vas a ofrecer: Fontanería, Informática, Transporte...</li>
    <li>Como bienvenida te damos 1 cupón en tu monedero para poder canjear un servicio de los disponibles.</li>
    <li>Puedes chatear con el usuario al que has solicitado el servicio y concretar horarios.</li>
    <li>Una vez hayas recibido o relizado un servicio deja tu valoración y una reseña de la experiencia.</li> 
	<li>...Y a disfrutar de nuevos servicios.</li> </div>
	<img src="img/info.jpg" alt="imagen decorativa" id="imgInfo"/>
	</ol>
	
</div>	
EOS;

require __DIR__.'/includes/comun/layout.php';