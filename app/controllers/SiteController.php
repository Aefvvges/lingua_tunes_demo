<?php 
namespace app\controllers;

use \Controller;

class SiteController extends Controller
{
    public static function head()
    {
        $head = file_get_contents(APP_PATH . '/views/inc/head.php');
        return str_replace('#PATH#', self::$ruta, $head);
    }

    public static function header()
    {
        $header = file_get_contents(APP_PATH . '/views/inc/header.php');
        return str_replace('#PATH#', self::$ruta, $header);
    }

    public static function footer()
    {
        $footer = file_get_contents(APP_PATH . '/views/inc/footer.php');
        return str_replace('#PATH#', self::$ruta, $footer);
    }
}
