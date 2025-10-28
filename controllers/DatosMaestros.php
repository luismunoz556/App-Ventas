<?php 

namespace Controller;

use MVC\Router;
use Model\Productos;

class DatosMaestros {
    public static function index(Router $router) {
        $router->render('maestros/index', []);
    }

    public static function clientes(Router $router) {
        $router->render('maestros/clientes', []);
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
            'errores' => $errores
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
            $errores = $producto->validar();
            
            if(empty($errores)) {
                $producto->guardar();
                header('Location: /maestros/productos');
                return;
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
            $id = $_POST['id'] ?? '';
            $producto = Productos::find($id);
            
            if($producto) {
                $producto->eliminar();
            }
        }
        
        header('Location: /maestros/productos');
    }
}