<?php
// Definir rutas base
define('ROOT_PATH', dirname(__DIR__) . '/');   // carpeta "app" principal
define('APP_PATH', ROOT_PATH . 'app');         // apuntar directamente a /app
define('CORE_PATH', APP_PATH . '/core');          // núcleo del framework
define('BASE_URL', '/lingua_tunes_demo/public/');  // ajustar según tu carpeta public

// Cargar el autoloader
require_once CORE_PATH . '/Autoloader.php';

// Registrar autoload
\app\core\Autoloader::register();

// Cargar clase App
use app\core\App;

// Ejecutar la aplicación
$app = new App();
$app->ejecutar();
?>