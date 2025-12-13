<?php
namespace app\controllers;

use app\models\AlbumModel;
use \Controller;
use \Response;
use app\controllers\SiteController;

class AlbumController extends Controller {

    // listar albumes
    public function actionIndex($var = null) {
        $albumes = AlbumModel::all();

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $path = self::path();

        Response::render("albumes", "index", [
            'title' => 'Álbumes',
            'head' => $head,
            'header' => $header,
            'footer' => $footer,
            'path' => $path,
            'albumes' => $albumes
        ]);
    }

    // mostrar album y sus canciones
    public function actionShow($id = null, $var = null) {

        if (!$id) {
            $this->action404();
            return;
        }

        $album = AlbumModel::find($id);

        if (!$album) {
            $this->action404();
            return;
        }

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $path = self::path();

        Response::render("albumes", "show", [
            'title' => $album->titulo,
            'head' => $head,
            'header' => $header,
            'footer' => $footer,
            'path' => $path,
            'album' => $album,
            'canciones' => $album->canciones
        ]);
    }
}
