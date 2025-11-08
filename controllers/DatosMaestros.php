<?php 

namespace Controller;

use MVC\Router;
use Model\Productos;
use Model\Cliente;
use Model\ComboDet;

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
        
        // Obtener productos que NO son combos (para seleccionar en combo)
        $todosProductos = Productos::all();
        $productos = array_filter($todosProductos, function($p) {
            return empty($p->escombo) || $p->escombo != 1;
        });
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto->sincronizar($_POST);
            
            // Asegurar que escombo sea 0 o 1
            $producto->escombo = isset($_POST['escombo']) && $_POST['escombo'] == '1' ? 1 : 0;
            
            // Establecer fecha_creacion si es un producto nuevo
            if(empty($producto->id)) {
                $producto->fecha_creacion = date('Y-m-d H:i:s');
            }
            
            $alertas = $producto->validar();
            $errores = $alertas['error'] ?? [];
            
            // Si es combo, validar componentes
            if($producto->escombo == 1) {
                $comboDetalle = $_POST['combo_detalle'] ?? [];
                
                if(empty($comboDetalle) || !is_array($comboDetalle)) {
                    $errores[] = 'Si el producto es un combo, debe tener al menos un producto componente';
                } else {
                    // Validar cada componente del combo (sin id_combo aún, solo validamos datos básicos)
                    foreach($comboDetalle as $index => $detalle) {
                        if(empty($detalle['id_producto']) || !is_numeric($detalle['id_producto'])) {
                            $errores[] = "Componente #" . ($index + 1) . ": El ID del producto es obligatorio";
                        }
                        
                        if(empty($detalle['cantidad']) || !is_numeric($detalle['cantidad']) || floatval($detalle['cantidad']) <= 0) {
                            $errores[] = "Componente #" . ($index + 1) . ": La cantidad debe ser un número mayor a 0";
                        }
                    }
                }
            }
            
            if(empty($errores)) {
                $resultado = $producto->guardar();
                if($resultado['resultado']) {
                    $idProducto = $resultado['id'];
                    
                    // Si es combo, guardar los componentes
                    if($producto->escombo == 1 && !empty($comboDetalle)) {
                        $componentesGuardados = 0;
                        foreach($comboDetalle as $detalle) {
                            $comboDet = new ComboDet();
                            $comboDet->id_combo = $idProducto;
                            $comboDet->id_producto = intval($detalle['id_producto']);
                            $comboDet->cantidad = floatval($detalle['cantidad']);
                            
                            $resultadoDet = $comboDet->guardar();
                            if($resultadoDet['resultado']) {
                                $componentesGuardados++;
                            }
                        }
                        
                        if($componentesGuardados == 0) {
                            $errores[] = 'Error al guardar los componentes del combo';
                        }
                    }
                    
                    if(empty($errores)) {
                        header('Location: /maestros/productos?creado=1');
                        return;
                    }
                } else {
                    $errores[] = 'Error al crear el producto';
                }
            }
        }
        
        $router->render('maestros/productos/crear', [
            'producto' => $producto,
            'errores' => $errores,
            'cantidad' => $cantidad,
            'productos' => $productos
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
        
        // Obtener productos que NO son combos (para seleccionar en combo)
        // Excluir también el producto actual si está editando
        $todosProductos = Productos::all();
        $productos = array_filter($todosProductos, function($p) use ($id) {
            return (empty($p->escombo) || $p->escombo != 1) && $p->id != $id;
        });
        
        // Obtener componentes existentes del combo si es combo
        $componentesExistentes = [];
        if($producto->escombo == 1) {
            $componentesExistentes = ComboDet::obtenerComponentes($producto->id);
        }
        
        $errores = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto->sincronizar($_POST);
            
            // Asegurar que escombo sea 0 o 1
            $producto->escombo = isset($_POST['escombo']) && $_POST['escombo'] == '1' ? 1 : 0;
            
            $alertas = $producto->validar();
            $errores = $alertas['error'] ?? [];
            
            // Si es combo, validar componentes
            if($producto->escombo == 1) {
                $comboDetalle = $_POST['combo_detalle'] ?? [];
                
                if(empty($comboDetalle) || !is_array($comboDetalle)) {
                    $errores[] = 'Si el producto es un combo, debe tener al menos un producto componente';
                } else {
                    // Validar cada componente del combo (sin id_combo aún, solo validamos datos básicos)
                    foreach($comboDetalle as $index => $detalle) {
                        if(empty($detalle['id_producto']) || !is_numeric($detalle['id_producto'])) {
                            $errores[] = "Componente #" . ($index + 1) . ": El ID del producto es obligatorio";
                        }
                        
                        if(empty($detalle['cantidad']) || !is_numeric($detalle['cantidad']) || floatval($detalle['cantidad']) <= 0) {
                            $errores[] = "Componente #" . ($index + 1) . ": La cantidad debe ser un número mayor a 0";
                        }
                    }
                }
            }
            
            if(empty($errores)) {
                $resultado = $producto->guardar();
                if($resultado) {
                    // Si es combo, actualizar componentes
                    if($producto->escombo == 1) {
                        // Eliminar componentes antiguos
                        ComboDet::eliminarPorCombo($producto->id);
                        
                        // Guardar nuevos componentes
                        if(!empty($comboDetalle)) {
                            $componentesGuardados = 0;
                            foreach($comboDetalle as $detalle) {
                                $comboDet = new ComboDet();
                                $comboDet->id_combo = $producto->id;
                                $comboDet->id_producto = intval($detalle['id_producto']);
                                $comboDet->cantidad = floatval($detalle['cantidad']);
                                
                                $resultadoDet = $comboDet->guardar();
                                if($resultadoDet['resultado']) {
                                    $componentesGuardados++;
                                }
                            }
                            
                            if($componentesGuardados == 0 && !empty($comboDetalle)) {
                                $errores[] = 'Error al guardar los componentes del combo';
                            }
                        }
                    } else {
                        // Si ya no es combo, eliminar componentes existentes
                        ComboDet::eliminarPorCombo($producto->id);
                    }
                    
                    if(empty($errores)) {
                        header('Location: /maestros/productos?editado=1');
                        return;
                    }
                } else {
                    $errores[] = 'Error al actualizar el producto';
                }
            }
        }
        
        $router->render('maestros/productos/editar', [
            'producto' => $producto,
            'errores' => $errores,
            'productos' => $productos,
            'componentesExistentes' => $componentesExistentes
        ]);
    }

    // Eliminar producto
    public static function eliminarProducto(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'] ?? '';
            
            if($id) {
                $producto = Productos::find($id);
                
                if($producto) {
                    // Si es combo, eliminar primero sus componentes
                    if($producto->escombo == 1) {
                        ComboDet::eliminarPorCombo($id);
                    }
                    
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
            
            // Establecer fecha_creacion si es un cliente nuevo
            if(empty($cliente->id)) {
                $cliente->fecha_creacion = date('Y-m-d H:i:s');
            }
            
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

    public static function editarCliente(Router $router) {
        $id = $_GET['id'] ?? '';
        $cliente = Cliente::find($id);
        if(!$cliente) {
            header('Location: /maestros/clientes');
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //debuguear($_POST);
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar();
            $errores = $alertas['error'] ?? [];
            if(empty($errores)) {
                $resultado = $cliente->guardar();
                if($resultado) {
                    header('Location: /maestros/clientes?editado=1');
                    return;
                } else {
                    $errores[] = 'Error al actualizar el cliente';
                }
            }
        }

        $errores = [];
        $router->render('maestros/clientes/editar', [
            'cliente' => $cliente,
            'errores' => $errores
        ]);
    }

    public static function eliminarCliente(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $id = $_POST['id'] ?? '';
            
            if($id) {
                $cliente = Cliente::find($id);
                
                if($cliente) {
                    $resultado = $cliente->eliminar();
                    if($resultado) {
                        header('Location: /maestros/clientes?eliminado=1');
                        return;
                    } else {
                        header('Location: /maestros/clientes?error=1');
                        return;
                    }
                } else {
                    header('Location: /maestros/clientes?error=1');
                    return;
                }
            }
        }
        
        header('Location: /maestros/clientes');
     
    }

    public static function verCliente(Router $router) {
        $id = $_GET['id'] ?? '';
        $cliente = Cliente::find($id);
        if(!$cliente) {
            header('Location: /maestros/clientes');
            return;
        }
        $router->render('maestros/clientes/ver', [
            'cliente' => $cliente
        ]);
    }
}