<?php 

namespace Controller;

use MVC\Router;
use Model\Ventas;
use Model\VentasDet;
use Model\Cliente;
use Model\Productos;
use Model\Kardex;

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
                        $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$detalle['id_prod']));
                    
                        // Guardar el detalle usando el método guardar()
                        // El modelo VentasDet tiene sobrescrito guardar() para crear cuando id es FK
                        $resultadoDet = $ventaDet->guardar();
                        $inserPro = Kardex::insertarKardex($ventaDet->id_prod,$ventaDet->cantidad*-1,'venta',$cantidadHist);
                        $actInv = Productos::actualizaInventario($ventaDet->id_prod,$ventaDet->cantidad*-1,$cantidadHist);

                        if($resultadoDet['resultado'] && $inserPro['resultado']) {
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

    public static function editarVenta(Router $router) {
        $id = $_GET['id'] ?? null;
        $venta = Ventas::find($id);
        $clientes = Cliente::all();
        $productos = Productos::all();
        $errores = [];
        
        if(!$venta) {
            header('Location: /ventas');
            return;
        }

        // Obtener detalles de la venta
        $detalles = $venta->obtenerDetalles();
        
        // Si es POST, procesar la actualización
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $_POST['id_usu'] = $_SESSION['id'] ?? $venta->id_usu;
            
            // Si no tiene fecha, mantener la existente
            if(empty($_POST['fecha'])) {
                $_POST['fecha'] = $venta->fecha;
            }
            
            // Sincronizar datos del encabezado
            $venta->sincronizar($_POST);
            
            // Validar venta usando el modelo
            $alertasVenta = $venta->validar();
            $errores = $alertasVenta['error'] ?? [];
            
            // Validar detalles de productos
            $detallesPost = $_POST['detalles'] ?? [];
            
            if(empty($detallesPost) || !is_array($detallesPost)) {
                $errores[] = 'Debe agregar al menos un producto al pedido';
            } else {
                // Validar cada detalle usando el modelo
                $totalCalculado = 0;
                foreach($detallesPost as $index => $detalle) {
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
            
            // Si no hay errores, actualizar
            if(empty($errores)) {
                // Guardar copia de detalles antiguos antes de eliminarlos
                $detallesAntiguos = $detalles;
                
                // Crear un mapa de detalles antiguos por id_prod para comparación rápida
                $mapaAntiguos = [];
                foreach($detallesAntiguos as $detAnt) {
                    $idProd = intval($detAnt['id_prod']);
                    $mapaAntiguos[$idProd] = floatval($detAnt['cantidad']);
                }
                
                // Crear un mapa de detalles nuevos por id_prod
                $mapaNuevos = [];
                foreach($detallesPost as $detNuevo) {
                    $idProd = intval($detNuevo['id_prod']);
                    $mapaNuevos[$idProd] = floatval($detNuevo['cantidad']);
                }
                
                // Actualizar la venta (encabezado)
                $resultado = $venta->actualizar();
                
                if($resultado) {
                    // Procesar movimientos en Kardex antes de eliminar detalles
                    $movimientosKardex = 0;
                    
                    // 1. Productos eliminados: revertir movimiento (cantidad positiva porque era negativa)
                    foreach($mapaAntiguos as $idProd => $cantidadAntigua) {
                        if(!isset($mapaNuevos[$idProd])) {
                            // Producto eliminado - revertir la salida
                            $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$idProd));
                            $inserPro = Kardex::insertarKardex($idProd, $cantidadAntigua, 'reversoVenta',$cantidadHist);
                            $actInv = Productos::actualizaInventario($idProd, $cantidadAntigua, $cantidadHist);
                            
                            if($inserPro['resultado'] && $actInv) {
                                $movimientosKardex++;
                            }
                        }
                    }
                    
                    // 2. Productos modificados: ajustar la diferencia
                    foreach($mapaNuevos as $idProd => $cantidadNueva) {
                        if(isset($mapaAntiguos[$idProd])) {
                            $cantidadAntigua = $mapaAntiguos[$idProd];
                            $diferencia = $cantidadNueva - $cantidadAntigua;
                            
                            // Solo registrar si hay diferencia
                            if($diferencia != 0) {
                                $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$idProd));
                                // La diferencia negativa porque es una venta
                                $inserPro = Kardex::insertarKardex($idProd, $diference * -1, 'ajusteVenta',$cantidadHist);
                                $actInv = Productos::actualizaInventario($idProd, $diferencia * -1, $cantidadHist);
                                
                                if($inserPro['resultado'] && $actInv) {
                                    $movimientosKardex++;
                                }
                            }
                        }
                    }
                    
                    // 3. Productos nuevos: registrar como venta (cantidad negativa)
                    foreach($mapaNuevos as $idProd => $cantidadNueva) {
                        if(!isset($mapaAntiguos[$idProd])) {
                            // Producto nuevo - registrar venta
                            $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$idProd));
                            $inserPro = Kardex::insertarKardex($idProd, $cantidadNueva * -1, 'venta',$cantidadHist);
                            $actInv = Productos::actualizaInventario($idProd, $cantidadNueva * -1, $cantidadHist);
                            
                            if($inserPro['resultado'] && $actInv) {
                                $movimientosKardex++;
                            }
                        }
                    }
                    
                    // Eliminar los detalles antiguos usando el modelo
                    VentasDet::eliminarPorVenta($venta->id);
                    
                    // Guardar los nuevos detalles
                    $detallesGuardados = 0;
                    
                    foreach($detallesPost as $detalle) {
                        $ventaDet = new VentasDet();
                        
                        // Establecer el id de la venta como FK
                        $ventaDet->id = $venta->id;
                        $ventaDet->id_prod = intval($detalle['id_prod']);
                        $ventaDet->cantidad = floatval($detalle['cantidad']);
                        $ventaDet->precio = floatval($detalle['precio']);
                        
                        // Guardar el detalle
                        $resultadoDet = $ventaDet->guardar();
                        
                        if($resultadoDet['resultado']) {
                            $detallesGuardados++;
                        }
                    }
                    
                    if($detallesGuardados > 0) {
                        header('Location: /ventas?actualizado=1');
                        return;
                    } else {
                        $errores[] = 'Error al guardar los detalles de la venta';
                    }
                } else {
                    $errores[] = 'Error al actualizar la venta';
                }
            }
            
            // Si hay errores, recargar los detalles para mostrarlos
            $detalles = []; // Se recalcularán desde $_POST si es necesario
        }

        $router->render('ventas/editar', [
            'venta' => $venta,
            'clientes' => $clientes,
            'productos' => $productos,
            'errores' => $errores,
            'detalles' => $detalles
        ]);
    }

    public static function eliminarVenta(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            
            if(!$id) {
                header('Location: /ventas?error=1');
                return;
            }
            
            $venta = Ventas::find($id);
            
            if(!$venta) {
                header('Location: /ventas?error=1');
                return;
            }
            
            // Primero eliminar los detalles de la venta
            VentasDet::eliminarPorVenta($venta->id);
            
            // Luego eliminar la venta (encabezado)
            $resultado = $venta->eliminar();
            
            if($resultado) {
                header('Location: /ventas?eliminado=1');
                return;
            } else {
                header('Location: /ventas?error=1');
                return;
            }
        }
        
        // Si no es POST, redirigir a la lista
        header('Location: /ventas');
        return;
    }
}