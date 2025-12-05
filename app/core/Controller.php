<?php
class Controller
{
    protected $title = 'MVC Proyecto | ';
    public static $ruta;

    public function actionIndex($var = null){
        $this->action404();
    }
    public static function path() {
        $reemplazar = str_replace('url=', '', $_SERVER['QUERY_STRING']);
        $camino = str_replace($reemplazar, '', $_SERVER['REQUEST_URI']);
        self::$ruta = $camino;
        return self::$ruta;
    }
    protected function viewDir($nameSpace){
        $replace = array($nameSpace,'Controller');
        $viewDir = str_replace($replace , '', get_class($this)).'/';
        $viewDir = str_replace('\\', '', $viewDir);
        $viewDir = strtolower($viewDir);
        return $viewDir;
    }
    public function action404(){
        static::path();
        if (class_exists('Response')){
            Response::render('errors', '404');
        } else {
            header ('Location:' . self::$ruta . '404');
        }
        exit;
    }
    // Genera un token de seguridad
    public static function generarToken($longitud = 32)
    {
        return bin2hex(random_bytes($longitud));
    }
    protected static function tokenSeguro($longitud = 25)
    {
        return self::generarToken($longitud);
    }    
}
