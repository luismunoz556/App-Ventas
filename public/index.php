<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\VentasController;
use Controller\DatosMaestros;
use Controller\LoginController;
use Controller\PaginaPrincipal;
use Controller\EntradasController;
use Controller\KardexController;


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
$router->get('/maestros/clientes/editar', [DatosMaestros::class, 'editarCliente']);
$router->post('/maestros/clientes/editar', [DatosMaestros::class, 'editarCliente']);
$router->post('/maestros/clientes/eliminar', [DatosMaestros::class, 'eliminarCliente']);
$router->get('/maestros/clientes/ver', [DatosMaestros::class, 'verCliente']);

// Ventas
$router->get('/ventas', [VentasController::class, 'ventas']);
$router->get('/ventas/crear', [VentasController::class, 'crearVenta']);
$router->post('/ventas/crear', [VentasController::class, 'crearVenta']);
$router->get('/ventas/ver', [VentasController::class, 'verVenta']);
$router->get('/ventas/editar', [VentasController::class, 'editarVenta']);
$router->post('/ventas/editar', [VentasController::class, 'editarVenta']);
$router->post('/ventas/eliminar', [VentasController::class, 'eliminarVenta']);

//Entradas de Productos
$router->get('/entradas-productos', [EntradasController::class, 'entradasProductos']);
$router->get('/entradas-productos/crear', [EntradasController::class, 'crearEntradaProducto']);
$router->post('/entradas-productos/crear', [EntradasController::class, 'crearEntradaProducto']);
$router->get('/entradas-productos/editar', [EntradasController::class, 'editarEntradaProducto']);
$router->post('/entradas-productos/editar', [EntradasController::class, 'editarEntradaProducto']);
$router->post('/entradas-productos/eliminar', [EntradasController::class, 'eliminarEntradaProducto']);

// Kardex
$router->get('/kardex', [KardexController::class, 'index']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

