<?php 

namespace Controller;

use Model\Usuario;
use MVC\Router;
use Classes\Email;
class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD']==='POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario) {
                    if($usuario->comprobarPasswordConfirmado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        if($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /principal');
                        }
                        else{
                            header('Location: /principal');
                        }
                    }
                }
                else{
                    Usuario::setAlerta('error', 'Usuario No Encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',
        [
            'alertas' => $alertas,
            'auth' => $auth
        ]
    );
    }

    public static function logout() {
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvidePassword(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $auth->validarEmail();
            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1") {
                     $usuario->generarToken();
                     $usuario->guardar();
                     $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                     $email->enviarInstrucciones();
                     Usuario::setAlerta('exito', 'Hemos Enviado Instrucciones a tu Email');
                }
                else{
                    Usuario::setAlerta('error', 'Usuario No Encontrado o No Confirmado');
                }
            }

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',
    [
        'alertas' => $alertas
    ]
    );
    }

    public static function recuperarPassword(Router $router) {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']??'');
        if (!empty($token)) {
        $usuario = Usuario::where('token', $token);
        //debuguear($usuario);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
             $error = true;
        }
    }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $usuario->$_POST['usuario'];
            $alertas = $password->validarPassword();
            if(empty($alertas)) {
                $usuario->password = '';
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = "";
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }

    
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',
        [
            'alertas' => $alertas,
            'error' => $error,
            'usuario' => $usuario


        ]
        );
        
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
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    $res = $usuario->guardar();
                    if($res) {
                        header('Location: /mensaje');
                    }
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

    public static function confirmarCuenta(Router $router) {
       $alertas = [];
       $token = s($_GET['token']);
       $usuario = Usuario::where('token', $token);
       if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
       }
       else{
           $usuario->confirmado = "1";
           $usuario->token ="";
           $usuario->guardar();
           Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
           
       }
       $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',
        [
            'alertas' => $alertas
        ]
        );
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje',
        []
        );
    }
}


