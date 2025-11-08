<?php

namespace Model;

class Kardex extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'kardex';
    protected static $columnasDB = ['id', 'id_refV', 'id_refE', 'id_prod', 'fecha', 'tipo', 'cantidad', 'saldo'];
    public $id;
    public $id_refV;
    public $id_refE;
    public $id_prod;
    public $fecha;
    public $tipo;
    public $cantidad;
    public $saldo;
    public $producto_nombre;


    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_refV = $args['id_refV'] ?? null;
        $this->id_refE = $args['id_refE'] ?? null;
        $this->id_prod = $args['id_prod'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->tipo = $args['tipo'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->saldo = $args['saldo'] ?? null;
    }

    public function validar() {
        self::$alertas = [];

        if(!$this->id_prod) {
            self::$alertas['error'][] = 'El ID del producto es obligatorio';
        } elseif(!is_numeric($this->id_prod)) {
            self::$alertas['error'][] = 'El ID del producto no es válido';
        }
    }

    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id' && !is_null($this->id)) {
                $atributos[$columna] = $this->$columna;
            } elseif($columna !== 'id') {
                $atributos[$columna] = $this->$columna;
            }
        }
        return $atributos;
 
 
    }

    public function guardar() {
        return $this->crear();
    }

    public static function insertarKardex($id_prod,$cantidad,$tipo,$cantidadAnt,$id_refV=null,$id_refE=null) {
        $kardex = new Kardex();
        $kardex->id_refV = $id_refV;
        $kardex->id_refE = $id_refE;
        $kardex->id_prod = $id_prod;
        $kardex->fecha = date('Y-m-d H:i:s');
        $kardex->tipo = $tipo;
        $kardex->cantidad = $cantidad;
        $kardex->saldo = $cantidadAnt + $cantidad;
        return $kardex->guardar();
    }

    public static function eliminarPorVenta($idVenta) {
        if(!$idVenta || !is_numeric($idVenta)) {
            return false;
        }
        
        // Obtener todos los detalles de la venta antes de eliminarlos
        $query = "SELECT id_prod, cantidad FROM ventas_det WHERE id = " . self::$db->escape_string(intval($idVenta));
        $resultado = self::$db->query($query);
        
        if(!$resultado) {
            return false;
        }
        
        $detalles = [];
        while($registro = $resultado->fetch_assoc()) {
            $detalles[] = $registro;
        }
        $resultado->free();
        
        // Para cada detalle, revertir la venta en Kardex y actualizar inventario
        foreach($detalles as $detalle) {
            $idProd = intval($detalle['id_prod']);
            $cantidad = floatval($detalle['cantidad']);
            
            // Obtener cantidad actual del producto
            $cantidadHist = intval(Productos::buscaCampoValor('cantidad', 'id', $idProd));
            
            // Revertir la venta: cantidad positiva (porque la venta era negativa)
            $kardex = new Kardex();
            $kardex->id_refV = $idVenta;
            $kardex->id_refE = null;
            $kardex->id_prod = $idProd;
            $kardex->fecha = date('Y-m-d H:i:s');
            $kardex->tipo = 'reversoVenta';
            $kardex->cantidad = $cantidad; // Positiva para revertir
            $kardex->saldo = $cantidadHist + $cantidad;
            $kardex->guardar();
            
            // Actualizar inventario del producto (sumar la cantidad)
            Productos::actualizaInventario($idProd, $cantidad, $cantidadHist);
        }
        
        return true;
    }     

    public static function eliminarPorEntrada($idEntrada) {
        if(!$idEntrada || !is_numeric($idEntrada)) {
            return false;
        }
        
        // Obtener todos los detalles de la entrada antes de eliminarlos
        $query = "SELECT id_prod, cantidad FROM entrada_det WHERE id = " . self::$db->escape_string(intval($idEntrada));
        $resultado = self::$db->query($query);
        
        if(!$resultado) {
            return false;
        }
        
        $detalles = [];
        while($registro = $resultado->fetch_assoc()) {
            $detalles[] = $registro;
        }
        $resultado->free();
        
        // Para cada detalle, revertir la entrada en Kardex y actualizar inventario
        foreach($detalles as $detalle) {
            $idProd = intval($detalle['id_prod']);
            $cantidad = floatval($detalle['cantidad']);
            
            // Obtener cantidad actual del producto
            $cantidadHist = intval(Productos::buscaCampoValor('cantidad', 'id', $idProd));
            
            // Revertir la entrada: cantidad negativa (porque la entrada era positiva)
            $kardex = new Kardex();
            $kardex->id_refV = null;
            $kardex->id_refE = $idEntrada;
            $kardex->id_prod = $idProd;
            $kardex->fecha = date('Y-m-d H:i:s');
            $kardex->tipo = 'reversoEntrada';
            $kardex->cantidad = $cantidad * -1; // Negativa para revertir
            $kardex->saldo = $cantidadHist - $cantidad;
            $kardex->guardar();
            
            // Actualizar inventario del producto (restar la cantidad)
            Productos::actualizaInventario($idProd, $cantidad * -1, $cantidadHist);
        }
        
        return true;
    }

    public static function allConProducto() {
        $query = "SELECT k.*, p.nombre as producto_nombre 
                  FROM " . static::$tabla . " k 
                  LEFT JOIN productos p ON k.id_prod = p.id
                  ORDER BY k.fecha ASC, k.id ASC";
       // debuguear($query);
        
        return self::consultarSQL($query);
    }

    public static function filtrarPorProducto($idProducto) {
        if(!$idProducto || !is_numeric($idProducto)) {
            return [];
        }
        
        $query = "SELECT k.*, p.nombre as producto_nombre 
                  FROM " . static::$tabla . " k 
                  LEFT JOIN productos p ON k.id_prod = p.id
                  WHERE k.id_prod = " . self::$db->escape_string(intval($idProducto)) . "
                  ORDER BY k.fecha DESC, k.id DESC";
        
        return self::consultarSQL($query);
    }    
}