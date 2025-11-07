<?php
namespace app\controllers;
use app\core\Response;

class SiteController {

    // Página de inicio público (si HomeController es más de dashboard, este puede ser la portada)
    public function actionIndex() {
        Response::render('site', 'index'); // carpeta site, vista index.php
    }

    // Página de contacto
    public function actionContact() {
        Response::render('site', 'contact'); // carpeta site, vista contact.php
    }

    // Página "Acerca de"
    public function actionAbout() {
        Response::render('site', 'about'); // carpeta site, vista about.php
    }

    // Página de login (si no querés un controlador separado)
    public function actionLogin() {
        Response::render('site', 'login'); // carpeta site, vista login.php
    }

    // Página de registro (opcional)
    public function actionRegister() {
        Response::render('site', 'register'); // carpeta site, vista register.php
    }
}
