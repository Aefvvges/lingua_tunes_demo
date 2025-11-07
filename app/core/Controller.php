<?php
namespace app\core;

use app\core\Response;
class Controller
{
    protected $title = 'MVC Proyecto | ';

    public function actionIndex(){
        $this->action404();
    }
    protected function render($folder, $view, $data = []) {
        Response::render($folder, $view, $data = []);
    }
    public function action404(){
        http_response_code(404);
        Response::render('errors', '404');
        exit;
    }
    // Genera un token de seguridad
    public static function generarToken($longitud = 32)
    {
        return bin2hex(random_bytes($longitud));
    }
}
