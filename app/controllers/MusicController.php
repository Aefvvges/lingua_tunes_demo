<?php
namespace app\controllers;
use app\models\MusicaModel;
use Response;
use SiteController;

class MusicaController {

    // Mostrar una canción específica
    public function actionShow($id) {
        $cancion = MusicaModel::findCancion($id);
        if (!$cancion) {
            $this->action404();
            return;
        }

        $head = SiteController::head();
        $header = SiteController::header();
        $path = static::path();

        Response::render(__DIR__ . "/../views/musica", "show", [
            'title' => $cancion->cancion,
            'head' => $head,
            'header' => $header,
            'musica' => $cancion,
            'path' => $path
        ]);
    }

    // Mostrar todas las canciones
    public function actionIndex() {
        $canciones = MusicaModel::all();

        $head = SiteController::head();
        $header = SiteController::header();
        $path = static::path();

        Response::render(__DIR__ . "/../views/musica", "index", [
            'title' => 'Todas las canciones',
            'head' => $head,
            'header' => $header,
            'canciones' => $canciones,
            'path' => $path
        ]);
    }

    private function action404() {
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
        exit;
    }
}
