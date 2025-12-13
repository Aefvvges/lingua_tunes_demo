<?php
namespace app\controllers;

use app\models\ArtistModel;
use \Controller;
use \Response;
use app\controllers\SiteController;

class ArtistController extends Controller {

    public function actionIndex($var = null) {
        $artistas = ArtistModel::all();

        Response::render("artistas", "index", [
            'title' => "Artistas",
            'head' => SiteController::head(),
            'header' => SiteController::header(),
            'footer' => SiteController::footer(),
            'path' => self::path(),
            'artistas' => $artistas
        ]);
    }

    public function actionShow($id = null) {
        if (!$id) return $this->action404();

        $artista = ArtistModel::find($id);
        if (!$artista) return $this->action404();

        Response::render("artistas", "show", [
            'title' => $artista->nombre,
            'head' => SiteController::head(),
            'header' => SiteController::header(),
            'footer' => SiteController::footer(),
            'path' => self::path(),
            'artista' => $artista,
            'albumes' => $artista->albumes
        ]);
    }
}
