<?php
namespace app\core;

class Autoloader {
    public static function register() {
        spl_autoload_register(function($class) {
            // Solo cargamos clases del namespace "app"
            if (strpos($class, 'app\\') === 0) {
                // Quitamos "app\" y convertimos \ en /
                $relativeClass = substr($class, 4);
                $file = realpath(__DIR__ . '/../') . '/' . str_replace('\\', '/', $relativeClass) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                } else {
                    echo "<p style='color:red'>No se encontró el archivo para la clase: $class<br>Ruta buscada: $file</p>";
                    die();
                }
            }
        });
    }
}
