<?php 

namespace Controller;

use MVC\Router;
use Model\Entrada;
use Model\EntradaDet;
use Model\Productos;
use Model\Kardex;

class EntradasController {
    public static function entradasProductos(Router $router) {
        $entradas = Entrada::all();
        $router->render('entradas/index', [
            'entradas' => $entradas
        ]);
    }

    public static function crearEntradaProducto(Router $router) {
        $entrada = new Entrada();
        $productos = Productos::all();
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['id_usu'] = $_SESSION['id'] ?? '';
            
            // Si no tiene fecha, asignar fecha actual
            if(empty($_POST['fecha'])) {
                $_POST['fecha'] = date('Y-m-d');
            }

            $entrada->sincronizar($_POST);
            $alertasVenta = $entrada->validar();
            $errores = $alertasVenta['error'] ?? [];

            $detalles = $_POST['detalles'] ?? [];

            if(empty($detalles) || !is_array($detalles)) {
                $errores[] = 'Debe agregar al menos un producto a la entrada';
            } else {
                // Validar cada detalle usando el modelo
                $totalCalculado = 0;
                foreach($detalles as $index => $detalle) {
                    $entradaDet = new EntradaDet();
                    $entradaDet->sincronizar($detalle);
                    $alertasDet = $entradaDet->validar();
                    
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
               // $entrada->total = $totalCalculado;
            }

            if(empty($errores)) {
                $resultado = $entrada->guardar();
                if($resultado['resultado']) 
                    $idEntrada = $resultado['id'];
                
               // debuguear($idEntrada);    
                $detallesGuardados = 0;
                    
                foreach($detalles as $detalle){
                    $cantidadHist = 0;
                    
                    $entradaDet = new EntradaDet();
                    $entradaDet->id = $idEntrada;
                    $entradaDet->id_prod = intval($detalle['id_prod']);
                    $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$detalle['id_prod']));
                    $entradaDet->cantidad = floatval($detalle['cantidad']);
                    $resultadoDet = $entradaDet->guardar();
                    
                    if($resultadoDet['resultado']){
                        $inserPro = Kardex::insertarKardex($entradaDet->id_prod,$entradaDet->cantidad,'entrada',$cantidadHist);
                        
                        $actInv = Productos::actualizaInventario($entradaDet->id_prod,$entradaDet->cantidad,$cantidadHist);
                       
                        if($actInv && $inserPro){
                            $detallesGuardados++;
                        }
                    }

                   
                    
                }   
                if($detallesGuardados > 0) {
                    header('Location: /entradas-productos?creado=1');
                    return;
                } 
                else {
                    $errores[] = 'Error al guardar los detalles de la Entrada';
                }     
            
            }    
        }
        $router->render('entradas/crear', [
            'entrada'=>$entrada,
            'productos'=>$productos,
            'errore'=>$errores
        ]);
    }
    

    public static function editarEntradaProducto(Router $router) {
        $id = $_GET['id'] ?? null;
        $entrada = Entrada::find($_GET['id']);
        $productos = Productos::all();
        $errores = [];

        if (!$entrada) {
            header('Location: /entradas-productos');
            return;
        }

        $detalles = $entrada->obtenerDetalles();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['id_usu'] = $_SESSION['id'] ?? $entrada->id_usu;
            
            // Si no tiene fecha, mantener la existente
            if(empty($_POST['fecha'])) {
                $_POST['fecha'] = $entrada->fecha;
            }
            
            // Sincronizar datos del encabezado
            $entrada->sincronizar($_POST);
            
            // Validar entrada usando el modelo
            $alertasEntrada = $entrada->validar();
            $errores = $alertasEntrada['error'] ?? [];
            
            // Validar detalles de productos
            $detallesPost = $_POST['detalles'] ?? [];
            
            if(empty($detallesPost) || !is_array($detallesPost)) {
                $errores[] = 'Debe agregar al menos un producto a la entrada';
            } else {
                // Validar cada detalle usando el modelo
                foreach($detallesPost as $index => $detalle) {
                    $entradaDet = new EntradaDet();
                    $entradaDet->sincronizar($detalle);
                    $alertasDet = $entradaDet->validar();
                    
                    if(!empty($alertasDet['error'])) {
                        foreach($alertasDet['error'] as $errorDet) {
                            $errores[] = "Producto #" . ($index + 1) . ": " . $errorDet;
                        }
                    }
                }
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
                
                $resultado = $entrada->guardar();
                
                if($resultado) {
                    // Procesar movimientos en Kardex antes de eliminar detalles
                    $movimientosKardex = 0;
                    
                    // 1. Productos eliminados: revertir entrada (cantidad negativa porque era positiva)
                    foreach($mapaAntiguos as $idProd => $cantidadAntigua) {
                        if(!isset($mapaNuevos[$idProd])) {
                            // Producto eliminado - revertir la entrada
                            $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$idProd));
                            $inserPro = Kardex::insertarKardex($idProd, $cantidadAntigua * -1, 'reversoEntrada',$cantidadHist);
                            $actInv = Productos::actualizaInventario($idProd, $cantidadAntigua * -1, $cantidadHist);
                            
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
                                // La diferencia positiva porque es una entrada
                                $inserPro = Kardex::insertarKardex($idProd, $diferencia, 'ajusteEntrada',$cantidadHist);
                                $actInv = Productos::actualizaInventario($idProd, $diferencia, $cantidadHist);
                                
                                if($inserPro['resultado'] && $actInv) {
                                    $movimientosKardex++;
                                }
                            }
                        }
                    }
                    
                    // 3. Productos nuevos: registrar como entrada (cantidad positiva)
                    foreach($mapaNuevos as $idProd => $cantidadNueva) {
                        if(!isset($mapaAntiguos[$idProd])) {
                            // Producto nuevo - registrar entrada
                            $cantidadHist = intval(Productos::buscaCampoValor('cantidad','id',$idProd));
                            $inserPro = Kardex::insertarKardex($idProd, $cantidadNueva, 'entrada',$cantidadHist);
                            $actInv = Productos::actualizaInventario($idProd, $cantidadNueva, $cantidadHist);
                            
                            if($inserPro['resultado'] && $actInv) {
                                $movimientosKardex++;
                            }
                        }
                    }
                    
                    // Eliminar los detalles antiguos usando el modelo
                    EntradaDet::eliminarPorEntrada($entrada->id);
                    
                    // Guardar los nuevos detalles
                    $detallesGuardados = 0;
                    
                    foreach($detallesPost as $detalle) {
                        $entradaDet = new EntradaDet();
                        
                        $entradaDet->id = $entrada->id;
                        $entradaDet->id_prod = intval($detalle['id_prod']);
                        $entradaDet->cantidad = floatval($detalle['cantidad']);
                        
                        // Guardar el detalle
                        $resultadoDet = $entradaDet->guardar();
                        
                        if($resultadoDet['resultado']) {
                            $detallesGuardados++;
                        }
                    }
                    
                    if($detallesGuardados > 0) {
                        header('Location: /entradas-productos?actualizado=1');
                        return;
                    } else {
                        $errores[] = 'Error al guardar los detalles de la entrada';
                    }
                } else {
                    $errores[] = 'Error al actualizar la entrada';
                }
            }
            
            // Si hay errores, recargar los detalles para mostrarlos
            $detalles = []; // Se recalcularán desde $_POST si es necesario
        }


        $router->render('entradas/editar', [
            'entrada' => $entrada,
            'productos' => $productos,
            'errores' => $errores,
            'detalles' => $detalles

        ]);

    }



}