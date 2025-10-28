<?php 

namespace Controller;

use MVC\Router;

class PaginaPrincipal {
    public static function index(Router $router) {
        $router->render('paginas/index', []);
    }

    
}