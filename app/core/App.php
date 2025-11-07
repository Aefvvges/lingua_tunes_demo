<?php
namespace app\core;

class App
{
    protected $controller = "app\\controllers\\HomeController";
    protected $method = "actionIndex";
    protected $params = [];

    public function __construct()
    {
        $this->parseUrl();
    }

    protected function parseUrl()
    {
        // Tomar la URL (por ejemplo: ?url=sesion/login)
        $url = $_GET['url'] ?? '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        // Controlador (si existe)
        if (!empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerPath = "app\\controllers\\" . $controllerName;

            if (class_exists($controllerPath)) {
                $this->controller = $controllerPath;
                unset($url[0]);
            }
        }

        // Instanciar el controlador
        $this->controller = new $this->controller;

        // Método (si existe)
        if (isset($url[1])) {
            $methodName = 'action' . ucfirst($url[1]);
            if (method_exists($this->controller, $methodName)) {
                $this->method = $methodName;
                unset($url[1]);
            }
        }

        // Parámetros restantes
        $this->params = $url ? array_values($url) : [];
    }

    public function ejecutar()
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
