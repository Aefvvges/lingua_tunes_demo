<?php
namespace app\controllers;
use app\core\Response;

class HomeController {

    public function actionIndex() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['id'])) {
            Response::render('home', 'inicio'); // vista de inicio para usuario logueado
        } else {
            Response::redirect('index.php?url=sesion/login'); // redirigir al login
        }
    }

    public function actionError() {
        Response::render('home', 'error'); // opcional
    }
}
