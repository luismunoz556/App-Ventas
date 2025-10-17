<?php 

namespace Controller;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login');
    }

    public static function logout() {
        echo "Desde el LogoutController";
    }

    public static function olvidePassword(Router $router) {
        $router->render('auth/olvide-password',
    []
    );
    }

    public static function recuperarPassword() {
        echo "Desde el RecuperarPasswordController";
    }

    public static function crearCuenta(Router $router) {
        $router->render('auth/crear-cuenta',
        [

        ]        
    
    );
    }
}