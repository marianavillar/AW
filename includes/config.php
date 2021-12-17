<?php
// Varios defines para los parámetros de configuración de acceso a la BD y la URL desde la que se sirve la aplicación

//Descomentar para que funcione en local
define('BD_HOST', 'localhost');
define('RUTA_APP', '/aw/servitrade');

//Descomentar para que funcione en VPS de guacamole
/*define('BD_HOST', 'vm09.db.swarm.test');
define('RUTA_APP', '/servitrade');*/

define('BD_NAME', 'servitrade');
define('BD_USER', 'usuario_servitrade');
define('BD_PASS', 'servi trade1');
define('RUTA_IMGS', RUTA_APP.'/img');
define('RUTA_CSS', RUTA_APP.'/css');
define('RUTA_JS', RUTA_APP.'/js');

/* */
/* Configuración de Codificación */
/* */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

spl_autoload_register(function ($class) {

  // project-specific namespace prefix
  $prefix = 'es\\ucm\\fdi\\aw\\';

  // base directory for the namespace prefix
  $base_dir = __DIR__ .'/';

  // does the class use the namespace prefix?
  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) {
      // no, move to the next registered autoloader
      return;
  }

  // get the relative class name
  $relative_class = substr($class, $len);

  // replace the namespace prefix with the base directory, replace namespace
  // separators with directory separators in the relative class name, append
  // with .php
  $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

  // if the file exists, require it
  if (file_exists($file)) {
      require $file;
  }
});

$app = es\ucm\fdi\aw\Aplicacion::getInstancia();
$datosConexionBD= array('host'=>BD_HOST,'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS);
$app->init($datosConexionBD);

register_shutdown_function(array($app, 'shutdown'));
