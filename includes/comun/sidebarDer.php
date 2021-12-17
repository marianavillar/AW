<aside id="sidebarDer">
	<h4>Panel de usuario</h4>
	<div id="editarPerfil">
		<ul>
			<?php
				$raizApp = RUTA_APP;
				if(esAdmin()){
					echo '<li><a href="'.$raizApp.'/admin.php">Administrar</a></li>';
				}
			?>
			
			<li><a href="<?= RUTA_APP?>/perfilUsuario.php?user=<?=$_SESSION["nombre"]?>">Perfil</a></li>
			<li><a href="<?= RUTA_APP?>/editarPerfil.php">Configuración</a></li>
			<li><a href="<?= RUTA_APP?>/ServiciosEnCursoVista.php">Servicios</a></li>
			<li><a href="<?= RUTA_APP?>/logout.php">Salir</a></li>
		</ul>
	</div>
</aside>