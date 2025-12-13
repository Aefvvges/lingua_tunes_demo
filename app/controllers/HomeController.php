<?php
namespace app\controllers;

use app\models\MusicModel;
use \Controller;
use \Response;
use \DataBase;

class HomeController extends Controller
{
    // Constructor
    public function __construct() {
        // Aquí podrías inicializar sesiones si querés
    }

    // Página principal (puede ser un saludo simple)
    public function actionIndex($id = null){
        $canciones = MusicModel::all();

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $path = static::path();

        if (isset($_SESSION['id'])) {
            Response::render($this->viewDir(__NAMESPACE__), "inicio", [
                'title' => 'Inicio',
                'head'  => $head,
                'header' => $header,
                'footer' => $footer,
                'canciones' => $canciones,
                'path' => $path,
            ]);
        } else {
            Response::render('user', 'login', [
                'title'   => 'Iniciar sesión',
                'head'    => $head,
                'path'    => $path
            ]);
        }
    }


    // Página "Acerca de"
    public function actionAbout(){
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $path = static::path();
        Response::render($this->viewDir(__NAMESPACE__), "about", [
            'title' => 'Acerca de',
            'head'  => $head,
            'header' => $header,
            'footer' => $footer,
            'path' => $path
        ]);
    }

    // Error 404
    public function action404(){
        $head = SiteController::head();
        Response::render("errors/", "404", [
            'title' => $this->title.' 404',
            'head'  => $head,
        ]);
    }
}
