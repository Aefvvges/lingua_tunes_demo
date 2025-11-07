<?php
namespace app\core;

class Response
{
    private function __construct() {}

    /**
     * Renderiza una vista con variables
     * @param string $viewDir Carpeta de la vista relativa a /views
     * @param string $view Nombre de la vista (sin .php)
     * @param array $vars Variables a pasar a la vista
     */
    public static function render($viewDir, $view, $vars = [])
    {
        // Validar y asignar variables dinámicamente
        foreach ($vars as $key => $value) {
            if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                $$key = $value;
            }
        }

        // Normalizar rutas
        $viewDir = rtrim($viewDir, '/') . '/';
        $viewPath = APP_PATH . '/views/' . $viewDir . $view . '.php';

        // Verificar si la vista existe
        if (!file_exists($viewPath)) {
            echo "<h3 style='color:red'>Error: no se encontró la vista</h3>";
            echo "<p>Ruta buscada: <strong>$viewPath</strong></p>";
            die();
        }

        require $viewPath;
    }

    /**
     * Redirige a otra ruta
     * @param string $ruta Ruta relativa o absoluta
     */
    public static function redirect($ruta)
    {
        // Si la ruta no es absoluta, agregarle el prefijo base
        if (strpos($ruta, 'http') !== 0) {
            $base = '/lingua_tunes_demo/public';
            $ruta = rtrim($base, '/') . '/' . ltrim($ruta, '/');
        }

        // Debug opcional (podés comentarlo luego)
        // echo "<h3>Redirigiendo a:</h3><p>$ruta</p>";

        header("Location: $ruta");
        exit;
    }
}
