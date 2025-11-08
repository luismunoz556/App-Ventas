<?php 

namespace Controller;

use MVC\Router;
use Model\Kardex;
use Model\Productos;

class KardexController {
    public static function index(Router $router) {
        $idProducto = $_GET['producto'] ?? null;
       // debuguear($idProducto);
        $productos = Productos::all();
       // debuguear($productos);
        
        if($idProducto) {
            $kardex = Kardex::filtrarPorProducto($idProducto);
        } else {
            $kardex = Kardex::allConProducto();
        }
        
        // Calcular estadísticas
        $totalMovimientos = count($kardex);
        $totalEntradas = 0;
        $totalVentas = 0;
        $saldoActual = 0;
        
        foreach($kardex as $movimiento) {
            if($movimiento->tipo === 'entrada') {
                $totalEntradas += abs($movimiento->cantidad ?? 0);
            } elseif($movimiento->tipo === 'venta') {
                $totalVentas += abs($movimiento->cantidad ?? 0);
            }
            $saldoActual = $movimiento->saldo ?? 0;
        }
        
        $router->render('kardex/index', [
            'kardex' => $kardex,
            'productos' => $productos,
            'productoSeleccionado' => $idProducto,
            'estadisticas' => [
                'totalMovimientos' => $totalMovimientos,
                'totalEntradas' => $totalEntradas,
                'totalVentas' => $totalVentas,
                'saldoActual' => $saldoActual
            ]
        ]);
    }
}

