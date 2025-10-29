<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\LoginController;
use Controller\PaginaPrincipal;
use Controller\DatosMaestros;


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

// Confirmar Cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmarCuenta']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

// Pagina Principal
$router->get('/principal', [PaginaPrincipal::class, 'index']);

//Ingreso de Datos Maestros
$router->get('/datos-maestros', [DatosMaestros::class, 'index']);

// Datos Maestros
$router->get('/maestros', [DatosMaestros::class, 'index']);
$router->get('/maestros/clientes', [DatosMaestros::class, 'clientes']);

// Maestros - Productos
$router->get('/maestros/productos', [DatosMaestros::class, 'productos']);
$router->get('/maestros/productos/ver', [DatosMaestros::class, 'verProducto']);
$router->get('/maestros/productos/crear', [DatosMaestros::class, 'crearProducto']);
$router->post('/maestros/productos/crear', [DatosMaestros::class, 'crearProducto']);
$router->get('/maestros/productos/editar', [DatosMaestros::class, 'editarProducto']);
$router->post('/maestros/productos/editar', [DatosMaestros::class, 'editarProducto']);
$router->post('/maestros/productos/eliminar', [DatosMaestros::class, 'eliminarProducto']);

// Maestros - Clientes
$router->get('/maestros/clientes/crear', [DatosMaestros::class, 'crearCliente']);
$router->post('/maestros/clientes/crear', [DatosMaestros::class, 'crearCliente']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

