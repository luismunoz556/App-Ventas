<?php 

namespace Controller;

use Model\Usuario;
use MVC\Router;
use Classes\Email;
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
        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if(empty($alertas)) {
                //Valida que no exista el usuario
                $usuarioExiste = $usuario->existeUsuario();
                if($usuarioExiste->num_rows) {
                    $alertas = Usuario::getAlertas();
                }
                else {
                    //hashear el password
                    $usuario->hashPassword();

                    //generar un token
                    $usuario->generarToken();
                    //enviar el email
                    $email = new Email($usuario->EMAIL, $usuario->NOMBRE, $usuario->TOKEN);
                    $email->enviarConfirmacion();
            }
            
        }

        }

        $router->render('auth/crear-cuenta',
        [
           'usuario' => $usuario,
           'alertas' => $alertas
        ]        
        );
    }
}


