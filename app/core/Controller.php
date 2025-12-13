<?php
class Controller
{
    protected $title = 'MVC Proyecto | ';
    public static $ruta = '/lingua_tunes_demo/'; 

    public function actionIndex($var = null)
    {
        $this->action404();
    }

    // Ruta base del proyecto
    public static function path() {
        return self::$ruta;
    }

    // Directorio de la vista
    protected function viewDir($nameSpace)
    {
        $replace = array($nameSpace, 'Controller');
        $viewDir = str_replace($replace, '', get_class($this)) . '/';
        $viewDir = str_replace('\\', '', $viewDir);
        return strtolower($viewDir);
    }

    // Error 404
    public function action404()
    {
        if (class_exists('Response')) {
            Response::render('errors', '404');
        } else {
            header('Location:' . self::$ruta . '404');
        }
        exit;
    }

    // Token de seguridad
    public static function generarToken($longitud = 32)
    {
        return bin2hex(random_bytes($longitud));
    }

    protected static function tokenSeguro($longitud = 25)
    {
        return self::generarToken($longitud);
    }    
}
