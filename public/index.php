<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\LoginController;

$router = new Router();
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar Password
$router->get('/olvide-password', [LoginController::class, 'olvidePassword']);
$router->post('/olvide-password', [LoginController::class, 'olvidePassword']);
$router->get('/recuperar-password', [LoginController::class, 'recuperarPassword']);
$router->post('/recuperar-password', [LoginController::class, 'recuperarPassword']);

// Crear Cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crearCuenta']);
$router->post('/crear-cuenta', [LoginController::class, 'crearCuenta']);





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();