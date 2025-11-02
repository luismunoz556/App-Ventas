<?php 

namespace Controller;

use MVC\Router;
use Model\Ventas;
use Model\VentasDet;
use Model\Cliente;
use Model\Productos;

class VentasController {
    public static function ventas(Router $router) {
        $ventas = Ventas::allConCliente();
        //debuguear($ventas);
        $router->render('ventas/index', 
        [
            'ventas' => $ventas
        ]);
    }

    public static function crearVenta(Router $router) {
        $venta = new Ventas();
        $errores = [];
        
        // Obtener clientes y productos para el formulario
        $clientes = Cliente::all();
        $productos = Productos::all();
        
        // Si es POST, procesar el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $_POST['id_usu'] = $_SESSION['id'] ?? '';
            
            // Si no tiene fecha, asignar fecha actual
            if(empty($_POST['fecha'])) {
                $_POST['fecha'] = date('Y-m-d');
            }
            
            // Sincronizar datos del encabezado
            $venta->sincronizar($_POST);
            
            // Validar venta usando el modelo
            $alertasVenta = $venta->validar();
            $errores = $alertasVenta['error'] ?? [];
            
            // Validar detalles de productos
            $detalles = $_POST['detalles'] ?? [];
            
            if(empty($detalles) || !is_array($detalles)) {
                $errores[] = 'Debe agregar al menos un producto al pedido';
            } else {
                // Validar cada detalle usando el modelo
                $totalCalculado = 0;
                foreach($detalles as $index => $detalle) {
                    $ventaDet = new VentasDet();
                    $ventaDet->sincronizar($detalle);
                    $alertasDet = $ventaDet->validar();
                    
                    if(!empty($alertasDet['error'])) {
                        foreach($alertasDet['error'] as $errorDet) {
                            $errores[] = "Producto #" . ($index + 1) . ": " . $errorDet;
                        }
                    } else {
                        // Si la validación pasa, calcular subtotal
                        $cantidad = floatval($detalle['cantidad'] ?? 0);
                        $precio = floatval($detalle['precio'] ?? 0);
                        $totalCalculado += ($cantidad * $precio);
                    }
                }
                
                // Actualizar el total calculado
                $venta->total = $totalCalculado;
            }
            
            // Si no hay errores, guardar
            if(empty($errores)) {
                // Guardar la venta (encabezado)
                $resultado = $venta->guardar();
                
                if($resultado['resultado']) {
                    $idVenta = $resultado['id'];
                    
                    // Guardar los detalles usando el método guardar() del modelo
                    $detallesGuardados = 0;
                    
                    foreach($detalles as $detalle) {
                        $ventaDet = new VentasDet();
                        
                        // Establecer el id de la venta como FK (el campo id en ventas_det es el FK a ventas)
                        $ventaDet->id = $idVenta;
                        $ventaDet->id_prod = intval($detalle['id_prod']);
                        $ventaDet->cantidad = floatval($detalle['cantidad']);
                        $ventaDet->precio = floatval($detalle['precio']);
                        
                        // Guardar el detalle usando el método guardar()
                        // El modelo VentasDet tiene sobrescrito guardar() para crear cuando id es FK
                        $resultadoDet = $ventaDet->guardar();
                        
                        if($resultadoDet['resultado']) {
                            $detallesGuardados++;
                        }
                    }
                    
                    if($detallesGuardados > 0) {
                        header('Location: /ventas?creado=1');
                        return;
                    } else {
                        $errores[] = 'Error al guardar los detalles de la venta';
                    }
                } else {
                    $errores[] = 'Error al crear la venta';
                }
            }
        }
        
        $router->render('ventas/crear', [
            'venta' => $venta,
            'clientes' => $clientes,
            'productos' => $productos,
            'errores' => $errores
        ]);
    }

    public static function verVenta(Router $router) {
        $id = $_GET['id'] ?? null;
        
        if(!$id) {
            header('Location: /ventas');
            return;
        }
        
        // Obtener la venta
        $venta = Ventas::find($id);
        
        if(!$venta) {
            header('Location: /ventas');
            return;
        }
        
        // Obtener el cliente y detalles usando los métodos del modelo
        $cliente = $venta->obtenerCliente();
        $detalles = $venta->obtenerDetalles(); 
        
        $router->render('ventas/ver', [
            'venta' => $venta,
            'cliente' => $cliente,
            'detalles' => $detalles
        ]);
    }
}