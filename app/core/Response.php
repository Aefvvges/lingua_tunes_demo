<?php
class Response
{
    private function __construct() {}

    public static function render($viewDir, $view, $vars = [])
    {
        // Validar y asignar variables dinámicamente
        foreach ($vars as $key => $value) {
            if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                $$key = $value;
            }
        }

        $viewPath = APP_PATH . "views/" . $viewDir . '/' . $view . '.php';

        // Verificar si la vista existe
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new Exception("La vista $view no se encuentra en el directorio $viewDir");
        }
    }
}
