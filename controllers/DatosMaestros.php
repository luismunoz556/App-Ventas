<?php 

namespace Controller;

use MVC\Router;
use Model\Productos;
use Model\Cliente;

class DatosMaestros {
    public static function index(Router $router) {
        $router->render('maestros/index', []);
    }

    public static function clientes(Router $router) {
        $clientes = Cliente::all(); // Obtener todos los clientes
        $router->render('maestros/clientes/index', [
            'clientes' => $clientes
        ]);
    }

    // Vista principal de productos (listado)
    public static function productos(Router $router) {
        $productos = Productos::all(); // Obtener todos los productos
        $router->render('maestros/productos/index', [
            'productos' => $productos
        ]);
    }

    // Ver un producto específico
    public static function verProducto(Router $router) {
        $id = $_GET['id'] ?? '';
        $producto = Productos::find($id);
        if(!$producto) {
            header('Location: /maestros/productos');
            return;
        }
        
        $router->render('maestros/productos/ver', [
            'producto' => $producto
        ]);
    }

    // Formulario para crear producto
    public static function crearProducto(Router $router) {
        $producto = new Productos();
        $errores = [];
        $cantidad = 0;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            $errores = $alertas['error'] ?? [];
            
            if(empty($errores)) {
                $resultado = $producto->guardar();
                if($resultado['resultado']) {
                    header('Location: /maestros/productos?creado=1');
                    return;
                } else {
                    $errores[] = 'Error al crear el producto';
                }
            }
        }
        
        $router->render('maestros/productos/crear', [
            'producto' => $producto,
            'errores' => $errores,
            'cantidad' => $cantidad
        ]);
    }

    // Formulario para editar producto
    public static function editarProducto(Router $router) {
        $id = $_GET['id'] ?? '';
        $producto = Productos::find($id);
        
        if(!$producto) {
            header('Location: /maestros/productos');
            return;
        }
        
        $errores = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            $errores = $alertas['error'] ?? [];
            
            if(empty($errores)) {
                $resultado = $producto->guardar();
                if($resultado) {
                    header('Location: /maestros/productos?editado=1');
                    return;
                } else {
                    $errores[] = 'Error al actualizar el producto';
                }
            }
        }
        
        $router->render('maestros/productos/editar', [
            'producto' => $producto,
            'errores' => $errores
        ]);
    }

    // Eliminar producto
    public static function eliminarProducto(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            debuguear($_POST);
            $id = $_POST['id'] ?? '';
            
            if($id) {
                $producto = Productos::find($id);
                
                if($producto) {
                    $resultado = $producto->eliminar();
                    if($resultado) {
                        header('Location: /maestros/productos?eliminado=1');
                        return;
                    } else {
                        header('Location: /maestros/productos?error=1');
                        return;
                    }
                } else {
                    header('Location: /maestros/productos?error=1');
                    return;
                }
            }
        }
        
        header('Location: /maestros/productos');
    }

    public static function crearCliente(Router $router) {
        $cliente = new Cliente();
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar();
            $errores = $alertas['error'] ?? [];
            
            if(empty($errores)) {
                $resultado = $cliente->guardar();
                if($resultado['resultado']) {
                    header('Location: /maestros/clientes?creado=1');
                    return;
                } else {
                    $errores[] = 'Error al crear el cliente';
                }
            }
        }
        $router->render('maestros/clientes/crear', [
            'cliente' => $cliente,
            'errores' => $errores
        ]);
    }
}