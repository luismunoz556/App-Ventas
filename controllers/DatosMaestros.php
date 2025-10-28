<?php 

namespace Controller;

use MVC\Router;

class DatosMaestros {
    public static function index(Router $router) {
        $router->render('Maestros/index', []);
    }
}